<?php

namespace App\Modul\Knowledgebase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Knowledgebase\Model\KBCategory;
use App\Modul\Knowledgebase\Model\KBArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class KBAdminController extends Controller
{
    // Category Management
    public function indexCategory()
    {
        $categories = KBCategory::with('parent')->orderBy('urutan')->get();
        return view('knowledgebase::admin.category_index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['nama' => 'required']);
        KBCategory::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'parent_id' => $request->parent_id,
            'ikon' => $request->ikon,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0
        ]);
        return back()->with('berhasil', 'Kategori KB berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $cat = KBCategory::findOrFail($id);
        
        // Prevent category from being its own parent
        if ($request->parent_id == $id) {
            return back()->with('error', 'Kategori tidak dapat menjadi induk dari dirinya sendiri.');
        }
        
        // Prevent circular reference (if new parent is a child of this category)
        if ($request->parent_id) {
            $checkParent = KBCategory::find($request->parent_id);
            while ($checkParent) {
                if ($checkParent->parent_id == $id) {
                    return back()->with('error', 'Tidak dapat membuat circular reference. Kategori yang dipilih adalah sub kategori dari kategori ini.');
                }
                $checkParent = $checkParent->parent;
            }
        }
        
        $cat->update($request->all());
        return back()->with('berhasil', 'Kategori KB berhasil diperbarui.');
    }

    public function deleteCategory($id)
    {
        KBCategory::findOrFail($id)->delete();
        return back()->with('berhasil', 'Kategori KB berhasil dihapus.');
    }

    // Article Management
    public function indexArticle()
    {
        $articles = KBArticle::with('category')->latest()->paginate(20);
        $categories = KBCategory::all();
        return view('knowledgebase::admin.article_index', compact('articles', 'categories'));
    }

    public function createArticle()
    {
        $categories = KBCategory::all();
        if($categories->isEmpty()) return redirect('/admin/kb/category')->with('error', 'Buat kategori terlebih dahulu.');
        return view('knowledgebase::admin.article_create', compact('categories'));
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'category_id' => 'required',
            'konten' => 'required'
        ]);

        KBArticle::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'category_id' => $request->category_id,
            'konten' => $request->konten,
            'aktif' => $request->has('aktif'),
            'urutan' => $request->urutan ?? 0,
            'tags' => $request->tags
        ]);

        return redirect('/admin/kb/article')->with('berhasil', 'Artikel KB berhasil disimpan.');
    }

    public function editArticle($id)
    {
        $article = KBArticle::findOrFail($id);
        $categories = KBCategory::all();
        return view('knowledgebase::admin.article_edit', compact('article', 'categories'));
    }

    public function updateArticle(Request $request, $id)
    {
        $article = KBArticle::findOrFail($id);
        $article->update([
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'konten' => $request->konten,
            'aktif' => $request->has('aktif'),
            'urutan' => $request->urutan ?? 0,
            'tags' => $request->tags
        ]);
        return redirect('/admin/kb/article')->with('berhasil', 'Artikel KB berhasil diperbarui.');
    }

    public function deleteArticle($id)
    {
        KBArticle::findOrFail($id)->delete();
        return back()->with('berhasil', 'Artikel KB berhasil dihapus.');
    }

    public function aiBantu(Request $request)
    {
        $request->validate([
            'perintah' => 'required|string',
            'judul' => 'nullable|string',
            'isi' => 'nullable|string',
        ]);

        $settings = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        $apiKey = $settings['ai_gemini_key'] ?? null;
        $model = $settings['ai_gemini_model'] ?? 'gemini-flash-latest';

        if (!$apiKey) {
            return response()->json(['berhasil' => false, 'pesan' => 'API Key Gemini belum diatur di Pengaturan.']);
        }

        $perintah = $request->perintah;
        $judul = $request->judul ?: '';
        $isi = strip_tags($request->isi ?: '');

        $prompt = "Kamu adalah AI Assistant Pakar Knowledge Base & Dokumentasi Teknis.
Instruksi: $perintah.

DATA INPUT ARTIKEL KB:
- Judul: $judul
- Konten: $isi
" . ($judul ? "" : "(Jika judul kosong, buatkan judul panduan yang jelas berdasarkan konteks)") . "

TUGAS:
1. Analisis data input.
2. Lakukan instruksi di atas dengan tepat untuk membuat artikel Knowledge Base yang sangat membantu, terstruktur, dan mudah dipahami.
3. Gunakan nada bicara yang membantu (helpful), sabar, dan jelas.
4. Gunakan format Markdown-like dalam HTML untuk instruksi langkah-demi-langkah jika diperlukan.

OUTPUT YANG DIHARAPKAN (FORMAT JSON):
{
  \"judul\": \"Judul panduan yang jelas dan spesifik\",
  \"isi\": \"Konten panduan lengkap dalam format HTML (gunakan tag <p>, <h3>, <strong>, <ul>, <ol>, <li>, <pre><code> etc)\",
  \"tags\": \"tag1, tag2, tag3, tag4, tag5\",
  \"alasan\": \"Singkat: apa yang telah ditingkatkan oleh AI?\"
}

PENTING: Hanya kembalikan JSON saja.";

        try {
            $response = Http::timeout(60)->withHeaders([
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
                return response()->json(['berhasil' => false, 'pesan' => 'Gagal dari Gemini: ' . $error . ' (HTTP ' . $response->status() . ')']);
            }

            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                return response()->json(['berhasil' => false, 'pesan' => 'Gemini tidak memberikan respon yang valid.']);
            }

            $text = trim($text);
            if (preg_match('/^```json\s+(.*?)\s+```$/s', $text, $matches)) {
                $text = $matches[1];
            } elseif (preg_match('/^```\s+(.*?)\s+```$/s', $text, $matches)) {
                $text = $matches[1];
            }
            
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
                    'pesan' => 'Gagal memproses format JSON dari AI. Silakan coba lagi.',
                    'debug_raw' => substr($text, 0, 100)
                ]);
            }

            return response()->json([
                'berhasil' => true,
                'data' => $aiData
            ]);

        } catch (\Exception $e) {
            return response()->json(['berhasil' => false, 'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
