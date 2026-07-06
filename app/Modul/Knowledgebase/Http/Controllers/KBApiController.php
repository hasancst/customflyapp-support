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
     * Without ?q: returns all top-level categories (with children + article count)
     *             and the 5 most-viewed active articles.
     * With ?q:    returns search results matching judul or konten.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');

        if ($search) {
            $results = KBArticle::with('category')
                ->where('aktif', true)
                ->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                          ->orWhere('konten', 'like', "%{$search}%");
                })
                ->orderBy('views', 'desc')
                ->get()
                ->map(fn ($article) => [
                    'id'       => $article->id,
                    'judul'    => $article->judul,
                    'slug'     => $article->slug,
                    'ringkasan' => mb_substr(strip_tags($article->konten), 0, 160),
                    'views'    => $article->views,
                    'kategori' => $article->category
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

        // No search — return categories + popular articles
        $categories = KBCategory::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->orderBy('urutan');
            }])
            ->withCount(['articles as jumlah_artikel'])
            ->orderBy('urutan')
            ->get()
            ->map(fn ($cat) => [
                'id'             => $cat->id,
                'nama'           => $cat->nama,
                'slug'           => $cat->slug,
                'ikon'           => $cat->ikon,
                'deskripsi'      => $cat->deskripsi,
                'jumlah_artikel' => $cat->jumlah_artikel,
                'sub_kategori'   => $cat->children->map(fn ($child) => [
                    'id'   => $child->id,
                    'nama' => $child->nama,
                    'slug' => $child->slug,
                    'ikon' => $child->ikon,
                ]),
            ]);

        $popularArticles = KBArticle::with('category')
            ->where('aktif', true)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get()
            ->map(fn ($article) => [
                'id'       => $article->id,
                'judul'    => $article->judul,
                'slug'     => $article->slug,
                'views'    => $article->views,
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
