<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('video', function (Blueprint $table) {
            $table->boolean('unggulan')->default(false)->after('aktif');
        });
    }

    public function down()
    {
        Schema::table('video', function (Blueprint $table) {
            $table->dropColumn('unggulan');
        });
    }
};
