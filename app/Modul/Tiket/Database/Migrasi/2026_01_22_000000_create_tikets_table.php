<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tikets', function (Blueprint $create) {
            $create->id();
            $create->string('no_tiket')->unique();
            $create->string('judul');
            $create->unsignedBigInteger('user_id'); // ID Pengunjung atau Pengguna
            $create->string('email')->nullable();
            $create->string('kategori')->default('Umum');
            $create->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $create->enum('status', ['terbuka', 'proses', 'selesai', 'ditutup'])->default('terbuka');
            $create->text('pesan_awal');
            $create->timestamps();
        });

        Schema::create('tiket_pesans', function (Blueprint $create) {
            $create->id();
            $create->unsignedBigInteger('tiket_id');
            $create->unsignedBigInteger('user_id')->nullable(); // Nullable if system or quest
            $create->string('nama_pengirim')->nullable();
            $create->text('pesan');
            $create->string('lampiran')->nullable();
            $create->boolean('is_admin')->default(false);
            $create->timestamps();

            $create->foreign('tiket_id')->references('id')->on('tikets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiket_pesans');
        Schema::dropIfExists('tikets');
    }
};
