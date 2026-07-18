<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Chat\Model\ChatSession;
use App\Modul\Chat\Model\ChatMessage;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function activeSessions()
    {
        $sessions = ChatSession::whereIn('status', ['aktif', 'eskalasi'])
            ->with(['messages' => function($q) { $q->latest()->limit(1); }])
            ->orderBy('aktivitas_terakhir', 'desc')
            ->get()
            ->map(function($s) {
                $lastMsg = $s->messages->first();
                $unreadCount = $s->messages()->where('pengirim', 'pengunjung')->count(); 

                return [
                    'id'              => $s->id,
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

        return response()->json(['success' => true, 'data' => $sessions]);
    }

    public function messages($sessionId)
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

        return response()->json(['success' => true, 'data' => $messages]);
    }

    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate(['pesan' => 'required|string']);

        $session = ChatSession::findOrFail($sessionId);

        $message = ChatMessage::create([
            'session_id' => $session->id,
            'pengirim'   => 'agen',
            'pesan'      => $request->pesan,
        ]);

        $session->updateAktivitas();

        return response()->json(['success' => true, 'data' => $message]);
    }

    public function closeSession($sessionId)
    {
        $session = ChatSession::findOrFail($sessionId);

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
}
