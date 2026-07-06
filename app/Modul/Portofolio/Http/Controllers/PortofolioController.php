<?php

namespace App\Modul\Portofolio\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Portofolio\Model\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortofolioController extends Controller
{
    public function indeks()
    {
        $portofolio = Portofolio::orderBy('urutan')->get();
        return view('portofolio::indeks', compact('portofolio'));
    }

    public function tambah()
    {
        return view('portofolio::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required|file|max:2048',
        ]);

        if (!in_array(strtolower($request->file('gambar')->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
            return back()->withInput()->withErrors(['gambar' => 'File harus berupa gambar (jpg, png, gif, webp, svg).']);
        }

        $gambarPath = $request->file('gambar')->store('portofolio', 'public');

        Portofolio::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'kategori' => $request->kategori,
            'klien' => $request->klien,
            'tags' => $request->tags,
            'gambar' => $gambarPath,
            'deskripsi' => $request->deskripsi,
            'url' => $request->url,
            'tanggal' => $request->tanggal,
            'urutan' => $request->urutan ?? 0,
            'aktif' => true,
        ]);

        return redirect('/admin/portofolio')->with('berhasil', 'Portofolio berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $item = Portofolio::findOrFail($id);
        return view('portofolio::ubah', compact('item'));
    }

    public function perbarui(Request $request, $id)
    {
        $item = Portofolio::findOrFail($id);
        
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('gambar') && !in_array(strtolower($request->file('gambar')->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
            return back()->withInput()->withErrors(['gambar' => 'File harus berupa gambar (jpg, png, gif, webp, svg).']);
        }

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'kategori' => $request->kategori,
            'klien' => $request->klien,
            'tags' => $request->tags,
            'deskripsi' => $request->deskripsi,
            'url' => $request->url,
            'tanggal' => $request->tanggal,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ];

        if ($request->hasFile('gambar')) {
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        $item->update($data);

        return redirect('/admin/portofolio')->with('berhasil', 'Portofolio berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $item = Portofolio::findOrFail($id);
        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }
        $item->delete();
        return redirect('/admin/portofolio')->with('berhasil', 'Portofolio berhasil dihapus.');
    }
}
