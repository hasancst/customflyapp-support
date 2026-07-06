<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'nama_situs' => 'Rumah Koalisi',
            'deskripsi_situs' => 'Portal informasi dan edukasi terpercaya untuk masyarakat Indonesia.',
            'email_admin' => 'admin@rumahkoalisi.id',
            'alamat' => 'Jl. Panglima Sudirman No 24 Jakarta - Indonesia',
            'optimasi_redis_aktif' => '0',
            'optimasi_redis_host' => '127.0.0.1',
            'optimasi_redis_port' => '6379',
            'optimasi_redis_password' => '',
            'optimasi_webp_aktif' => '0',
            'optimasi_webp_kualitas' => '80',
            'mail_driver' => 'smtp',
            'mail_host' => '',
            'mail_port' => '587',
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => '',
            'mail_from_address' => '',
            'mail_from_name' => '',
            'captcha_aktif' => '0',
            'captcha_site_key' => '',
            'captcha_secret_key' => '',
            'tema_aktif' => 'pinterhukum',
        ];

        foreach ($settings as $key => $value) {
            \DB::table('pengaturan')->updateOrInsert(
                ['kunci' => $key],
                ['nilai' => $value, 'updated_at' => now()]
            );
        }
    }
}
