<?php

namespace App\Modul\Tiket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use App\Modul\Tiket\Model\TiketKategori;
use App\Modul\Tiket\Model\TiketLampiran;
use App\Modul\Tiket\Model\TiketMakro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TiketController extends Controller
{
    public function indeks(Request $request)
    {
        $query = Tiket::with(['tiketKategori.parent']);

        if ($request->filled('kategori_id')) {
            $selectedId = (int) $request->kategori_id;

            // If selecting a parent category, include all its children too
            $childIds = TiketKategori::where('parent_id', $selectedId)->pluck('id')->toArray();
            $ids = array_merge([$selectedId], $childIds);

            $query->whereIn('category_id', $ids);
        }

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('no_tiket', 'like', '%' . $request->cari . '%');
            });
        }

        $tikets = $query->orderBy('created_at', 'desc')->paginate(20);

        // Build ordered category list: parents first, children nested under their parent
        $parents = TiketKategori::where('aktif', true)
            ->whereNull('parent_id')
            ->with(['children' => fn($q) => $q->where('aktif', true)->orderBy('urutan')])
            ->orderBy('urutan')
            ->get();

        // Flatten into grouped list for the dropdown
        $categories = collect();
        foreach ($parents as $parent) {
            $categories->push($parent);
            foreach ($parent->children as $child) {
                $categories->push($child);
            }
        }

        // Preload client app per email (single query)
        $emails = $tikets->pluck('email')->filter()->unique()->values();
        $clientApps = \App\Models\Client::whereIn('email', $emails)
            ->pluck('app', 'email');

        return view('tiket::indeks', compact('tikets', 'categories', 'clientApps'));
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
        $tiket = Tiket::with(['tiketKategori', 'lampiran', 'pesans' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->findOrFail($id);
        
        $categories = TiketKategori::where('aktif', true)->orderBy('urutan')->get();
        $makros = \App\Modul\Tiket\Model\TiketMakro::where('aktif', true)
            ->orderBy('urutan')->orderBy('judul')->get(['id', 'judul', 'isi']);

        return view('tiket::detail', compact('tiket', 'categories', 'makros'));
    }

    public function balas(Request $request, $id)
    {
        $request->validate([
            'pesan'       => 'required',
            'lampiran.*'  => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,zip',
        ]);

        $tiket = Tiket::findOrFail($id);

        TiketPesan::create([
            'tiket_id'      => $tiket->id,
            'user_id'       => Auth::id(),
            'nama_pengirim' => Auth::user()->nama,
            'pesan'         => $request->pesan,
            'is_admin'      => true,
        ]);

        // Handle file attachments
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $ext  = $file->getClientOriginalExtension();
                $uuid = Str::uuid();
                $path = "tikets/{$tiket->id}/{$uuid}.{$ext}";

                Storage::disk('s3')->put($path, file_get_contents($file), 'public');
                $url = rtrim(config('filesystems.disks.s3.url'), '/') . '/' . $path;

                TiketLampiran::create([
                    'tiket_id'      => $tiket->id,
                    'nama_file'     => $file->getClientOriginalName(),
                    'path'          => $path,
                    'url'           => $url,
                    'mime_type'     => $file->getMimeType(),
                    'ukuran'        => $file->getSize(),
                    'diunggah_oleh' => Auth::user()->email,
                ]);
            }
        }

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
