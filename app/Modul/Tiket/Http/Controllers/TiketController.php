<?php

namespace App\Modul\Tiket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use App\Modul\Tiket\Model\TiketKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function indeks(Request $request)
    {
        $query = Tiket::with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('category_id', $request->kategori_id);
        }

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('no_tiket', 'like', '%' . $request->cari . '%');
            });
        }

        $tikets = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = TiketKategori::where('aktif', true)->orderBy('urutan')->get();

        return view('tiket::indeks', compact('tikets', 'categories'));
    }

    public function tambah()
    {
        $categories = TiketKategori::where('aktif', true)->orderBy('urutan')->get();
        return view('tiket::tambah', compact('categories'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pesan' => 'required',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'category_id' => 'required|exists:tiket_categories,id',
        ]);

        $noTiket = 'TKT-' . strtoupper(substr(uniqid(), 7));

        $tiket = Tiket::create([
            'no_tiket' => $noTiket,
            'judul' => $request->judul,
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'category_id' => $request->category_id,
            'prioritas' => $request->prioritas,
            'status' => 'terbuka',
            'pesan_awal' => $request->pesan,
        ]);

        return redirect('/admin/tiket/detail/' . $tiket->id)->with('berhasil', 'Tiket baru berhasil dibuat.');
    }

    public function detail($id)
    {
        $tiket = Tiket::with(['kategori', 'lampiran', 'pesans' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->findOrFail($id);
        
        $categories = TiketKategori::where('aktif', true)->orderBy('urutan')->get();

        return view('tiket::detail', compact('tiket', 'categories'));
    }

    public function balas(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required',
        ]);

        $tiket = Tiket::findOrFail($id);

        TiketPesan::create([
            'tiket_id' => $tiket->id,
            'user_id' => Auth::id(),
            'nama_pengirim' => Auth::user()->nama,
            'pesan' => $request->pesan,
            'is_admin' => true,
        ]);

        // Jika status selesai, buka kembali jika dibalas? 
        // Biasanya kalau admin balas, status jadi 'proses'
        if ($tiket->status == 'terbuka' || $tiket->status == 'selesai') {
            $tiket->update(['status' => 'proses']);
        }

        return back()->with('berhasil', 'Balasan berhasil dikirim.');
    }

    public function gantiStatus(Request $request, $id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->update(['status' => $request->status]);

        return back()->with('berhasil', 'Status tiket diperbarui menjadi ' . $request->status);
    }

    public function hapus($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return redirect('/admin/tiket')->with('berhasil', 'Tiket berhasil dihapus.');
    }
}
