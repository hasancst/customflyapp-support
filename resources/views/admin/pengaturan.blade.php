@extends('admin.layout')

@section('judul', 'Pengaturan Sistem')

@section('styles')
<style>
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 10px;
    }
    .tab-item {
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 10px;
        font-weight: 600;
        color: var(--text-muted);
        transition: all 0.2s;
    }
    .tab-item:hover {
        background: var(--primary-light);
        color: var(--primary);
    }
    .tab-item.active {
        background: var(--primary);
        color: #fff;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
@endsection

@section('konten')
<div class="card">
    <div class="tabs">
        <div class="tab-item active" onclick="switchTab('umum')">Umum</div>
        <div class="tab-item" onclick="switchTab('optimasi')">Optimasi</div>
        <div class="tab-item" onclick="switchTab('ai')">Kecerdasan Buatan (AI)</div>
        <div class="tab-item" onclick="switchTab('email')">Konfigurasi Email</div>
        <div class="tab-item" onclick="switchTab('keamanan')">Keamanan</div>
        <div class="tab-item" onclick="switchTab('backup')">Backup DB</div>
        <div class="tab-item" onclick="switchTab('pemeliharaan')">Pemeliharaan</div>
    </div>

    <form action="/admin/pengaturan" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Tab Umum -->
        <div id="umum" class="tab-content active">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Informasi Situs</h3>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Logo Website</label>
                        @if(isset($pengaturan['logo']) && $pengaturan['logo'])
                            <div style="margin-bottom: 10px;">
                                <img src="/storage/{{ $pengaturan['logo'] }}" alt="Logo Saat Ini" style="max-height: 80px; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" style="width: 100%; padding: 8px; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px; display: {{ isset($pengaturan['logo']) ? 'none' : 'block' }}">Format: PNG, JPG, SVG (Max 2MB)</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nama Situs</label>
                        <input type="text" name="nama_situs" value="{{ $pengaturan['nama_situs'] ?? 'CMS Rumah Koalisi' }}">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Deskripsi Situs</label>
                        <textarea name="deskripsi_situs" rows="3">{{ $pengaturan['deskripsi_situs'] ?? '' }}</textarea>
                    </div>
                </div>

                <div>
                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Kontak</h3>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email Admin</label>
                        <input type="email" name="email_admin" value="{{ $pengaturan['email_admin'] ?? 'admin@rumahkoalisi.id' }}">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ $pengaturan['no_hp'] ?? '' }}" placeholder="Contoh: 08123456789">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Alamat Kantor</label>
                        <textarea name="alamat" rows="3">{{ $pengaturan['alamat'] ?? '' }}</textarea>
                    </div>

                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Media Sosial</h3>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600;">Facebook URL</label>
                        <input type="text" name="sosmed_facebook" value="{{ $pengaturan['sosmed_facebook'] ?? '' }}" placeholder="https://facebook.com/username">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600;">Twitter/X URL</label>
                        <input type="text" name="sosmed_twitter" value="{{ $pengaturan['sosmed_twitter'] ?? '' }}" placeholder="https://twitter.com/username">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600;">Instagram URL</label>
                        <input type="text" name="sosmed_instagram" value="{{ $pengaturan['sosmed_instagram'] ?? '' }}" placeholder="https://instagram.com/username">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600;">LinkedIn URL</label>
                        <input type="text" name="sosmed_linkedin" value="{{ $pengaturan['sosmed_linkedin'] ?? '' }}" placeholder="https://linkedin.com/in/username">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600;">YouTube URL</label>
                        <input type="text" name="sosmed_youtube" value="{{ $pengaturan['sosmed_youtube'] ?? '' }}" placeholder="https://youtube.com/c/channelname">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Optimasi -->
        <div id="optimasi" class="tab-content">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Redis Cache</h3>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Gunakan Redis</label>
                        <select name="optimasi_redis_aktif">
                            <option value="0" {{ ($pengaturan['optimasi_redis_aktif'] ?? '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="1" {{ ($pengaturan['optimasi_redis_aktif'] ?? '0') == '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Pastikan server Redis Anda sudah berjalan.</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Redis Host</label>
                        <input type="text" name="optimasi_redis_host" value="{{ $pengaturan['optimasi_redis_host'] ?? '127.0.0.1' }}">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Redis Port</label>
                        <input type="text" name="optimasi_redis_port" value="{{ $pengaturan['optimasi_redis_port'] ?? '6379' }}">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Redis Password</label>
                        <input type="password" name="optimasi_redis_password" value="{{ $pengaturan['optimasi_redis_password'] ?? '' }}" placeholder="Kosongkan jika tidak ada">
                    </div>
                </div>

                <div>
                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Optimasi Gambar</h3>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Auto Convert ke WebP</label>
                        <select name="optimasi_webp_aktif">
                            <option value="0" {{ ($pengaturan['optimasi_webp_aktif'] ?? '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="1" {{ ($pengaturan['optimasi_webp_aktif'] ?? '0') == '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Semua gambar yang di-upload akan otomatis dikonversi ke format .webp untuk kecepatan akses.</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Kualitas WebP (1-100)</label>
                        <input type="text" name="optimasi_webp_kualitas" value="{{ $pengaturan['optimasi_webp_kualitas'] ?? '80' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab AI -->
        <div id="ai" class="tab-content">
            <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Integrasi AI (Google Gemini &amp; 9router)</h3>
            <div style="max-width: 650px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Provider AI Aktif</label>
                    <select name="ai_provider" id="ai_provider" onchange="toggleAiProvider()">
                        <option value="gemini" {{ ($pengaturan['ai_provider'] ?? 'gemini') == 'gemini' ? 'selected' : '' }}>Google Gemini (Direct API)</option>
                        <option value="9router" {{ ($pengaturan['ai_provider'] ?? 'gemini') == '9router' ? 'selected' : '' }}>9router (OpenAI-Compatible Proxy)</option>
                    </select>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Pilih provider AI yang digunakan untuk fitur AI Assistant pada Blog, Artikel, dan Knowledge Base.</p>
                </div>

                <!-- Panel Google Gemini -->
                <div id="ai-gemini-panel" style="display: {{ ($pengaturan['ai_provider'] ?? 'gemini') == 'gemini' ? 'block' : 'none' }};">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Google Gemini API Key</label>
                        <input type="password" name="ai_gemini_key" id="ai_gemini_key" value="{{ $pengaturan['ai_gemini_key'] ?? '' }}" placeholder="AIzaSy...">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Gunakan API Key dari <a href="https://aistudio.google.com/app/apikey" target="_blank">Google AI Studio</a>.</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Model Gemini</label>
                        <select name="ai_gemini_model" id="ai_gemini_model">
                            <option value="gemini-flash-latest" {{ ($pengaturan['ai_gemini_model'] ?? 'gemini-flash-latest') == 'gemini-flash-latest' ? 'selected' : '' }}>Gemini Flash Latest (Terbaru - Paling Cepat)</option>
                            <option value="gemini-1.5-flash-latest" {{ ($pengaturan['ai_gemini_model'] ?? 'gemini-flash-latest') == 'gemini-1.5-flash-latest' ? 'selected' : '' }}>Gemini 1.5 Flash Latest</option>
                            <option value="gemini-1.5-pro" {{ ($pengaturan['ai_gemini_model'] ?? 'gemini-flash-latest') == 'gemini-1.5-pro' ? 'selected' : '' }}>Gemini 1.5 Pro</option>
                            <option value="gemini-2.0-flash-exp" {{ ($pengaturan['ai_gemini_model'] ?? 'gemini-flash-latest') == 'gemini-2.0-flash-exp' ? 'selected' : '' }}>Gemini 2.0 Flash Experimental</option>
                        </select>
                    </div>
                </div>

                <!-- Panel 9router -->
                <div id="ai-9router-panel" style="display: {{ ($pengaturan['ai_provider'] ?? 'gemini') == '9router' ? 'block' : 'none' }};">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">9router Base URL (Endpoint)</label>
                        <input type="url" name="ai_9router_url" id="ai_9router_url" value="{{ $pengaturan['ai_9router_url'] ?? 'http://localhost:20128/v1' }}" placeholder="http://localhost:20128/v1" oninput="update9RouterDashboardLink()">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Endpoint OpenAI-compatible 9router Anda (default lokal: <code>http://localhost:20128/v1</code>).</p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label style="font-weight: 600; margin: 0;">9router API Key</label>
                            <a id="link-9router-dashboard" href="http://localhost:20128/dashboard" target="_blank" style="font-size: 0.8rem; color: var(--primary); font-weight: 600; text-decoration: none;">
                                <i class="fas fa-key"></i> Get API Key dari 9router Dashboard <i class="fas fa-external-link-alt" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>
                        <input type="password" name="ai_9router_key" id="ai_9router_key" value="{{ $pengaturan['ai_9router_key'] ?? '' }}" placeholder="Masukkan API Key dari 9router Dashboard...">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Buka 9router Dashboard untuk membuat/menyalin API Key lokal Anda (opsional jika autentikasi 9router dimatikan).</p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label style="font-weight: 600; margin: 0;">Model / Combo 9router</label>
                            <button type="button" onclick="ambilModel9Router(event)" class="btn" style="padding: 4px 10px; font-size: 0.75rem; background: #0ea5e9;">
                                <i class="fas fa-sync-alt"></i> Ambil Daftar Model
                            </button>
                        </div>
                        <input type="text" name="ai_9router_model" id="ai_9router_model" list="nine-router-models-list" value="{{ $pengaturan['ai_9router_model'] ?? '' }}" placeholder="Contoh: gemini-2.5-flash, gpt-4o, atau nama combo">
                        <datalist id="nine-router-models-list"></datalist>
                        <div id="nine-router-models-picker" style="display: none; margin-top: 8px;">
                            <select id="nine-router-models-select" onchange="if(this.value) document.getElementById('ai_9router_model').value = this.value;" style="font-size: 0.85rem;">
                                <option value="">-- Pilih Model dari 9router --</option>
                            </select>
                        </div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Ketik nama model/combo secara manual atau klik <strong>Ambil Daftar Model</strong> dari endpoint <code>/v1/models</code>.</p>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <button type="button" onclick="testKoneksiGemini(event)" class="btn" style="background: #eab308; width: 100%; justify-content: center;">
                        <i class="fas fa-plug"></i> Test Koneksi API
                    </button>
                    <div id="test-ai-status" style="margin-top: 10px; font-size: 0.85rem; display: none; padding: 10px; border-radius: 8px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Email -->
        <div id="email" class="tab-content">
            <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">SMTP (Mail Server)</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Mail Driver</label>
                        <select name="mail_driver">
                            <option value="smtp" {{ ($pengaturan['mail_driver'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="mailgun" {{ ($pengaturan['mail_driver'] ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="sendmail" {{ ($pengaturan['mail_driver'] ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Host</label>
                        <input type="text" name="mail_host" value="{{ $pengaturan['mail_host'] ?? '' }}" placeholder="smtp.gmail.com">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Port</label>
                        <input type="text" name="mail_port" value="{{ $pengaturan['mail_port'] ?? '587' }}">
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Username</label>
                        <input type="text" name="mail_username" value="{{ $pengaturan['mail_username'] ?? '' }}">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Password</label>
                        <input type="password" name="mail_password" value="{{ $pengaturan['mail_password'] ?? '' }}">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Enkripsi</label>
                        <select name="mail_encryption">
                            <option value="tls" {{ ($pengaturan['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS (Direkomendasikan)</option>
                            <option value="ssl" {{ ($pengaturan['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ ($pengaturan['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px;">
                <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Identitas Pengirim</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email Pengirim (From Address)</label>
                        <input type="email" name="mail_from_address" value="{{ $pengaturan['mail_from_address'] ?? '' }}" placeholder="no-reply@domain.com">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nama Pengirim (From Name)</label>
                        <input type="text" name="mail_from_name" value="{{ $pengaturan['mail_from_name'] ?? '' }}" placeholder="Admin Rumah Koalisi">
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #e2e8f0;">
                <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">
                    <i class="fas fa-bell"></i> Notifikasi Email Tiket
                </h3>
                <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #3b82f6;">
                    <p style="margin: 0; color: #1e40af; font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Email notifikasi</strong> akan dikirim ke alamat email yang Anda masukkan di bawah ini setiap kali ada tiket baru masuk atau customer membalas tiket.
                    </p>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">
                        Email Admin untuk Notifikasi Tiket
                        <span style="color: #64748b; font-weight: normal; font-size: 0.85rem;">(pisahkan dengan koma jika lebih dari satu)</span>
                    </label>
                    <textarea 
                        name="tiket_notif_emails" 
                        rows="3" 
                        placeholder="admin@example.com, support@example.com, manager@example.com"
                        style="font-family: monospace; font-size: 0.9rem;"
                    >{{ $pengaturan['tiket_notif_emails'] ?? '' }}</textarea>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">
                        Contoh: admin@perusahaan.com, support@perusahaan.com<br>
                        Kosongkan jika ingin menggunakan Email Admin di atas sebagai penerima notifikasi.
                    </p>
                </div>
            </div>

            <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #e2e8f0;">
                <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">
                    <i class="fas fa-paper-plane"></i> Uji Coba Pengiriman Email (Test SMTP)
                </h3>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px;">
                    <p style="margin-top: 0; margin-bottom: 15px; color: #475569; font-size: 0.9rem;">
                        Gunakan tombol di bawah ini untuk memastikan konfigurasi SMTP di atas dapat terhubung dan berhasil mengirim email ke inbox.
                    </p>
                    <div style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px;">
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Kirim Test Email Ke:</label>
                            <input type="email" id="email_test_tujuan" value="{{ $pengaturan['email_admin'] ?? ($pengaturan['mail_username'] ?? '') }}" placeholder="nama@domain.com" style="width: 100%;">
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline" onclick="testKirimEmail(event)" style="padding: 10px 20px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-paper-plane"></i> Kirim Test Email
                            </button>
                        </div>
                    </div>
                    <div id="test-email-status" style="display: none; margin-top: 15px; padding: 12px 15px; border-radius: 6px; font-size: 0.85rem; white-space: pre-line;"></div>
                </div>
            </div>

        </div>

        <!-- Tab Keamanan -->
        <div id="keamanan" class="tab-content">
            <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Google reCAPTCHA v2</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Status CAPTCHA</label>
                        <select name="captcha_aktif">
                            <option value="0" {{ ($pengaturan['captcha_aktif'] ?? '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="1" {{ ($pengaturan['captcha_aktif'] ?? '0') == '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Aktifkan untuk mencegah spam pada form komentar.</p>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Site Key</label>
                        <input type="text" name="captcha_site_key" value="{{ $pengaturan['captcha_site_key'] ?? '' }}" placeholder="Contoh: 6Ld...">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Secret Key</label>
                        <input type="text" name="captcha_secret_key" value="{{ $pengaturan['captcha_secret_key'] ?? '' }}" placeholder="Contoh: 6Ld...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Backup -->
        <div id="backup" class="tab-content">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Pengaturan Backup</h3>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Backup Otomatis</label>
                        <select name="backup_otomatis">
                            <option value="0" {{ ($pengaturan['backup_otomatis'] ?? '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="1" {{ ($pengaturan['backup_otomatis'] ?? '0') == '1' ? 'selected' : '' }}>Aktif (Harian)</option>
                        </select>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Memerlukan Cron Job untuk berjalan secara otomatis.</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Simpan Backup di Server</label>
                        <select name="backup_simpan_server">
                            <option value="1" {{ ($pengaturan['backup_simpan_server'] ?? '1') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ ($pengaturan['backup_simpan_server'] ?? '1') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Kirim Ke Email</label>
                        <input type="text" name="backup_email" value="{{ $pengaturan['backup_email'] ?? '' }}" placeholder="email@tujuan.com">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Backup akan dikirim sebagai lampiran (jika ukuran memungkinkan).</p>
                    </div>
                </div>
                <div>
                    <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Backup Manual</h3>
                    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <p style="margin-bottom: 15px; font-size: 0.9rem;">Klik tombol di bawah untuk mencadangkan database Anda secara langsung ke server.</p>
                        <button type="button" onclick="lakukanBackup()" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <i class="fas fa-download"></i> Buat Backup Sekarang
                        </button>
                        <div id="backup-status" style="margin-top: 15px; font-size: 0.85rem; display: none;">
                            <span class="badge" id="status-text">Memproses...</span>
                        </div>
                    </div>

                    <div style="margin-top: 25px;">
                        <h4 style="margin-bottom: 15px; font-size: 1rem;">File Terakhir</h4>
                        <div id="daftar-backup" style="max-height: 200px; overflow-y: auto;">
                            <!-- Akan diisi via JS/PHP -->
                            <p style="color: var(--text-muted); font-size: 0.85rem;">Belum ada file backup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Pemeliharaan -->
        <div id="pemeliharaan" class="tab-content">
            <div style="max-width: 600px;">
                <h3 style="border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px;">Mode Pemeliharaan</h3>
                <div style="background: #fff8e1; border-left: 5px solid #ffc107; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                    <p style="color: #856404; font-size: 0.9rem; margin-bottom: 0;">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Penting:</strong> Mengaktifkan mode pemeliharaan akan membuat website tidak bisa diakses oleh publik. Anda masih bisa mengakses admin melalui URL bypass jika diperlukan.
                    </p>
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Status Pemeliharaan</label>
                    <select name="fitur_pemeliharaan" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <option value="0" {{ ($pengaturan['fitur_pemeliharaan'] ?? '0') == '0' ? 'selected' : '' }}>Situs Aktif (Normal)</option>
                        <option value="1" {{ ($pengaturan['fitur_pemeliharaan'] ?? '0') == '1' ? 'selected' : '' }}>Mode Pemeliharaan (Under Maintenance)</option>
                    </select>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Target Waktu Selesai (Countdown)</label>
                    <input type="datetime-local" name="pemeliharaan_sampai" value="{{ $pengaturan['pemeliharaan_sampai'] ?? '' }}" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">Waktu ini akan ditampilkan pada halaman countdown.</p>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pesan Tambahan</label>
                    <textarea name="pemeliharaan_pesan" rows="3" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;" placeholder="Contoh: Kami sedang melakukan upgrade server.">{{ $pengaturan['pemeliharaan_pesan'] ?? 'Rumahnya Masih Dibangun' }}</textarea>
                </div>
                
                @if(($pengaturan['fitur_pemeliharaan'] ?? '0') == '1')
                <div style="margin-top: 10px; padding: 10px; background: #e3f2fd; border-radius: 8px;">
                    <p style="font-size: 0.85rem; color: #0d47a1; margin-bottom: 0;">
                        <i class="fas fa-info-circle"></i> URL Bypass: <a href="{{ url('/') }}/admin-bypass" target="_blank" style="font-weight: bold; color: #0d47a1;">{{ url('/') }}/admin-bypass</a>
                    </p>
                </div>
                @endif
            </div>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(tabId) {
        // Hilangkan active dari semua tab item
        document.querySelectorAll('.tab-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Sembunyikan semua konten
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        // Tambahkan active ke tab yang dipilih
        event.currentTarget.classList.add('active');
        document.getElementById(tabId).classList.add('active');

        if (tabId === 'backup') {
            loadBackupList();
        }
    }

    function loadBackupList() {
        fetch('/admin/backup/daftar')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('daftar-backup');
                if (data.length === 0) {
                    container.innerHTML = '<p style="color: var(--text-muted); font-size: 0.85rem;">Belum ada file backup.</p>';
                    return;
                }

                let html = '<table style="width: 100%; font-size: 0.85rem; border-collapse: collapse;">';
                data.forEach(file => {
                    html += `
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 8px 0;">
                                <strong>${file.nama}</strong><br>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">${file.tanggal} - ${file.ukuran}</span>
                            </td>
                            <td style="text-align: right; padding: 8px 0;">
                                <a href="/admin/backup/unduh/${file.nama}" class="btn-icon" title="Unduh" style="color: var(--primary);"><i class="fas fa-download"></i></a>
                                <button type="button" onclick="restoreBackup('${file.nama}')" class="btn-icon" title="Restore" style="color: #10b981; background: none; border: none; cursor: pointer; display: inline-block; margin: 0 5px;"><i class="fas fa-history"></i> Restore</button>
                                <button type="button" onclick="hapusBackup('${file.nama}')" class="btn-icon" title="Hapus" style="color: var(--danger); background: none; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
                html += '</table>';
                container.innerHTML = html;
            });
    }

    function lakukanBackup() {
        const btn = event.currentTarget;
        const status = document.getElementById('backup-status');
        const statusText = document.getElementById('status-text');

        btn.disabled = true;
        status.style.display = 'block';
        statusText.innerText = 'Sedang memproses...';
        statusText.style.background = 'var(--primary-light)';
        statusText.style.color = 'var(--primary)';

        fetch('/admin/backup/buat', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            if (data.berhasil) {
                statusText.innerText = 'Backup Berhasil!';
                statusText.style.background = '#dcfce7';
                statusText.style.color = '#166534';
                loadBackupList();
            } else {
                statusText.innerText = 'Gagal: ' + data.pesan;
                statusText.style.background = '#fee2e2';
                statusText.style.color = '#991b1b';
            }
            setTimeout(() => {
                status.style.display = 'none';
            }, 5000);
        })
        .catch(error => {
            btn.disabled = false;
            statusText.innerText = 'Terjadi kesalahan sistem.';
            statusText.style.background = '#fee2e2';
            statusText.style.color = '#991b1b';
        });
    }

    function hapusBackup(filename) {
        if (!confirm('Hapus file backup ini?')) return;

        fetch('/admin/backup/hapus', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ file: filename })
        })
        .then(response => response.json())
        .then(data => {
            if (data.berhasil) {
                loadBackupList();
            } else {
                alert('Gagal menghapus: ' + data.pesan);
            }
        });
    }

    function restoreBackup(filename) {
        if (!confirm('⚠️ PERINGATAN: Restore akan mengganti semua data database saat ini dengan data dari backup.\n\nApakah Anda yakin ingin melanjutkan?')) return;
        
        if (!confirm('Konfirmasi sekali lagi: Data saat ini akan HILANG dan diganti dengan backup. Lanjutkan?')) return;

        const btn = event.currentTarget;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch('/admin/backup/restore', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ file: filename })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-history"></i>';
            
            if (data.berhasil) {
                alert('✅ Database berhasil di-restore!\n\nHalaman akan dimuat ulang.');
                window.location.reload();
            } else {
                alert('❌ Gagal restore: ' + data.pesan);
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-history"></i>';
            alert('❌ Terjadi kesalahan sistem: ' + error.message);
        });
    }

    function toggleAiProvider() {
        const provider = document.getElementById('ai_provider').value;
        document.getElementById('ai-gemini-panel').style.display = provider === 'gemini' ? 'block' : 'none';
        document.getElementById('ai-9router-panel').style.display = provider === '9router' ? 'block' : 'none';
        document.getElementById('test-ai-status').style.display = 'none';
        if (provider === '9router') {
            update9RouterDashboardLink();
        }
    }

    function update9RouterDashboardLink() {
        const urlInput = document.getElementById('ai_9router_url');
        const link = document.getElementById('link-9router-dashboard');
        if (!urlInput || !link) return;
        const raw = (urlInput.value || 'http://localhost:20128/v1').trim();
        try {
            const parsed = new URL(raw);
            link.href = parsed.origin + '/dashboard';
        } catch (e) {
            link.href = 'http://localhost:20128/dashboard';
        }
    }

    function ambilModel9Router(e) {
        const baseUrl = document.getElementById('ai_9router_url').value.trim();
        const apiKey = document.getElementById('ai_9router_key').value.trim();
        const statusDiv = document.getElementById('test-ai-status');
        const btn = e ? e.currentTarget : event.currentTarget;

        if (!baseUrl) {
            alert('Silakan masukkan 9router Base URL terlebih dahulu.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

        fetch('/admin/pengaturan/9router-models', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ base_url: baseUrl, api_key: apiKey })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync-alt"></i> Ambil Daftar Model';

            statusDiv.style.display = 'block';
            statusDiv.innerText = data.pesan;

            if (data.berhasil && Array.isArray(data.models) && data.models.length > 0) {
                statusDiv.style.background = '#dcfce7';
                statusDiv.style.color = '#166534';

                const datalist = document.getElementById('nine-router-models-list');
                const select = document.getElementById('nine-router-models-select');
                const picker = document.getElementById('nine-router-models-picker');
                datalist.innerHTML = '';
                select.innerHTML = '<option value="">-- Pilih Model dari 9router --</option>';

                data.models.forEach(m => {
                    const opt1 = document.createElement('option');
                    opt1.value = m;
                    datalist.appendChild(opt1);

                    const opt2 = document.createElement('option');
                    opt2.value = m;
                    opt2.textContent = m;
                    select.appendChild(opt2);
                });

                picker.style.display = 'block';
                const modelInput = document.getElementById('ai_9router_model');
                if (!modelInput.value && data.models[0]) {
                    modelInput.value = data.models[0];
                }
            } else {
                statusDiv.style.background = '#fee2e2';
                statusDiv.style.color = '#991b1b';
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync-alt"></i> Ambil Daftar Model';
            alert('Terjadi kesalahan: ' + error.message);
        });
    }

    document.addEventListener('DOMContentLoaded', update9RouterDashboardLink);

    function testKoneksiGemini(e) {
        const provider = document.getElementById('ai_provider').value;
        const statusDiv = document.getElementById('test-ai-status');
        const btn = e ? e.currentTarget : event.currentTarget;

        let payload = { provider: provider };
        if (provider === '9router') {
            payload.base_url = document.getElementById('ai_9router_url').value.trim();
            payload.api_key = document.getElementById('ai_9router_key').value.trim();
            payload.model = document.getElementById('ai_9router_model').value.trim();
            if (!payload.base_url || !payload.model) {
                alert('Silakan masukkan Base URL dan Model 9router terlebih dahulu.');
                return;
            }
        } else {
            payload.api_key = document.getElementById('ai_gemini_key').value.trim();
            payload.model = document.getElementById('ai_gemini_model').value;
            if (!payload.api_key) {
                alert('Silakan masukkan API Key Gemini terlebih dahulu.');
                return;
            }
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghubungkan...';
        statusDiv.style.display = 'none';

        fetch('/admin/pengaturan/test-gemini', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Test Koneksi API';
            statusDiv.style.display = 'block';
            statusDiv.innerText = data.pesan;
            
            if (data.berhasil) {
                statusDiv.style.background = '#dcfce7';
                statusDiv.style.color = '#166534';
            } else {
                statusDiv.style.background = '#fee2e2';
                statusDiv.style.color = '#991b1b';
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug"></i> Test Koneksi API';
            alert('Terjadi kesalahan: ' + error.message);
        });
    }

    function testKirimEmail(event) {
        const tujuan = document.getElementById('email_test_tujuan').value.trim();
        const statusDiv = document.getElementById('test-email-status');
        const btn = event.currentTarget;

        if (!tujuan) {
            alert('Silakan masukkan alamat email tujuan uji coba.');
            return;
        }

        const mailDriver = document.querySelector('select[name="mail_driver"]')?.value || 'smtp';
        const mailHost = document.querySelector('input[name="mail_host"]')?.value || '';
        const mailPort = document.querySelector('input[name="mail_port"]')?.value || '587';
        const mailUsername = document.querySelector('input[name="mail_username"]')?.value || '';
        const mailPassword = document.querySelector('input[name="mail_password"]')?.value || '';
        const mailEncryption = document.querySelector('select[name="mail_encryption"]')?.value || '';
        const mailFromAddress = document.querySelector('input[name="mail_from_address"]')?.value || '';
        const mailFromName = document.querySelector('input[name="mail_from_name"]')?.value || '';

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim Test Email...';
        statusDiv.style.display = 'none';

        fetch('/admin/pengaturan/test-email', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email_tujuan: tujuan,
                mail_driver: mailDriver,
                mail_host: mailHost,
                mail_port: mailPort,
                mail_username: mailUsername,
                mail_password: mailPassword,
                mail_encryption: mailEncryption,
                mail_from_address: mailFromAddress,
                mail_from_name: mailFromName
            })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Test Email';
            statusDiv.style.display = 'block';
            statusDiv.innerText = data.pesan;

            if (data.berhasil) {
                statusDiv.style.background = '#dcfce7';
                statusDiv.style.color = '#166534';
                statusDiv.style.border = '1px solid #86efac';
            } else {
                statusDiv.style.background = '#fee2e2';
                statusDiv.style.color = '#991b1b';
                statusDiv.style.border = '1px solid #fca5a5';
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Test Email';
            alert('Terjadi kesalahan koneksi: ' + error.message);
        });
    }
</script>
@endsection
