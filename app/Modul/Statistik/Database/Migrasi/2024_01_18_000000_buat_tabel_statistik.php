<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stat_pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->index();
            $table->string('perangkat')->nullable(); // User Agent
            $table->string('url')->nullable();
            $table->string('referensi')->nullable(); // Referer
            $table->date('tanggal')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stat_pengunjung');
    }
};
