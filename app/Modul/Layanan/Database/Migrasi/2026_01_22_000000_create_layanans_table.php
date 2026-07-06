<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('layanans', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('judul');
            $blueprint->text('deskripsi')->nullable();
            $blueprint->string('ikon')->nullable(); // FontAwesome class or image path
            $blueprint->integer('urutan')->default(0);
            $blueprint->boolean('aktif')->default(true);
            $blueprint->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanans');
    }
};
