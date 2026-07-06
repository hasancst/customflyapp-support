# iMakeCustom CMS - Premium Modular Solution

iMakeCustom adalah Content Management System (CMS) modern yang dibangun dengan arsitektur modular, dirancang khusus untuk kebutuhan manufaktur kustom dan solusi bespoke premium.

## 🚀 Teknologi yang Digunakan

| Komponen | Teknologi | Versi |
| :--- | :--- | :--- |
| **Bahasa Pemrograman** | PHP | 8.3+ |
| **Framework Utama** | Laravel | 12.x |
| **Database Engine** | PostgreSQL | 14+ |
| **Frontend Utilities** | Blade, AlpineJS, Vanilla CSS | - |
| **Server Environment** | Linux (Ubuntu/Debian) | - |

## 📂 Struktur Folder Proyek

Proyek ini mengikuti struktur Laravel standar dengan kustomisasi modular yang kuat:

```text
/
├── app/
│   ├── Http/             # Controller dan Middleware Global
│   ├── Inti/             # Core Engine (Module Loader, Theme Manager, Backup)
│   ├── Modul/            # Struktur Modular (Setiap fitur adalah modul terpisah)
│   └── Providers/        # Service Providers Aplikasi
├── config/               # Konfigurasi Aplikasi
├── public/               # File Publik (CSS Core, JS Core, Images)
│   └── theme/            # Aset statis untuk setiap tema
├── resources/
│   ├── views/            # View Admin dan Global
│   └── theme/            # Template Blade untuk Tema Publik
│       └── imakecustom/  # Template Utama iMakeCustom
├── routes/               # Definisi Route Global
└── storage/              # File Upload dan Log
```

## 🛠️ Struktur Coding (Arsitektur)

Aplikasi ini menggunakan pendekatan **Modular Monolith**. Berikut adalah karakteristik utamanya:

### 1. Sistem Modul (`app/Modul`)
Setiap fitur (Berita, Layanan, Portofolio, dll.) dipisahkan ke dalam folder modulnya sendiri. Struktur di dalam modul biasanya meliputi:
- `Http/Controllers/`: Logika unik untuk setiap modul.
- `Model/`: Representasi database menggunakan Eloquent.
- `Resources/views/`: View khusus untuk area Admin modul tersebut.
- `Rute/`: Definisi route khusus modul.
- `manifest.json`: Metadata modul (Nama, Versi, Provider, Izin).

### 2. Core Engine (`app/Inti`)
Internal CMS yang mengelola siklus hidup aplikasi:
- **ModuleLoader**: Mendeteksi dan melakukan bootstrapping pada modul yang aktif.
- **ThemeManager**: Mengatur lokasi view dan aset berdasarkan tema yang dipilih.
- **MediaManager**: Mengelola unggahan file ke storage.
- **DatabaseBackup**: Menangani dumping database menggunakan `pg_dump`.

### 3. Theme Engine
Aplikasi mendukung multi-tema. Lokasi file tema berada di `resources/theme/[nama_tema]`. Data dari database (pengaturan, menu, dll.) diinjeksikan secara global melalui `AppServiceProvider` menggunakan `View::composer`.

## 📦 Database Engine
Sistem ini menggunakan **PostgreSQL** sebagai database utama untuk performa query yang lebih baik dan dukungan tipe data JSON yang kuat. Versi yang didukung adalah 14 ke atas.

## 🛠️ Instalasi & Pengembangan

1. Clone repositori.
2. Jalankan `composer install`.
3. Salin `.env.example` ke `.env` dan sesuaikan kredensial PostgreSQL.
4. Jalankan `php artisan migrate --seed`.
5. Jalankan `php artisan serve`.

---
© 2026 iMakeCustom - Built for Precision.
