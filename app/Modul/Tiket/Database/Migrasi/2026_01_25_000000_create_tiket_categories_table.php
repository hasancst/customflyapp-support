<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tiket_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('tiket_categories')->onDelete('cascade');
        });

        // Update tikets table to use category_id instead of string kategori
        Schema::table('tikets', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('judul');
            $table->foreign('category_id')->references('id')->on('tiket_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        Schema::dropIfExists('tiket_categories');
    }
};
