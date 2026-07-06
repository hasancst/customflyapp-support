<?php

namespace App\Modul\Chat\Services;

use App\Modul\Knowledgebase\Model\KBArticle;
use Illuminate\Support\Facades\DB;

class AIService
{
    private const CONFIDENCE_THRESHOLD = 0.65;
    private const MAX_RESULTS = 3;

    /**
     * Generate AI response with confidence scoring
     */
    public function generateResponse(string $query): array
    {
        $kbResults = $this->searchKnowledgeBase($query);
        
        if (empty($kbResults)) {
            return [
                'answer' => null,
                'confidence' => 0,
                'kb_articles' => [],
                'should_escalate' => true
            ];
        }

        $topResult = $kbResults[0];
        $confidence = $this->calculateConfidence($query, $topResult);
        $answer = $this->formatAnswer($topResult, $confidence);
        
        return [
            'answer' => $answer,
            'confidence' => $confidence,
            'kb_articles' => array_slice($kbResults, 0, self::MAX_RESULTS),
            'should_escalate' => $confidence < self::CONFIDENCE_THRESHOLD
        ];
    }

    /**
     * Search Knowledge Base using full-text search
     */
    private function searchKnowledgeBase(string $query): array
    {
        $keywords = $this->extractKeywords($query);
        
        $articles = KBArticle::where('published', true)
            ->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('judul', 'ILIKE', "%{$keyword}%")
                      ->orWhere('konten', 'ILIKE', "%{$keyword}%")
                      ->orWhere('tags', 'ILIKE', "%{$keyword}%");
                }
            })
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return $articles->map(function($article) use ($query) {
            return [
                'id' => $article->id,
                'title' => $article->judul,
                'content' => $article->konten,
                'url' => url('/kb/article/' . $article->slug),
                'relevance' => $this->calculateRelevance($query, $article)
            ];
        })->sortByDesc('relevance')->values()->toArray();
    }

    /**
     * Calculate confidence score (0-1)
     */
    private function calculateConfidence(string $query, array $kbResult): float
    {
        $relevance = $kbResult['relevance'];
        
        $queryLower = strtolower($query);
        $titleLower = strtolower($kbResult['title']);
        
        if (str_contains($titleLower, $queryLower)) {
            $relevance += 0.2;
        }
        
        return min(1.0, $relevance);
    }

    /**
     * Calculate relevance score
     */
    private function calculateRelevance(string $query, $article): float
    {
        $queryWords = $this->extractKeywords($query);
        $articleText = strtolower($article->judul . ' ' . strip_tags($article->konten));
        
        $matches = 0;
        foreach ($queryWords as $word) {
            if (str_contains($articleText, strtolower($word))) {
                $matches++;
            }
        }
        
        return $matches / max(1, count($queryWords));
    }

    /**
     * Extract keywords from query
     */
    private function extractKeywords(string $text): array
    {
        $stopWords = ['apa', 'bagaimana', 'kenapa', 'dimana', 'kapan', 'siapa', 'yang', 'dan', 'atau', 'the', 'is', 'how', 'what', 'where', 'saya', 'bisa', 'mau'];
        
        $words = preg_split('/\s+/', strtolower($text));
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });
        
        return array_values($keywords);
    }

    /**
     * Format AI answer
     */
    private function formatAnswer(array $kbResult, float $confidence): string
    {
        $content = strip_tags($kbResult['content']);
        $excerpt = mb_substr($content, 0, 300) . '...';
        
        $answer = $excerpt . "\n\n";
        $answer .= "📚 Sumber: {$kbResult['title']}\n";
        $answer .= "🔗 Baca selengkapnya: {$kbResult['url']}";
        
        if ($confidence < 0.8) {
            $answer .= "\n\n💡 Jika jawaban ini kurang membantu, saya akan menghubungkan Anda dengan tim support kami.";
        }
        
        return $answer;
    }

    /**
     * Generate chat summary for ticket
     */
    public function generateChatSummary(array $messages): string
    {
        $visitorMessages = array_filter($messages, fn($m) => $m['pengirim'] === 'pengunjung');
        
        if (empty($visitorMessages)) {
            return 'Chat tanpa pesan dari pengunjung.';
        }

        $firstMessage = reset($visitorMessages)['pesan'];
        $messageCount = count($visitorMessages);
        
        return "Pengunjung memulai chat dengan: \"{$firstMessage}\"\n" .
               "Total {$messageCount} pesan dari pengunjung.\n" .
               "AI tidak dapat memberikan solusi yang memuaskan.";
    }

    /**
     * Detect escalation intent
     */
    public function detectEscalationIntent(string $message): bool
    {
        $escalationKeywords = [
            'human', 'agent', 'support', 'help', 'manusia', 
            'customer service', 'cs', 'operator', 'staff', 'bicara dengan'
        ];
        
        $messageLower = strtolower($message);
        
        foreach ($escalationKeywords as $keyword) {
            if (str_contains($messageLower, $keyword)) {
                return true;
            }
        }
        
        return false;
    }
}
