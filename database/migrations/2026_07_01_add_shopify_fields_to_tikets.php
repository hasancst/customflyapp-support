<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('tikets', function (Blueprint $table) {
            if (!Schema::hasColumn('tikets', 'shop_id')) {
                $table->string('shop_id')->nullable()->after('email');
            }
            if (!Schema::hasColumn('tikets', 'nama')) {
                $table->string('nama')->nullable()->after('shop_id');
            }
        });
    }
    public function down(): void {
        Schema::table('tikets', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('tikets', 'shop_id')) $columns[] = 'shop_id';
            if (Schema::hasColumn('tikets', 'nama')) $columns[] = 'nama';
            if (!empty($columns)) $table->dropColumn($columns);
        });
    }
};
