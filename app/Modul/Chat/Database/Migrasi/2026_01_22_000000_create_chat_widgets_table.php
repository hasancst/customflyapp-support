<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('public_key')->unique();
            $table->string('secret_key');
            $table->string('domain')->nullable();
            $table->json('pengaturan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_widgets');
    }
};
