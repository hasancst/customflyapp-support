<?php

namespace App\Modul\Knowledgebase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Knowledgebase\Model\KBArticle;
use App\Modul\Knowledgebase\Model\KBCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KBApiController extends Controller
{
    /**
     * GET /api/shopify/kb
     *
     * Scoped to Customfly app only (parent category id=3).
     * Without ?q: returns Customfly sub-categories with article counts
     *             and the 5 most-viewed active Customfly articles.
     * With ?q:    returns search results scoped to Customfly articles only.
     * With ?category_slug: returns articles in that specific sub-category.
     */
    public function index(Request $request)
    {
        $search       = $request->input('q');
        $categorySlug = $request->input('category_slug');

        // Get all Customfly sub-category IDs (parent_id = 3)
        $customflySubIds = KBCategory::where('parent_id', 3)->pluck('id');

        // ── Category article list ────────────────────────────────────────────
        if ($categorySlug) {
            $cat = KBCategory::where('slug', $categorySlug)
                ->whereIn('id', $customflySubIds)
                ->first();

            if (!$cat) {
                return response()->json(['berhasil' => false, 'data' => []]);
            }

            $articles = KBArticle::with('category')
                ->where('aktif', true)
                ->where('category_id', $cat->id)
                ->orderBy('urutan')
                ->orderBy('judul')
                ->get()
                ->map(fn($a) => [
                    'id'        => $a->id,
                    'judul'     => $a->judul,
                    'slug'      => $a->slug,
                    'ringkasan' => mb_substr(strip_tags($a->konten), 0, 160),
                    'views'     => $a->views,
                ]);

            return response()->json(['berhasil' => true, 'tipe' => 'kategori', 'kategori' => $cat->nama, 'artikel' => $articles]);
        }

        if ($search) {
            $results = KBArticle::with('category')
                ->where('aktif', true)
                ->whereIn('category_id', $customflySubIds)
                ->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                          ->orWhere('konten', 'like', "%{$search}%");
                })
                ->orderBy('views', 'desc')
                ->get()
                ->map(fn ($article) => [
                    'id'        => $article->id,
                    'judul'     => $article->judul,
                    'slug'      => $article->slug,
                    'ringkasan' => mb_substr(strip_tags($article->konten), 0, 160),
                    'views'     => $article->views,
                    'kategori'  => $article->category
                        ? ['id' => $article->category->id, 'nama' => $article->category->nama, 'slug' => $article->category->slug]
                        : null,
                ]);

            return response()->json([
                'berhasil' => true,
                'tipe'     => 'pencarian',
                'q'        => $search,
                'data'     => $results,
            ]);
        }

        // No search — return Customfly sub-categories with article count
        $categories = KBCategory::where('parent_id', 3)
            ->orderBy('urutan')
            ->get()
            ->map(function ($cat) {
                $count = KBArticle::where('category_id', $cat->id)->where('aktif', true)->count();
                return [
                    'id'             => $cat->id,
                    'nama'           => $cat->nama,
                    'slug'           => $cat->slug,
                    'ikon'           => $cat->ikon ?? null,
                    'deskripsi'      => $cat->deskripsi ?? null,
                    'jumlah_artikel' => $count,
                    'sub_kategori'   => [],
                ];
            });

        $popularArticles = KBArticle::with('category')
            ->where('aktif', true)
            ->whereIn('category_id', $customflySubIds)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get()
            ->map(fn ($article) => [
                'id'      => $article->id,
                'judul'   => $article->judul,
                'slug'    => $article->slug,
                'views'   => $article->views,
                'kategori' => $article->category
                    ? ['id' => $article->category->id, 'nama' => $article->category->nama, 'slug' => $article->category->slug]
                    : null,
            ]);

        return response()->json([
            'berhasil'        => true,
            'tipe'            => 'indeks',
            'kategori'        => $categories,
            'artikel_populer' => $popularArticles,
        ]);
    }

    /**
     * GET /api/shopify/kb/{slug}
     *
     * Returns a single active article by slug, increments its view count,
     * and includes up to 5 related articles from the same category.
     */
    public function article(string $slug)
    {
        $article = KBArticle::with('category')
            ->where('slug', $slug)
            ->where('aktif', true)
            ->first();

        if (! $article) {
            return response()->json([
                'berhasil' => false,
                'pesan'    => 'Artikel tidak ditemukan.',
            ], 404);
        }

        // Increment view count
        $article->increment('views');

        $related = KBArticle::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('aktif', true)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get()
            ->map(fn ($rel) => [
                'id'    => $rel->id,
                'judul' => $rel->judul,
                'slug'  => $rel->slug,
                'views' => $rel->views,
            ]);

        return response()->json([
            'berhasil' => true,
            'data'     => [
                'id'        => $article->id,
                'judul'     => $article->judul,
                'slug'      => $article->slug,
                'konten'    => $article->konten,
                'views'     => $article->views,
                'tags'      => $article->tags,
                'kategori'  => $article->category
                    ? [
                        'id'   => $article->category->id,
                        'nama' => $article->category->nama,
                        'slug' => $article->category->slug,
                        'ikon' => $article->category->ikon,
                    ]
                    : null,
                'artikel_terkait' => $related,
                'diperbarui_pada' => $article->updated_at,
            ],
        ]);
    }

    // === ADMIN API: CATEGORIES ===

    public function listCategories()
    {
        $categories = KBCategory::with('parent', 'children')->orderBy('urutan')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['nama' => 'required']);
        $category = KBCategory::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'parent_id' => $request->parent_id,
            'ikon' => $request->ikon,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0
        ]);
        return response()->json(['success' => true, 'data' => $category], 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = KBCategory::findOrFail($id);
        
        // Prevent category from being its own parent
        if ($request->parent_id == $id) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak dapat menjadi induk dari dirinya sendiri.'], 400);
        }
        
        // Prevent circular reference (if new parent is a child of this category)
        if ($request->parent_id) {
            $checkParent = KBCategory::find($request->parent_id);
            while ($checkParent) {
                if ($checkParent->parent_id == $id) {
                    return response()->json(['success' => false, 'message' => 'Tidak dapat membuat circular reference.'], 400);
                }
                $checkParent = $checkParent->parent;
            }
        }
        
        $data = $request->all();
        if ($request->has('nama')) {
            $data['slug'] = Str::slug($request->nama);
        }
        $category->update($data);
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function deleteCategory($id)
    {
        KBCategory::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // === ADMIN API: ARTICLES ===

    public function listArticles(Request $request)
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

        $articles = $query->latest()->paginate(20);
        return response()->json(['success' => true, 'data' => $articles]);
    }

    public function showArticle($id)
    {
        $article = KBArticle::with('category')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $article]);
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'category_id' => 'required',
            'konten' => 'required'
        ]);

        $article = KBArticle::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'category_id' => $request->category_id,
            'konten' => $request->konten,
            'aktif' => $request->boolean('aktif', true),
            'urutan' => $request->urutan ?? 0,
            'tags' => $request->tags
        ]);

        return response()->json(['success' => true, 'data' => $article], 201);
    }

    public function updateArticle(Request $request, $id)
    {
        $article = KBArticle::findOrFail($id);
        $data = $request->only('judul', 'category_id', 'konten', 'aktif', 'urutan', 'tags');
        if ($request->has('judul')) {
            $data['slug'] = Str::slug($request->judul);
        }
        $data['aktif'] = $request->boolean('aktif', $article->aktif);
        $article->update($data);
        return response()->json(['success' => true, 'data' => $article]);
    }

    public function deleteArticle($id)
    {
        KBArticle::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
