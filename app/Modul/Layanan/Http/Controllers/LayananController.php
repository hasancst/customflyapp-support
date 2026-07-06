<?php

namespace App\Modul\Layanan\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Layanan\Model\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function indeks()
    {
        $layanans = Layanan::orderBy('urutan')->get();
        return view('layanan::indeks', compact('layanans'));
    }

    public function tambah()
    {
        return view('layanan::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        Layanan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'ikon' => $request->ikon,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect('/admin/layanan')->with('berhasil', 'Layanan berhasil ditambahkan');
    }

    public function ubah($id)
    {
        $item = Layanan::findOrFail($id);
        return view('layanan::ubah', compact('item'));
    }

    public function perbarui(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $item = Layanan::findOrFail($id);
        $item->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'ikon' => $request->ikon,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect('/admin/layanan')->with('berhasil', 'Layanan berhasil diperbarui');
    }

    public function hapus($id)
    {
        $item = Layanan::findOrFail($id);
        $item->delete();
        return redirect('/admin/layanan')->with('berhasil', 'Layanan berhasil dihapus');
    }
}
