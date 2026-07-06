<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('berita')) {
            Schema::table('berita', function (Blueprint $table) {
                if (!Schema::hasColumn('berita', 'gambar_utama')) {
                    $table->string('gambar_utama')->nullable();
                }
                if (!Schema::hasColumn('berita', 'unggulan')) {
                    $table->boolean('unggulan')->default(false);
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('berita')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->dropColumn(['gambar_utama', 'unggulan']);
            });
        }
    }
};
