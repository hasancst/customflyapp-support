<?php

namespace App\Modul\Komentar\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Komentar\Model\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function indeks()
    {
        $komentar = Komentar::with(['user', 'komentabel'])->latest()->get();
        return view('komentar::indeks', compact('komentar'));
    }

    public function setujui($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->update(['status' => 'disetujui']);
        return back()->with('berhasil', 'Komentar telah disetujui.');
    }

    public function tandaiSpam($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->update(['status' => 'spam']);
        return back()->with('berhasil', 'Komentar ditandai sebagai spam.');
    }

    public function hapus($id)
    {
        Komentar::destroy($id);
        return back()->with('berhasil', 'Komentar berhasil dihapus.');
    }

    // Fungsi Public untuk submit komentar
    public function kirim(Request $request)
    {
        $request->validate([
            'komentabel_id' => 'required',
            'komentabel_type' => 'required',
            'isi' => 'required|min:3',
            'nama' => auth()->check() ? 'nullable' : 'required',
            'email' => auth()->check() ? 'nullable' : 'required|email',
        ]);

        // Validasi CAPTCHA jika aktif
        $pengaturan = \Illuminate\Support\Facades\DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        if (($pengaturan['captcha_aktif'] ?? '0') == '1') {
            $secret = $pengaturan['captcha_secret_key'] ?? '';
            $response = $request->input('g-recaptcha-response');
            
            if (!$response) {
                return back()->withErrors(['captcha' => 'Silakan selesaikan CAPTCHA.'])->withInput();
            }

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
            $captchaSuccess = json_decode($verify);

            if (!$captchaSuccess->success) {
                return back()->withErrors(['captcha' => 'Verifikasi CAPTCHA gagal. Silakan coba lagi.'])->withInput();
            }
        }

        Komentar::create([
            'komentabel_id' => $request->komentabel_id,
            'komentabel_type' => $request->komentabel_type, // Misal: App\Modul\Berita\Model\Berita
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'isi' => $request->isi,
            'ip_address' => $request->ip(),
            'status' => 'pending' // Default moderasi aktif
        ]);

        return back()->with('berhasil', 'Komentar Anda telah terkirim dan sedang menunggu moderasi.');
    }
}
