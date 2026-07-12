<?php

namespace App\Modul\Tiket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketKategori;
use App\Modul\Tiket\Model\TiketPesan;
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
     * GET /api/shopify/tickets/{id}
     * Detail satu tiket + percakapan + lampiran
     */
    public function show(Request $request, int $id)
    {
        $tiket = Tiket::with(['lampiran', 'pesans' => fn($q) => $q->orderBy('created_at'), 'tiketKategori'])
            ->where('id', $id)
            ->where('shop_id', $request->header('X-Bridge-Shop'))
            ->firstOrFail();

        $pesans = $tiket->pesans->map(fn($p) => [
            'id'            => $p->id,
            'pesan'         => $p->pesan,
            'nama_pengirim' => $p->nama_pengirim,
            'is_admin'      => (bool) $p->is_admin,
            'created_at'    => $p->created_at->toISOString(),
        ]);

        $lampiran = $tiket->lampiran->map(fn($l) => [
            'id'        => $l->id,
            'nama_file' => $l->nama_file,
            'url'       => $l->url,
            'mime_type' => $l->mime_type,
            'is_image'  => $l->isImage(),
        ]);

        return response()->json([
            'tiket' => [
                'id'         => $tiket->id,
                'no_tiket'   => $tiket->no_tiket,
                'judul'      => $tiket->judul,
                'pesan_awal' => $tiket->pesan_awal,
                'status'     => $tiket->status,
                'prioritas'  => $tiket->prioritas,
                'kategori'   => $tiket->getRelation('tiketKategori')?->nama ?? $tiket->getRawOriginal('kategori'),
                'email'      => $tiket->email,
                'nama'       => $tiket->nama,
                'created_at' => $tiket->created_at->toISOString(),
                'pesans'     => $pesans,
                'lampiran'   => $lampiran,
            ],
        ]);
    }

    /**
     * POST /api/shopify/tickets/{id}/reply
     * Kirim balasan dari customer (bukan admin)
     */
    public function reply(Request $request, int $id)
    {
        $request->validate([
            'pesan' => 'required|string|max:5000',
            'nama'  => 'nullable|string|max:100',
        ]);

        $tiket = Tiket::where('id', $id)
            ->where('shop_id', $request->header('X-Bridge-Shop'))
            ->firstOrFail();

        // Jangan izinkan reply ke tiket yang sudah ditutup
        if ($tiket->status === 'ditutup') {
            return response()->json(['error' => 'Tiket sudah ditutup.'], 422);
        }

        $pesan = TiketPesan::create([
            'tiket_id'      => $tiket->id,
            'nama_pengirim' => $request->nama ?? $tiket->nama ?? $tiket->email,
            'pesan'         => $request->pesan,
            'is_admin'      => false,
        ]);

        // Jika status selesai, buka kembali ke terbuka saat customer reply
        if ($tiket->status === 'selesai') {
            $tiket->update(['status' => 'terbuka']);
        }

        return response()->json([
            'berhasil' => true,
            'pesan' => [
                'id'            => $pesan->id,
                'pesan'         => $pesan->pesan,
                'nama_pengirim' => $pesan->nama_pengirim,
                'is_admin'      => false,
                'created_at'    => $pesan->created_at->toISOString(),
            ],
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
