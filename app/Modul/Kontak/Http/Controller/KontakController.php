<?php

namespace App\Modul\Kontak\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Kontak\Model\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function indeks()
    {
        $pesan = Kontak::latest()->get();
        return view('kontak::indeks', compact('pesan'));
    }

    public function detail($id)
    {
        $pesan = Kontak::findOrFail($id);
        
        // Tandai sebagai dibaca
        if ($pesan->status == 'belum_dibaca') {
            $pesan->update(['status' => 'sudah_dibaca']);
        }

        return view('kontak::detail', compact('pesan'));
    }

    public function hapus($id)
    {
        Kontak::destroy($id);
        return redirect('/admin/kontak')->with('berhasil', 'Pesan kontak berhasil dihapus.');
    }

    // Fungsi untuk publik (bisa digunakan di frontend nanti)
    public function kirim(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required',
        ]);

        Kontak::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'perihal' => $request->perihal,
            'pesan' => $request->pesan,
        ]);

        return back()->with('berhasil', 'Pesan Anda telah dikirim. Terima kasih!');
    }
}
