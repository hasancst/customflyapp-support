@extends('admin.layout')

@section('judul', 'Tambah Berita Baru')

@section('konten')
<div class="card">
    <form action="/admin/berita/tambah" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 30px;">
            <!-- Kolom Utama -->
            <div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Berita</label>
                    <input type="text" name="judul" required placeholder="Masukkan judul berita...">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Ringkasan</label>
                    <textarea name="ringkasan" rows="3" placeholder="Ringkasan singkat untuk tampilan kartu berita..."></textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Isi Berita</label>
                    <textarea name="isi" id="summernote" required></textarea>
                </div>
            </div>

            <!-- Kolom Samping (Meta) -->
            <div>
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
                            <option value="Buat draft berita lengkap berdasarkan judul yang saya tulis.">Buat Draft dari Judul</option>
                            <option value="Perbaiki tata bahasa dan ejaan (Auto-Correct).">Perbaiki Tata Bahasa</option>
                        </select>
                    </div>
                    <button type="button" id="btn-ai-magic" class="btn-magic" style="width: 100%; background: white; color: #4f46e5; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic
                    </button>
                    <div id="ai-result-info" style="margin-top: 15px; font-size: 0.75rem; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 10px; border-left: 4px solid #fff; display: none; line-height: 1.5;">
                    </div>
                </div>

                <!-- SEO Assistant -->
                <div style="margin-bottom: 25px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <label style="font-weight: 600;"><i class="fas fa-search" style="color: var(--primary);"></i> SEO Assistant</label>
                        <span id="seo-status-badge" class="badge" style="background: #f1f5f9; color: #64748b;">Menunggu...</span>
                    </div>
                    <div style="text-align: center; margin-bottom: 15px;">
                        <div id="seo-score" style="font-size: 2.5rem; font-weight: 800; color: #94a3b8;">0</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">SEO SCORE</div>
                    </div>
                    <div id="seo-recommendations" style="font-size: 0.8rem; color: #475569; line-height: 1.4;">
                        Tulis berita untuk melihat analisis SEO.
                    </div>
                </div>

                <!-- Gambar Utama -->
                <div style="margin-bottom: 25px; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid var(--border);">
                    <label style="display: block; margin-bottom: 12px; font-weight: 600;">Gambar Utama</label>
                    <div id="image-preview" style="width: 100%; height: 150px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; border: 2px dashed #cbd5e1; overflow: hidden;">
                        <i class="fas fa-image" style="font-size: 2rem; color: #94a3b8;"></i>
                    </div>
                    <input type="file" name="gambar_utama" id="image-input" accept="image/*" style="font-size: 0.8rem;">
                </div>

                <!-- Kategori -->
                <div style="margin-bottom: 25px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="font-weight: 600;">Kategori</label>
                        <a href="/admin/berita/kategori" style="font-size: 0.8rem; color: var(--primary); text-decoration: none;"><i class="fas fa-plus-circle"></i> Kelola</a>
                    </div>
                    <div style="max-height: 150px; overflow-y: auto; background: #fff; padding: 12px; border-radius: 12px; border: 1px solid var(--border);">
                        @foreach($kategori as $k)
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.85rem; margin-bottom: 8px;">
                                <input type="checkbox" name="kategori_ids[]" value="{{ $k->id }}" style="width: auto !important;">
                                {{ $k->nama }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Tags -->
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tags</label>
                    <input type="text" name="tags" placeholder="tag1, tag2, tag3" style="font-size: 0.85rem;">
                    <small style="color: var(--text-muted); font-size: 0.75rem; display: block; mt-1">Pisahkan dengan koma</small>
                </div>

                <!-- Unggulan -->
                <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 10px; background: var(--primary-light); padding: 15px; border-radius: 12px; border: 1px solid rgba(78, 115, 223, 0.1);">
                    <input type="checkbox" name="unggulan" id="unggulan" style="width: 20px; height: 20px; cursor: pointer;">
                    <label for="unggulan" style="font-weight: 600; cursor: pointer; color: var(--primary);">Jadikan Berita Unggulan</label>
                </div>




                <button type="submit" class="btn" style="width: 100%; justify-content: center; padding: 15px;">
                    <i class="fas fa-save"></i> Terbitkan Berita
                </button>
                <a href="/admin/berita" style="display: block; text-align: center; margin-top: 15px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    .note-editor { background: #fff !important; border-radius: 12px !important; border: 1px solid var(--border) !important; }
    .note-editable { 
        background: #fff !important; 
        color: #333 !important; 
        font-family: 'Outfit', sans-serif !important;
        font-size: 1rem !important;
        line-height: 1.6 !important;
    }
    .note-toolbar { background: #f8fafc !important; border-top-left-radius: 12px !important; border-top-right-radius: 12px !important; border-bottom: 1px solid var(--border) !important; }
    
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
        $('#summernote').summernote({
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

        // Image Preview
        $('#image-input').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#image-preview').html(`<img src="${event.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`);
                }
                reader.readAsDataURL(file);
            }
        });

        hitungSeo();
    });

    function hitungSeo() {
        let score = 0;
        let tips = [];
        
        let judul = $('input[name="judul"]').val() || '';
        let ringkasan = $('textarea[name="ringkasan"]').val() || '';
        let isi = $('#summernote').summernote('code').replace(/<[^>]*>/g, '') || '';
        
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
        $('#seo-score').text(score);
        
        let color = "#94a3b8";
        let status = "Menunggu...";
        let badgeClass = {background: "#f1f5f9", color: "#64748b"};

        if (score >= 80) {
            color = "#22c55e"; status = "Sangat Baik";
            badgeClass = {background: "#dcfce7", color: "#166534"};
        } else if (score >= 50) {
            color = "#f59e0b"; status = "Cukup Baik";
            badgeClass = {background: "#fef3c7", color: "#92400e"};
        } else {
            color = "#ef4444"; status = "Perlu Optimasi";
            badgeClass = {background: "#fee2e2", color: "#b91c1c"};
        }
        
        $('#seo-score').css('color', color);
        $('#seo-status-badge').text(status).css(badgeClass);
        
        if (tips.length > 0) {
            let list = '<ul style="padding-left: 15px; margin-top: 10px;">';
            tips.forEach(item => { list += `<li style="margin-bottom: 5px;">${item}</li>`; });
            list += '</ul>';
            $('#seo-recommendations').html(list);
        } else {
            $('#seo-recommendations').html('<div style="margin-top: 10px; color: #22c55e;"><i class="fas fa-check-circle"></i> SEO konten Anda sudah optimal!</div>');
        }
    }

    $('#btn-ai-magic').click(function() {
        let instruksi = $('#ai-custom-prompt').val();
        let command = $('#ai-command').val();
        let perintah = command;
        
        if (instruksi.trim() !== '') {
            perintah = instruksi + ". Dan terapkan tindakan berikut: " + command;
        }

        let judul = $('input[name="judul"]').val();
        let isi = $('#summernote').summernote('code');
        
        let btn = $(this);
        let status = $('#ai-status');
        let info = $('#ai-result-info');

        btn.disabled = true;
        btn.html('<i class="fas fa-spinner fa-spin"></i> Sedang Berpikir...');
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
                    
                    // Update content
                    if (res.data.judul) $('input[name="judul"]').val(res.data.judul);
                    if (res.data.ringkasan) $('textarea[name="ringkasan"]').val(res.data.ringkasan);
                    if (res.data.isi) $('#summernote').summernote('code', res.data.isi);
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
