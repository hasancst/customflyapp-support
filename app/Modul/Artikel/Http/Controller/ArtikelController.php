<?php

namespace App\Modul\Artikel\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Artikel\Model\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function indeks()
    {
        $artikel = Artikel::with('penulis')->latest()->get();
        return view('artikel::indeks', compact('artikel'));
    }

    public function tambah()
    {
        return view('artikel::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        Artikel::create([
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'isi' => $request->isi,
            'status' => 'terbit',
            'penulis_id' => auth()->id() ?? 1,
        ]);

        return redirect('/admin/artikel')->with('berhasil', 'Artikel berhasil disimpan.');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('artikel::edit', compact('artikel'));
    }

    public function perbarui(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->update([
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'isi' => $request->isi,
        ]);

        return redirect('/admin/artikel')->with('berhasil', 'Artikel berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        return redirect('/admin/artikel')->with('berhasil', 'Artikel berhasil dihapus.');
    }
}
