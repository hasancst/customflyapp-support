<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('stat_pengunjung')) {
            Schema::table('stat_pengunjung', function (Blueprint $table) {
                if (!Schema::hasColumn('stat_pengunjung', 'negara')) {
                    $table->string('negara')->nullable()->after('ip');
                }
                if (!Schema::hasColumn('stat_pengunjung', 'kode_negara')) {
                    $table->string('kode_negara', 5)->nullable()->after('negara');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('stat_pengunjung')) {
            Schema::table('stat_pengunjung', function (Blueprint $table) {
                $table->dropColumn(['negara', 'kode_negara']);
            });
        }
    }
};
