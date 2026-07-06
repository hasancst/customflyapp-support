<?php

namespace App\Modul\Knowledgebase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Knowledgebase\Model\KBCategory;
use App\Modul\Knowledgebase\Model\KBArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KBPublicController extends Controller
{
    public function index(Request $request)
    {
        $categories = KBCategory::whereNull('parent_id')->with('children')->withCount('articles')->orderBy('urutan')->get();
        $popularArticles = KBArticle::where('aktif', true)->orderBy('views', 'desc')->limit(5)->get();
        $pengaturan = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();

        // Search logic
        $search = $request->q;
        $results = null;
        if($search) {
            $results = KBArticle::where('aktif', true)
                ->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%$search%")
                      ->orWhere('konten', 'like', "%$search%");
                })->get();
        }

        return view('knowledgebase::public.index', compact('categories', 'popularArticles', 'pengaturan', 'results', 'search'));
    }

    public function showCategory($slug)
    {
        $category = KBCategory::with('children')->where('slug', $slug)->firstOrFail();
        $articles = KBArticle::where('category_id', $category->id)->where('aktif', true)->orderBy('urutan')->get();
        $pengaturan = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        
        return view('knowledgebase::public.category', compact('category', 'articles', 'pengaturan'));
    }

    public function showArticle($slug)
    {
        $article = KBArticle::with('category')->where('slug', $slug)->firstOrFail();
        
        // Update views
        $article->increment('views');
        
        $relatedArticles = KBArticle::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('aktif', true)
            ->limit(5)
            ->get();
            
        $pengaturan = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        
        return view('knowledgebase::public.article', compact('article', 'relatedArticles', 'pengaturan'));
    }

    public function aiAssistant(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500'
        ]);

        $settings = \DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        $apiKey = $settings['ai_gemini_key'] ?? null;
        $model = $settings['ai_gemini_model'] ?? 'gemini-2.0-flash-exp';

        if (!$apiKey) {
            return response()->json([
                'berhasil' => false, 
                'pesan' => 'AI Assistant belum dikonfigurasi. Silakan hubungi administrator.'
            ]);
        }

        $pertanyaan = $request->pertanyaan;

        // Get all active articles with their categories
        $articles = KBArticle::with('category')
            ->where('aktif', true)
            ->get()
            ->map(function($article) {
                return [
                    'judul' => $article->judul,
                    'kategori' => $article->category->nama ?? '',
                    'konten' => strip_tags($article->konten),
                    'slug' => $article->slug
                ];
            });

        $knowledgeContext = "KNOWLEDGE BASE ARTICLES:\n";
        foreach ($articles as $idx => $article) {
            $knowledgeContext .= "\n[" . ($idx + 1) . "] Judul: {$article['judul']}\n";
            $knowledgeContext .= "Kategori: {$article['kategori']}\n";
            $knowledgeContext .= "Konten: " . substr($article['konten'], 0, 500) . "...\n";
            $knowledgeContext .= "URL: /kb/{$article['slug']}\n";
        }

        $prompt = "Kamu adalah AI Assistant untuk Knowledge Base iMakeCustom.

KONTEKS KNOWLEDGE BASE:
$knowledgeContext

PERTANYAAN USER:
$pertanyaan

TUGAS:
1. Analisis pertanyaan user
2. Cari artikel yang paling relevan dari knowledge base di atas
3. Berikan jawaban yang informatif dan ramah
4. Jika ada artikel yang relevan, sebutkan artikel tersebut dengan link URL-nya
5. Jika tidak ada informasi yang relevan, katakan dengan sopan dan sarankan untuk menghubungi support

FORMAT JAWABAN (JSON):
{
  \"jawaban\": \"Jawaban lengkap dalam format HTML (gunakan <p>, <strong>, <ul>, <li>, <a> sesuai kebutuhan)\",
  \"artikel_relevan\": [
    {\"judul\": \"Judul Artikel\", \"url\": \"/kb/slug\"}
  ]
}

PENTING: Hanya kembalikan JSON saja, tanpa markdown code block.";

        try {
            $response = \Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_NONE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_NONE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_NONE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_NONE',
                    ],
                ]
            ]);

            if ($response->failed()) {
                $error = $response->json()['error']['message'] ?? 'Connection error';
                return response()->json([
                    'berhasil' => false, 
                    'pesan' => 'Gagal menghubungi AI: ' . $error
                ]);
            }

            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                return response()->json([
                    'berhasil' => false, 
                    'pesan' => 'AI tidak memberikan respon yang valid.'
                ]);
            }

            // Clean up markdown if any
            $text = trim($text);
            if (preg_match('/^```json\s+(.*?)\s+```$/s', $text, $matches)) {
                $text = $matches[1];
            } elseif (preg_match('/^```\s+(.*?)\s+```$/s', $text, $matches)) {
                $text = $matches[1];
            }

            // Extract JSON if wrapped in text
            if (!str_starts_with($text, '{')) {
                $start = strpos($text, '{');
                $end = strrpos($text, '}');
                if ($start !== false && $end !== false) {
                    $text = substr($text, $start, $end - $start + 1);
                }
            }

            $aiData = json_decode($text, true);
            if (!$aiData) {
                return response()->json([
                    'berhasil' => false,
                    'pesan' => 'Gagal memproses respon AI. Silakan coba lagi.'
                ]);
            }

            return response()->json([
                'berhasil' => true,
                'data' => $aiData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'berhasil' => false, 
                'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
