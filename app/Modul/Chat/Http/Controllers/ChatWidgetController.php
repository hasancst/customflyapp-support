<?php

namespace App\Modul\Chat\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Chat\Model\ChatWidget;
use App\Modul\Chat\Model\ChatSession;
use App\Modul\Chat\Model\ChatMessage;
use App\Modul\Chat\Services\AIService;
use App\Modul\Chat\Services\TicketEscalationService;
use Illuminate\Http\Request;

class ChatWidgetController extends Controller
{
    private AIService $aiService;
    private TicketEscalationService $escalationService;

    public function __construct(AIService $aiService, TicketEscalationService $escalationService)
    {
        $this->aiService = $aiService;
        $this->escalationService = $escalationService;
    }

    /**
     * Resume existing active session or create new one
     * Prevents duplicate sessions for same visitor
     */
    public function resumeOrCreate(Request $request)
    {
        $request->validate([
            'widget_key'    => 'required|string',
            'visitor_email' => 'required|email',
            'visitor_name'  => 'nullable|string|max:100',
            'force_new'     => 'nullable|boolean',
        ]);

        $widget = ChatWidget::where('public_key', $request->widget_key)
            ->where('aktif', true)->first();

        if (!$widget) {
            return response()->json(['error' => 'Invalid widget key'], 401);
        }

        // Look for existing resumable session (skip if force_new = true)
        $existing = null;
        $forceNew = filter_var($request->input('force_new', false), FILTER_VALIDATE_BOOLEAN);
        if (!$forceNew) {
            $existing = ChatSession::where('widget_id', $widget->id)
                ->where('email_pengunjung', $request->visitor_email)
                ->where(function($q) {
                    $q->whereIn('status', ['aktif', 'eskalasi'])
                      ->orWhere(function($q2) {
                          $q2->where('status', 'selesai')
                             ->whereNotNull('tiket_id');
                      });
                })
                ->orderByRaw("CASE status WHEN 'aktif' THEN 1 WHEN 'eskalasi' THEN 2 ELSE 3 END")
                ->orderBy('aktivitas_terakhir', 'desc')
                ->first();
        }

        if ($existing) {
            $existing->updateAktivitas();
            $messages = $existing->messages()
                ->orderBy('created_at')
                ->get()
                ->map(fn($m) => [
                    'id'        => $m->id,
                    'sender'    => $m->pengirim,
                    'message'   => $m->pesan,
                    'timestamp' => $m->created_at->toISOString(),
                ]);

            // Load ticket number if escalated
            $noTiket = null;
            if ($existing->tiket_id) {
                $tiket = \App\Modul\Tiket\Model\Tiket::find($existing->tiket_id);
                $noTiket = $tiket?->no_tiket;
            }

            return response()->json([
                'session_token' => $existing->session_token,
                'resumed'       => true,
                'status'        => $existing->status,
                'tiket_id'      => $existing->tiket_id,
                'no_tiket'      => $noTiket,
                'messages'      => $messages,
            ]);
        }

        // Create new session
        $session = ChatSession::create([
            'widget_id'        => $widget->id,
            'nama_pengunjung'  => $request->visitor_name,
            'email_pengunjung' => $request->visitor_email,
            'ip_pengunjung'    => $request->ip(),
            'user_agent'       => $request->userAgent(),
            'status'           => 'aktif',
        ]);

        $welcome = ChatMessage::create([
            'session_id' => $session->id,
            'pengirim'   => 'ai',
            'pesan'      => "Hello! 👋 I'm your support assistant. How can I help you today?",
        ]);

        return response()->json([
            'session_token' => $session->session_token,
            'resumed'       => false,
            'status'        => 'aktif',
            'tiket_id'      => null,
            'messages'      => [[
                'id'        => $welcome->id,
                'sender'    => 'ai',
                'message'   => $welcome->pesan,
                'timestamp' => $welcome->created_at->toISOString(),
            ]],
        ]);
    }

    /**
     * Poll for new messages since last_id — efficient polling endpoint
     */
    public function poll(Request $request, string $sessionToken)
    {
        $session = ChatSession::where('session_token', $sessionToken)->first();

        if (!$session) {
            return response()->json(['error' => 'Invalid session'], 404);
        }

        $lastId   = (int) $request->query('last_id', 0);
        $messages = $session->messages()
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'        => $m->id,
                'sender'    => $m->pengirim,
                'message'   => $m->pesan,
                'timestamp' => $m->created_at->toISOString(),
            ]);

        $session->updateAktivitas();

        return response()->json([
            'messages' => $messages,
            'status'   => $session->status,
            'tiket_id' => $session->tiket_id,
        ]);
    }

    /**
     * Close a chat session (customer-initiated)
     */
    public function closeSession(Request $request)
    {
        $request->validate(['session_token' => 'required|string']);

        $session = ChatSession::where('session_token', $request->session_token)->first();

        if ($session && in_array($session->status, ['aktif', 'eskalasi'])) {
            $session->update(['status' => 'selesai']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Initialize new chat session (legacy — use resumeOrCreate instead)
     */
    public function initSession(Request $request)
    {
        $request->validate([
            'widget_key' => 'required|string',
            'visitor_name' => 'nullable|string|max:100',
            'visitor_email' => 'nullable|email',
            'page_url' => 'nullable|url'
        ]);

        $widget = ChatWidget::where('public_key', $request->widget_key)
            ->where('aktif', true)
            ->first();

        if (!$widget) {
            return response()->json(['error' => 'Invalid widget key'], 401);
        }

        $session = ChatSession::create([
            'widget_id' => $widget->id,
            'nama_pengunjung' => $request->visitor_name,
            'email_pengunjung' => $request->visitor_email,
            'ip_pengunjung' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'halaman_url' => $request->page_url,
            'status' => 'aktif'
        ]);

        // Send welcome message
        ChatMessage::create([
            'session_id' => $session->id,
            'pengirim' => 'ai',
            'pesan' => "Hello! 👋 I'm your support assistant. How can I help you today?"
        ]);

        return response()->json([
            'session_token' => $session->session_token,
            'widget_settings' => $widget->pengaturan
        ]);
    }

    /**
     * Send message and get AI response
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_token' => 'required|string',
            'message' => 'required|string|max:1000'
        ]);

        $session = ChatSession::where('session_token', $request->session_token)->first();

        if (!$session) {
            return response()->json(['error' => 'Invalid session'], 404);
        }

        // Save visitor message
        ChatMessage::create([
            'session_id' => $session->id,
            'pengirim' => 'pengunjung',
            'pesan' => $request->message
        ]);

        $session->updateAktivitas();

        // Check for escalation intent
        if ($this->aiService->detectEscalationIntent($request->message)) {
            return $this->autoEscalate($session);
        }

        // Generate AI response
        $aiResponse = $this->aiService->generateResponse($request->message);

        // Auto-escalate if low confidence
        if ($aiResponse['should_escalate']) {
            return $this->autoEscalate($session);
        }

        // Save AI response
        $aiMessage = ChatMessage::create([
            'session_id' => $session->id,
            'pengirim' => 'ai',
            'pesan' => $aiResponse['answer'],
            'metadata' => [
                'confidence' => $aiResponse['confidence'],
                'kb_articles' => $aiResponse['kb_articles']
            ]
        ]);

        return response()->json([
            'message' => $aiMessage->pesan,
            'confidence' => $aiResponse['confidence'],
            'kb_articles' => $aiResponse['kb_articles']
        ]);
    }

    /**
     * Manual escalation to human agent
     */
    public function escalate(Request $request)
    {
        $request->validate([
            'session_token' => 'required|string'
        ]);

        $session = ChatSession::where('session_token', $request->session_token)->first();

        if (!$session) {
            return response()->json(['error' => 'Invalid session'], 404);
        }

        return $this->autoEscalate($session);
    }

    /**
     * Auto-escalate session to ticket
     */
    private function autoEscalate(ChatSession $session)
    {
        if ($session->status === 'eskalasi') {
            return response()->json([
                'escalated' => true,
                'ticket_id' => $session->tiket_id,
                'message' => 'Your support ticket has already been created. Our team will contact you soon.'
            ]);
        }

        $ticket = $this->escalationService->escalateToTicket($session);

        ChatMessage::create([
            'session_id' => $session->id,
            'pengirim' => 'ai',
            'pesan' => "✅ Your support ticket has been created (#{$ticket->no_tiket}). Our team will get back to you via email. You can also track it in the My Tickets tab."
        ]);

        return response()->json([
            'escalated' => true,
            'ticket_id' => $ticket->id,
            'no_tiket'  => $ticket->no_tiket,
            'message'   => 'Ticket created. Our support team will contact you soon.'
        ]);
    }

    /**
     * Get chat history
     */
    public function getHistory(Request $request, string $sessionToken)
    {
        $session = ChatSession::where('session_token', $sessionToken)->first();

        if (!$session) {
            return response()->json(['error' => 'Invalid session'], 404);
        }

        $messages = $session->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($msg) => [
                'sender' => $msg->pengirim,
                'message' => $msg->pesan,
                'timestamp' => $msg->created_at->toISOString()
            ]);

        return response()->json([
            'messages' => $messages,
            'status' => $session->status
        ]);
    }

    /**
     * End chat session
     */
    public function endSession(Request $request)
    {
        $request->validate([
            'session_token' => 'required|string'
        ]);

        $session = ChatSession::where('session_token', $request->session_token)->first();

        if ($session && $session->status === 'aktif') {
            $session->update(['status' => 'selesai']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Admin: List all widgets
     */
    public function index()
    {
        $widgets = ChatWidget::withCount('sessions')->get();
        return view('chat::admin.widgets', compact('widgets'));
    }

    /**
     * Admin: Create new widget
     */
    public function createWidget(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'domain' => 'nullable|url'
        ]);

        $widget = ChatWidget::create([
            'nama' => $request->nama,
            'domain' => $request->domain,
            'pengaturan' => [
                'theme_color' => '#4e73df',
                'position' => 'bottom-right',
                'greeting' => 'Halo! Ada yang bisa kami bantu?'
            ]
        ]);

        return redirect()->back()->with('berhasil', 'Widget berhasil dibuat!');
    }

    /**
     * Admin: List chat sessions
     */
    public function listSessions(Request $request)
    {
        $sessions = ChatSession::with(['widget', 'tiket'])
            ->latest()
            ->paginate(20);

        return view('chat::admin.sessions', compact('sessions'));
    }


    public function getAdminMessages($sessionId)
    {
        $session  = ChatSession::findOrFail($sessionId);
        $messages = $session->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($msg) => [
                'id'        => $msg->id,
                'sender'    => $msg->pengirim,
                'message'   => $msg->pesan,
                'timestamp' => $msg->created_at->toISOString(),
            ]);

        return response()->json($messages);
    }

    public function sendAdminMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:chat_sessions,id',
            'message' => 'required|string'
        ]);

        $session = ChatSession::findOrFail($request->session_id);

        ChatMessage::create([
            'session_id' => $session->id,
            'pengirim'   => 'agen',
            'pesan'      => $request->message
        ]);

        $session->updateAktivitas();

        return response()->json(['success' => true]);
    }

    /**
     * Admin: Poll new messages since last_id for a session
     */
    public function pollAdminMessages(Request $request, int $sessionId)
    {
        $session  = ChatSession::findOrFail($sessionId);
        $lastId   = (int) $request->query('last_id', 0);
        $messages = $session->messages()
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'        => $m->id,
                'sender'    => $m->pengirim,
                'message'   => $m->pesan,
                'timestamp' => $m->created_at->toISOString(),
            ]);

        return response()->json([
            'messages' => $messages,
            'status'   => $session->status,
            'tiket_id' => $session->tiket_id,
        ]);
    }

    /**
     * Admin: Close a session
     */
    public function adminCloseSession(Request $request)
    {
        $request->validate(['session_id' => 'required|exists:chat_sessions,id']);
        $session = ChatSession::findOrFail($request->session_id);

        if (in_array($session->status, ['aktif', 'eskalasi'])) {
            ChatMessage::create([
                'session_id' => $session->id,
                'pengirim'   => 'agen',
                'pesan'      => 'This chat session has been closed by the support team.',
            ]);
            $session->update(['status' => 'selesai']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Admin: Escalate session to ticket
     */
    public function adminEscalateSession(Request $request)
    {
        $request->validate(['session_id' => 'required|exists:chat_sessions,id']);
        $session = ChatSession::findOrFail($request->session_id);

        if ($session->status === 'eskalasi' && $session->tiket_id) {
            return response()->json(['success' => true, 'tiket_id' => $session->tiket_id]);
        }

        $ticket = $this->escalationService->escalateToTicket($session);

        ChatMessage::create([
            'session_id' => $session->id,
            'pengirim'   => 'agen',
            'pesan'      => "✅ Support ticket #{$ticket->no_tiket} has been created. The customer will be contacted via email.",
        ]);

        return response()->json([
            'success'  => true,
            'tiket_id' => $ticket->id,
            'no_tiket' => $ticket->no_tiket,
        ]);
    }

    /**
     * Admin: Delete a session permanently (removes messages too via cascade)
     */
    public function adminDeleteSession(int $sessionId)
    {
        $session = ChatSession::findOrFail($sessionId);
        $session->messages()->delete();
        $session->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Admin: Get active sessions with email + status
     */
    public function getAdminActiveSessions()
    {
        $sessions = ChatSession::whereIn('status', ['aktif', 'eskalasi'])
            ->with(['messages' => function($q) { $q->latest()->limit(1); }])
            ->orderBy('aktivitas_terakhir', 'desc')
            ->get()
            ->map(function($s) {
                // Derive shop name from email (e.g. "dawn-theme-cst.myshopify.com" from shop_id or email)
                $shopName = $s->widget?->nama_toko
                    ?? $this->extractShopName($s->email_pengunjung)
                    ?? $s->nama_pengunjung
                    ?? 'Anonymous';

                $lastMsg    = $s->messages->first();
                $unreadCount = $s->messages()->where('pengirim', 'pengunjung')->count();

                return [
                    'id'              => $s->id,
                    'shop_name'       => $shopName,
                    'nama_pengunjung' => $s->nama_pengunjung ?? 'Anonymous',
                    'email'           => $s->email_pengunjung ?? '',
                    'status'          => $s->status,
                    'tiket_id'        => $s->tiket_id,
                    'last_message'    => $lastMsg?->pesan ?? '',
                    'last_message_id' => $lastMsg?->id ?? 0,
                    'unread_count'    => $unreadCount,
                    'updated_at'      => $s->aktivitas_terakhir,
                ];
            });

        return response()->json($sessions);
    }

    /**
     * Extract shop name from email domain or shop_id
     * e.g. "dawn-theme-cst.myshopify.com" → "Dawn-theme-cst"
     */
    private function extractShopName(?string $email): ?string
    {
        if (!$email) return null;
        // If it looks like a shop domain
        if (str_contains($email, 'myshopify.com')) {
            $domain = str_replace('.myshopify.com', '', $email);
            return ucwords(str_replace('-', ' ', $domain));
        }
        return null;
    }
}
