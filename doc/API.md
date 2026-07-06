# API Documentation — cms.local

**Base URL:** `http://cms.local`  
**Content-Type:** `application/json`  
**Last Updated:** 2026-07-01

---

## Daftar Isi

1. [💬 Chat Widget API](#1-chat-widget-api)
2. [✅ Task API](#2-task-api)
3. [📚 Knowledgebase (Public)](#3-knowledgebase-public)
4. [📰 Berita (Public)](#4-berita-public)
5. [📄 Artikel (Public)](#5-artikel-public)
6. [🖼️ Portofolio (Public)](#6-portofolio-public)
7. [🎬 Video (Public)](#7-video-public)
8. [📬 Kontak (Public)](#8-kontak-public)
9. [📃 Halaman Statis (Public)](#9-halaman-statis-public)
10. [🔐 Autentikasi Admin](#10-autentikasi-admin)
11. [⚙️ Utilitas](#11-utilitas)
12. [📝 Catatan Penting](#12-catatan-penting)

---

## 1. 💬 Chat Widget API

> **Prefix:** `/api/chat`  
> Tidak memerlukan autentikasi. Menggunakan `widget_key` dan `session_token`.

---

### `POST /api/chat/init`

Membuat sesi chat baru untuk pengunjung.

**Request Body:**

| Field           | Tipe   | Wajib | Keterangan                          |
|-----------------|--------|-------|-------------------------------------|
| `widget_key`    | string | ✅    | Public key dari chat widget         |
| `visitor_name`  | string | ❌    | Nama pengunjung (maks. 100 karakter)|
| `visitor_email` | email  | ❌    | Email pengunjung                    |
| `page_url`      | url    | ❌    | URL halaman saat ini                |

**Contoh Request:**
```json
{
  "widget_key": "pk_abc123",
  "visitor_name": "Budi Santoso",
  "visitor_email": "budi@example.com",
  "page_url": "https://cms.local/kontak"
}
```

**Response `200 OK`:**
```json
{
  "session_token": "tok_xyz789abc",
  "widget_settings": {
    "theme_color": "#4e73df",
    "position": "bottom-right",
    "greeting": "Halo! Ada yang bisa kami bantu?"
  }
}
```

**Response `401 Unauthorized`:**
```json
{ "error": "Invalid widget key" }
```

---

### `POST /api/chat/message`

Mengirim pesan dari pengunjung dan mendapatkan balasan AI.

**Request Body:**

| Field            | Tipe   | Wajib | Keterangan                      |
|------------------|--------|-------|---------------------------------|
| `session_token`  | string | ✅    | Token sesi dari `/api/chat/init`|
| `message`        | string | ✅    | Pesan pengunjung (maks. 1000)   |

**Contoh Request:**
```json
{
  "session_token": "tok_xyz789abc",
  "message": "Bagaimana cara upload file custom?"
}
```

**Response `200 OK` — Balasan AI:**
```json
{
  "message": "Untuk upload file custom, Anda bisa menggunakan fitur...",
  "confidence": 0.87,
  "kb_articles": [
    { "id": 3, "title": "Cara Upload File Custom" }
  ]
}
```

**Response `200 OK` — Auto-eskalasi ke tiket support:**
```json
{
  "escalated": true,
  "ticket_id": 12,
  "message": "Tiket berhasil dibuat. Tim support akan menghubungi Anda segera."
}
```

**Response `404 Not Found`:**
```json
{ "error": "Invalid session" }
```

> **Catatan:** AI akan otomatis mengalihkan ke tiket support jika mendeteksi intent eskalasi (kata seperti "minta tolong agent", "hubungi manusia", dll.) atau jika confidence rendah.

---

### `POST /api/chat/escalate`

Eskalasi manual sesi chat ke tiket support.

**Request Body:**

| Field           | Tipe   | Wajib | Keterangan         |
|-----------------|--------|-------|--------------------|
| `session_token` | string | ✅    | Token sesi aktif   |

**Contoh Request:**
```json
{
  "session_token": "tok_xyz789abc"
}
```

**Response `200 OK`:**
```json
{
  "escalated": true,
  "ticket_id": 12,
  "message": "Tiket support Anda sudah dibuat sebelumnya."
}
```

---

### `GET /api/chat/history/{sessionToken}`

Mengambil seluruh riwayat percakapan dalam sebuah sesi.

**Path Parameter:**

| Parameter      | Tipe   | Keterangan              |
|----------------|--------|-------------------------|
| `sessionToken` | string | Token sesi dari `init`  |

**Contoh Request:**
```
GET /api/chat/history/tok_xyz789abc
```

**Response `200 OK`:**
```json
{
  "messages": [
    {
      "sender": "ai",
      "message": "Halo! 👋 Saya asisten AI. Ada yang bisa saya bantu?",
      "timestamp": "2026-07-01T10:00:00.000Z"
    },
    {
      "sender": "pengunjung",
      "message": "Bagaimana cara upload file?",
      "timestamp": "2026-07-01T10:01:00.000Z"
    },
    {
      "sender": "ai",
      "message": "Untuk upload file...",
      "timestamp": "2026-07-01T10:01:02.000Z"
    }
  ],
  "status": "aktif"
}
```

**Nilai `status`:** `aktif` | `eskalasi` | `selesai`

---

### `POST /api/chat/end`

Mengakhiri sesi chat.

**Request Body:**

| Field           | Tipe   | Wajib | Keterangan         |
|-----------------|--------|-------|--------------------|
| `session_token` | string | ✅    | Token sesi aktif   |

**Response `200 OK`:**
```json
{ "success": true }
```

---

## 2. ✅ Task API

> **Prefix:** `/v1/tasks`  
> ⚠️ **Memerlukan autentikasi** — sesi login admin (cookie session).

---

### `GET /v1/tasks`

Mengambil daftar semua task (paginated).

**Query Parameters (opsional):**

| Parameter     | Tipe    | Keterangan                                                   |
|---------------|---------|--------------------------------------------------------------|
| `status`      | string  | Filter: `pending` \| `in_progress` \| `done` \| `cancelled` |
| `assigned_to` | integer | Filter berdasarkan ID pengguna                               |

**Contoh Request:**
```
GET /v1/tasks?status=pending&assigned_to=2
```

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "uuid": "550e8400-e29b-41d4-a716-446655440000",
      "title": "Fix login bug",
      "description": null,
      "status": "pending",
      "priority": "high",
      "assigned_to": null,
      "created_by": 1,
      "tiket_id": null,
      "parent_task_id": null,
      "due_at": null,
      "created_at": "2026-07-01T10:00:00.000000Z",
      "updated_at": "2026-07-01T10:00:00.000000Z"
    }
  ],
  "current_page": 1,
  "per_page": 20,
  "total": 5,
  "last_page": 1
}
```

---

### `POST /v1/tasks`

Membuat task baru.

**Request Body:**

| Field            | Tipe    | Wajib | Keterangan                                       |
|------------------|---------|-------|--------------------------------------------------|
| `title`          | string  | ✅    | Judul task (maks. 255 karakter)                  |
| `priority`       | string  | ✅    | `low` \| `medium` \| `high` \| `urgent`          |
| `tiket_id`       | integer | ❌    | ID tiket terkait (tabel `tikets`)                |
| `parent_task_id` | integer | ❌    | ID task induk jika ini sub-task (tabel `tasks`)  |

**Contoh Request:**
```json
{
  "title": "Investigasi error upload gambar",
  "priority": "high",
  "tiket_id": 5
}
```

**Response `201 Created`:**
```json
{
  "id": 8,
  "uuid": "b3d9a1f2-...",
  "title": "Investigasi error upload gambar",
  "status": "pending",
  "priority": "high",
  "created_by": 1,
  "tiket_id": 5
}
```

**Response `422 Unprocessable Entity`:**
```json
{
  "message": "The priority field is required.",
  "errors": { "priority": ["The priority field is required."] }
}
```

---

### `GET /v1/tasks/{uuid}`

Mengambil detail satu task beserta riwayat aktivitasnya.

**Path Parameter:**

| Parameter | Tipe   | Keterangan  |
|-----------|--------|-------------|
| `uuid`    | string | UUID task   |

**Response `200 OK`:**
```json
{
  "id": 8,
  "uuid": "b3d9a1f2-...",
  "title": "Investigasi error upload gambar",
  "description": "Cek kenapa upload gagal di endpoint /api/upload",
  "status": "in_progress",
  "priority": "high",
  "assigned_to": 2,
  "due_at": "2026-07-10T00:00:00.000000Z",
  "activities": [
    {
      "id": 1,
      "task_id": 8,
      "action": "created",
      "actor_id": 1,
      "created_at": "2026-07-01T10:00:00.000000Z"
    },
    {
      "id": 2,
      "task_id": 8,
      "action": "status_changed",
      "actor_id": 1,
      "created_at": "2026-07-01T10:05:00.000000Z"
    }
  ]
}
```

---

### `PUT /v1/tasks/{uuid}`

Memperbarui judul, deskripsi, atau deadline task.

**Request Body:**

| Field         | Tipe     | Wajib | Keterangan                             |
|---------------|----------|-------|----------------------------------------|
| `title`       | string   | ❌    | Judul baru task                        |
| `description` | string   | ❌    | Deskripsi task                         |
| `due_at`      | datetime | ❌    | Deadline (ISO 8601, `null` untuk hapus)|

**Contoh Request:**
```json
{
  "title": "Investigasi & fix error upload gambar",
  "description": "Cek handler di StorageController",
  "due_at": "2026-07-15T17:00:00"
}
```

**Response `200 OK`:** Data task yang diperbarui.

---

### `POST /v1/tasks/{uuid}/status`

Mengubah status task.

**Request Body:**

| Field    | Tipe   | Wajib | Keterangan                                                   |
|----------|--------|-------|--------------------------------------------------------------|
| `status` | string | ✅    | `pending` \| `in_progress` \| `done` \| `cancelled`         |

**Contoh Request:**
```json
{ "status": "done" }
```

**Response `200 OK`:** Data task yang diperbarui.

---

### `POST /v1/tasks/{uuid}/assign`

Menetapkan task ke pengguna tertentu.

**Request Body:**

| Field         | Tipe    | Wajib | Keterangan                             |
|---------------|---------|-------|----------------------------------------|
| `assigned_to` | integer | ✅    | ID pengguna (harus ada di tabel `pengguna`) |

**Contoh Request:**
```json
{ "assigned_to": 3 }
```

**Response `200 OK`:** Data task yang diperbarui.

---

### `DELETE /v1/tasks/{uuid}`

Menghapus task secara permanen.

**Response `200 OK`:**
```json
{ "message": "Task deleted" }
```

---

### `POST /v1/tasks/generate-ai`

Membuat task secara otomatis menggunakan AI berdasarkan konten teks.

**Request Body:**

| Field     | Tipe   | Wajib | Keterangan                                   |
|-----------|--------|-------|----------------------------------------------|
| `content` | string | ✅    | Teks/deskripsi yang dianalisis AI untuk membuat task |

**Contoh Request:**
```json
{
  "content": "Pelanggan melaporkan halaman login tidak bisa diakses sejak pukul 14.00 WIB. Perlu investigasi dan perbaikan segera."
}
```

**Response `200 OK`:**
```json
{
  "data": [
    { "title": "Investigasi error halaman login", "priority": "urgent" },
    { "title": "Cek log server pukul 14.00 WIB", "priority": "high" },
    { "title": "Buat laporan incident", "priority": "medium" }
  ]
}
```

---

## 3. 📚 Knowledgebase (Public)

> Tidak memerlukan autentikasi.

---

### `GET /kb`

Halaman utama Knowledgebase — menampilkan semua kategori, artikel populer, dan hasil pencarian.

**Query Parameter (opsional):**

| Parameter | Tipe   | Keterangan                    |
|-----------|--------|-------------------------------|
| `q`       | string | Kata kunci pencarian artikel  |

**Contoh Request:**
```
GET /kb?q=cara upload
```

**Response:** `200 OK` — HTML view

---

### `GET /kb/category/{slug}`

Menampilkan semua artikel dalam satu kategori KB.

**Path Parameter:**

| Parameter | Tipe   | Keterangan           |
|-----------|--------|----------------------|
| `slug`    | string | Slug kategori KB     |

**Response:** `200 OK` — HTML view | `404` jika kategori tidak ditemukan

---

### `GET /kb/{slug}`

Menampilkan detail satu artikel KB. View count artikel akan otomatis bertambah.

**Path Parameter:**

| Parameter | Tipe   | Keterangan        |
|-----------|--------|-------------------|
| `slug`    | string | Slug artikel KB   |

**Response:** `200 OK` — HTML view | `404` jika artikel tidak ditemukan

---

### `POST /kb/ai-assistant`

Mengajukan pertanyaan ke AI yang akan menjawab berdasarkan konten Knowledgebase.

**Request Body:**

| Field        | Tipe   | Wajib | Keterangan                      |
|--------------|--------|-------|---------------------------------|
| `pertanyaan` | string | ✅    | Pertanyaan pengguna (maks. 500) |

**Contoh Request:**
```json
{
  "pertanyaan": "Bagaimana cara mengatur ulang kata sandi akun saya?"
}
```

**Response `200 OK` — Berhasil:**
```json
{
  "berhasil": true,
  "data": {
    "jawaban": "<p>Untuk mengatur ulang kata sandi, ikuti langkah berikut:</p><ol><li>Klik <strong>Lupa Kata Sandi</strong> di halaman login</li><li>Masukkan email Anda</li><li>Cek email untuk tautan reset</li></ol>",
    "artikel_relevan": [
      { "judul": "Cara Reset Password", "url": "/kb/cara-reset-password" },
      { "judul": "Pengaturan Akun", "url": "/kb/pengaturan-akun" }
    ]
  }
}
```

**Response `200 OK` — Gagal (API key belum dikonfigurasi):**
```json
{
  "berhasil": false,
  "pesan": "AI Assistant belum dikonfigurasi. Silakan hubungi administrator."
}
```

> ⚠️ **Prasyarat:** Gemini API Key (`ai_gemini_key`) harus sudah diisi di halaman **Admin → Pengaturan → AI** sebelum endpoint ini dapat digunakan.

---

## 4. 📰 Berita (Public)

> Tidak memerlukan autentikasi.

---

### `GET /berita`

Daftar semua berita (paginated, 12 per halaman).

**Query Parameter (opsional):**

| Parameter | Tipe   | Keterangan                        |
|-----------|--------|-----------------------------------|
| `cari`    | string | Pencarian berdasarkan judul/isi   |

**Contoh Request:**
```
GET /berita?cari=shopify
```

**Response:** `200 OK` — HTML view

---

### `GET /berita/{kategori}/{slug}`

Detail berita beserta berita terkait dan video terbaru.

**Path Parameters:**

| Parameter  | Tipe   | Keterangan             |
|------------|--------|------------------------|
| `kategori` | string | Slug kategori berita   |
| `slug`     | string | Slug berita            |

**Response:** `200 OK` — HTML view | `404` jika tidak ditemukan

---

### `GET /berita/kategori/{slug}`

Daftar berita dalam satu kategori.

| Parameter | Tipe   | Keterangan           |
|-----------|--------|----------------------|
| `slug`    | string | Slug kategori berita |

**Response:** `200 OK` — HTML view | `404` jika kategori tidak ditemukan

---

### `GET /tag/{slug}`

Daftar berita berdasarkan tag.

| Parameter | Tipe   | Keterangan    |
|-----------|--------|---------------|
| `slug`    | string | Slug tag      |

**Response:** `200 OK` — HTML view | `404` jika tag tidak ditemukan

---

## 5. 📄 Artikel (Public)

> Tidak memerlukan autentikasi.

---

| Method | URL                         | Keterangan                              |
|--------|-----------------------------|-----------------------------------------|
| `GET`  | `/artikel`                  | Daftar semua artikel (paginated)        |
| `GET`  | `/artikel/{slug}`           | Detail artikel + artikel terkait        |
| `GET`  | `/artikel/kategori/{slug}`  | Daftar artikel dalam kategori           |

**Response:** `200 OK` — HTML view | `404` jika tidak ditemukan

---

## 6. 🖼️ Portofolio (Public)

> Tidak memerlukan autentikasi.

---

### `GET /portofolio`

Daftar semua portofolio (paginated, 12 per halaman, diurutkan berdasarkan `urutan`).

**Query Parameter (opsional):**

| Parameter | Tipe   | Keterangan                            |
|-----------|--------|---------------------------------------|
| `tag`     | string | Filter portofolio berdasarkan tag     |

**Contoh Request:**
```
GET /portofolio?tag=web-design
```

**Response:** `200 OK` — HTML view

---

## 7. 🎬 Video (Public)

> Tidak memerlukan autentikasi.

---

| Method | URL               | Keterangan                                               |
|--------|-------------------|----------------------------------------------------------|
| `GET`  | `/video`          | Daftar semua video aktif (unggulan diprioritaskan)       |
| `GET`  | `/video/{slug}`   | Detail video + 4 video terkait                           |

**Response:** `200 OK` — HTML view | `404` jika tidak ditemukan

---

## 8. 📬 Kontak (Public)

> Tidak memerlukan autentikasi.

---

### `GET /kontak`

Menampilkan halaman formulir kontak.

**Response:** `200 OK` — HTML view

---

### `POST /kontak`

Mengirim pesan kontak. Data akan disimpan ke tabel `kontak` dengan status `baru`.

**Content-Type:** `application/x-www-form-urlencoded` atau `multipart/form-data`

**Request Body:**

| Field     | Tipe   | Wajib | Validasi        | Keterangan        |
|-----------|--------|-------|-----------------|-------------------|
| `nama`    | string | ✅    | maks. 255       | Nama pengirim     |
| `email`   | email  | ✅    | maks. 255       | Email pengirim    |
| `perihal` | string | ✅    | maks. 255       | Subjek pesan      |
| `pesan`   | string | ✅    | -               | Isi pesan         |

**Response:** Redirect kembali ke halaman `/kontak` dengan flash message:
```
berhasil: "Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda."
```

---

## 9. 📃 Halaman Statis (Public)

> Tidak memerlukan autentikasi.  
> Halaman ini otomatis menampilkan konten dari tabel `artikel` jika slug yang cocok ditemukan.

| Method | URL              | Slug Artikel Dicari      | Keterangan          |
|--------|------------------|--------------------------|---------------------|
| `GET`  | `/tentang-kami`  | `tentang-kami`           | Halaman tentang kami|
| `GET`  | `/redaksi`       | `redaksi`                | Halaman redaksi     |
| `GET`  | `/kebijakan`     | `kebijakan-privasi`      | Kebijakan privasi   |
| `GET`  | `/syarat`        | `syarat-dan-ketentuan`   | Syarat & ketentuan  |

**Response:** `200 OK` — HTML view (konten dari artikel jika ada, atau template statis)

---

## 10. 🔐 Autentikasi Admin

> Autentikasi berbasis **session** Laravel (bukan token API).

---

### `GET /mlebu`

Menampilkan halaman form login admin.

**Response:** `200 OK` — HTML view

---

### `POST /mlebu`

Memproses login admin.

**Content-Type:** `application/x-www-form-urlencoded`

**Request Body:**

| Field      | Tipe   | Wajib | Keterangan       |
|------------|--------|-------|------------------|
| `email`    | email  | ✅    | Email admin      |
| `password` | string | ✅    | Password admin   |

**Contoh:**
```
email=admin@imakecustom.com&password=admin123
```

**Response berhasil:** Redirect ke `/admin`  
**Response gagal:** Redirect kembali ke `/mlebu` dengan error validasi

> ⚠️ **Catatan untuk integrasi eksternal:** Autentikasi ini berbasis cookie session. Untuk mengakses endpoint admin yang terproteksi dari aplikasi eksternal, Anda harus menyertakan cookie sesi (`laravel_session`) yang didapat setelah login berhasil.

---

### `POST /keluar`

Logout dari sesi admin.

**Catatan:** Memerlukan CSRF token (field `_token`).

---

## 11. ⚙️ Utilitas

---

### `GET /up`

Health check — memastikan aplikasi berjalan dengan baik.

**Response `200 OK`:** (kosong atau status message)

---

### `GET /storage/{path}`

Mengakses file yang diupload (gambar, dokumen, dll.).

**Path Parameter:**

| Parameter | Tipe   | Keterangan                  |
|-----------|--------|-----------------------------|
| `path`    | string | Relatif path file di storage|

**Contoh:**
```
GET /storage/berita/filename.jpg
GET /storage/portfolio/project-image.png
GET /storage/slideshow/hero-slide.jpg
GET /storage/artikel/cover.jpg
```

> File disimpan di `storage/app/public/` dan dapat diakses melalui symlink `public/storage`.

---

## 12. 📝 Catatan Penting

### 🔑 Ringkasan Autentikasi

| Grup Endpoint            | Metode Auth            | Keterangan                               |
|--------------------------|------------------------|------------------------------------------|
| `GET /api/chat/*`        | `widget_key`           | Public key dari widget yang aktif        |
| `POST /api/chat/*`       | `session_token`        | Token dari `/api/chat/init`              |
| `GET|POST /v1/tasks/*`   | Session cookie         | Harus login admin terlebih dahulu        |
| `GET /kb/*`              | Tidak perlu            | Akses publik                             |
| `POST /kb/ai-assistant`  | Tidak perlu            | Perlu Gemini API key di pengaturan admin |
| Semua endpoint publik    | Tidak perlu            | Akses terbuka                            |

### 📦 Format Response

| Tipe Endpoint    | Format Response      | Keterangan                                           |
|------------------|----------------------|------------------------------------------------------|
| API (`/api/*`, `/v1/*`) | JSON         | `Content-Type: application/json`                    |
| Halaman publik   | HTML                 | Server-rendered Blade view                           |
| POST form        | Redirect             | Redirect dengan flash session message                |

### 🔒 CSRF Token

Semua request `POST` ke halaman web (bukan ke `/api/*` atau `/v1/*`) memerlukan CSRF token:

```html
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

Atau via header:
```
X-CSRF-TOKEN: {token}
```

### 🤖 Fitur AI yang Tersedia

| Fitur                | Endpoint                       | Model AI                        |
|----------------------|--------------------------------|---------------------------------|
| Chat AI otomatis     | `POST /api/chat/message`       | Dikonfigurasi via panel ChatWidget |
| KB AI Assistant      | `POST /kb/ai-assistant`        | Google Gemini (diatur di Admin → Pengaturan) |
| Task Generator AI    | `POST /v1/tasks/generate-ai`   | AI Task Generator service       |

### 📁 Folder Upload Storage

File upload tersedia di path berikut (relatif terhadap `storage/app/public/`):

| Tipe Konten | Folder Storage    | URL Akses                         |
|-------------|-------------------|-----------------------------------|
| Berita      | `berita/`         | `/storage/berita/filename.jpg`    |
| Artikel     | `artikel/`        | `/storage/artikel/filename.jpg`   |
| Portofolio  | `portfolio/`      | `/storage/portfolio/filename.jpg` |
| Slideshow   | `slideshow/`      | `/storage/slideshow/filename.jpg` |
| Iklan       | `iklan/`          | `/storage/iklan/filename.jpg`     |
| Layanan     | `layanans/`       | `/storage/layanans/filename.jpg`  |
| Tema        | `tema/`           | `/storage/tema/filename.jpg`      |
