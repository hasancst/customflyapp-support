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
     * Initialize new chat session
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
            'pesan' => 'Halo! 👋 Saya asisten AI. Ada yang bisa saya bantu?'
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
                'message' => 'Tiket support Anda sudah dibuat sebelumnya.'
            ]);
        }

        $ticket = $this->escalationService->escalateToTicket($session);

        ChatMessage::create([
            'session_id' => $session->id,
            'pengirim' => 'ai',
            'pesan' => "Saya telah membuat tiket support untuk Anda. Tim kami akan segera menghubungi Anda melalui email. Nomor tiket: #{$ticket->id}"
        ]);

        return response()->json([
            'escalated' => true,
            'ticket_id' => $ticket->id,
            'message' => 'Tiket berhasil dibuat. Tim support akan menghubungi Anda segera.'
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

    // Agent API Methods
    public function getAdminActiveSessions()
    {
        $sessions = ChatSession::whereIn('status', ['aktif', 'eskalasi'])
            ->with(['messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function($s) {
                return [
                    'id' => $s->id,
                    'nama_pengunjung' => $s->nama_pengunjung,
                    'last_message' => $s->messages->first()->pesan ?? '',
                    'updated_at' => $s->updated_at
                ];
            });

        return response()->json($sessions);
    }

    public function getAdminMessages($sessionId)
    {
        $session = ChatSession::findOrFail($sessionId);
        $messages = $session->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($msg) => [
                'sender' => $msg->pengirim,
                'message' => $msg->pesan,
                'timestamp' => $msg->created_at->toISOString()
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
            'pengirim' => 'agent', // Human agent
            'pesan' => $request->message
        ]);
        
        $session->updateAktivitas();

        return response()->json(['success' => true]);
    }
}
