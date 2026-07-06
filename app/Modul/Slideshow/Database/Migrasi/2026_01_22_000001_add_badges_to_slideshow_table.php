<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('slideshow', function (Blueprint $table) {
            $table->string('badge_1')->nullable()->after('deskripsi');
            $table->string('badge_2')->nullable()->after('badge_1');
        });
    }

    public function down()
    {
        Schema::table('slideshow', function (Blueprint $table) {
            $table->dropColumn(['badge_1', 'badge_2']);
        });
    }
};
