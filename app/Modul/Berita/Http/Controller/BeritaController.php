<?php

namespace App\Modul\Berita\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Berita\Model\Berita;
use App\Modul\Berita\Model\Kategori;
use App\Modul\Berita\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
    public function indeks(Request $request)
    {
        $query = Berita::with(['penulis', 'kategoris', 'tags'])->latest();

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            });
        }

        $berita = $query->paginate(20)->withQueryString();
        $kategori = Kategori::all();

        return view('berita::indeks', compact('berita', 'kategori'));
    }

    public function tambah()
    {
        $kategori = Kategori::all();
        return view('berita::tambah', compact('kategori'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_ids' => 'required|array',
            'gambar_utama' => 'nullable|file|max:2048',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return back()->withErrors(['gambar_utama' => 'File harus berupa gambar (jpg, jpeg, png, gif, webp).'])->withInput();
            }
        }

        $gambarPath = null;
        if ($request->hasFile('gambar_utama')) {
            $media = new \App\Inti\MediaManager();
            $gambarPath = $media->upload($request->file('gambar_utama'), 'berita/sampul');
        }

        $berita = Berita::create([
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'penulis_id' => auth()->id() ?: 1,
            'gambar_utama' => $gambarPath,
            'unggulan' => $request->has('unggulan'),
        ]);

        $berita->kategoris()->sync($request->kategori_ids);

        // Proses Tags
        if ($request->filled('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $name) {
                $name = trim($name);
                if ($name) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => str()->slug($name)],
                        ['nama' => $name]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $berita->tags()->sync($tagIds);
        }

        return redirect('/admin/blog')->with('berhasil', 'Berita berhasil disimpan.');
    }

    public function ubah(Request $request, $id)
    {
        $berita = Berita::with(['kategoris', 'tags'])->findOrFail($id);
        $kategori = Kategori::all();
        if ($request->get('panel')) {
            return view('berita::ubah_panel', compact('berita', 'kategori'));
        }
        return view('berita::ubah', compact('berita', 'kategori'));
    }

    public function perbarui(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_ids' => 'required|array',
            'gambar_utama' => 'nullable|file|max:2048',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return back()->withErrors(['gambar_utama' => 'File harus berupa gambar (jpg, jpeg, png, gif, webp).'])->withInput();
            }
        }

        $data = [
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'unggulan' => $request->has('unggulan'),
        ];

        if ($request->hasFile('gambar_utama')) {
            $media = new \App\Inti\MediaManager();
            $data['gambar_utama'] = $media->upload($request->file('gambar_utama'), 'berita/sampul');
        }

        $berita->update($data);
        $berita->kategoris()->sync($request->kategori_ids);

        // Proses Tags
        if ($request->filled('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $name) {
                $name = trim($name);
                if ($name) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => str()->slug($name)],
                        ['nama' => $name]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $berita->tags()->sync($tagIds);
        }

        if ($request->ajax() || $request->get('panel')) {
            return response()->json(['berhasil' => true, 'pesan' => 'Berita berhasil diperbarui.']);
        }
        return redirect('/admin/blog')->with('berhasil', 'Berita berhasil diperbarui.');
    }

    public function toggleUnggulan($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->unggulan = !$berita->unggulan;
        $berita->save();

        return back()->with('berhasil', 'Status unggulan berhasil diperbarui.');
    }

    public function quickKategori(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $berita->kategoris()->sync($request->kategori_ids);
        
        // Update the 'kategori' helper column as well
        $firstKategori = Kategori::whereIn('id', $request->kategori_ids)->first();
        if ($firstKategori) {
            $berita->kategori = $firstKategori->nama;
            $berita->save();
        }

        return back()->with('berhasil', 'Kategori berhasil diperbarui secara cepat.');
    }

    public function hapus($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return redirect('/admin/blog')->with('berhasil', 'Berita berhasil dihapus.');
    }

    public function formImportWP()
    {
        return view('berita::import_wp');
    }

    public function prosesImportWP(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $baseUrl = rtrim($request->url, '/');
        
        try {
            Artisan::call('modul:import-wp', ['url' => $baseUrl]);
            $output = Artisan::output();
            return redirect('/admin/blog')->with('berhasil', 'Import WordPress berhasil.');
        } catch (\Exception $e) {
            return back()->withErrors(['url' => 'Gagal import: ' . $e->getMessage()]);
        }
    }

    public function aiBantu(Request $request)
    {
        $request->validate([
            'perintah' => 'required|string',
            'judul' => 'nullable|string',
            'isi' => 'nullable|string',
            'isi_b64' => 'nullable|string',
        ]);

        $perintah = $request->perintah;
        $judul = $request->judul ?: '';
        $rawIsi = $request->filled('isi_b64')
            ? (base64_decode($request->isi_b64, true) ?: '')
            : ($request->isi ?: '');
        $isi = strip_tags($rawIsi);

        $prompt = "Kamu adalah AI Assistant Content Strategist & SEO Expert.
Instruksi: $perintah.

DATA INPUT:
- Judul: $judul
- Konten: $isi
" . ($judul ? "" : "(Jika judul kosong, buatkan judul yang menarik berdasarkan konteks)") . "

TUGAS:
1. Analisis data input.
2. Lakukan instruksi di atas dengan tepat.
3. Pastikan konten yang dihasilkan ramah SEO (Search Engine Optimization), AEO (Answer Engine Optimization), dan GEO (Generative Engine Optimization).

OUTPUT YANG DIHARAPKAN (FORMAT JSON):
{
  \"judul\": \"Judul hasil optimasi/pembuatan\",
  \"isi\": \"Konten lengkap dalam format HTML (gunakan tag <p>, <h3>, <strong>, <ul>, etc sesuai kebutuhan)\",
  \"ringkasan\": \"Ringkasan meta deskripsi/AEO (120-160 karakter)\",
  \"tags\": \"tag1, tag2, tag3, tag4, tag5\",
  \"alasan\": \"Singkat: apa yang dioptimasi?\"
}

PENTING: Hanya kembalikan JSON saja.";

        $res = \App\Inti\AIClient::generate($prompt, ['json' => true]);
        if (!$res['berhasil']) {
            return response()->json(['berhasil' => false, 'pesan' => $res['pesan']]);
        }

        $aiData = \App\Inti\AIClient::decodeJson($res['text']);
        if (!$aiData) {
            return response()->json([
                'berhasil' => false,
                'pesan' => 'Gagal memproses format JSON dari AI. Silakan coba lagi.',
                'debug_raw' => substr($res['text'] ?? '', 0, 100)
            ]);
        }

        return response()->json([
            'berhasil' => true,
            'data' => $aiData
        ]);
    }
}
