<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Modul\Berita\Model\Berita;
use App\Modul\Berita\Model\Kategori;
use App\Models\User;
use Exception;

class ImportWordPress extends Command
{
    protected $signature = 'modul:import-wp {url : URL base WordPress (contoh: https://blog.anda.com)}';
    protected $description = 'Import kategori dan berita dari WordPress REST API';

    public function handle()
    {
        $baseUrl = rtrim($this->argument('url'), '/');
        $this->info("Memulai import dari: $baseUrl");

        // 1. Import Kategori
        $this->info("Mengambil kategori...");
        try {
            $categoriesResponse = Http::get("$baseUrl/wp-json/wp/v2/categories", ['per_page' => 100]);
            if ($categoriesResponse->failed()) {
                $this->error("Gagal mengambil kategori. Pastikan REST API aktif.");
                return 1;
            }
            $wpCategories = $categoriesResponse->json();
            $categoryMap = []; // wp_id => local_id

            foreach ($wpCategories as $wpCat) {
                $cat = Kategori::updateOrCreate(
                    ['slug' => $wpCat['slug']],
                    ['nama' => $wpCat['name']]
                );
                $categoryMap[$wpCat['id']] = $cat->id;
                $this->line("Kategori: {$wpCat['name']} [Imported]");
            }
        } catch (Exception $e) {
            $this->error("Error kategori: " . $e->getMessage());
        }

        // 2. Import Posts (Berita)
        $this->info("\nMengambil berita...");
        $page = 1;
        $count = 0;
        $admin = User::first();

        while (true) {
            try {
                $postsResponse = Http::get("$baseUrl/wp-json/wp/v2/posts", [
                    'per_page' => 20,
                    'page' => $page,
                    '_embed' => 1
                ]);

                if ($postsResponse->failed() || empty($postsResponse->json())) {
                    break;
                }

                $wpPosts = $postsResponse->json();

                foreach ($wpPosts as $wpPost) {
                    // Cek slug berita
                    $existing = Berita::where('slug', $wpPost['slug'])->first();
                    if ($existing) {
                        $this->warn("Berita diabaikan (sudah ada): {$wpPost['title']['rendered']}");
                        continue;
                    }

                    // Handle Gambar Utama
                    $gambarUtama = null;
                    if (isset($wpPost['_embedded']['wp:featuredmedia'][0]['source_url'])) {
                        $imgUrl = $wpPost['_embedded']['wp:featuredmedia'][0]['source_url'];
                        $imgName = basename($imgUrl);
                        $path = 'berita/' . Str::random(10) . '_' . $imgName;
                        
                        try {
                            $imgContent = Http::get($imgUrl)->body();
                            Storage::disk('public')->put($path, $imgContent);
                            $gambarUtama = $path;
                        } catch (Exception $e) {
                            $this->warn("Gagal download gambar: " . $imgUrl);
                        }
                    }

                    // Simpan Berita
                    $berita = Berita::create([
                        'judul' => $wpPost['title']['rendered'],
                        'slug' => $wpPost['slug'],
                        'ringkasan' => Str::limit(strip_tags($wpPost['excerpt']['rendered']), 250),
                        'isi' => $wpPost['content']['rendered'],
                        'penulis_id' => $admin->id,
                        'gambar_utama' => $gambarUtama,
                        'unggulan' => false,
                        'created_at' => $wpPost['date'],
                    ]);

                    // Hubungkan Kategori
                    if (isset($wpPost['categories'])) {
                        $localCatIds = [];
                        foreach ($wpPost['categories'] as $wpCatId) {
                            if (isset($categoryMap[$wpCatId])) {
                                $localCatIds[] = $categoryMap[$wpCatId];
                            }
                        }
                        $berita->kategoris()->sync($localCatIds);
                    }

                    $this->line("Berita: " . Str::limit($wpPost['title']['rendered'], 40) . " [Imported]");
                    $count++;
                }

                if (count($wpPosts) < 20) break;
                $page++;

            } catch (Exception $e) {
                $this->error("Error berita halaman $page: " . $e->getMessage());
                break;
            }
        }

        $this->info("\nSelesai! Berhasil mengimport $count berita.");
        return 0;
    }
}
