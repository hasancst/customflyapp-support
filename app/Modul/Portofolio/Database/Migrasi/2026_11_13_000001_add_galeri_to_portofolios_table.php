<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('portofolios', 'galeri')) {
            Schema::table('portofolios', function (Blueprint $table) {
                $table->json('galeri')->nullable()->after('gambar');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('portofolios', 'galeri')) {
            Schema::table('portofolios', function (Blueprint $table) {
                $table->dropColumn('galeri');
            });
        }
    }
};

