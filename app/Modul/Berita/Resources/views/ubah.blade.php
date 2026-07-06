@extends('admin.layout')

@section('judul', 'Ubah Berita')

@section('konten')
<div class="card">
    <form action="/admin/berita/ubah/{{ $berita->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Judul Berita</label>
                    <input type="text" name="judul" value="{{ $berita->judul }}" required placeholder="Masukkan judul menarik...">
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Ringkasan (AEO/GEO Optimized)</label>
                    <textarea name="ringkasan" rows="3" placeholder="Ringkasan singkat untuk mesin pencari & AI...">{{ $berita->ringkasan }}</textarea>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Isi Berita</label>
                    <textarea name="isi" id="editor" required>{{ $berita->isi }}</textarea>
                </div>
            </div>

            <div>
                <div class="card" style="margin-bottom: 25px; background: #fdf2f2; border-left: 4px solid #ef4444;">
                    <h4 style="margin-bottom: 10px;"><i class="fas fa-search"></i> SEO Score</h4>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div id="seo-score-circle" style="width: 55px; height: 55px; border-radius: 50%; border: 5px solid #ef4444; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; color: #ef4444;">
                            0
                        </div>
                        <div>
                            <div id="seo-status" style="font-weight: 600; font-size: 0.85rem;">Perlu Optimasi</div>
                            <small style="color: var(--text-muted); display: block; font-size: 0.75rem;" id="seo-tips">Lengkapi konten Anda...</small>
                        </div>
                    </div>
                </div>
                
                <!-- AI Magic Assistant -->
                <div class="ai-assistant-card" style="margin-bottom: 25px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 20px; border-radius: 12px; border: none; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); color: white; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(255,255,255,0.1); transform: rotate(15deg); pointer-events: none;">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; position: relative;">
                        <label style="font-weight: 700; display: flex; align-items: center; gap: 10px; font-size: 1.1rem;"><i class="fas fa-sparkles"></i> AI Magic Assistant</label>
                        <span id="ai-status" style="font-size: 0.7rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); padding: 2px 10px; border-radius: 20px; backdrop-filter: blur(5px);">Ready</span>
                    </div>
                    <div style="margin-bottom: 12px; position: relative;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; color: rgba(255,255,255,0.9);">Instruksi Khusus (Opsional):</label>
                        <textarea id="ai-custom-prompt" rows="2" placeholder="Contoh: Gunakan gaya bahasa santai, perbanyak data teknis..." 
                            style="width: 100%; padding: 12px; border-radius: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2); color: white; font-size: 0.85rem; resize: none; transition: all 0.3s; font-family: inherit; outline: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);"></textarea>
                        <style>
                            #ai-custom-prompt::placeholder { color: rgba(255,255,255,0.6); }
                            #ai-custom-prompt:focus { background: rgba(0,0,0,0.3) !important; border-color: rgba(255,255,255,0.5) !important; }
                        </style>
                    </div>
                    <div style="margin-bottom: 18px; position: relative;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; color: rgba(255,255,255,0.9);">Pilih Tindakan Utama:</label>
                        <select id="ai-command" style="width: 100%; padding: 12px; border-radius: 10px; background: white; border: none; color: #1e1b4b; font-size: 0.9rem; cursor: pointer; font-weight: 600; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%234f46e5%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                            <option value="Tulis ulang berita ini agar lebih menarik dan profesional.">Tulis Ulang Profesional</option>
                            <option value="Optimasi SEO, AEO, dan GEO untuk konten ini dan buatkan meta deskripsi.">Optimasi SEO & AEO</option>
                            <option value="Perbaiki tata bahasa dan ejaan (Auto-Correct).">Perbaiki Tata Bahasa</option>
                            <option value="Berikan saran untuk pengembangan artikel ini.">Saran Pengembangan</option>
                        </select>
                    </div>
                    <button type="button" id="btn-ai-magic" class="btn-magic" style="width: 100%; background: white; color: #4f46e5; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic
                    </button>
                    <div id="ai-result-info" style="margin-top: 15px; font-size: 0.75rem; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 10px; border-left: 4px solid #fff; display: none; line-height: 1.5;">
                    </div>
                </div>

                <div class="card" style="margin-bottom: 25px; background: #f8fafc;">
                    <h4 style="margin-bottom: 15px;">Publikasi</h4>
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="unggulan" value="1" {{ $berita->unggulan ? 'checked' : '' }} style="width: auto;">
                            <span>Berita Unggulan</span>
                        </label>
                    </div>
                    <button type="submit" class="btn" style="width: 100%; justify-content: center;">
                        <i class="fas fa-save"></i> Perbarui Berita
                    </button>
                    <a href="/admin/berita" class="btn" style="width: 100%; justify-content: center; margin-top: 10px; background: #94a3b8;">Batal</a>
                </div>

                <div class="card" style="margin-bottom: 25px;">
                    <h4 style="margin-bottom: 15px;">Pilih Kategori</h4>
                    <div style="max-height: 200px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px;">
                        @foreach($kategori as $kat)
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.9rem;">
                                <input type="checkbox" name="kategori_ids[]" value="{{ $kat->id }}" 
                                    {{ $berita->kategoris->contains($kat->id) ? 'checked' : '' }} style="width: auto;">
                                <span>{{ $kat->nama }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="card" style="margin-bottom: 25px;">
                    <h4 style="margin-bottom: 15px;">Gambar Utama</h4>
                    @if($berita->gambar_utama)
                        @php
                            $imgUrl = $berita->gambar_utama;
                            if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                                $imgUrl = '/storage/' . $imgUrl;
                            }
                        @endphp
                        <img src="{{ $imgUrl }}" style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
                    @endif
                    <input type="file" name="gambar_utama" accept="image/*">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 8px;">Format: JPG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengubah.</p>
                </div>

                <div class="card">
                    <h4 style="margin-bottom: 15px;">Tags (LLMO)</h4>
                    <input type="text" name="tags" value="{{ $berita->tags->pluck('nama')->implode(', ') }}" placeholder="Pisahkan dengan koma...">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 8px;">Penting untuk pemetaan entitas oleh mesin AI.</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    .note-editable {
        font-family: 'Outfit', sans-serif !important;
        font-size: 1rem !important;
        line-height: 1.6 !important;
        color: #2d3748 !important;
    }

    .btn-magic:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2) !important;
        background: #f8fafc !important;
    }
    .btn-magic:active { transform: translateY(0); }
    
    #ai-custom-prompt:focus {
        outline: none;
        background: rgba(255,255,255,0.25) !important;
        border-color: rgba(255,255,255,0.5) !important;
    }

    #ai-command option {
        padding: 10px;
        background: white;
        color: #333;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            placeholder: 'Tulis isi berita di sini...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    hitungSeo();
                }
            }
        });

        // Live calculation
        $('input[name="judul"], textarea[name="ringkasan"], input[name="tags"]').on('input change', function() {
            hitungSeo();
        });

        hitungSeo(); // Start up
    });

    function hitungSeo() {
        let score = 0;
        let tips = [];
        
        let judul = $('input[name="judul"]').val() || '';
        let ringkasan = $('textarea[name="ringkasan"]').val() || '';
        let isi = $('#editor').summernote('code').replace(/<[^>]*>/g, '') || '';
        
        // Title Score (25%)
        if (judul.length >= 40 && judul.length <= 70) score += 25;
        else if (judul.length > 0) { score += 10; tips.push("Judul idealnya 40-70 karakter."); }

        // Ringkasan Score (25%) - AEO
        if (ringkasan.length >= 120 && ringkasan.length <= 160) score += 25;
        else if (ringkasan.length > 0) { score += 10; tips.push("Ringkasan (AEO) idealnya 120-160 karakter."); }

        // Content Length (30%) - GEO
        let wordCount = isi.trim().split(/\s+/).filter(w => w.length > 0).length;
        if (wordCount >= 300) score += 30;
        else if (wordCount > 50) { score += 15; tips.push("Konten (GEO) minimal 300 kata."); }

        // LLMO Tags (20%)
        let tags = $('input[name="tags"]').val() || '';
        let tagCount = tags.split(',').filter(t => t.trim().length > 0).length;
        if (tagCount >= 3) score += 20;
        else if (tagCount > 0) { score += 10; tips.push("Gunakan min. 3 tags untuk LLMO."); }

        // Update UI
        score = Math.min(score, 100);
        $('#seo-score-circle').text(score);
        
        let color = "#ef4444";
        let status = "Perlu Optimasi";
        if (score > 80) { color = "#22c55e"; status = "Sangat Baik"; }
        else if (score > 50) { color = "#f59e0b"; status = "Cukup Baik"; }
        
        $('#seo-score-circle').css({'border-color': color, 'color': color});
        $('#seo-status').text(status).css('color', color);
        $('#seo-tips').text(tips.length > 0 ? tips[0] : "Konten sudah sangat baik!");
    }

    $('#btn-ai-magic').click(function() {
        let instruksi = $('#ai-custom-prompt').val();
        let command = $('#ai-command').val();
        let perintah = command;
        
        if (instruksi.trim() !== '') {
            perintah = instruksi + ". Dan terapkan tindakan berikut: " + command;
        }

        let judul = $('input[name="judul"]').val();
        let isi = $('#editor').summernote('code');
        
        let btn = $(this);
        let status = $('#ai-status');
        let info = $('#ai-result-info');

        btn.disabled = true;
        btn.html('<i class="fas fa-spinner fa-spin"></i> Thinking...');
        status.text('Working...');

        $.ajax({
            url: '/admin/berita/ai-bantu',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                perintah: perintah,
                judul: judul,
                isi: isi
            },
            success: function(res) {
                btn.disabled = false;
                btn.html('<i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic');
                
                if (res.berhasil) {
                    status.text('Applied!');
                    
                    if (res.data.judul) $('input[name="judul"]').val(res.data.judul);
                    if (res.data.ringkasan) $('textarea[name="ringkasan"]').val(res.data.ringkasan);
                    if (res.data.isi) $('#editor').summernote('code', res.data.isi);
                    if (res.data.tags) $('input[name="tags"]').val(res.data.tags);
                    
                    info.show().html('<strong>Hasil AI:</strong> ' + res.data.alasan);
                    hitungSeo();
                } else {
                    status.text('Error');
                    alert(res.pesan);
                }
            },
            error: function() {
                btn.disabled = false;
                btn.html('<i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic');
                status.text('Connection Error');
                alert('Terjadi kesalahan koneksi ke server.');
            }
        });
    });
</script>
@endsection
