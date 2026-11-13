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

    private function prosesGaleri(Request $request, array $existing = []): array
    {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $galeri = [];

        for ($i = 1; $i <= 4; $i++) {
            $slot = $existing[$i - 1] ?? null;

            if ($request->boolean("hapus_galeri_{$i}") && $slot) {
                if (Storage::disk('public')->exists($slot)) {
                    Storage::disk('public')->delete($slot);
                }
                $slot = null;
            }

            if ($request->hasFile("galeri_{$i}")) {
                $file = $request->file("galeri_{$i}");
                if (!in_array(strtolower($file->getClientOriginalExtension()), $allowed)) {
                    abort(back()->withInput()->withErrors(["galeri_{$i}" => "Gambar {$i} harus berupa jpg, png, gif, webp, atau svg."]));
                }
                if ($slot && Storage::disk('public')->exists($slot)) {
                    Storage::disk('public')->delete($slot);
                }
                $slot = $file->store('portofolio', 'public');
            }

            if ($slot) {
                $galeri[] = $slot;
            }
        }

        return $galeri;
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required|file|max:2048',
            'galeri_1' => 'nullable|file|max:2048',
            'galeri_2' => 'nullable|file|max:2048',
            'galeri_3' => 'nullable|file|max:2048',
            'galeri_4' => 'nullable|file|max:2048',
        ]);

        if (!in_array(strtolower($request->file('gambar')->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
            return back()->withInput()->withErrors(['gambar' => 'File harus berupa gambar (jpg, png, gif, webp, svg).']);
        }

        $gambarPath = $request->file('gambar')->store('portofolio', 'public');
        $galeri = $this->prosesGaleri($request);

        Portofolio::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'kategori' => $request->kategori,
            'klien' => $request->klien,
            'tags' => $request->tags,
            'gambar' => $gambarPath,
            'galeri' => $galeri,
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
            'galeri_1' => 'nullable|file|max:2048',
            'galeri_2' => 'nullable|file|max:2048',
            'galeri_3' => 'nullable|file|max:2048',
            'galeri_4' => 'nullable|file|max:2048',
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
            'galeri' => $this->prosesGaleri($request, is_array($item->galeri) ? $item->galeri : []),
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
        foreach ((is_array($item->galeri) ? $item->galeri : []) as $g) {
            if ($g && Storage::disk('public')->exists($g)) {
                Storage::disk('public')->delete($g);
            }
        }
        $item->delete();
        return redirect('/admin/portofolio')->with('berhasil', 'Portofolio berhasil dihapus.');
    }
}
