<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->string('status')->default('draft'); // draft, terbit
            $table->foreignId('penulis_id')->constrained('pengguna');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel');
    }
};
