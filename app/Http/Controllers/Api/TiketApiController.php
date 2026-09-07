<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use App\Modul\Tiket\Model\TiketKategori;
use App\Modul\Tiket\Model\TiketMakro;
use App\Modul\Tiket\Services\TiketNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TiketApiController extends Controller
{
    protected $notificationService;

    public function __construct(TiketNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index(Request $request)
    {
        $status = $request->query('status');
        $kategoriId = $request->query('kategori_id');
        $query  = Tiket::with('tiketKategori.parent')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($kategoriId) {
            $selectedId = (int) $kategoriId;
            $childIds = TiketKategori::where('parent_id', $selectedId)->pluck('id')->toArray();
            $ids = array_merge([$selectedId], $childIds);
            $query->whereIn('category_id', $ids);
        }

        $tiket = $query->paginate(20);

        // Preload client name and app per email (single query)
        $emails = $tiket->pluck('email')->filter()->unique()->values();
        $clients = \App\Models\Client::whereIn('email', $emails)
            ->get(['email', 'name', 'app'])
            ->keyBy('email');

        $tiket->getCollection()->transform(function($t) use ($clients) {
            $client = $clients->get($t->email);
            $t->client_name = $client ? $client->name : null;
            $t->client_app = $client ? $client->app : null;
            return $t;
        });

        return response()->json(['success' => true, 'data' => $tiket]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'pesan_awal'    => 'required',
            'prioritas'     => 'required|in:rendah,sedang,tinggi',
            'category_id'   => 'required|exists:tiket_categories,id',
        ]);

        $noTiket = 'TKT-' . strtoupper(substr(uniqid(), 7));

        $tiket = Tiket::create([
            'no_tiket'      => $noTiket,
            'judul'         => $request->judul,
            'user_id'       => Auth::id(),
            'email'         => Auth::user()->email,
            'category_id'   => $request->category_id,
            'prioritas'     => $request->prioritas,
            'status'        => 'terbuka',
            'pesan_awal'    => $request->pesan_awal,
        ]);

        $this->notificationService->notifyNewTicket($tiket);

        return response()->json(['success' => true, 'data' => $tiket], 201);
    }

    public function show($id)
    {
        $tiket = Tiket::with(['tiketKategori.parent', 'pesans' => function($q) {
            $q->orderBy('created_at', 'asc');
        }, 'lampiran'])->findOrFail($id);

        $client = \App\Models\Client::where('email', $tiket->email)->first(['name', 'app']);
        $tiket->client_name = $client ? $client->name : null;
        $tiket->client_app = $client ? $client->app : null;

        return response()->json(['success' => true, 'data' => $tiket]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['pesan' => 'required|string']);

        $tiket = Tiket::findOrFail($id);

        $pesan = TiketPesan::create([
            'tiket_id'      => $tiket->id,
            'user_id'       => $request->user()->id,
            'nama_pengirim' => $request->user()->nama,
            'pesan'         => $request->pesan,
            'is_admin'      => true,
        ]);

        $statusLama = $tiket->status;
        if ($tiket->status == 'terbuka' || $tiket->status == 'selesai') {
            $tiket->update(['status' => 'proses']);
            if ($statusLama !== 'proses') {
                $this->notificationService->notifyStatusChange($tiket, $statusLama, 'proses');
            }
        }

        $this->notificationService->notifyTicketReply($tiket, $pesan);

        return response()->json(['success' => true, 'data' => $pesan]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:terbuka,proses,selesai,ditutup']);

        $tiket = Tiket::findOrFail($id);
        $statusLama = $tiket->status;
        $statusBaru = $request->status;
        $tiket->update(['status' => $statusBaru]);

        if ($statusLama !== $statusBaru) {
            $this->notificationService->notifyStatusChange($tiket, $statusLama, $statusBaru);
        }

        return response()->json(['success' => true, 'data' => $tiket]);
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return response()->json(['success' => true]);
    }

    // CATEGORIES
    public function categories()
    {
        $roots = TiketKategori::with(['children' => function ($q) {
            $q->orderBy('urutan')->orderBy('nama');
        }])
            ->whereNull('parent_id')
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        $categories = collect();
        foreach ($roots as $root) {
            $categories->push($root);
            foreach ($root->children as $child) {
                $categories->push($child);
            }
        }

        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function categoriesStore(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:tiket_categories,id',
        ]);

        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug(Str::slug($request->slug))
            : $this->generateUniqueSlug($request->nama);

        $cat = TiketKategori::create([
            'nama'      => $request->nama,
            'slug'      => $slug,
            'parent_id' => $request->parent_id ?: null,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->aktif ?? true,
        ]);

        return response()->json(['success' => true, 'data' => $cat], 201);
    }

    public function categoriesUpdate(Request $request, $id)
    {
        $cat = TiketKategori::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:tiket_categories,id',
        ]);

        if ($request->parent_id == $id) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak dapat menjadi induk dari dirinya sendiri.'], 422);
        }

        if ($request->parent_id) {
            $checkParent = TiketKategori::find($request->parent_id);
            while ($checkParent) {
                if ($checkParent->parent_id == $id) {
                    return response()->json(['success' => false, 'message' => 'Tidak dapat membuat circular reference.'], 422);
                }
                $checkParent = $checkParent->parent;
            }
        }

        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug(Str::slug($request->slug), $id)
            : $this->generateUniqueSlug($request->nama, $id);

        $cat->update([
            'nama'      => $request->nama,
            'slug'      => $slug,
            'parent_id' => $request->parent_id ?: null,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->aktif ?? true,
        ]);

        return response()->json(['success' => true, 'data' => $cat]);
    }

    public function categoriesDestroy($id)
    {
        TiketKategori::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // MACROS
    public function macros()
    {
        $makros = TiketMakro::orderBy('urutan')->orderBy('judul')->get();
        return response()->json(['success' => true, 'data' => $makros]);
    }

    public function macrosStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
        ]);

        $makro = TiketMakro::create([
            'judul'  => $request->judul,
            'isi'    => $request->isi,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => $request->aktif ?? true,
        ]);

        return response()->json(['success' => true, 'data' => $makro], 201);
    }

    public function macrosUpdate(Request $request, $id)
    {
        $makro = TiketMakro::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
        ]);

        $makro->update([
            'judul'  => $request->judul,
            'isi'    => $request->isi,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => $request->aktif ?? true,
        ]);

        return response()->json(['success' => true, 'data' => $makro]);
    }

    public function macrosDestroy($id)
    {
        TiketMakro::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function kbSearch(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (!$q) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $articles = \App\Modul\Knowledgebase\Model\KBArticle::where('aktif', true)
            ->where(function($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                      ->orWhere('konten', 'like', "%{$q}%");
            })
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get(['id', 'judul', 'slug']);

        $data = $articles->map(fn($a) => [
            'id'    => $a->id,
            'judul' => $a->judul,
            'url'   => url('/kb/' . $a->slug),
        ]);

        return response()->json(['success' => true, 'data' => $data]);
    }

    private function generateUniqueSlug(string $nama, ?int $excludeId = null): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $counter = 2;

        while (true) {
            $query = TiketKategori::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
