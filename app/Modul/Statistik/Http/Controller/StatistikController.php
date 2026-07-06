<?php

namespace App\Modul\Statistik\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Statistik\Model\Pengunjung;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function indeks()
    {
        // Statistik Ringkasan
        $totalPengunjung = Pengunjung::count();
        $totalHariIni = Pengunjung::where('tanggal', now()->toDateString())->count();
        $totalMingguIni = Pengunjung::where('tanggal', '>=', now()->startOfWeek())->count();
        
        // Data Grafik 7 Hari Terakhir
        $grafikData = Pengunjung::select('tanggal', DB::raw('count(*) as jumlah'))
            ->where('tanggal', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Top 5 Browser (Sederhana)
        $topPages = Pengunjung::select('url', DB::raw('count(*) as jumlah'))
            ->groupBy('url')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();

        // Top 5 Negara (Sidebar)
        $topCountries = Pengunjung::select('negara', 'kode_negara', DB::raw('count(*) as jumlah'))
            ->groupBy('negara', 'kode_negara')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();

        // Semua Negara untuk Peta
        $mapData = Pengunjung::select('negara', 'kode_negara', DB::raw('count(*) as jumlah'))
            ->whereNotNull('kode_negara')
            ->groupBy('negara', 'kode_negara')
            ->get();

        return view('statistik::indeks', compact(
            'totalPengunjung', 'totalHariIni', 'totalMingguIni', 'grafikData', 'topPages', 'topCountries', 'mapData'
        ));
    }
}
