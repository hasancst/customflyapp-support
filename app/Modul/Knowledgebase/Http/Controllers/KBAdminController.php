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

    /**
     * GET /admin/kb/search?q=term  — JSON search for ticket reply KB picker
     */
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));

        $articles = KBArticle::where('aktif', true)
            ->when($q, fn($query) => $query->where(function($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                      ->orWhere('konten', 'like', "%{$q}%");
            }))
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get(['id', 'judul', 'slug']);

        return response()->json($articles->map(fn($a) => [
            'id'    => $a->id,
            'judul' => $a->judul,
            'url'   => url('/kb/' . $a->slug),
        ]));
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
    public function indexArticle(Request $request)
    {
        $query = KBArticle::with('category');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('slug', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('category_id')) {
            $selectedId = (int) $request->category_id;
            // If selecting a parent, include all its children too
            $childIds = KBCategory::where('parent_id', $selectedId)->pluck('id')->toArray();
            $ids = array_merge([$selectedId], $childIds);
            $query->whereIn('category_id', $ids);
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->status === 'aktif');
        }

        $articles = $query->latest()->paginate(20)->withQueryString();

        // Build grouped list: parents with their children
        $categoryGroups = KBCategory::whereNull('parent_id')
            ->with(['children' => fn($q) => $q->orderBy('nama')])
            ->orderBy('nama')
            ->get();

        return view('knowledgebase::admin.article_index', compact('articles', 'categoryGroups'));
    }

    public function createArticle(Request $request)
    {
        $categories = KBCategory::all();
        if($categories->isEmpty()) return redirect('/admin/kb/category')->with('error', 'Buat kategori terlebih dahulu.');
        if ($request->get('panel')) {
            return view('knowledgebase::admin.article_create_panel', compact('categories'));
        }
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

    public function editArticle(Request $request, $id)
    {
        $article = KBArticle::findOrFail($id);
        $categories = KBCategory::all();
        if ($request->get('panel')) {
            return view('knowledgebase::admin.article_edit_panel', compact('article', 'categories'));
        }
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
        if ($request->ajax() || $request->get('panel')) {
            return response()->json(['berhasil' => true, 'pesan' => 'Artikel KB berhasil diperbarui.']);
        }
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

        $res = \App\Inti\AIClient::generate($prompt, ['json' => true]);
        if (!$res['berhasil']) {
            return response()->json(['berhasil' => false, 'pesan' => $res['pesan']]);
        }

        $aiData = \App\Inti\AIClient::decodeJson($res['text']);
        if (!$aiData) {
            return response()->json([
                'berhasil' => false,
                'pesan' => 'Gagal memproses format JSON dari AI. Silakan coba lagi.',
                'debug_raw' => substr($res['text'] ?? '', 0, 100)
            ]);
        }

        return response()->json([
            'berhasil' => true,
            'data' => $aiData
        ]);
    }
}
