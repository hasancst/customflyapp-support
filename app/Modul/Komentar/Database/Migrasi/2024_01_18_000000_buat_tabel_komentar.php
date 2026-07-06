<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->morphs('komentabel'); // Menghasilkan komentabel_id dan komentabel_type
            $table->foreignId('user_id')->nullable()->constrained('pengguna')->onDelete('cascade');
            $table->string('nama')->nullable(); // Untuk tamu
            $table->string('email')->nullable(); // Untuk tamu
            $table->text('isi');
            $table->enum('status', ['pending', 'disetujui', 'spam'])->default('pending');
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentar');
    }
};
