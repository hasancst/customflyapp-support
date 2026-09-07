# 🧪 Cara Test Email Notifikasi Tiket

## 📋 Persiapan

### 1. Setup Konfigurasi Email

Login ke admin panel dan setup email:

1. Buka `/admin/pengaturan`
2. Tab **"Konfigurasi Email"**
3. Isi konfigurasi SMTP

**Contoh untuk Gmail:**
```
Mail Driver     : smtp
Host            : smtp.gmail.com
Port            : 587
Username        : your-email@gmail.com
Password        : xxxx xxxx xxxx xxxx (App Password)
Enkripsi        : TLS
Email Pengirim  : noreply@domain.com
Nama Pengirim   : Customer Support
```

4. Scroll ke bawah ke bagian **"Notifikasi Email Tiket"**
5. Isi email admin:
```
admin@perusahaan.com, support@perusahaan.com
```

6. Klik **"Simpan Pengaturan"**

### 2. Generate Gmail App Password (Jika Pakai Gmail)

1. Buka [Google Account](https://myaccount.google.com/)
2. **Security** → **2-Step Verification** (aktifkan jika belum)
3. **Security** → **App passwords**
4. Pilih **Mail** dan **Other device**
5. Generate → Copy password 16 digit
6. Paste ke field "Password" di Settings

---

## 🎯 Metode Testing

Ada **3 cara** untuk test email notifikasi:

### Metode 1: Via Script Test (Paling Mudah) ⭐

```bash
cd /www/wwwroot/imakecustom.com
php test_email_tiket.php
```

**Menu yang tersedia:**
1. **Test Email Sederhana** - Test koneksi SMTP dasar
2. **Test Notifikasi Tiket Baru** - Test email tiket baru lengkap
3. **Test Notifikasi Reply** - Test email balasan
4. **Lihat Daftar Tiket** - Untuk reference
5. **Keluar**

**Output yang diharapkan:**
```
✅ Email berhasil dikirim!
   Cek inbox Anda di: admin@example.com
```

---

### Metode 2: Via Admin Panel

#### Test Tiket Baru:

1. Login ke `/admin`
2. Menu **Tiket** → **Open New Ticket**
3. Isi form:
   - Judul: Test Email Notifikasi
   - Pesan: Ini test
   - Prioritas: Tinggi
   - Kategori: Pilih salah satu
4. Klik **Submit**
5. **Cek inbox admin Anda** → Email notifikasi harus masuk

#### Test Reply Customer:

1. Buka tiket yang ada di `/admin/tiket`
2. Klik salah satu tiket
3. Scroll ke form balasan
4. Tulis balasan sebagai admin
5. Klik **Kirim Balasan**
6. **Email TIDAK akan dikirim** (karena dari admin)

---

### Metode 3: Via Tinker (Advanced)

```bash
php artisan tinker
```

#### Test Email Sederhana:
```php
Mail::raw('Test email', function($m) {
    $m->to('admin@example.com')->subject('Test');
});
```

#### Test Tiket Baru:
```php
use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Services\TiketNotificationService;

$tiket = Tiket::create([
    'no_tiket' => 'TEST-' . rand(1000, 9999),
    'judul' => 'Test Email',
    'email' => 'customer@test.com',
    'nama' => 'Test Customer',
    'pesan_awal' => 'Test pesan',
    'prioritas' => 'tinggi',
    'status' => 'terbuka',
]);

$service = new TiketNotificationService();
$service->notifyNewTicket($tiket);
```

#### Test Reply:
```php
use App\Modul\Tiket\Model\TiketPesan;

$tiket = Tiket::first();

$pesan = TiketPesan::create([
    'tiket_id' => $tiket->id,
    'nama_pengirim' => 'Customer',
    'pesan' => 'Test reply',
    'is_admin' => false,
]);

$service = new TiketNotificationService();
$service->notifyTicketReply($tiket, $pesan);
```

---

## 🔍 Verifikasi

### 1. Cek Email Masuk

**Email Tiket Baru harus berisi:**
- ✅ Subject: "Tiket Baru: TKT-XXXXX - Judul Tiket"
- ✅ Nomor tiket
- ✅ Judul
- ✅ Badge status & prioritas
- ✅ Info customer (nama, email)
- ✅ Isi pesan awal
- ✅ Link ke detail tiket

**Email Reply harus berisi:**
- ✅ Subject: "Balasan Tiket: TKT-XXXXX - Judul"
- ✅ Isi balasan baru
- ✅ Info pengirim
- ✅ Link ke detail tiket

### 2. Cek Log

```bash
# Real-time monitoring
tail -f storage/logs/laravel.log | grep -i tiket

# Atau lihat log terakhir
tail -100 storage/logs/laravel.log | grep -i "email"
```

**Log yang diharapkan:**

✅ **Success:**
```
[INFO] Email notifikasi tiket baru berhasil dikirim
{"tiket_id":123,"no_tiket":"TKT-ABC123","recipients":2}
```

⚠️ **Warning (Non-critical):**
```
[WARNING] Tidak ada email admin yang dikonfigurasi
```

❌ **Error:**
```
[ERROR] Gagal mengirim email notifikasi tiket baru
{"error":"Connection refused"}
```

### 3. Cek Folder Spam

Jika email tidak masuk inbox:
- ✅ Cek folder **Spam/Junk**
- ✅ Tambahkan sender ke whitelist
- ✅ Setup SPF/DKIM di DNS (untuk production)

---

## ❌ Troubleshooting

### Problem 1: Email tidak terkirim

**Cek konfigurasi:**
```bash
php artisan tinker
```

```php
// Cek mail config
config('mail.mailers.smtp');

// Cek email admin
DB::table('pengaturan')->where('kunci', 'tiket_notif_emails')->value('nilai');
```

**Solution:**
- Pastikan SMTP host, port, username, password benar
- Untuk Gmail, gunakan **App Password** bukan password biasa
- Cek firewall tidak block port 587

### Problem 2: Connection refused

**Error:**
```
Connection refused on port 587
```

**Solution:**
```bash
# Test koneksi SMTP
telnet smtp.gmail.com 587

# Jika gagal, coba port alternatif:
# Port 465 (SSL) atau port 25
```

### Problem 3: Authentication failed

**Error:**
```
Authentication failed: Invalid username/password
```

**Solution:**
- Gmail: Harus pakai **App Password**, bukan password akun
- SMTP lain: Cek username dan password benar

### Problem 4: Email masuk spam

**Solution:**
1. **Sementara:** Tambahkan sender ke contacts
2. **Permanent:** Setup di DNS:
   ```
   SPF:   v=spf1 include:_spf.google.com ~all
   DKIM:  Setup via email provider
   DMARC: v=DMARC1; p=quarantine;
   ```

### Problem 5: Template tidak muncul / error

**Solution:**
```bash
# Clear cache
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# Re-run test
php test_email_tiket.php
```

---

## 📊 Test Checklist

Gunakan checklist ini untuk memastikan semua berfungsi:

### Basic Tests:
- [ ] Konfigurasi SMTP tersimpan di Settings
- [ ] Email notifikasi tiket sudah diisi
- [ ] Test email sederhana berhasil terkirim
- [ ] Email masuk ke inbox (bukan spam)

### Functional Tests:
- [ ] Buat tiket baru → Email notifikasi diterima admin
- [ ] Customer reply tiket → Email notifikasi diterima admin
- [ ] Admin reply tiket → Email TIDAK dikirim (seharusnya)
- [ ] Email berisi informasi lengkap dan link bekerja

### Log & Monitoring:
- [ ] Log menunjukkan success message
- [ ] Tidak ada error di log
- [ ] Email diterima dalam < 1 menit

---

## 🚀 Test Production

Sebelum go-live:

1. **Test dengan email real** (bukan test)
2. **Verify semua link** dalam email berfungsi
3. **Test dari Shopify App** jika sudah terintegrasi
4. **Monitor log** saat launch
5. **Setup alert** untuk email failures

---

## 💡 Tips

### Development:
- Gunakan [Mailtrap](https://mailtrap.io) untuk test tanpa kirim email real
- Set `MAIL_MAILER=log` di `.env` untuk log ke file

### Production:
- Gunakan dedicated email service (SendGrid, Mailgun)
- Monitor email delivery rate
- Setup queue untuk async processing
- Regular health check

---

## 📞 Quick Commands

```bash
# Test via script
php test_email_tiket.php

# Monitor log real-time
tail -f storage/logs/laravel.log | grep -i tiket

# Check config
php artisan tinker
config('mail')

# Clear cache
php artisan cache:clear && php artisan view:clear

# Check database settings
mysql -u root -p
use your_database;
SELECT * FROM pengaturan WHERE kunci LIKE '%mail%' OR kunci LIKE '%tiket%';
```

---

## ✅ Expected Results

Jika semua benar, Anda akan melihat:

1. ✅ Email masuk ke inbox admin dalam < 1 menit
2. ✅ Template email tampil dengan baik (HTML)
3. ✅ Semua informasi lengkap (nomor tiket, link, dll)
4. ✅ Link "Lihat Detail Tiket" berfungsi
5. ✅ Log success tanpa error

**Selamat! Email notifikasi tiket sudah berfungsi! 🎉**

---

**Last Updated:** 2026-09-01
