<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Berita\Model\Berita;
use App\Modul\Artikel\Model\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentApiController extends Controller
{
    // === NEWS (BERITA) ===

    public function listNews()
    {
        $news = Berita::with('kategoris')->latest()->paginate(20);
        return response()->json(['success' => true, 'data' => $news]);
    }

    public function showNews($id)
    {
        $news = Berita::with('kategoris')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $news]);
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
            'ringkasan' => 'nullable|string',
        ]);

        $news = Berita::create([
            'judul'       => $request->judul,
            'slug'        => Str::slug($request->judul),
            'ringkasan'   => $request->ringkasan ?? Str::limit(strip_tags($request->isi), 150),
            'isi'         => $request->isi,
            'penulis_id'  => $request->user()->id,
            'unggulan'    => $request->boolean('unggulan', false),
        ]);

        if ($request->has('kategori_ids')) {
            $news->kategoris()->sync($request->kategori_ids);
        }

        return response()->json(['success' => true, 'data' => $news], 201);
    }

    public function updateNews(Request $request, $id)
    {
        $news = Berita::findOrFail($id);
        
        $data = $request->only('judul', 'isi', 'ringkasan');
        if ($request->has('judul')) {
            $data['slug'] = Str::slug($request->judul);
        }
        if ($request->has('unggulan')) {
            $data['unggulan'] = $request->boolean('unggulan');
        }

        $news->update($data);

        if ($request->has('kategori_ids')) {
            $news->kategoris()->sync($request->kategori_ids);
        }

        return response()->json(['success' => true, 'data' => $news]);
    }

    public function deleteNews($id)
    {
        $news = Berita::findOrFail($id);
        $news->kategoris()->detach();
        $news->delete();
        return response()->json(['success' => true]);
    }


    // === ARTICLES (ARTIKEL) ===

    public function listArticles()
    {
        $articles = Artikel::latest()->paginate(20);
        return response()->json(['success' => true, 'data' => $articles]);
    }

    public function showArticle($id)
    {
        $article = Artikel::findOrFail($id);
        return response()->json(['success' => true, 'data' => $article]);
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'judul'  => 'required|string|max:255',
            'isi'    => 'required|string',
            'status' => 'required|in:draft,publikasi',
        ]);

        $article = Artikel::create([
            'judul'      => $request->judul,
            'slug'       => Str::slug($request->judul),
            'isi'        => $request->isi,
            'status'     => $request->status,
            'penulis_id' => $request->user()->id,
        ]);

        return response()->json(['success' => true, 'data' => $article], 201);
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Artikel::findOrFail($id);

        $data = $request->only('judul', 'isi', 'status');
        if ($request->has('judul')) {
            $data['slug'] = Str::slug($request->judul);
        }

        $article->update($data);

        return response()->json(['success' => true, 'data' => $article]);
    }

    public function deleteArticle($id)
    {
        $article = Artikel::findOrFail($id);
        $article->delete();
        return response()->json(['success' => true]);
    }
}
