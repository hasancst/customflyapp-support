<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'shop_domain')) {
                $table->string('shop_domain')->nullable()->after('shop_id');
            }
            if (!Schema::hasColumn('clients', 'customer_id')) {
                $table->string('customer_id')->nullable()->after('shop_domain');
            }
            if (!Schema::hasColumn('clients', 'first_name')) {
                $table->string('first_name')->nullable()->after('customer_id');
            }
            if (!Schema::hasColumn('clients', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('clients', 'shop_domain')) $columns[] = 'shop_domain';
            if (Schema::hasColumn('clients', 'customer_id')) $columns[] = 'customer_id';
            if (Schema::hasColumn('clients', 'first_name')) $columns[] = 'first_name';
            if (Schema::hasColumn('clients', 'last_name')) $columns[] = 'last_name';
            if (!empty($columns)) $table->dropColumn($columns);
        });
    }
};
