<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('modul')->insert([
            'nama' => 'Video',
            'slug' => 'video',
            'deskripsi' => 'Modul pengelolaan video Youtube.',
            'versi' => '1.0.0',
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        DB::table('modul')->where('slug', 'video')->delete();
    }
};
