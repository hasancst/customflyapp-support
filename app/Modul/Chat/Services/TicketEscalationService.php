<?php

namespace App\Modul\Chat\Services;

use App\Modul\Chat\Model\ChatSession;
use App\Modul\Tiket\Model\Tiket;
use Illuminate\Support\Str;

class TicketEscalationService
{
    private AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Auto-create ticket from chat session
     */
    public function escalateToTicket(ChatSession $session): Tiket
    {
        $messages = $session->messages()->orderBy('created_at')->get()->toArray();
        
        $summary = $this->aiService->generateChatSummary($messages);
        $transcript = $this->formatChatTranscript($messages);
        
        $ticket = Tiket::create([
            'judul' => $this->generateTicketTitle($messages),
            'deskripsi' => $summary . "\n\n--- Transkrip Chat ---\n" . $transcript,
            'nama' => $session->nama_pengunjung ?? 'Anonymous',
            'email' => $session->email_pengunjung ?? 'no-email@chat.widget',
            'prioritas' => $this->determinePriority($messages),
            'status' => 'terbuka',
            'kategori' => 'Chat Escalation'
        ]);

        $session->update([
            'tiket_id' => $ticket->id,
            'status' => 'eskalasi'
        ]);

        return $ticket;
    }

    /**
     * Format chat messages as readable transcript
     */
    private function formatChatTranscript(array $messages): string
    {
        $transcript = '';
        
        foreach ($messages as $msg) {
            $sender = match($msg['pengirim']) {
                'pengunjung' => 'Pengunjung',
                'ai' => 'AI Assistant',
                'agen' => 'Support Agent',
                default => 'Unknown'
            };
            
            $time = date('H:i', strtotime($msg['created_at']));
            $transcript .= "[{$time}] {$sender}: {$msg['pesan']}\n";
        }
        
        return $transcript;
    }

    /**
     * Generate ticket title from first visitor message
     */
    private function generateTicketTitle(array $messages): string
    {
        $firstVisitorMsg = collect($messages)
            ->firstWhere('pengirim', 'pengunjung');
        
        if (!$firstVisitorMsg) {
            return 'Chat Support Request';
        }
        
        $title = Str::limit($firstVisitorMsg['pesan'], 60);
        return "Chat: {$title}";
    }

    /**
     * Determine ticket priority
     */
    private function determinePriority(array $messages): string
    {
        $urgentKeywords = ['urgent', 'emergency', 'asap', 'critical', 'mendesak', 'darurat', 'segera'];
        
        foreach ($messages as $msg) {
            if ($msg['pengirim'] === 'pengunjung') {
                $messageLower = strtolower($msg['pesan']);
                foreach ($urgentKeywords as $keyword) {
                    if (str_contains($messageLower, $keyword)) {
                        return 'tinggi';
                    }
                }
            }
        }
        
        return 'sedang';
    }

    /**
     * Check if session should auto-escalate
     */
    public function shouldAutoEscalate(ChatSession $session): bool
    {
        // Escalate if no activity for 10 minutes
        if ($session->aktivitas_terakhir->diffInMinutes(now()) > 10) {
            return true;
        }

        // Escalate if too many messages without resolution
        $messageCount = $session->messages()->where('pengirim', 'pengunjung')->count();
        if ($messageCount > 8) {
            return true;
        }

        return false;
    }
}
