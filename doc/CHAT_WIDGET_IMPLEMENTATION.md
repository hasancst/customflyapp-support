# AI-Powered Chat Widget System - Complete Implementation Guide

## System Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    CHAT WIDGET (Frontend)                    │
│  - Embeddable JavaScript                                     │
│  - Session Management                                        │
│  - Real-time UI                                              │
└──────────────────────┬──────────────────────────────────────┘
                       │ REST API
┌──────────────────────▼──────────────────────────────────────┐
│                   LARAVEL BACKEND API                        │
│  ┌────────────┐  ┌──────────────┐  ┌───────────────┐       │
│  │   Chat     │  │  AI Engine   │  │   Ticket      │       │
│  │ Controller │──│  - KB Search │──│  Auto-Create  │       │
│  └────────────┘  │  - Scoring   │  └───────────────┘       │
│                  │  - Summary   │                           │
│                  └──────────────┘                           │
└──────────────────────┬──────────────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────────────┐
│                    DATA LAYER                                │
│  - chat_sessions                                             │
│  - chat_messages                                             │
│  - chat_widgets (multi-tenant)                               │
│  - Existing: kb_articles, tikets                             │
└─────────────────────────────────────────────────────────────┘
```

## Database Schema

### Migration: chat_widgets table
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('public_key')->unique();
            $table->string('secret_key');
            $table->string('domain')->nullable(); // allowed domain
            $table->json('settings')->nullable(); // widget customization
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_widgets');
    }
};
```

### Migration: chat_sessions table
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('widget_id')->constrained('chat_widgets')->onDelete('cascade');
            $table->string('session_token')->unique();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('visitor_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('page_url')->nullable();
            $table->enum('status', ['active', 'resolved', 'escalated'])->default('active');
            $table->foreignId('ticket_id')->nullable()->constrained('tikets')->onDelete('set null');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_sessions');
    }
};
```

### Migration: chat_messages table
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('chat_sessions')->onDelete('cascade');
            $table->enum('sender_type', ['visitor', 'ai', 'agent']);
            $table->text('message');
            $table->json('metadata')->nullable(); // AI confidence, KB article ID, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
};
```

## Models

### ChatWidget Model
```php
<?php

namespace App\Modul\Chat\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatWidget extends Model
{
    protected $fillable = [
        'name',
        'public_key',
        'secret_key',
        'domain',
        'settings',
        'active'
    ];

    protected $casts = [
        'settings' => 'array',
        'active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($widget) {
            $widget->public_key = 'pk_' . Str::random(32);
            $widget->secret_key = 'sk_' . Str::random(32);
        });
    }

    public function sessions()
    {
        return $this->hasMany(ChatSession::class, 'widget_id');
    }
}
```

### ChatSession Model
```php
<?php

namespace App\Modul\Chat\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Modul\Tiket\Model\Tiket;

class ChatSession extends Model
{
    protected $fillable = [
        'widget_id',
        'session_token',
        'visitor_name',
        'visitor_email',
        'visitor_ip',
        'user_agent',
        'page_url',
        'status',
        'ticket_id',
        'last_activity_at'
    ];

    protected $casts = [
        'last_activity_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($session) {
            $session->session_token = Str::random(64);
            $session->last_activity_at = now();
        });
    }

    public function widget()
    {
        return $this->belongsTo(ChatWidget::class, 'widget_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Tiket::class, 'ticket_id');
    }

    public function updateActivity()
    {
        $this->update(['last_activity_at' => now()]);
    }
}
```

### ChatMessage Model
```php
<?php

namespace App\Modul\Chat\Model;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'sender_type',
        'message',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function session()
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}
```

## Core Services

### AIService - Knowledge Base Search & Confidence Scoring
```php
<?php

namespace App\Modul\Chat\Services;

use App\Modul\Knowledgebase\Model\KBArticle;
use Illuminate\Support\Facades\DB;

class AIService
{
    private const CONFIDENCE_THRESHOLD = 0.65;
    private const MAX_RESULTS = 3;

    /**
     * Search KB and generate AI response with confidence score
     */
    public function generateResponse(string $query): array
    {
        // Search Knowledge Base
        $kbResults = $this->searchKnowledgeBase($query);
        
        if (empty($kbResults)) {
            return [
                'answer' => null,
                'confidence' => 0,
                'kb_articles' => [],
                'should_escalate' => true
            ];
        }

        // Calculate confidence based on relevance
        $topResult = $kbResults[0];
        $confidence = $this->calculateConfidence($query, $topResult);
        
        // Generate answer from top KB article
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
                'url' => route('kb.article', $article->slug),
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
        
        // Boost confidence if exact keyword match
        $queryLower = strtolower($query);
        $titleLower = strtolower($kbResult['title']);
        
        if (str_contains($titleLower, $queryLower)) {
            $relevance += 0.2;
        }
        
        return min(1.0, $relevance);
    }

    /**
     * Calculate relevance score between query and article
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
        $stopWords = ['apa', 'bagaimana', 'kenapa', 'dimana', 'kapan', 'siapa', 'yang', 'dan', 'atau', 'the', 'is', 'how', 'what', 'where'];
        
        $words = preg_split('/\s+/', strtolower($text));
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });
        
        return array_values($keywords);
    }

    /**
     * Format AI answer with confidence indicator
     */
    private function formatAnswer(array $kbResult, float $confidence): string
    {
        $content = strip_tags($kbResult['content']);
        $excerpt = substr($content, 0, 300) . '...';
        
        $answer = $excerpt . "\n\n";
        $answer .= "📚 Sumber: [{$kbResult['title']}]({$kbResult['url']})";
        
        if ($confidence < 0.8) {
            $answer .= "\n\n💡 Jika jawaban ini kurang membantu, saya akan menghubungkan Anda dengan tim support kami.";
        }
        
        return $answer;
    }

    /**
     * Generate chat summary for ticket creation
     */
    public function generateChatSummary(array $messages): string
    {
        $visitorMessages = array_filter($messages, fn($m) => $m['sender_type'] === 'visitor');
        
        if (empty($visitorMessages)) {
            return 'Chat tanpa pesan dari visitor.';
        }

        $firstMessage = reset($visitorMessages)['message'];
        $messageCount = count($visitorMessages);
        
        return "Visitor memulai chat dengan: \"{$firstMessage}\"\n" .
               "Total {$messageCount} pesan dari visitor.\n" .
               "AI tidak dapat memberikan solusi yang memuaskan.";
    }

    /**
     * Detect escalation intent from user message
     */
    public function detectEscalationIntent(string $message): bool
    {
        $escalationKeywords = [
            'human', 'agent', 'support', 'help', 'manusia', 
            'customer service', 'cs', 'operator', 'staff'
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
```

### TicketEscalationService
```php
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
        
        // Generate AI summary
        $summary = $this->aiService->generateChatSummary($messages);
        
        // Format chat transcript
        $transcript = $this->formatChatTranscript($messages);
        
        // Create ticket
        $ticket = Tiket::create([
            'judul' => $this->generateTicketTitle($messages),
            'deskripsi' => $summary . "\n\n--- Chat Transcript ---\n" . $transcript,
            'nama' => $session->visitor_name ?? 'Anonymous',
            'email' => $session->visitor_email ?? 'no-email@chat.widget',
            'prioritas' => $this->determinePriority($messages),
            'status' => 'terbuka',
            'kategori' => 'Chat Escalation'
        ]);

        // Link ticket to session
        $session->update([
            'ticket_id' => $ticket->id,
            'status' => 'escalated'
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
            $sender = match($msg['sender_type']) {
                'visitor' => 'Visitor',
                'ai' => 'AI Assistant',
                'agent' => 'Support Agent',
                default => 'Unknown'
            };
            
            $time = date('H:i', strtotime($msg['created_at']));
            $transcript .= "[{$time}] {$sender}: {$msg['message']}\n";
        }
        
        return $transcript;
    }

    /**
     * Generate ticket title from first visitor message
     */
    private function generateTicketTitle(array $messages): string
    {
        $firstVisitorMsg = collect($messages)
            ->firstWhere('sender_type', 'visitor');
        
        if (!$firstVisitorMsg) {
            return 'Chat Support Request';
        }
        
        $title = Str::limit($firstVisitorMsg['message'], 60);
        return "Chat: {$title}";
    }

    /**
     * Determine ticket priority based on message patterns
     */
    private function determinePriority(array $messages): string
    {
        $urgentKeywords = ['urgent', 'emergency', 'asap', 'critical', 'mendesak', 'darurat'];
        
        foreach ($messages as $msg) {
            if ($msg['sender_type'] === 'visitor') {
                $messageLower = strtolower($msg['message']);
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
        if ($session->last_activity_at->diffInMinutes(now()) > 10) {
            return true;
        }

        // Escalate if too many messages without resolution
        $messageCount = $session->messages()->where('sender_type', 'visitor')->count();
        if ($messageCount > 8) {
            return true;
        }

        return false;
    }
}
```

## API Routes

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Chat\Http\Controllers\ChatWidgetController;

// Public Chat Widget API (CORS enabled)
Route::prefix('api/chat')->middleware(['api', 'cors'])->group(function () {
    // Initialize chat session
    Route::post('/init', [ChatWidgetController::class, 'initSession']);
    
    // Send message
    Route::post('/message', [ChatWidgetController::class, 'sendMessage']);
    
    // Get chat history
    Route::get('/history/{sessionToken}', [ChatWidgetController::class, 'getHistory']);
    
    // Request human agent (escalate)
    Route::post('/escalate', [ChatWidgetController::class, 'escalate']);
    
    // End chat session
    Route::post('/end', [ChatWidgetController::class, 'endSession']);
});

// Admin Widget Management
Route::prefix('admin/chat-widget')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [ChatWidgetController::class, 'index']);
    Route::post('/create', [ChatWidgetController::class, 'createWidget']);
    Route::get('/sessions', [ChatWidgetController::class, 'listSessions']);
});
```

## Controller

```php
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
            ->where('active', true)
            ->first();

        if (!$widget) {
            return response()->json(['error' => 'Invalid widget key'], 401);
        }

        $session = ChatSession::create([
            'widget_id' => $widget->id,
            'visitor_name' => $request->visitor_name,
            'visitor_email' => $request->visitor_email,
            'visitor_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'page_url' => $request->page_url,
            'status' => 'active'
        ]);

        // Send welcome message
        ChatMessage::create([
            'session_id' => $session->id,
            'sender_type' => 'ai',
            'message' => 'Halo! 👋 Saya asisten AI. Ada yang bisa saya bantu?'
        ]);

        return response()->json([
            'session_token' => $session->session_token,
            'widget_settings' => $widget->settings
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
            'sender_type' => 'visitor',
            'message' => $request->message
        ]);

        $session->updateActivity();

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
            'sender_type' => 'ai',
            'message' => $aiResponse['answer'],
            'metadata' => [
                'confidence' => $aiResponse['confidence'],
                'kb_articles' => $aiResponse['kb_articles']
            ]
        ]);

        return response()->json([
            'message' => $aiMessage->message,
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
        if ($session->status === 'escalated') {
            return response()->json([
                'escalated' => true,
                'ticket_id' => $session->ticket_id,
                'message' => 'Tiket support Anda sudah dibuat sebelumnya.'
            ]);
        }

        $ticket = $this->escalationService->escalateToTicket($session);

        ChatMessage::create([
            'session_id' => $session->id,
            'sender_type' => 'ai',
            'message' => "Saya telah membuat tiket support untuk Anda. Tim kami akan segera menghubungi Anda melalui email. Nomor tiket: #{$ticket->id}"
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
                'sender' => $msg->sender_type,
                'message' => $msg->message,
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

        if ($session && $session->status === 'active') {
            $session->update(['status' => 'resolved']);
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
            'name' => 'required|string|max:100',
            'domain' => 'nullable|url'
        ]);

        $widget = ChatWidget::create([
            'name' => $request->name,
            'domain' => $request->domain,
            'settings' => [
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
        $sessions = ChatSession::with(['widget', 'ticket'])
            ->latest()
            ->paginate(20);

        return view('chat::admin.sessions', compact('sessions'));
    }
}
```

---

**CONTINUED IN NEXT FILE...**
