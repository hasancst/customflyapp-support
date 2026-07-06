<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('iklan')) {
            Schema::create('iklan', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->enum('jenis', ['gambar', 'script'])->default('gambar'); // Gambar atau Script AdSense dll
                $table->text('konten'); // Path gambar atau kode script
                $table->string('posisi')->comment('header, sidebar, footer, article_middle');
                $table->string('link')->nullable(); // Untuk jenis gambar
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('iklan');
    }
};
