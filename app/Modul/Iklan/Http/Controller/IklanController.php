<?php

namespace App\Modul\Iklan\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Iklan\Model\Iklan;
use Illuminate\Http\Request;
use App\Inti\MediaManager;

class IklanController extends Controller
{
    public function indeks()
    {
        $iklan = Iklan::latest()->get();
        return view('iklan::indeks', compact('iklan'));
    }

    public function tambah()
    {
        return view('iklan::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jenis' => 'required|in:gambar,script',
            'posisi' => 'required',
            'gambar' => 'required_if:jenis,gambar|file|max:2048',
            'script' => 'required_if:jenis,script',
            'link' => 'nullable|url'
        ]);

        if ($request->jenis == 'gambar' && $request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return back()->withErrors(['gambar' => 'File harus berupa gambar (jpg, jpeg, png, gif, webp).'])->withInput();
            }
        }

        $konten = $request->script;

        if ($request->jenis == 'gambar' && $request->hasFile('gambar')) {
            $media = new MediaManager();
            $konten = $media->upload($request->file('gambar'), 'iklan');
        }

        Iklan::create([
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'konten' => $konten,
            'posisi' => $request->posisi,
            'link' => $request->link,
            'aktif' => true
        ]);

        return redirect('/admin/iklan')->with('berhasil', 'Iklan berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $iklan = Iklan::findOrFail($id);
        return view('iklan::ubah', compact('iklan'));
    }

    public function perbarui(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);
        
        $request->validate([
            'judul' => 'required',
            'jenis' => 'required|in:gambar,script',
            'posisi' => 'required',
            'gambar' => 'nullable|file|max:2048',
            'script' => 'required_if:jenis,script',
            'link' => 'nullable|url'
        ]);

        if ($request->jenis == 'gambar' && $request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return back()->withErrors(['gambar' => 'File harus berupa gambar (jpg, jpeg, png, gif, webp).'])->withInput();
            }
        }

        $data = [
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'posisi' => $request->posisi,
            'link' => $request->link,
            'aktif' => $request->has('aktif')
        ];

        if ($request->jenis == 'script') {
            $data['konten'] = $request->script;
        }

        if ($request->jenis == 'gambar' && $request->hasFile('gambar')) {
            $media = new MediaManager();
            $data['konten'] = $media->upload($request->file('gambar'), 'iklan');
        }

        $iklan->update($data);

        return redirect('/admin/iklan')->with('berhasil', 'Iklan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->delete();
        return redirect('/admin/iklan')->with('berhasil', 'Iklan berhasil dihapus.');
    }
}
