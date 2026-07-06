<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('berita')) {
            Schema::create('berita', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('slug')->unique();
                $table->text('ringkasan')->nullable();
                $table->text('isi');
                $table->string('kategori')->default('umum');
                $table->foreignId('penulis_id')->constrained('pengguna');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};
