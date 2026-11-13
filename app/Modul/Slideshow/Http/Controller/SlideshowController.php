<?php

namespace App\Modul\Slideshow\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Slideshow\Model\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function indeks()
    {
        $slideshow = Slideshow::orderBy('urutan')->get();
        $pengaturanSlider = DB::table('pengaturan')
            ->whereIn('kunci', ['slider_3d_judul', 'slider_3d_deskripsi', 'slider_3d_sumber'])
            ->pluck('nilai', 'kunci')
            ->toArray();

        return view('slideshow::indeks', compact('slideshow', 'pengaturanSlider'));
    }

    public function simpanPengaturanSlider(Request $request)
    {
        $request->validate([
            'slider_3d_judul' => 'required|string|max:255',
            'slider_3d_deskripsi' => 'nullable|string|max:500',
            'slider_3d_sumber' => 'required|in:slideshow,gabungan',
        ]);

        $items = [
            'slider_3d_judul' => $request->input('slider_3d_judul'),
            'slider_3d_deskripsi' => $request->input('slider_3d_deskripsi', ''),
            'slider_3d_sumber' => $request->input('slider_3d_sumber'),
        ];

        foreach ($items as $kunci => $nilai) {
            DB::table('pengaturan')->updateOrInsert(
                ['kunci' => $kunci],
                ['nilai' => $nilai ?? '', 'updated_at' => now()]
            );
        }

        return redirect('/admin/slideshow')->with('berhasil', 'Pengaturan teks dan sumber gambar 3D Rotating Slider berhasil disimpan.');
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
