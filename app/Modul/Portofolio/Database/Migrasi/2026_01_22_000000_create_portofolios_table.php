<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portofolios', function (Blueprint $结构) {
            $结构->id();
            $结构->string('judul');
            $结构->string('slug')->unique();
            $结构->string('kategori')->nullable();
            $结构->string('klien')->nullable();
            $结构->string('gambar');
            $结构->text('deskripsi')->nullable();
            $结构->string('url')->nullable();
            $结构->date('tanggal')->nullable();
            $结构->integer('urutan')->default(0);
            $结构->boolean('aktif')->default(true);
            $结构->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('portofolios');
    }
};
