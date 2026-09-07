# ⚡ Test Email Tiket - Quick Start

## 🎯 3 Langkah Setup

### 1️⃣ Setup Email (5 menit)

Login `/admin/pengaturan` → Tab **"Konfigurasi Email"**

**Gmail:**
```
Host     : smtp.gmail.com
Port     : 587
Username : your-email@gmail.com
Password : (App Password - 16 digit dari Google)
Enkripsi : TLS
```

**Email Notifikasi Tiket:**
```
admin@perusahaan.com, support@perusahaan.com
```

Klik **Simpan**

---

### 2️⃣ Test (30 detik)

```bash
cd /www/wwwroot/imakecustom.com
php test_email_tiket.php
```

Pilih: **1** (Test Email Sederhana)

---

### 3️⃣ Verify

✅ Cek inbox Anda  
✅ Email dengan subject "Test Email dari Sistem Tiket" harus masuk  
✅ Jika tidak ada, cek folder spam

---

## 🧪 Full Test

Setelah test sederhana berhasil:

```bash
php test_email_tiket.php
```

**Pilih 2:** Test Notifikasi Tiket Baru  
→ Email notifikasi tiket lengkap akan dikirim

**Pilih 3:** Test Notifikasi Reply  
→ Email notifikasi balasan akan dikirim

---

## ❌ Troubleshooting Cepat

**Email tidak terkirim?**
```bash
# Cek log
tail -50 storage/logs/laravel.log | grep -i error

# Test koneksi
telnet smtp.gmail.com 587
```

**Gmail error?**
- Gunakan **App Password** bukan password biasa
- [Generate App Password](https://myaccount.google.com/apppasswords)

**Email masuk spam?**
- Whitelist sender di email Anda
- Untuk production: setup SPF/DKIM

---

## 📞 Commands

```bash
# Test script
php test_email_tiket.php

# Monitor log
tail -f storage/logs/laravel.log | grep tiket

# Clear cache
php artisan cache:clear
```

---

## ✅ Success Indicators

- ✅ Email masuk inbox dalam 1 menit
- ✅ Template HTML tampil bagus
- ✅ Semua info lengkap (nomor tiket, link)
- ✅ Link berfungsi

---

**Need detailed guide?** → `CARA_TEST_EMAIL_TIKET.md`

**Configuration help?** → `app/Modul/Tiket/README_EMAIL.md`
