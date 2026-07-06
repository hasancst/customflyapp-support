<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('kategori_berita')) {
            Schema::create('kategori_berita', function (Blueprint $table) {
                $table->id();
                $table->string('nama')->unique();
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // Update tabel berita untuk menggunakan relasi kategori
        if (Schema::hasTable('berita')) {
            Schema::table('berita', function (Blueprint $table) {
                if (!Schema::hasColumn('berita', 'kategori_id')) {
                    $table->unsignedBigInteger('kategori_id')->nullable();
                    $table->foreign('kategori_id')->references('id')->on('kategori_berita')->onDelete('set null');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('berita')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->dropForeign(['kategori_id']);
                $table->dropColumn('kategori_id');
            });
        }
        Schema::dropIfExists('kategori_berita');
    }
};
