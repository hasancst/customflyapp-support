<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_diverifikasi_pada')->nullable();
            $table->string('kata_sandi');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('kata_sandi_reset_token', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('dibuat_pada')->nullable();
        });

        Schema::create('sesi', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('singgahan', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('singgahan_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('tugas_gagal', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('peran', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('slug')->unique();
            $table->string('modul')->nullable();
            $table->timestamps();
        });

        Schema::create('peran_izin', function (Blueprint $table) {
            $table->foreignId('peran_id')->constrained('peran')->onDelete('cascade');
            $table->foreignId('izin_id')->constrained('izin')->onDelete('cascade');
            $table->primary(['peran_id', 'izin_id']);
        });

        Schema::create('pengguna_peran', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('peran_id')->constrained('peran')->onDelete('cascade');
            $table->primary(['pengguna_id', 'peran_id']);
        });

        Schema::create('modul', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('versi');
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(false);
            $table->timestamps();
        });

        Schema::create('tema', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('versi');
            $table->boolean('aktif')->default(false);
            $table->timestamps();
        });

        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique();
            $table->text('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
        Schema::dropIfExists('tema');
        Schema::dropIfExists('modul');
        Schema::dropIfExists('pengguna_peran');
        Schema::dropIfExists('peran_izin');
        Schema::dropIfExists('izin');
        Schema::dropIfExists('peran');
        Schema::dropIfExists('tugas_gagal');
        Schema::dropIfExists('tugas');
        Schema::dropIfExists('singgahan_locks');
        Schema::dropIfExists('singgahan');
        Schema::dropIfExists('sesi');
        Schema::dropIfExists('kata_sandi_reset_token');
        Schema::dropIfExists('pengguna');
    }
};
