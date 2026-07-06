<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('berita_memiliki_kategori')) {
            Schema::create('berita_memiliki_kategori', function (Blueprint $table) {
                $table->foreignId('berita_id')->constrained('berita')->onDelete('cascade');
                $table->foreignId('kategori_id')->constrained('kategori_berita')->onDelete('cascade');
                $table->primary(['berita_id', 'kategori_id']);
            });
        }

        // Hapus kolom kategori_id lama dari tabel berita jika ada
        if (Schema::hasColumn('berita', 'kategori_id')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->dropForeign(['kategori_id']);
                $table->dropColumn('kategori_id');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('berita_memiliki_kategori');
        
        // Kembalikan kolom kategori_id jika perlu rollback (opsional)
        if (!Schema::hasColumn('berita', 'kategori_id')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->unsignedBigInteger('kategori_id')->nullable();
                $table->foreign('kategori_id')->references('id')->on('kategori_berita')->onDelete('set null');
            });
        }
    }
};
