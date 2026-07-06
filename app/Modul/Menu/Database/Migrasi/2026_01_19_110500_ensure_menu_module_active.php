<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $exists = DB::table('modul')->where('slug', 'menu')->exists();
        
        if (!$exists) {
            DB::table('modul')->insert([
                'nama' => 'Manajemen Menu',
                'slug' => 'menu', // lowercase just to be safe and consistent
                'deskripsi' => 'Modul untuk mengelola navigasi menu pada website.',
                'versi' => '1.0.0',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
             DB::table('modul')->where('slug', 'menu')->update(['aktif' => true]);
        }
    }

    public function down()
    {
        // No down action to prevent data loss
    }
};
