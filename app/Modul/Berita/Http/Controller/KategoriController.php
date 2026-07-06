<?php

namespace App\Modul\Berita\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Berita\Model\Kategori;
use App\Modul\Menu\Model\Menu;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function indeks()
    {
        $kategori = Kategori::latest()->get();
        
        // Cek kategori mana saja yang sudah ada di menu
        $menuKategori = Menu::where('url', 'like', '/berita/kategori/%')
            ->get()
            ->groupBy('url');

        return view('berita::kategori.indeks', compact('kategori', 'menuKategori'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategori_berita,nama',
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'slug' => str()->slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('berhasil', 'Kategori baru berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('berita::kategori.ubah', compact('kategori'));
    }

    public function perbarui(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate([
            'nama' => 'required|unique:kategori_berita,nama,' . $id,
        ]);

        $kategori->update([
            'nama' => $request->nama,
            'slug' => str()->slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/admin/berita/kategori')->with('berhasil', 'Kategori berhasil diperbarui.');
    }

    public function hapus($id)
    {
        Kategori::destroy($id);
        return back()->with('berhasil', 'Kategori berhasil dihapus.');
    }

    public function keMenu(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $posisi = $request->posisi ?? 'header';

        // Cari urutan terakhir
        $urutan = Menu::where('posisi', $posisi)->max('urutan') ?? 0;

        Menu::create([
            'label' => $kategori->nama,
            'url' => '/berita/kategori/' . $kategori->slug,
            'posisi' => $posisi,
            'urutan' => $urutan + 1,
            'target' => '_self'
        ]);

        return back()->with('berhasil', "Kategori '{$kategori->nama}' berhasil ditambahkan ke menu {$posisi}.");
    }

    public function dariMenu(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $posisi = $request->posisi ?? 'header';
        $url = '/berita/kategori/' . $kategori->slug;

        Menu::where('url', $url)->where('posisi', $posisi)->delete();

        return back()->with('berhasil', "Kategori '{$kategori->nama}' berhasil dihapus dari menu {$posisi}.");
    }
}
