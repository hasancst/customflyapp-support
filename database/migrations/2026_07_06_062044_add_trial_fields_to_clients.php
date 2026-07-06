<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'trial_used')) {
                $table->boolean('trial_used')->default(false)->after('plan');
            }
            if (!Schema::hasColumn('clients', 'trial_started_at')) {
                $table->timestamp('trial_started_at')->nullable()->after('trial_used');
            }
            if (!Schema::hasColumn('clients', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable()->after('trial_started_at');
            }
            if (!Schema::hasColumn('clients', 'trial_reminder_sent_at')) {
                $table->timestamp('trial_reminder_sent_at')->nullable()->after('trial_ends_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $columns = ['trial_used', 'trial_started_at', 'trial_ends_at', 'trial_reminder_sent_at'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('clients', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
