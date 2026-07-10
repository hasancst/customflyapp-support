<?php

namespace App\Modul\Tiket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\TiketMakro;
use Illuminate\Http\Request;

class TiketMakroController extends Controller
{
    public function index()
    {
        $makros = TiketMakro::orderBy('urutan')->orderBy('judul')->get();
        return view('tiket::admin.makro_index', compact('makros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
        ]);

        TiketMakro::create([
            'judul'  => $request->judul,
            'isi'    => $request->isi,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => $request->has('aktif'),
        ]);

        return back()->with('berhasil', 'Macro berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
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
            'aktif'  => $request->has('aktif'),
        ]);

        return back()->with('berhasil', 'Macro berhasil diperbarui.');
    }

    public function delete($id)
    {
        TiketMakro::findOrFail($id)->delete();
        return back()->with('berhasil', 'Macro berhasil dihapus.');
    }

    /**
     * API: return active macros as JSON for the detail page dropdown
     */
    public function apiList()
    {
        $makros = TiketMakro::where('aktif', true)
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get(['id', 'judul', 'isi']);

        return response()->json($makros);
    }
}
