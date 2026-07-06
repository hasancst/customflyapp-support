<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Rename 'berita-nasional' to 'nasional' if it exists
        DB::table('kategori_berita')
            ->where('slug', 'berita-nasional')
            ->update(['slug' => 'nasional', 'nama' => 'Nasional']);

        // 2. Ensure 'hukum' exists
        $hukum = DB::table('kategori_berita')->where('slug', 'hukum')->first();
        if (!$hukum) {
            DB::table('kategori_berita')->insert([
                'nama' => 'Hukum',
                'slug' => 'hukum',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        // No need to reverse
    }
};
