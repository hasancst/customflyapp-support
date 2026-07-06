<?php

namespace App\Modul\Statistik\Http\Middleware;

use Closure;
use App\Modul\Statistik\Model\Pengunjung;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class CatatPengunjung
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan catat request admin, API, atau file statis
        $path = $request->path();
        $isAsset = preg_match('/\.(jpg|jpeg|png|gif|svg|webp|ico|css|js|map)$/i', $path);

        if (!$request->is('admin*') && !$request->expectsJson() && !$isAsset) {
            
            $ip = $request->ip();
            $countryData = session('visitor_geo_' . $ip);

            if (!$countryData) {
                try {
                    // Gunakan IP-API (Free)
                    $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                    if ($response->successful()) {
                        $data = $response->json();
                        $countryData = [
                            'negara' => $data['country'] ?? 'Unknown',
                            'kode_negara' => $data['countryCode'] ?? '??'
                        ];
                        // Simpan di session agar tidak hit API terus menerus dalam satu sesi
                        session(['visitor_geo_' . $ip => $countryData]);
                    }
                } catch (\Exception $e) {
                    $countryData = ['negara' => 'Unknown', 'kode_negara' => '??'];
                }
            }

            Pengunjung::create([
                'ip' => $ip,
                'negara' => $countryData['negara'] ?? 'Unknown',
                'kode_negara' => $countryData['kode_negara'] ?? '??',
                'perangkat' => $request->header('User-Agent'),
                'url' => $request->url(),
                'referensi' => $request->header('referer'),
                'tanggal' => now()->toDateString(),
            ]);
        }

        return $next($request);
    }
}
