<?php

namespace App\Modul\Knowledgebase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Knowledgebase\Model\KBArticle;
use App\Modul\Knowledgebase\Model\KBCategory;
use Illuminate\Http\Request;

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
}
