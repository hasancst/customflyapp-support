# Dokumentasi CMS Laravel Modular Anti-Gravity

## 🚀 Teknologi Utama
- **PHP**: 8.3 (Dikonversi dari standar Laravel modern)
- **Framework**: Laravel 12.x
- **Database**: PostgreSQL (Driver `pgsql`)
- **Arsitektur**: Modular Monolith

## 📂 Struktur Folder Global
- `app/Inti`: Core engine (Module Loader, Theme Manager, Media & Backup).
- `app/Modul`: Direktori untuk fitur modular (Setiap fitur adalah package mandiri).
- `resources/theme`: Lokasi view untuk tema frontend publik.
- `public/theme`: Lokasi aset statis (CSS, JS, Img) untuk tema publik.
- `database/migrations`: Migrasi tabel core sistem.

## 🏗️ Struktur Coding & Arsitektur
Aplikasi ini dirancang dengan prinsip **Separation of Concerns** yang ketat melalui modul:

### 1. Struktur Modul (`app/Modul/{Slug}`)
Setiap modul wajib mengikuti struktur berikut:
- `Http/Controllers/`: Penanganan request admin.
- `Model/`: Eloquent Model untuk tabel modul.
- `Resources/views/`: Blade template untuk dashboard admin.
- `Rute/web.php`: Definisi URL untuk modul tersebut.
- `Database/Migrasi/`: Daftar migrasi tabel spesifik modul.
- `manifest.json`: Berisi metadata penting dan entry point Service Provider.

### 2. Provider Injection
Data global (Settings, Menu, Active Modules) diinjeksikan ke seluruh view melalui `AppServiceProvider` menggunakan `View::composer('*')`. Ini memastikan tema publik dapat mengakses data dinamis tanpa harus memanggil controller manual.

### 3. Localization & Database standard
- Nama tabel dan kolom menggunakan Bahasa Indonesia (contoh: `pengaturan`, `berita`, `layanans`).
- Frontend menggunakan multi-bahasa melalui helper standar Laravel.

## Cara Membuat Modul Baru
1. Buat folder di `app/Modul/{NamaModul}`.
2. Buat file `manifest.json` yang berisi informasi modul.
3. Buat ServiceProvider `app/Modul/{NamaModul}/{NamaModul}ServiceProvider.php`.
4. Jalankan `php artisan modul:pasang {slug}` untuk menginstal.

## Lifecycle Modul
- **Pasang**: Menjalankan migrasi di folder `Database/Migrasi` milik modul dan mendaftarkannya ke DB.
- **Aktifkan**: Mengizinkan Laravel me-load ServiceProvider modul tersebut.
- **Nonaktifkan**: Menghentikan load ServiceProvider tanpa menghapus data.
- **Copot**: Me-rollback migrasi dan menghapus catatan modul dari DB.

## Cara Membuat Tema Baru
1. Buat folder di `resources/theme/{nama-tema}`.
2. Buat file `theme.json`.
3. Gunakan `@extends('tema::layout.main')` (atau sejenisnya) untuk menggunakan view tema.

## Standar Kode
- Wajib menggunakan Bahasa Indonesia untuk nama tabel, kolom, function, dan komentar.
- Gunakan Event (Laravel Events) untuk komunikasi antar modul.
- Autoloading mengikuti PSR-4 dengan namespace `App\Modul\{Slug}`.
