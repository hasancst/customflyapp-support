<?php

namespace App\Modul\Tiket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketKategori;
use Illuminate\Http\Request;

class TiketPublikController extends Controller
{
    /**
     * GET /api/shopify/tickets?email=...&shop=...
     * Daftar tiket milik customer, include jumlah lampiran
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'shop'  => 'required|string',
        ]);

        $tikets = Tiket::with('lampiran')
            ->where('email', $request->email)
            ->where('shop_id', $request->shop)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($t) => [
                'id'              => $t->id,
                'no_tiket'        => $t->no_tiket,
                'judul'           => $t->judul,
                'status'          => $t->status,
                'prioritas'       => $t->prioritas,
                'created_at'      => $t->created_at->toISOString(),
                'lampiran_count'  => $t->lampiran->count(),
            ]);

        return response()->json(['tikets' => $tikets]);
    }

    /**
     * POST /api/shopify/tickets
     * Buat tiket baru, dukung category_id dari Shopify App
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'pesan'       => 'required|string',
            'email'       => 'required|email',
            'nama'        => 'required|string|max:100',
            'shop'        => 'required|string',
            'prioritas'   => 'nullable|in:rendah,sedang,tinggi',
            'category_id' => 'nullable|exists:tiket_categories,id',
        ]);

        // Jika category_id tidak dikirim, fallback ke sub-kategori pertama Customfly
        $categoryId = $request->category_id;
        if (!$categoryId) {
            $customfly  = TiketKategori::where('nama', 'Customfly')->whereNull('parent_id')->first();
            $kategori   = $customfly
                ? TiketKategori::where('parent_id', $customfly->id)->orderBy('urutan')->first()
                : TiketKategori::orderBy('id')->first();
            $categoryId = $kategori?->id;
        }

        $noTiket = 'TKT-' . strtoupper(substr(uniqid(), -6));

        $tiket = Tiket::create([
            'no_tiket'    => $noTiket,
            'judul'       => $request->judul,
            'email'       => $request->email,
            'nama'        => $request->nama,
            'shop_id'     => $request->shop,
            'pesan_awal'  => $request->pesan,
            'prioritas'   => $request->prioritas ?? 'sedang',
            'status'      => 'terbuka',
            'category_id' => $categoryId,
        ]);

        return response()->json([
            'berhasil' => true,
            'no_tiket' => $tiket->no_tiket,
            'tiket_id' => $tiket->id,
        ], 201);
    }

    /**
     * GET /api/shopify/categories?parent=Customfly
     * Sub-kategori dari parent tertentu (default: Customfly)
     * Digunakan oleh Shopify App untuk dropdown kategori tiket
     */
    public function categories(Request $request)
    {
        $parentNama = $request->input('parent', 'Customfly');

        $parent = TiketKategori::where('nama', $parentNama)
            ->whereNull('parent_id')
            ->first();

        if (!$parent) {
            return response()->json(['categories' => []]);
        }

        $categories = TiketKategori::where('parent_id', $parent->id)
            ->where('aktif', true)
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get()
            ->map(fn($c) => [
                'id'   => $c->id,
                'nama' => $c->nama,
                'slug' => $c->slug,
            ]);

        return response()->json(['categories' => $categories]);
    }
}
