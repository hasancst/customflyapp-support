<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('widget_id')->constrained('chat_widgets')->onDelete('cascade');
            $table->string('session_token')->unique();
            $table->string('nama_pengunjung')->nullable();
            $table->string('email_pengunjung')->nullable();
            $table->string('ip_pengunjung')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('halaman_url')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'eskalasi'])->default('aktif');
            $table->foreignId('tiket_id')->nullable()->constrained('tikets')->onDelete('set null');
            $table->timestamp('aktivitas_terakhir')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_sessions');
    }
};
