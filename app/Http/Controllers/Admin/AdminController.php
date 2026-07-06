<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Inti\ZipExtractor;

class AdminController extends Controller
{
    /**
     * Dashboard Utama
     */
    public function dashboard()
    {
        $data = [
            'jumlahModul' => DB::table('modul')->where('aktif', true)->count(),
            'jumlahTema' => DB::table('tema')->count(),
            'jumlahPengguna' => DB::table('pengguna')->count(),
            'jumlahArtikel' => DB::table('artikel')->count(),
            'jumlahBerita' => DB::table('berita')->count(),
        ];
        
        // Data peta pengunjung
        $visitorData = [];
        try {
            $visitorData = DB::table('stat_pengunjung')
                ->select('kode_negara', 'negara', DB::raw('count(*) as total'))
                ->groupBy('kode_negara', 'negara')
                ->orderByDesc('total')
                ->get();
        } catch (\Exception $e) {
            // Table might not exist yet
        }
        
        // Data Berita Populer
        $popularPages = [];
        try {
            $popularPages = DB::table('stat_pengunjung')
                ->select('url', DB::raw('count(*) as total'))
                ->where('url', 'like', '%/berita/%')
                ->where('url', 'not like', '%.png%')
                ->where('url', 'not like', '%.jpg%')
                ->where('url', 'not like', '%.jpeg%')
                ->where('url', 'not like', '%.webp%')
                ->where('url', 'not like', '%.gif%')
                ->where('url', 'not like', '%.svg%')
                ->where('url', 'not like', '%.css%')
                ->where('url', 'not like', '%.js%')
                ->where('url', 'not like', '%.ico%')
                ->groupBy('url')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    // Extract path in case it's a full URL from another domain
                    $parsed = parse_url($item->url);
                    $path = $parsed['path'] ?? $item->url;
                    
                    // Coba ambil judul berita dari slug di URL
                    $slug = basename($path);
                    $berita = DB::table('berita')->where('slug', $slug)->first();
                    
                    if ($berita) {
                        $item->judul = $berita->judul;
                        // reconstruct URL with current domain
                        $item->url = url("berita/{$berita->kategori}/{$berita->slug}");
                    } else {
                        $item->judul = ucwords(str_replace(['-', '_'], ' ', $slug));
                        // Ensure URL is relative to current domain
                        $item->url = url($path);
                    }
                    
                    return $item;
                });
        } catch (\Exception $e) {
            // Ignore if table not found
        }
        
        return view('admin.dashboard', array_merge($data, [
            'visitorData' => $visitorData,
            'popularPages' => $popularPages
        ]));
    }

    /**
     * Manajemen Modul
     */
    public function indeksModul()
    {
        $folderModul = app_path('Modul');
        $directories = File::directories($folderModul);
        $modulTerpasang = DB::table('modul')->get();
        // Buat mapping case-insensitive
        $mappingModul = [];
        foreach ($modulTerpasang as $m) {
            $mappingModul[strtolower($m->slug)] = $m;
        }

        $daftarModul = [];
        foreach ($directories as $dir) {
            $slugDir = basename($dir);
            $slugLower = strtolower($slugDir);
            $manifestPath = $dir . '/manifest.json';
            
            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
                $isTerpasang = isset($mappingModul[$slugLower]);
                $modulData = $isTerpasang ? $mappingModul[$slugLower] : null;
                
                $daftarModul[] = [
                    'nama' => $manifest['nama'] ?? $slugDir,
                    'slug' => $slugDir, // Gunakan slug dari folder sebagai referensi utama
                    'versi' => $manifest['versi'] ?? '1.0.0',
                    'deskripsi' => $manifest['deskripsi'] ?? '',
                    'terpasang' => $isTerpasang,
                    'aktif' => $isTerpasang ? $modulData->aktif : false,
                ];
            }
        }

        return view('admin.modul.indeks', ['modul' => $daftarModul]);
    }

    public function pasangModul(Request $request)
    {
        $slug = $request->slug;
        Artisan::call('modul:pasang', ['slug' => $slug]);
        return back()->with('berhasil', "Modul {$slug} berhasil dipasang.");
    }

    public function aktifkanModul(Request $request)
    {
        $slug = $request->slug;
        // Update case-insensitive
        DB::table('modul')->whereRaw('LOWER(slug) = ?', [strtolower($slug)])->update(['aktif' => true]);
        return back()->with('berhasil', "Modul {$slug} diaktifkan.");
    }

    public function nonaktifkanModul(Request $request)
    {
        $slug = $request->slug;
        // Gunakan lower untuk memastikan ketemu di database pgsql
        DB::table('modul')->whereRaw('LOWER(slug) = ?', [strtolower($slug)])->update(['aktif' => false]);
        return back()->with('berhasil', "Modul {$slug} dinonaktifkan.");
    }

    public function copotModul(Request $request)
    {
        $slug = $request->slug;
        Artisan::call('modul:copot', ['slug' => $slug]);
        return back()->with('berhasil', "Modul {$slug} telah dicopot.");
    }

    public function unggahModul(Request $request)
    {
        $request->validate([
            'file_zip' => 'required|file|max:10240',
        ]);

        if (strtolower($request->file('file_zip')->getClientOriginalExtension()) !== 'zip') {
             return back()->withErrors(['file_zip' => 'File harus berupa arsip ZIP.']);
        }

        $zipPath = $request->file('file_zip')->path();
        $extractor = new ZipExtractor();
        
        if ($extractor->validasiModul($zipPath)) {
            // Kita butuh nama folder utama di dalam zip untuk slug
            // Sederhananya kita pakai nama file zip tanpa ekstensi atau random jika tidak ada folder
            $slug = pathinfo($request->file('file_zip')->getClientOriginalName(), PATHINFO_FILENAME);
            $tujuan = app_path("Modul/{$slug}");
            
            $extractor->ekstrak($zipPath, $tujuan);
            return back()->with('berhasil', "Modul diunggah ke folder {$slug}. Silakan klik pasang.");
        }

        return back()->withErrors(['error' => 'ZIP tidak valid atau tidak memiliki manifest.json']);
    }

    /**
     * Manajemen Tema
     */
    public function indeksTema()
    {
        $folderTema = resource_path('theme');
        $directories = File::directories($folderTema);
        $temaTerdaftar = DB::table('tema')->get()->keyBy('slug');

        $daftarTema = [];
        foreach ($directories as $dir) {
            $slug = basename($dir);
            $manifestPath = $dir . '/theme.json';
            
            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
                
                $daftarTema[] = [
                    'nama' => $manifest['nama'] ?? $slug,
                    'slug' => $slug,
                    'versi' => $manifest['versi'] ?? '1.0.0',
                    'aktif' => isset($temaTerdaftar[$slug]) ? $temaTerdaftar[$slug]->aktif : false,
                ];
            }
        }

        return view('admin.tema.indeks', ['tema' => $daftarTema]);
    }

    public function aktifkanTema(Request $request)
    {
        $slug = $request->slug;
        
        // Pastikan terdaftar di DB
        DB::table('tema')->updateOrInsert(
            ['slug' => $slug],
            [
                'nama' => $slug,
                'versi' => '1.0.0',
                'aktif' => false,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $themeManager = new \App\Inti\ThemeManager();
        $themeManager->setTema($slug);

        return back()->with('berhasil', "Tema {$slug} aktif.");
    }

    public function perbaruiTema(Request $request)
    {
        $slug = $request->slug;
        $nama = $request->nama;

        // Update di Database
        DB::table('tema')->where('slug', $slug)->update(['nama' => $nama, 'updated_at' => now()]);

        // Update di theme.json
        $manifestPath = resource_path("theme/{$slug}/theme.json");
        if (File::exists($manifestPath)) {
            $manifest = json_decode(File::get($manifestPath), true);
            $manifest['nama'] = $nama;
            File::put($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
        }

        return back()->with('berhasil', "Nama tema berhasil diperbarui.");
    }

    /**
     * Manajemen Pengaturan
     */
    public function indeksPengaturan()
    {
        $pengaturan = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function simpanPengaturan(Request $request)
    {
        $data = $request->except('_token', 'logo');
        
        // Handle Upload Logo
        if ($request->hasFile('logo')) {
            // Kita gunakan 'file' saja karena 'image' dan 'mimes' butuh ekstensi fileinfo yang tidak aktif di server ini
            $request->validate([
                'logo' => 'file|max:2048',
            ]);

            $file = $request->file('logo');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];

            if (!in_array($extension, $allowed)) {
                return back()->withErrors(['logo' => 'Format logo harus berupa gambar (jpg, png, gif, svg, webp).']);
            }

            try {
                $media = new \App\Inti\MediaManager();
                $path = $media->upload($file, 'situs'); // Upload ke folder situs
                 
                DB::table('pengaturan')->updateOrInsert(
                    ['kunci' => 'logo'],
                    ['nilai' => $path, 'updated_at' => now()]
                );
            } catch (\Exception $e) {
                return back()->withErrors(['logo' => 'Gagal mengunggah logo: ' . $e->getMessage()]);
            }
        }

        foreach ($data as $kunci => $nilai) {
            DB::table('pengaturan')->updateOrInsert(
                ['kunci' => $kunci],
                ['nilai' => $nilai, 'updated_at' => now()]
            );
        }

        // Sinkronisasi Redis ke .env
        if (isset($data['optimasi_redis_aktif'])) {
            $driver = $data['optimasi_redis_aktif'] == '1' ? 'redis' : 'database';
            $this->updateEnv('CACHE_STORE', $driver);
            $this->updateEnv('CACHE_DRIVER', $driver);
            
            if (isset($data['optimasi_redis_host'])) {
                $this->updateEnv('REDIS_HOST', $data['optimasi_redis_host']);
            }
            if (isset($data['optimasi_redis_port'])) {
                $this->updateEnv('REDIS_PORT', $data['optimasi_redis_port']);
            }
            if (isset($data['optimasi_redis_password'])) {
                $password = $data['optimasi_redis_password'] ?: 'null';
                $this->updateEnv('REDIS_PASSWORD', $password);
            }
        }

        // Pemeliharaan Mode Logic
        if (isset($data['fitur_pemeliharaan'])) {
            if ($data['fitur_pemeliharaan'] == '1') {
                Artisan::call('down', [
                    '--render' => 'errors.503',
                    '--secret' => 'admin-bypass'
                ]);
                
                // Manual update of the down file since some versions of Artisan::call('down') 
                // might not support multiple --except flags easily via array
                $downFile = storage_path('framework/down');
                if (file_exists($downFile)) {
                    $config = json_decode(file_get_contents($downFile), true);
                    $config['except'] = array_merge($config['except'] ?? [], [
                        'mlebu', 'mlebu/*', 'keluar', 'admin', 'admin/*'
                    ]);
                    // Unique and clean
                    $config['except'] = array_values(array_unique(array_map(function($path) {
                        return '/' . ltrim($path, '/');
                    }, $config['except'])));
                    file_put_contents($downFile, json_encode($config, JSON_PRETTY_PRINT));
                }
            } else {
                Artisan::call('up');
            }
        }

        return back()->with('berhasil', 'Pengaturan sistem berhasil diperbarui.');
    }

    public function testGemini(Request $request)
    {
        $request->validate([
            'api_key' => 'required',
            'model' => 'required'
        ]);

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativeLanguage.googleapis.com/v1beta/models/{$request->model}:generateContent?key={$request->api_key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'Test connection. Reply with "OK" only.']
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                return response()->json(['berhasil' => true, 'pesan' => 'Koneksi berhasil! ' . $response->json()['candidates'][0]['content']['parts'][0]['text']]);
            }

            $errorData = $response->json();
            $errorMessage = $errorData['error']['message'] ?? 'Unknown Error';
            return response()->json(['berhasil' => false, 'pesan' => 'Gagal: ' . $errorMessage . ' (HTTP ' . $response->status() . ')']);

        } catch (\Exception $e) {
            return response()->json(['berhasil' => false, 'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function unggahMedia(Request $request)
    {
        if ($request->hasFile('image')) {
            $media = new \App\Inti\MediaManager();
            $path = $media->upload($request->file('image'), 'berita');
            return response()->json(['url' => '/storage/' . $path]);
        }
        return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
    }

    /**
     * Manajemen Backup
     */
    public function buatBackup(Request $request)
    {
        $result = \App\Inti\DatabaseBackup::execute();

        if ($result['success']) {
            return response()->json([
                'berhasil' => true,
                'pesan' => 'Backup berhasil dibuat.',
                'file' => $result['file']
            ]);
        }

        return response()->json([
            'berhasil' => false,
            'pesan' => 'Gagal membuat backup. ' . ($result['error'] ?? '')
        ], 500);
    }

    public function daftarBackup()
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            return response()->json([]);
        }

        $files = File::files($backupDir);
        $data = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'sql') {
                $data[] = [
                    'nama' => $file->getFilename(),
                    'ukuran' => round($file->getSize() / 1024 / 1024, 2) . ' MB',
                    'tanggal' => date('d M Y H:i', $file->getMTime()),
                    'timestamp' => $file->getMTime()
                ];
            }
        }

        // Urutkan berdasarkan yang terbaru
        usort($data, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return response()->json($data);
    }

    public function unduhBackup($file)
    {
        $path = storage_path('app/backups/' . $file);
        if (File::exists($path)) {
            return response()->download($path);
        }
        return abort(404);
    }

    public function hapusBackup(Request $request)
    {
        $file = $request->file;
        $path = storage_path('app/backups/' . $file);
        if (File::exists($path)) {
            File::delete($path);
            return response()->json(['berhasil' => true]);
        }
        return response()->json(['berhasil' => false, 'pesan' => 'File tidak ditemukan.'], 404);
    }

    public function restoreBackup(Request $request)
    {
        $file = $request->file;
        $path = storage_path('app/backups/' . $file);
        
        if (!File::exists($path)) {
            if (File::exists(base_path($file))) {
                $path = base_path($file);
            } else {
                return response()->json(['berhasil' => false, 'pesan' => 'File tidak ditemukan.'], 404);
            }
        }

        $result = \App\Inti\DatabaseBackup::restore($path);

        if ($result['success']) {
            return response()->json([
                'berhasil' => true,
                'pesan' => 'Database berhasil di-restore.'
            ]);
        }

        return response()->json([
            'berhasil' => false,
            'pesan' => 'Gagal restore database. ' . ($result['error'] ?? '') . "\n" . ($result['output'] ?? '')
        ], 500);
    }

    /**
     * Helper untuk update file .env
     */
    protected function updateEnv($key, $value)
    {
        $path = base_path('.env');
        if (File::exists($path)) {
            $content = File::get($path);
            
            // Jika key sudah ada, ganti nilainya
            if (preg_match("/^{$key}=(.*)$/m", $content)) {
                $content = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $content);
            } else {
                // Jika belum ada, tambahkan di akhir
                $content .= "\n{$key}={$value}";
            }

            File::put($path, $content);
        }
    }
}
