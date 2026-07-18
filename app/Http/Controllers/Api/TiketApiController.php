<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use App\Modul\Tiket\Model\TiketKategori;
use Illuminate\Http\Request;

class TiketApiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query  = Tiket::with('tiketKategori')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $tiket = $query->paginate(20);

        return response()->json(['success' => true, 'data' => $tiket]);
    }

    public function show($id)
    {
        $tiket = Tiket::with(['tiketKategori', 'pesans' => function($q) {
            $q->orderBy('created_at', 'asc');
        }, 'lampiran'])->findOrFail($id);

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

        if ($tiket->status == 'terbuka' || $tiket->status == 'selesai') {
            $tiket->update(['status' => 'proses']);
        }

        return response()->json(['success' => true, 'data' => $pesan]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:terbuka,proses,selesai']);

        $tiket = Tiket::findOrFail($id);
        $tiket->update(['status' => $request->status]);

        return response()->json(['success' => true, 'data' => $tiket]);
    }
}
