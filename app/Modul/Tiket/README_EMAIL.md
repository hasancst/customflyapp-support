# 📧 Email Notifikasi Tiket - Panduan Singkat

## 🚀 Setup Cepat

### 1. Konfigurasi Email di Admin Panel

1. Login ke admin panel
2. Buka menu **Settings** (Pengaturan)
3. Pilih tab **Konfigurasi Email**
4. Isi konfigurasi SMTP:
   - Mail Driver: SMTP
   - Host: smtp.gmail.com (atau mail server lainnya)
   - Port: 587
   - Username: email Anda
   - Password: password atau app password
   - Enkripsi: TLS
   - Email Pengirim: noreply@domain.com
   - Nama Pengirim: Nama perusahaan Anda

5. Di bagian **Notifikasi Email Tiket**, masukkan email admin yang akan menerima notifikasi:
   ```
   admin@example.com, support@example.com, manager@example.com
   ```

6. Klik **Simpan Pengaturan**

### 2. Test

Buat tiket baru atau reply dari customer, lalu cek email admin.

## 📝 Kapan Email Dikirim?

✅ **Email AKAN dikirim ke admin saat:**
- Customer membuat tiket baru (dari Shopify App atau form publik)
- Customer membalas tiket

❌ **Email TIDAK dikirim saat:**
- Admin membalas tiket (untuk menghindari spam notifikasi)

## ⚙️ Konfigurasi

Semua konfigurasi dilakukan melalui halaman **Admin → Settings → tab Konfigurasi Email**.

**Konfigurasi SMTP:**
- Gunakan mail server Anda (Gmail, Mailgun, SendGrid, dll)
- Pastikan kredensial benar
- Gunakan TLS untuk enkripsi

**Email Notifikasi Tiket:**
- Isi dengan email admin yang akan menerima notifikasi
- Pisahkan dengan koma jika lebih dari satu
- Kosongkan untuk menggunakan Email Admin utama

## 🎯 Contoh Konfigurasi Gmail

### Langkah-langkah:

1. **Aktifkan 2-Factor Authentication** di Google Account
2. **Generate App Password:**
   - Buka Google Account Settings
   - Security → 2-Step Verification
   - App passwords → Generate
   - Pilih "Mail" dan "Other device"
   - Copy password yang dihasilkan (16 karakter)

3. **Isi di Settings:**
   - Host: `smtp.gmail.com`
   - Port: `587`
   - Username: `your-email@gmail.com`
   - Password: `paste app password disini`
   - Enkripsi: `TLS`

## 🔍 Troubleshooting

**Email tidak terkirim?**

1. Cek konfigurasi SMTP sudah benar
2. Cek email notifikasi sudah diisi
3. Lihat log: `tail -f storage/logs/laravel.log | grep -i tiket`
4. Test koneksi SMTP: `telnet smtp.gmail.com 587`

**Email masuk spam?**

- Setup SPF, DKIM, DMARC di DNS domain Anda
- Atau gunakan email service provider (SendGrid, Mailgun, AWS SES)

## 📚 Informasi Email

**Email Tiket Baru berisi:**
- Nomor tiket
- Judul
- Status & prioritas
- Kategori
- Info customer (nama, email, shop)
- Isi pesan awal
- Link ke detail tiket

**Email Balasan berisi:**
- Info tiket
- Isi balasan baru
- Info pengirim
- Link ke detail tiket

## 💡 Tips

- Untuk production, gunakan dedicated email service
- Monitor log untuk debugging
- Test dengan Mailtrap sebelum production
- Gunakan queue untuk volume tinggi

## 📦 File-file Terkait

- **Service:** `app/Modul/Tiket/Services/TiketNotificationService.php`
- **Mail Classes:** `app/Modul/Tiket/Mail/`
- **Templates:** `app/Modul/Tiket/Resources/views/emails/`
- **Controllers:** TiketController.php & TiketPublikController.php

---

**Sistem notifikasi email terintegrasi dengan pengaturan sistem yang sudah ada!**
