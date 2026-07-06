<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket_lampiran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tiket_id');
            $table->string('nama_file');           // original filename
            $table->string('path');                // S3 path e.g. tikets/attachments/uuid.pdf
            $table->string('url', 1000);           // full public URL
            $table->string('mime_type');           // image/jpeg, application/pdf, etc
            $table->unsignedBigInteger('ukuran');  // file size in bytes
            $table->string('diunggah_oleh')->nullable(); // email pengunggah
            $table->timestamps();

            $table->foreign('tiket_id')->references('id')->on('tikets')->onDelete('cascade');
            $table->index('tiket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_lampiran');
    }
};
