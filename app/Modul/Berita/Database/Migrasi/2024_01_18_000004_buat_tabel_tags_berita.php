<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tag_berita')) {
            Schema::create('tag_berita', function (Blueprint $table) {
                $table->id();
                $table->string('nama')->unique();
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('berita_memiliki_tag')) {
            Schema::create('berita_memiliki_tag', function (Blueprint $table) {
                $table->foreignId('berita_id')->constrained('berita')->onDelete('cascade');
                $table->foreignId('tag_id')->constrained('tag_berita')->onDelete('cascade');
                $table->primary(['berita_id', 'tag_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('berita_memiliki_tag');
        Schema::dropIfExists('tag_berita');
    }
};
