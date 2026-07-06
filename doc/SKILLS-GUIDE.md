# Panduan Lengkap Skills Kiro IDE
> Dokumentasi semua skill yang tersedia di `~/.kiro/skills/` — dalam Bahasa Indonesia

---

## Daftar Isi

1. [Cara Menggunakan Skill](#cara-menggunakan-skill)
2. [Arsitektur & Perencanaan](#arsitektur--perencanaan)
3. [Review Kode Umum](#review-kode-umum)
4. [Review Per Bahasa / Framework](#review-per-bahasa--framework)
5. [Perbaikan Build Error Per Bahasa](#perbaikan-build-error-per-bahasa)
6. [Pengujian & Kualitas](#pengujian--kualitas)
7. [Keamanan](#keamanan)
8. [Performa & Refactoring](#performa--refactoring)
9. [Alur Kerja Pengembangan](#alur-kerja-pengembangan)
10. [Database & Jaringan](#database--jaringan)
11. [Open Source & Dokumentasi](#open-source--dokumentasi)
12. [Agen GAN & Otomasi Lanjutan](#agen-gan--otomasi-lanjutan)
13. [Pemasaran & SEO](#pemasaran--seo)
14. [Khusus Domain](#khusus-domain)

---

## Cara Menggunakan Skill

Skill adalah agen khusus yang bisa dipanggil untuk menangani tugas tertentu. Kiro akan mengaktifkan skill yang relevan secara otomatis, atau Anda bisa memintanya secara eksplisit.

**Cara memanggil skill:**
```
Gunakan skill [nama-skill] untuk [tugas Anda]
```

**Contoh:**
```
Gunakan skill security-reviewer untuk memeriksa kode autentikasi ini
Gunakan skill react-build-resolver karena build React saya gagal
Gunakan skill brainstorming sebelum kita mulai membangun fitur ini
```

---

## Arsitektur & Perencanaan

### `architect`
**Kapan digunakan:** Saat merencanakan fitur baru, merefaktor sistem besar, atau membuat keputusan arsitektur.

Spesialis arsitektur perangkat lunak untuk desain sistem, skalabilitas, dan pengambilan keputusan teknis. Membantu merancang arsitektur yang skalabel dan mudah dipelihara, menganalisis trade-off, dan memberikan panduan arah teknis secara keseluruhan.

---

### `code-architect`
**Kapan digunakan:** Sebelum mengimplementasikan fitur kompleks — butuh blueprint implementasi yang konkret.

Merancang arsitektur fitur dengan menganalisis pola dan konvensi kodebase yang sudah ada, lalu memberikan blueprint implementasi lengkap: file yang perlu dibuat, antarmuka, alur data, dan urutan pembangunan.

---

### `a11y-architect`
**Kapan digunakan:** Saat mendesain komponen UI, membangun design system, atau mengaudit kode untuk inklusivitas.

Arsitek Aksesibilitas spesialis WCAG 2.2 untuk platform Web dan Native. Memastikan produk digital memenuhi prinsip POUR (Perceivable, Operable, Understandable, Robust) untuk semua pengguna termasuk penyandang disabilitas.

---

### `planner`
**Kapan digunakan:** Saat pengguna meminta implementasi fitur, perubahan arsitektur, atau refactoring kompleks.

Spesialis perencanaan untuk fitur kompleks dan refactoring. Membuat rencana implementasi yang detail dan terstruktur sebelum menyentuh kode.

---

### `homelab-architect`
**Kapan digunakan:** Saat merancang jaringan rumah atau lab kecil.

Merancang rencana jaringan rumah dan lab kecil dari inventaris perangkat keras, tujuan, dan tingkat pengalaman operator — dilengkapi panduan perubahan bertahap yang aman dan rollback.

---

### `brainstorming`
**Kapan digunakan:** WAJIB sebelum pekerjaan kreatif apapun — membuat fitur, membangun komponen, menambah fungsionalitas, atau mengubah perilaku sistem.

Membantu mengubah ide menjadi desain dan spesifikasi yang matang melalui dialog kolaboratif. Mengeksplorasi niat pengguna, persyaratan, dan desain sebelum implementasi dimulai.

---

### `writing-plans`
**Kapan digunakan:** Saat memiliki spesifikasi atau kebutuhan untuk tugas multi-langkah, sebelum menyentuh kode.

Menulis rencana implementasi yang komprehensif: file mana yang perlu diubah, kode, pengujian, dokumentasi yang perlu dicek, dan cara mengujinya. Semua dalam tugas-tugas kecil yang bisa dikerjakan satu per satu.

---

## Review Kode Umum

### `code-reviewer`
**Kapan digunakan:** Segera setelah menulis atau memodifikasi kode. WAJIB digunakan untuk semua perubahan kode.

Spesialis review kode untuk kualitas, keamanan, dan kemudahan pemeliharaan. Meninjau kode yang baru ditulis atau dimodifikasi untuk memastikan standar kode terpenuhi.

---

### `code-explorer`
**Kapan digunakan:** Sebelum memulai pekerjaan baru di area kodebase yang belum dikenal.

Menganalisis fitur kodebase yang ada secara mendalam dengan menelusuri jalur eksekusi, memetakan lapisan arsitektur, dan mendokumentasikan dependensi untuk menginformasikan pengembangan baru.

---

### `code-simplifier`
**Kapan digunakan:** Setelah menulis kode, terutama kode yang baru dimodifikasi.

Menyederhanakan dan memperbaiki kode untuk kejelasan, konsistensi, dan kemudahan pemeliharaan tanpa mengubah perilaku yang ada.

---

### `comment-analyzer`
**Kapan digunakan:** Saat ingin memastikan komentar kode akurat dan tidak usang.

Menganalisis komentar kode untuk akurasi, kelengkapan, kemudahan pemeliharaan, dan risiko "comment rot" (komentar yang sudah tidak sesuai dengan kode).

---

### `silent-failure-hunter`
**Kapan digunakan:** Setelah menulis kode penanganan error atau alur data penting.

Meninjau kode untuk kegagalan diam (silent failures), error yang ditelan, fallback yang buruk, dan propagasi error yang hilang. Sangat penting untuk menemukan bug yang tersembunyi.

---

### `type-design-analyzer`
**Kapan digunakan:** Saat mendesain tipe data, interface, atau struktur data.

Menganalisis desain tipe untuk enkapsulasi, ekspresi invariant, kegunaan, dan penegakan aturan tipe.

---

### `pr-test-analyzer`
**Kapan digunakan:** Saat mereview pull request untuk memastikan cakupan pengujian memadai.

Meninjau kualitas dan kelengkapan cakupan pengujian pull request, dengan penekanan pada cakupan perilaku dan pencegahan bug nyata.

---

### `conversation-analyzer`
**Kapan digunakan:** Saat menganalisis riwayat percakapan untuk menemukan perilaku yang perlu dicegah dengan hooks.

Dipicu dengan perintah `/hookify` tanpa argumen. Menganalisis riwayat percakapan untuk mengidentifikasi perilaku bermasalah yang sebaiknya dicegah.

---

## Review Per Bahasa / Framework

### `typescript-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode TypeScript dan JavaScript. WAJIB untuk proyek TypeScript/JavaScript.

Spesialis review TypeScript/JavaScript untuk keamanan tipe, async yang benar, keamanan Node/web, dan pola idiomatis.

---

### `react-reviewer`
**Kapan digunakan:** Untuk perubahan apapun yang menyentuh file `.tsx`/`.jsx` atau logika komponen React. WAJIB untuk proyek React.

Spesialis review React/JSX untuk kebenaran hook, performa render, batas komponen server/client, aksesibilitas, dan keamanan spesifik React.

---

### `php-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode PHP. WAJIB untuk proyek PHP.

Spesialis review PHP untuk kepatuhan PSR-12, sistem tipe PHP, pola Eloquent ORM, keamanan, dan performa.

---

### `python-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Python. WAJIB untuk proyek Python.

Spesialis review Python untuk kepatuhan PEP 8, idiom Pythonic, type hints, keamanan, dan performa.

---

### `django-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Django. WAJIB untuk proyek Django.

Spesialis review Django untuk kebenaran ORM, pola DRF, keamanan migrasi, miskonfigurasi keamanan, dan praktik Django tingkat produksi.

---

### `fastapi-reviewer`
**Kapan digunakan:** Untuk review aplikasi FastAPI.

Meninjau aplikasi FastAPI untuk kebenaran async, dependency injection, skema Pydantic, keamanan, kualitas OpenAPI, pengujian, dan kesiapan produksi.

---

### `java-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Java. WAJIB untuk proyek Java.

Spesialis review Java untuk proyek Spring Boot dan Quarkus. Mendeteksi framework secara otomatis dan menerapkan aturan review yang sesuai. Mencakup arsitektur berlapis, JPA/Panache, MongoDB, keamanan, dan konkurensi.

---

### `kotlin-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Kotlin/Android/KMP.

Meninjau kode Kotlin untuk pola idiomatis, keamanan coroutine, praktik Compose terbaik, pelanggaran clean architecture, dan masalah Android umum.

---

### `flutter-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Flutter/Dart.

Meninjau kode Flutter untuk praktik terbaik widget, pola state management, idiom Dart, jebakan performa, aksesibilitas, dan pelanggaran clean architecture. Tidak terikat pada library state management tertentu.

---

### `go-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Go. WAJIB untuk proyek Go.

Spesialis review Go untuk idiom Go, pola konkurensi, penanganan error, dan performa.

---

### `rust-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Rust. WAJIB untuk proyek Rust.

Spesialis review Rust untuk ownership, lifetimes, penanganan error, penggunaan unsafe, dan pola idiomatis.

---

### `swift-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode Swift. WAJIB untuk proyek Swift.

Spesialis review Swift untuk desain protocol-oriented, value semantics, manajemen memori ARC, Swift Concurrency, dan pola idiomatis.

---

### `cpp-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode C++. WAJIB untuk proyek C++.

Spesialis review C++ untuk keamanan memori, idiom C++ modern, konkurensi, dan performa.

---

### `csharp-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode C#. WAJIB untuk proyek C#.

Spesialis review C# untuk konvensi .NET, pola async, keamanan, nullable reference types, dan performa.

---

### `fsharp-reviewer`
**Kapan digunakan:** Untuk semua perubahan kode F#. WAJIB untuk proyek F#.

Spesialis review F# untuk idiom fungsional, keamanan tipe, pattern matching, computation expressions, dan performa.

---

### `harmonyos-app-resolver`
**Kapan digunakan:** Untuk proyek HarmonyOS/OpenHarmony.

Spesialis pengembangan aplikasi HarmonyOS dengan ArkTS dan ArkUI. Meninjau kode untuk kepatuhan manajemen state V2, pola routing Navigation, penggunaan API, dan praktik terbaik performa.

---

## Perbaikan Build Error Per Bahasa

### `build-error-resolver`
**Kapan digunakan:** Saat build gagal atau terjadi error TypeScript/JavaScript umum.

Spesialis perbaikan build dan error TypeScript. Memperbaiki error build/tipe dengan perubahan minimal — tidak ada perubahan arsitektur. Fokus pada membuat build kembali hijau dengan cepat.

---

### `react-build-resolver`
**Kapan digunakan:** WAJIB saat build React gagal.

Mendiagnosis dan memperbaiki kegagalan build React di Vite, webpack, Next.js, CRA, Parcel, esbuild, dan Bun. Menangani error compile JSX/TSX, hydration mismatch, kegagalan batas komponen server/client, missing types, dan masalah konfigurasi bundler.

---

### `java-build-resolver`
**Kapan digunakan:** Saat build Java gagal.

Spesialis perbaikan build Java/Maven/Gradle. Mendeteksi otomatis Spring Boot atau Quarkus dan menerapkan perbaikan spesifik framework. Memperbaiki error build, error compiler Java, dan masalah Maven/Gradle.

---

### `kotlin-build-resolver`
**Kapan digunakan:** Saat build Kotlin gagal.

Spesialis perbaikan build Kotlin/Gradle. Memperbaiki error build, error compiler Kotlin, dan masalah Gradle dengan perubahan minimal.

---

### `dart-build-resolver`
**Kapan digunakan:** Saat build Dart/Flutter gagal.

Spesialis perbaikan build Dart/Flutter. Memperbaiki error `dart analyze`, kegagalan kompilasi Flutter, konflik dependensi pub, dan masalah build_runner.

---

### `go-build-resolver`
**Kapan digunakan:** Saat build Go gagal.

Spesialis perbaikan build Go. Memperbaiki error build, masalah `go vet`, dan peringatan linter dengan perubahan minimal.

---

### `rust-build-resolver`
**Kapan digunakan:** Saat build Rust gagal.

Spesialis perbaikan build Rust. Memperbaiki error cargo build, masalah borrow checker, dan masalah Cargo.toml dengan perubahan minimal.

---

### `swift-build-resolver`
**Kapan digunakan:** Saat build Swift/Xcode gagal.

Spesialis perbaikan build Swift/Xcode. Memperbaiki error swift build, kegagalan build Xcode, masalah dependensi SPM, dan masalah code signing.

---

### `cpp-build-resolver`
**Kapan digunakan:** Saat build C++ gagal.

Spesialis perbaikan build C++, CMake, dan error kompilasi. Memperbaiki error build, masalah linker, dan error template dengan perubahan minimal.

---

### `django-build-resolver`
**Kapan digunakan:** Saat setup atau startup Django gagal.

Spesialis perbaikan build/migrasi Django/Python. Memperbaiki error pip/Poetry, konflik migrasi, error import, masalah konfigurasi Django, dan kegagalan collectstatic.

---

### `pytorch-build-resolver`
**Kapan digunakan:** Saat training atau inferensi PyTorch crash.

Spesialis perbaikan error runtime PyTorch, CUDA, dan training. Memperbaiki ketidakcocokan bentuk tensor, error device, masalah gradient, masalah DataLoader, dan kegagalan mixed precision.

---

## Pengujian & Kualitas

### `tdd-guide`
**Kapan digunakan:** PROAKTIF saat menulis fitur baru, memperbaiki bug, atau merefaktor kode.

Spesialis Test-Driven Development yang menegakkan metodologi tulis-tes-dulu. Memastikan cakupan pengujian minimal 80%.

**Alur kerja TDD:**
1. Tulis tes yang gagal
2. Tulis kode minimal untuk membuatnya lulus
3. Refaktor sambil menjaga tes tetap hijau

---

### `test-driven-development`
**Kapan digunakan:** Saat mengimplementasikan fitur atau bugfix apapun, sebelum menulis kode implementasi.

Skill workflow TDD: Tulis tes dulu. Lihat gagal. Tulis kode minimal untuk lulus.

---

### `e2e-runner`
**Kapan digunakan:** PROAKTIF untuk menghasilkan, memelihara, dan menjalankan tes end-to-end.

Spesialis pengujian end-to-end menggunakan Vercel Agent Browser (utama) dengan fallback Playwright. Mengelola journey tes, mengkarantina tes flaky, mengunggah artefak (screenshot, video, trace), dan memastikan alur pengguna kritis berfungsi.

---

### `pr-test-analyzer`
**Kapan digunakan:** Saat mereview pull request untuk memastikan cakupan pengujian.

Meninjau kualitas dan kelengkapan cakupan pengujian PR dengan penekanan pada cakupan perilaku dan pencegahan bug nyata.

---

## Keamanan

### `security-reviewer`
**Kapan digunakan:** PROAKTIF setelah menulis kode yang menangani input pengguna, autentikasi, endpoint API, atau data sensitif.

Spesialis deteksi dan remediasi kerentanan keamanan. Menandai secrets yang bocor, SSRF, injeksi, kriptografi tidak aman, dan kerentanan OWASP Top 10.

**Yang diperiksa:**
- SQL/Command Injection
- XSS dan CSRF
- Autentikasi dan otorisasi
- Secrets yang ter-hardcode
- Kriptografi tidak aman
- SSRF (Server-Side Request Forgery)

---

### `healthcare-reviewer`
**Kapan digunakan:** Untuk aplikasi kesehatan, EMR/EHR, sistem pendukung keputusan klinis.

Meninjau kode aplikasi kesehatan untuk keselamatan klinis, akurasi CDSS, kepatuhan PHI, dan integritas data medis. Spesialis untuk EMR/EHR dan sistem informasi kesehatan.

---

## Performa & Refactoring

### `performance-optimizer`
**Kapan digunakan:** PROAKTIF untuk mengidentifikasi bottleneck, mengoptimalkan kode lambat, mengurangi ukuran bundle, dan meningkatkan performa runtime.

Spesialis analisis dan optimasi performa. Mencakup profiling, kebocoran memori, optimasi render, dan peningkatan algoritmik.

---

### `refactor-cleaner`
**Kapan digunakan:** PROAKTIF untuk menghapus kode yang tidak digunakan, duplikat, dan refactoring.

Spesialis pembersihan dead code dan konsolidasi. Menjalankan alat analisis (knip, depcheck, ts-prune) untuk mengidentifikasi dan menghapus kode mati dengan aman.

---

### `code-simplifier`
**Kapan digunakan:** Setelah menulis kode, untuk menyederhanakan tanpa mengubah perilaku.

Menyederhanakan kode untuk kejelasan, konsistensi, dan kemudahan pemeliharaan sambil mempertahankan fungsionalitas yang ada.

---

## Alur Kerja Pengembangan

### `systematic-debugging`
**Kapan digunakan:** Saat menemukan bug, kegagalan tes, atau perilaku tak terduga — SEBELUM mengusulkan perbaikan.

Debugging terstruktur yang mencegah perbaikan acak yang membuang waktu dan menciptakan bug baru. Pendekatan sistematis untuk menemukan akar penyebab masalah.

---

### `verification-before-completion`
**Kapan digunakan:** Saat akan mengklaim pekerjaan selesai, diperbaiki, atau lulus — sebelum commit atau membuat PR.

Membutuhkan menjalankan perintah verifikasi dan mengkonfirmasi output sebelum membuat klaim keberhasilan apapun. Prinsip: bukti sebelum pernyataan.

---

### `requesting-code-review`
**Kapan digunakan:** Saat menyelesaikan tugas, mengimplementasikan fitur besar, atau sebelum merge.

Mengirimkan subagent reviewer kode untuk menangkap masalah sebelum cascading. Reviewer mendapat konteks yang dirancang khusus untuk evaluasi.

---

### `receiving-code-review`
**Kapan digunakan:** Saat menerima feedback code review, terutama jika feedback tidak jelas atau secara teknis diragukan.

Membutuhkan evaluasi teknis, bukan performa emosional. Mengharuskan verifikasi dan kekakuan teknis, bukan persetujuan buta atau implementasi tanpa berpikir.

---

### `finishing-a-development-branch`
**Kapan digunakan:** Saat implementasi selesai, semua tes lulus, dan Anda perlu memutuskan cara mengintegrasikan pekerjaan.

Memandu penyelesaian pekerjaan pengembangan dengan menyajikan opsi terstruktur untuk merge, PR, atau pembersihan.

---

### `using-git-worktrees`
**Kapan digunakan:** Saat memulai pekerjaan fitur yang membutuhkan isolasi dari workspace saat ini, atau sebelum menjalankan rencana implementasi.

Memastikan pekerjaan terjadi di workspace yang terisolasi. Lebih memilih alat worktree native platform. Jatuh ke git worktrees manual hanya jika tidak ada alat native.

---

### `executing-plans`
**Kapan digunakan:** Saat memiliki rencana implementasi tertulis untuk dieksekusi dalam sesi terpisah dengan checkpoint review.

Memuat rencana, meninjau secara kritis, mengeksekusi semua tugas, dan melapor saat selesai.

---

### `subagent-driven-development`
**Kapan digunakan:** Saat mengeksekusi rencana implementasi dengan tugas-tugas independen dalam sesi saat ini.

Mengeksekusi rencana dengan mendelegasikan subagent segar per tugas, dengan review dua tahap setelah masing-masing: review kepatuhan spesifikasi dulu, kemudian review kualitas kode.

---

### `dispatching-parallel-agents`
**Kapan digunakan:** Saat menghadapi 2+ tugas independen yang bisa dikerjakan tanpa shared state atau dependensi sekuensial.

Mendelegasikan tugas ke agen khusus dengan konteks terisolasi. Memastikan mereka tetap fokus dan berhasil pada tugasnya.

---

### `using-superpowers`
**Kapan digunakan:** Saat memulai percakapan baru — menetapkan cara menemukan dan menggunakan skill.

Memastikan skill yang relevan dipanggil sebelum RESPONS APAPUN, termasuk pertanyaan klarifikasi.

---

### `loop-operator`
**Kapan digunakan:** Saat mengoperasikan loop agen otonom yang macet atau membutuhkan intervensi.

Mengoperasikan loop agen otonom, memantau kemajuan, dan melakukan intervensi dengan aman saat loop macet.

---

### `harness-optimizer`
**Kapan digunakan:** Saat ingin menganalisis dan meningkatkan konfigurasi harness agen lokal.

Menganalisis dan meningkatkan konfigurasi harness agen lokal untuk keandalan, biaya, dan throughput.

---

## Database & Jaringan

### `database-reviewer`
**Kapan digunakan:** PROAKTIF saat menulis SQL, membuat migrasi, mendesain skema, atau memecahkan masalah performa database.

Spesialis database PostgreSQL untuk optimasi query, desain skema, keamanan, dan performa. Menggabungkan praktik terbaik Supabase.

**Yang diperiksa:**
- Query N+1 dan optimasi indeks
- Desain skema dan normalisasi
- Keamanan SQL (injection, RLS)
- Keamanan migrasi

---

### `network-architect`
**Kapan digunakan:** Saat merancang arsitektur jaringan enterprise atau multi-site.

Merancang arsitektur jaringan enterprise atau multi-site dari persyaratan, menggunakan skill jaringan yang ada untuk detail routing, validasi, otomasi, dan troubleshooting yang terfokus.

---

### `network-config-reviewer`
**Kapan digunakan:** Saat mereview konfigurasi router dan switch.

Meninjau konfigurasi router dan switch untuk keamanan, kebenaran, referensi usang, perintah berisiko di change window, dan penjaga operasional yang hilang.

---

### `network-troubleshooter`
**Kapan digunakan:** Saat mendiagnosis masalah konektivitas, routing, DNS, interface, atau kebijakan jaringan.

Mendiagnosis gejala konektivitas jaringan dengan alur kerja layer OSI read-only dan ringkasan akar penyebab yang didukung bukti.

---

## Open Source & Dokumentasi

### `opensource-forker`
**Kapan digunakan:** Tahap pertama pipeline open source — saat ingin melakukan fork proyek untuk di-open-source-kan.

Menyalin file, menghapus secrets dan kredensial (20+ pola), mengganti referensi internal dengan placeholder, menghasilkan `.env.example`, dan membersihkan riwayat git.

**Urutan pipeline open source:**
1. `opensource-forker` → fork dan strip secrets
2. `opensource-sanitizer` → verifikasi bersih
3. `opensource-packager` → buat packaging lengkap

---

### `opensource-sanitizer`
**Kapan digunakan:** Tahap kedua pipeline open source — PROAKTIF sebelum rilis publik apapun.

Memverifikasi fork open source sudah sepenuhnya dibersihkan sebelum dirilis. Memindai secrets yang bocor, PII, referensi internal, dan file berbahaya menggunakan 20+ pola regex. Menghasilkan laporan PASS/FAIL/PASS-WITH-WARNINGS.

---

### `opensource-packager`
**Kapan digunakan:** Tahap ketiga pipeline open source — setelah sanitisasi selesai.

Menghasilkan packaging open source lengkap untuk proyek yang sudah dibersihkan. Menghasilkan CLAUDE.md, setup.sh, README.md, LICENSE, CONTRIBUTING.md, dan template issue GitHub. Membuat repo langsung bisa digunakan.

---

### `doc-updater`
**Kapan digunakan:** PROAKTIF untuk memperbarui codemaps dan dokumentasi.

Spesialis dokumentasi dan codemap. Menjalankan `/update-codemaps` dan `/update-docs`, menghasilkan `docs/CODEMAPS/*`, dan memperbarui README dan panduan.

---

### `docs-lookup`
**Kapan digunakan:** Saat pengguna bertanya cara menggunakan library, framework, atau API, atau membutuhkan contoh kode terkini.

Menggunakan Context7 MCP untuk mengambil dokumentasi terkini dan mengembalikan jawaban dengan contoh. Gunakan untuk pertanyaan docs/API/setup.

---

### `writing-skills`
**Kapan digunakan:** Saat membuat skill baru, mengedit skill yang ada, atau memverifikasi skill berfungsi sebelum deployment.

Skill untuk menulis skill — seperti TDD yang diterapkan pada dokumentasi proses.

---

## Agen GAN & Otomasi Lanjutan

Tiga skill ini bekerja bersama sebagai "GAN Harness" — sistem agen Generator-Adversarial Network untuk pengembangan iteratif dengan evaluasi otomatis.

### `gan-planner`
**Kapan digunakan:** Langkah pertama GAN Harness — memperluas prompt satu baris menjadi spesifikasi produk lengkap.

Mengembangkan prompt sederhana menjadi spesifikasi produk penuh dengan fitur, sprint, kriteria evaluasi, dan arahan desain. Warna: ungu.

---

### `gan-generator`
**Kapan digunakan:** Langkah kedua GAN Harness — mengimplementasikan fitur sesuai spesifikasi.

Mengimplementasikan fitur sesuai spesifikasi, membaca feedback evaluator, dan beriterasi sampai ambang kualitas tercapai. Warna: hijau.

---

### `gan-evaluator`
**Kapan digunakan:** Langkah ketiga GAN Harness — menguji aplikasi yang berjalan dan memberikan skor.

Menguji aplikasi yang berjalan secara langsung melalui Playwright, memberi skor terhadap rubrik, dan memberikan feedback yang dapat ditindaklanjuti kepada Generator. Warna: merah.

---

**Cara menggunakan GAN Harness:**
```
1. Planner: "Buat aplikasi todo dengan fitur X, Y, Z"
2. Generator: Mengimplementasikan sesuai spec dari Planner
3. Evaluator: Menguji hasil Generator dan memberikan skor
4. Generator: Membaca feedback, memperbaiki, iterasi ulang
5. Ulangi sampai skor memenuhi threshold
```

---

## Pemasaran & SEO

### `marketing-agent`
**Kapan digunakan:** Saat ingin merencanakan atau mengeksekusi peluncuran produk atau kampanye pemasaran.

Ahli strategi pemasaran dan copywriter untuk perencanaan kampanye, riset audiens, positioning, pembuatan copy, dan review konten. Mencakup landing page, urutan email, postingan sosial, copy iklan, skrip video pendek, dan kalender konten.

---

### `seo-specialist`
**Kapan digunakan:** Untuk audit SEO teknis, optimasi on-page, data terstruktur, Core Web Vitals, dan pemetaan konten/keyword.

Spesialis SEO untuk audit situs, review meta tag, markup skema, masalah sitemap dan robots, dan rencana remediasi SEO.

**Yang dicakup:**
- Technical SEO audit
- Core Web Vitals
- Structured data / Schema markup
- Meta tags dan Open Graph
- Sitemap dan robots.txt
- Pemetaan keyword dan konten

---

## Khusus Domain

### `mle-reviewer`
**Kapan digunakan:** Saat ada perubahan kode ML, MLOps, pelatihan model, inferensi, feature store, atau evaluasi.

Reviewer machine learning engineering tingkat produksi untuk kontrak data, pipeline fitur, reproduksibilitas pelatihan, evaluasi offline/online, penyajian model, pemantauan, dan rollback.

---

### `healthcare-reviewer`
**Kapan digunakan:** Untuk aplikasi kesehatan — EMR/EHR, sistem pendukung keputusan klinis, sistem informasi kesehatan.

Meninjau kode aplikasi kesehatan untuk keselamatan klinis, akurasi CDSS, kepatuhan PHI, dan integritas data medis.

---

### `chief-of-staff`
**Kapan digunakan:** Saat mengelola alur kerja komunikasi multi-saluran (email, Slack, LINE, Messenger).

Chief of staff komunikasi pribadi yang melakukan triage email, Slack, LINE, dan Messenger. Mengklasifikasikan pesan ke dalam 4 tingkatan (skip/info_only/meeting_info/action_required), menghasilkan draft balasan, dan menegakkan tindak lanjut pasca-kirim melalui hooks.

---

### `homelab-architect`
**Kapan digunakan:** Saat merancang infrastruktur jaringan rumah atau lab kecil.

Merancang rencana jaringan rumah dan lab kecil dari inventaris perangkat keras, tujuan, dan tingkat pengalaman operator — dengan panduan perubahan bertahap yang aman dan rollback.

---

---

## Ringkasan Cepat — Kapan Menggunakan Skill Apa

| Situasi | Skill yang Digunakan |
|---|---|
| Sebelum mulai fitur baru | `brainstorming` → `writing-plans` |
| Build gagal (umum) | `build-error-resolver` |
| Build React gagal | `react-build-resolver` |
| Build Java gagal | `java-build-resolver` |
| Build Python/Django gagal | `django-build-resolver` |
| Build Flutter/Dart gagal | `dart-build-resolver` |
| Build Go gagal | `go-build-resolver` |
| Build Rust gagal | `rust-build-resolver` |
| Build Swift gagal | `swift-build-resolver` |
| Build C++ gagal | `cpp-build-resolver` |
| Build Kotlin gagal | `kotlin-build-resolver` |
| PyTorch error | `pytorch-build-resolver` |
| Setelah tulis kode | `code-reviewer` |
| Kode PHP | `php-reviewer` |
| Kode TypeScript/JS | `typescript-reviewer` |
| Kode React | `react-reviewer` |
| Kode Python | `python-reviewer` |
| Kode Django | `django-reviewer` |
| Kode FastAPI | `fastapi-reviewer` |
| Kode Java | `java-reviewer` |
| Kode Kotlin/Android | `kotlin-reviewer` |
| Kode Flutter | `flutter-reviewer` |
| Kode Go | `go-reviewer` |
| Kode Rust | `rust-reviewer` |
| Kode Swift | `swift-reviewer` |
| Kode C++ | `cpp-reviewer` |
| Kode C# | `csharp-reviewer` |
| Kode F# | `fsharp-reviewer` |
| Kode HarmonyOS | `harmonyos-app-resolver` |
| Kode ada bug | `systematic-debugging` |
| Kode perlu diamankan | `security-reviewer` |
| SQL / migrasi DB | `database-reviewer` |
| Kode lambat | `performance-optimizer` |
| Kode berantakan | `refactor-cleaner` |
| Komentar kode perlu dicek | `comment-analyzer` |
| Error tersembunyi | `silent-failure-hunter` |
| Desain tipe/interface | `type-design-analyzer` |
| Tulis tes dulu | `tdd-guide` / `test-driven-development` |
| Tes end-to-end | `e2e-runner` |
| Akan selesai / merge | `verification-before-completion` |
| Minta code review | `requesting-code-review` |
| Terima code review | `receiving-code-review` |
| Open source proyek | `opensource-forker` → `opensource-sanitizer` → `opensource-packager` |
| Update dokumentasi | `doc-updater` |
| Cari docs library | `docs-lookup` |
| SEO website | `seo-specialist` |
| Campaign marketing | `marketing-agent` |
| Masalah jaringan | `network-troubleshooter` |
| Desain jaringan | `network-architect` |
| Review konfigurasi router | `network-config-reviewer` |
| Review kode ML/MLOps | `mle-reviewer` |
| Aplikasi kesehatan | `healthcare-reviewer` |
| Aksesibilitas UI | `a11y-architect` |

---

*Dokumen ini dibuat otomatis dari skill yang terinstall di `~/.kiro/skills/`*
*Terakhir diperbarui: 1 Juli 2026*
