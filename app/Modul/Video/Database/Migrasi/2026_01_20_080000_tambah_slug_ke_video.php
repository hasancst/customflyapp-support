<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('video', 'slug')) {
            Schema::table('video', function (Blueprint $table) {
                $table->string('slug')->after('judul')->nullable();
            });

            // Populate slug for existing videos
            $videos = DB::table('video')->get();
            foreach ($videos as $video) {
                $slug = Str::slug($video->judul);
                // Ensure unique simple check
                if (DB::table('video')->where('slug', $slug)->exists()) {
                     $slug .= '-' . $video->id;
                }
                
                DB::table('video')
                    ->where('id', $video->id)
                    ->update(['slug' => $slug]);
            }
        }
    }

    public function down()
    {
        if (Schema::hasColumn('video', 'slug')) {
            Schema::table('video', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
