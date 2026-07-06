<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ModulNonaktifkan extends Command
{
    protected $signature = 'modul:nonaktifkan {slug}';
    protected $description = 'Menonaktifkan modul tanpa menghapus data';

    public function handle()
    {
        $slug = $this->argument('slug');

        $exists = DB::table('modul')->where('slug', $slug)->exists();
        if (!$exists) {
            $this->error("Modul [{$slug}] tidak terdaftar di database.");
            return;
        }

        DB::table('modul')->where('slug', $slug)->update(['aktif' => false]);

        $this->info("Modul [{$slug}] telah dinonaktifkan.");
    }
}
