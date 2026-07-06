<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if footer menus already exist to avoid double seeding
        $exists = DB::table('menus')->where('posisi', 'footer')->exists();
        
        if (!$exists) {
            DB::table('menus')->insert([
                [
                    'label' => 'Tentang Kami',
                    'url' => '/tentang-kami',
                    'urutan' => 1,
                    'parent_id' => null,
                    'target' => '_self',
                    'posisi' => 'footer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'label' => 'Redaksi',
                    'url' => '/redaksi',
                    'urutan' => 2,
                    'parent_id' => null,
                    'target' => '_self',
                    'posisi' => 'footer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'label' => 'Kebijakan Privasi',
                    'url' => '/kebijakan-privasi',
                    'urutan' => 3,
                    'parent_id' => null,
                    'target' => '_self',
                    'posisi' => 'footer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'label' => 'Syarat & Ketentuan',
                    'url' => '/syarat-ketentuan',
                    'urutan' => 4,
                    'parent_id' => null,
                    'target' => '_self',
                    'posisi' => 'footer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('menus')->where('posisi', 'footer')->delete();
    }
};
