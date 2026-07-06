<?php

namespace App\Modul\Slideshow\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Slideshow\Model\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function indeks()
    {
        $slideshow = Slideshow::orderBy('urutan')->get();
        return view('slideshow::indeks', compact('slideshow'));
    }

    public function tambah()
    {
        return view('slideshow::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required|file|max:2048',
        ]);

        if (!in_array(strtolower($request->file('gambar')->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return back()->withInput()->withErrors(['gambar' => 'File harus berupa gambar (jpg, png, gif, webp).']);
        }

        $gambarPath = $request->file('gambar')->store('slideshow', 'public');

        Slideshow::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'badge_1' => $request->badge_1,
            'badge_2' => $request->badge_2,
            'gambar' => $gambarPath,
            'url' => $request->url,
            'urutan' => $request->urutan ?? 0,
            'aktif' => true,
        ]);

        return redirect('/admin/slideshow')->with('berhasil', 'Slideshow berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $slide = Slideshow::findOrFail($id);
        return view('slideshow::ubah', compact('slide'));
    }

    public function perbarui(Request $request, $id)
    {
        $slide = Slideshow::findOrFail($id);
        
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('gambar') && !in_array(strtolower($request->file('gambar')->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return back()->withInput()->withErrors(['gambar' => 'File harus berupa gambar (jpg, png, gif, webp).']);
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'badge_1' => $request->badge_1,
            'badge_2' => $request->badge_2,
            'url' => $request->url,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ];

        if ($request->hasFile('gambar')) {
            if ($slide->gambar) {
                Storage::disk('public')->delete($slide->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('slideshow', 'public');
        }

        $slide->update($data);

        return redirect('/admin/slideshow')->with('berhasil', 'Slideshow berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $slide = Slideshow::findOrFail($id);
        if ($slide->gambar) {
            Storage::disk('public')->delete($slide->gambar);
        }
        $slide->delete();
        return redirect('/admin/slideshow')->with('berhasil', 'Slideshow berhasil dihapus.');
    }
}
