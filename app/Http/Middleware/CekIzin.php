<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CekIzin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $namaIzin): Response
    {
        $pengguna = $request->user();
        if (!$pengguna) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        // Cek izin di database via role (sangat sederhana untuk demo)
        $punyaIzin = DB::table('izin')
            ->join('peran_izin', 'izin.id', '=', 'peran_izin.izin_id')
            ->join('pengguna_peran', 'peran_izin.peran_id', '=', 'pengguna_peran.peran_id')
            ->where('pengguna_peran.pengguna_id', $pengguna->id)
            ->where('izin.slug', $namaIzin)
            ->exists();

        if (!$punyaIzin) {
            abort(403, "Anda tidak memiliki izin: {$namaIzin}");
        }

        return $next($request);
    }
}
