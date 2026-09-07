# 📧 Email Notifikasi Tiket

Sistem tiket sekarang sudah dilengkapi dengan fitur notifikasi email otomatis ke admin ketika ada tiket baru masuk atau ada balasan dari customer.

## 🎯 Fitur

- ✅ Email notifikasi saat tiket baru dibuat
- ✅ Email notifikasi saat ada balasan dari customer
- ✅ Template email yang profesional dan informatif
- ✅ Tidak mengirim notifikasi saat admin yang membalas
- ✅ Multiple admin emails support
- ✅ Logging untuk troubleshooting

## 📋 Cara Kerja

### 1. Tiket Baru Masuk

Ketika customer membuat tiket baru (dari Shopify App atau admin panel), sistem akan:
- Membuat tiket baru di database
- Mengirim email ke semua admin yang terdaftar
- Email berisi:
  - Nomor tiket
  - Judul
  - Status & prioritas
  - Kategori
  - Informasi customer
  - Isi pesan awal
  - Link langsung ke detail tiket

### 2. Balasan Customer

Ketika customer membalas tiket, sistem akan:
- Menyimpan pesan balasan
- Mengirim email ke semua admin yang terdaftar
- Email berisi:
  - Informasi tiket
  - Isi balasan baru
  - Informasi pengirim (customer/admin)
  - Konteks customer
  - Link langsung ke detail tiket

**Catatan:** Jika yang membalas adalah admin, notifikasi email **tidak** dikirim ke admin lain (untuk menghindari spam).

## ⚙️ Konfigurasi Email Admin

Ada 4 cara untuk mengatur email admin yang akan menerima notifikasi, dengan urutan prioritas:

### Prioritas 1: Database Settings (Rekomendasi)

Simpan email admin di database menggunakan tinker atau seeder:

```php
// Via tinker
php artisan tinker

use App\Modul\Tiket\Model\TiketSetting;

TiketSetting::setValue(
    'admin_notification_emails',
    ['admin@example.com', 'support@example.com'],
    'array',
    'Daftar email admin yang akan menerima notifikasi tiket'
);
```

Atau via migration/seeder:

```php
use App\Modul\Tiket\Model\TiketSetting;

TiketSetting::setValue(
    'admin_notification_emails',
    ['admin@example.com', 'support@example.com'],
    'array'
);
```

### Prioritas 2: Environment Variable

Tambahkan di file `.env`:

```env
TIKET_ADMIN_EMAILS="admin@example.com,support@example.com,manager@example.com"
```

Format: email dipisahkan dengan koma (,)

### Prioritas 3: Dari Tabel User

Sistem akan otomatis mengambil semua email dari tabel `users` dengan peran:
- `admin`
- `superadmin`

### Prioritas 4: Fallback

Jika semua cara di atas tidak ada, sistem akan menggunakan `MAIL_FROM_ADDRESS` dari `.env`

## 📧 Konfigurasi Mail Server

Pastikan mail server sudah dikonfigurasi di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Contoh Konfigurasi untuk Gmail

1. Buka Google Account Settings
2. Aktifkan 2-Factor Authentication
3. Generate App Password
4. Gunakan App Password di `MAIL_PASSWORD`

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourname@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Customer Support"
```

### Contoh untuk Mailtrap (Testing)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🧪 Testing

### Test Email Configuration

```bash
php artisan tinker
```

```php
Mail::raw('Test email from ticket system', function($message) {
    $message->to('your-email@example.com')
            ->subject('Test Email');
});
```

### Test Ticket Notification

Buat tiket baru via admin panel atau API, lalu cek:
1. Email masuk ke inbox admin
2. Log file di `storage/logs/laravel.log`

## 📝 Logging

Semua aktivitas email dicatat di log dengan informasi:
- Tiket ID dan nomor tiket
- Jumlah recipients
- Error jika ada masalah

Cek log:
```bash
tail -f storage/logs/laravel.log | grep -i tiket
```

## 🔧 Troubleshooting

### Email Tidak Terkirim

1. **Cek konfigurasi mail server**
   ```bash
   php artisan tinker
   config('mail')
   ```

2. **Cek apakah ada admin email terdaftar**
   ```bash
   php artisan tinker
   ```
   ```php
   use App\Modul\Tiket\Services\TiketNotificationService;
   $service = new TiketNotificationService();
   // Tidak bisa langsung akses protected method, jadi cek manual:
   
   // Cek database
   \App\Modul\Tiket\Model\TiketSetting::getValue('admin_notification_emails');
   
   // Cek env
   env('TIKET_ADMIN_EMAILS');
   
   // Cek user admin
   \App\Models\User::where('peran', 'admin')->pluck('email');
   ```

3. **Cek log untuk error details**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

4. **Test koneksi SMTP**
   ```bash
   telnet smtp.gmail.com 587
   ```

### Email Masuk Spam

1. Setup SPF record di DNS
2. Setup DKIM
3. Setup DMARC
4. Gunakan dedicated email service (SendGrid, Mailgun, SES)

### Template Email Tidak Muncul

1. Cek view path sudah benar
2. Clear view cache:
   ```bash
   php artisan view:clear
   php artisan config:clear
   ```

## 📦 File-file yang Ditambahkan

```
app/Modul/Tiket/
├── Mail/
│   ├── TiketBaruMail.php          # Mailable untuk tiket baru
│   └── TiketReplyMail.php          # Mailable untuk reply
├── Services/
│   └── TiketNotificationService.php # Service untuk handle notifikasi
├── Model/
│   └── TiketSetting.php            # Model untuk settings
├── Resources/views/emails/
│   ├── tiket-baru.blade.php        # Template email tiket baru
│   └── tiket-reply.blade.php       # Template email reply
└── Database/Migrasi/
    └── 2026_09_01_xxxxx_create_tiket_settings_table.php
```

## 🚀 Deployment

1. **Jalankan migration**
   ```bash
   php artisan migrate
   ```

2. **Set admin emails**
   ```bash
   php artisan tinker
   ```
   ```php
   use App\Modul\Tiket\Model\TiketSetting;
   TiketSetting::setValue(
       'admin_notification_emails',
       ['admin1@example.com', 'admin2@example.com'],
       'array'
   );
   ```

3. **Test dengan membuat tiket baru**

4. **Monitor log** untuk memastikan email terkirim

## 🔐 Keamanan

- Email dikirim menggunakan queue jika diaktifkan (recommended)
- Tidak ada data sensitif yang di-log
- Error handling mencegah aplikasi crash jika email gagal
- Email validation untuk mencegah invalid addresses

## 📊 Monitoring

Untuk production, rekomendasi:
1. Setup queue untuk email (jangan blocking)
2. Monitor queue jobs
3. Setup alert jika email gagal
4. Track email open rate (optional)

```env
QUEUE_CONNECTION=database
```

```bash
php artisan queue:work --daemon
```

## 💡 Tips

1. **Gunakan Queue untuk Production**
   - Update `TiketNotificationService` untuk use queue
   - Implement `ShouldQueue` di Mailable classes

2. **Rate Limiting**
   - Pertimbangkan rate limiting jika volume tinggi
   - Batch emails jika banyak admin

3. **Customization**
   - Edit template di `Resources/views/emails/`
   - Sesuaikan warna dan branding
   - Tambahkan logo company

4. **Alternative Email Providers**
   - SendGrid: Reliable dengan analytics
   - Mailgun: Good API, affordable
   - AWS SES: Cheap untuk volume besar
   - Postmark: Fast delivery

## 📞 Support

Jika ada pertanyaan atau issue:
1. Cek log file terlebih dahulu
2. Verify mail configuration
3. Test dengan sample ticket
4. Check firewall/port 587 atau 465

---

**Dibuat:** September 2026  
**Versi:** 1.0.0
