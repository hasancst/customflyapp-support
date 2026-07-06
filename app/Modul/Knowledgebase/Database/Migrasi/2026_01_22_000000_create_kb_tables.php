<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kb_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('ikon')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('kb_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->integer('views')->default(0);
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->string('tags')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('kb_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kb_articles');
        Schema::dropIfExists('kb_categories');
    }
};
