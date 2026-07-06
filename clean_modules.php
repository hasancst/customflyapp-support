<?php

/**
 * Clean Duplicate Modules Script
 * Removes duplicate module entries and keeps only lowercase slugs
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "🧹 Membersihkan duplikasi modul...\n\n";
    
    // Get all modules grouped by lowercase slug
    $modules = DB::table('modul')->get();
    $grouped = [];
    
    foreach ($modules as $module) {
        $lowerSlug = strtolower($module->slug);
        
        if (!isset($grouped[$lowerSlug])) {
            $grouped[$lowerSlug] = [];
        }
        
        $grouped[$lowerSlug][] = $module;
    }
    
    $deleted = 0;
    
    // For each group, keep only one (prefer lowercase slug and aktif=true)
    foreach ($grouped as $lowerSlug => $moduleGroup) {
        if (count($moduleGroup) > 1) {
            echo "📦 Ditemukan " . count($moduleGroup) . " duplikasi untuk slug: {$lowerSlug}\n";
            
            // Sort: prefer lowercase slug, then aktif=true, then newest
            usort($moduleGroup, function($a, $b) use ($lowerSlug) {
                // Prefer exact lowercase match
                if ($a->slug === $lowerSlug && $b->slug !== $lowerSlug) return -1;
                if ($a->slug !== $lowerSlug && $b->slug === $lowerSlug) return 1;
                
                // Prefer aktif=true
                if ($a->aktif && !$b->aktif) return -1;
                if (!$a->aktif && $b->aktif) return 1;
                
                // Prefer newer
                return strcmp($b->created_at, $a->created_at);
            });
            
            // Keep first, delete rest
            $keep = array_shift($moduleGroup);
            echo "  ✅ Mempertahankan: {$keep->nama} (slug: {$keep->slug}, aktif: " . ($keep->aktif ? 'Ya' : 'Tidak') . ")\n";
            
            foreach ($moduleGroup as $duplicate) {
                echo "  ❌ Menghapus: {$duplicate->nama} (slug: {$duplicate->slug}, aktif: " . ($duplicate->aktif ? 'Ya' : 'Tidak') . ")\n";
                DB::table('modul')->where('id', $duplicate->id)->delete();
                $deleted++;
            }
            
            echo "\n";
        }
    }
    
    if ($deleted > 0) {
        echo "✅ Berhasil menghapus {$deleted} duplikasi modul.\n";
    } else {
        echo "✅ Tidak ada duplikasi modul ditemukan.\n";
    }
    
    // Show final active modules
    echo "\n📊 Modul Aktif:\n";
    $activeModules = DB::table('modul')->where('aktif', true)->orderBy('nama')->get(['nama', 'slug']);
    foreach ($activeModules as $module) {
        echo "  • {$module->nama} ({$module->slug})\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
