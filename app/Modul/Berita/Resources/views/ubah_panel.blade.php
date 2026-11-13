<form id="panel-edit-form-berita" action="/admin/blog/ubah/{{ $berita->id }}" method="POST" enctype="multipart/form-data" data-panel-form>
    @csrf
    <input type="hidden" name="panel" value="1">

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px;">
        {{-- Left: Main Content --}}
        <div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Judul Berita</label>
                <input type="text" name="judul" id="berita-title" value="{{ $berita->judul }}" required
                    placeholder="Masukkan judul menarik..."
                    style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Ringkasan (AEO/GEO Optimized)</label>
                <textarea name="ringkasan" id="berita-ringkasan" rows="3"
                    placeholder="Ringkasan singkat untuk mesin pencari & AI..."
                    style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem; resize: vertical;">{{ $berita->ringkasan }}</textarea>
            </div>

            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Isi Berita</label>
                <textarea name="isi" id="panel-editor-berita" required>{{ $berita->isi }}</textarea>
            </div>
        </div>

        {{-- Right: Sidebar --}}
        <div>
            {{-- SEO Score Card --}}
            <div class="card" style="margin-bottom: 16px; background: #fdf2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin-bottom: 10px; font-size: 0.85rem; font-weight: 700;"><i class="fas fa-search"></i> SEO Score</h4>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div id="berita-seo-score-circle" style="width: 50px; height: 50px; border-radius: 50%; border: 4px solid #ef4444; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; color: #ef4444; flex-shrink: 0;">
                        0
                    </div>
                    <div>
                        <div id="berita-seo-status" style="font-weight: 600; font-size: 0.8rem; color: #ef4444;">Perlu Optimasi</div>
                        <small style="color: #64748b; display: block; font-size: 0.72rem; line-height: 1.2;" id="berita-seo-tips">Lengkapi konten Anda...</small>
                    </div>
                </div>
            </div>

            {{-- AI Magic Assistant Card --}}
            <div class="ai-assistant-card" style="margin-bottom: 16px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 15px; border-radius: 12px; color: white; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -15px; right: -15px; font-size: 4rem; color: rgba(255,255,255,0.1); transform: rotate(15deg); pointer-events: none;">
                    <i class="fas fa-robot"></i>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; position: relative;">
                    <label style="font-weight: 700; display: flex; align-items: center; gap: 8px; font-size: 0.9rem;"><i class="fas fa-sparkles"></i> AI Magic Assistant</label>
                    <span id="berita-ai-status" style="font-size: 0.65rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); padding: 1px 8px; border-radius: 20px;">Ready</span>
                </div>
                <div style="margin-bottom: 10px; position: relative;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 600; margin-bottom: 4px; color: rgba(255,255,255,0.9);">Instruksi Khusus (Opsional):</label>
                    <textarea id="berita-ai-custom-prompt" rows="2" placeholder="Gaya bahasa santai, perbanyak data teknis..." 
                        style="width: 100%; padding: 8px; border-radius: 8px; background: #ffffff !important; color: #1e293b !important; border: 1px solid #cbd5e1 !important; font-size: 0.8rem; resize: none; outline: none; font-family: inherit;"></textarea>
                </div>
                <div style="margin-bottom: 12px; position: relative;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 600; margin-bottom: 4px; color: rgba(255,255,255,0.9);">Pilih Tindakan Utama:</label>
                    <select id="berita-ai-command" style="width: 100%; padding: 8px; border-radius: 8px; background: white; border: none; color: #1e1b4b; font-size: 0.8rem; cursor: pointer; font-weight: 600;">
                        <option value="Tulis ulang berita ini agar lebih menarik dan profesional.">Tulis Ulang Profesional</option>
                        <option value="Optimasi SEO, AEO, dan GEO untuk konten ini dan buatkan meta deskripsi.">Optimasi SEO & AEO</option>
                        <option value="Perbaiki tata bahasa dan ejaan (Auto-Correct).">Perbaiki Tata Bahasa</option>
                        <option value="Berikan saran untuk pengembangan artikel ini.">Saran Pengembangan</option>
                    </select>
                </div>
                <button type="button" id="btn-berita-ai-magic" style="width: 100%; background: white; color: #4f46e5; border: none; padding: 10px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.8rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic
                </button>
                <div id="berita-ai-result-info" style="margin-top: 10px; font-size: 0.7rem; background: rgba(0,0,0,0.2); padding: 8px; border-radius: 8px; border-left: 3px solid #fff; display: none; line-height: 1.4;"></div>
            </div>

            {{-- Properties Sidebar --}}
            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 14px;">
                <h4 style="margin-bottom: 12px; font-size: 0.85rem; font-weight: 700;">Publikasi</h4>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.85rem; margin-bottom: 12px;">
                    <input type="checkbox" name="unggulan" value="1" {{ $berita->unggulan ? 'checked' : '' }} style="width: auto;">
                    <span>Berita Unggulan</span>
                </label>
            </div>

            {{-- Kategori --}}
            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 14px;">
                <h4 style="margin-bottom: 12px; font-size: 0.85rem; font-weight: 700;">Kategori</h4>
                <div style="max-height: 160px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px;">
                    @foreach($kategori as $kat)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.82rem;">
                            <input type="checkbox" name="kategori_ids[]" value="{{ $kat->id }}"
                                {{ $berita->kategoris->contains($kat->id) ? 'checked' : '' }} style="width: auto;">
                            <span>{{ $kat->nama }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Gambar --}}
            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 14px;">
                <h4 style="margin-bottom: 12px; font-size: 0.85rem; font-weight: 700;">Gambar Utama</h4>
                @if($berita->gambar_utama)
                    @php
                        $imgUrl = $berita->gambar_utama;
                        if ($imgUrl && !str_starts_with($imgUrl, 'http')) $imgUrl = '/storage/' . $imgUrl;
                    @endphp
                    <img src="{{ $imgUrl }}" style="width: 100%; border-radius: 6px; margin-bottom: 8px; max-height: 120px; object-fit: cover;">
                @endif
                <input type="file" name="gambar_utama" accept="image/*" style="font-size: 0.82rem;">
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 6px;">JPG/PNG, maks 2MB. Kosongkan jika tidak diubah.</p>
            </div>

            {{-- Tags --}}
            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin-bottom: 8px; font-size: 0.85rem; font-weight: 700;">Tags (LLMO)</h4>
                <input type="text" name="tags" id="berita-tags" value="{{ $berita->tags->pluck('nama')->implode(', ') }}"
                    placeholder="Pisahkan dengan koma..."
                    style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.82rem;">
            </div>
        </div>
    </div>
</form>

<script>
(function() {
    function initBeritaPanelEditor() {
        if (typeof $ === 'undefined' || typeof $.fn.summernote === 'undefined') {
            setTimeout(initBeritaPanelEditor, 100); return;
        }
        if ($('#panel-editor-berita').data('summernote')) return;
        $('#panel-editor-berita').summernote({
            placeholder: 'Tulis isi berita di sini...',
            tabsize: 2,
            height: 320,
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
                    hitungBeritaSeo();
                }
            }
        });

        // Event listeners for SEO calculation
        $('#berita-title, #berita-ringkasan, #berita-tags').on('input change', function() {
            hitungBeritaSeo();
        });

        hitungBeritaSeo();
    }

    function hitungBeritaSeo() {
        let score = 0;
        let tips = [];
        
        let judul = $('#berita-title').val() || '';
        let ringkasan = $('#berita-ringkasan').val() || '';
        let isi = $('#panel-editor-berita').summernote('code').replace(/<[^>]*>/g, '') || '';
        
        // Title Score (25%)
        if (judul.length >= 40 && judul.length <= 70) score += 25;
        else if (judul.length > 0) { score += 10; tips.push("Judul idealnya 40-70 karakter."); }

        // Ringkasan Score (25%)
        if (ringkasan.length >= 120 && ringkasan.length <= 160) score += 25;
        else if (ringkasan.length > 0) { score += 10; tips.push("Ringkasan idealnya 120-160 karakter."); }

        // Content Length (30%)
        let wordCount = isi.trim().split(/\s+/).filter(w => w.length > 0).length;
        if (wordCount >= 300) score += 30;
        else if (wordCount > 50) { score += 15; tips.push("Konten minimal 300 kata."); }

        // Tags (20%)
        let tags = $('#berita-tags').val() || '';
        let tagCount = tags.split(',').filter(t => t.trim().length > 0).length;
        if (tagCount >= 3) score += 20;
        else if (tagCount > 0) { score += 10; tips.push("Gunakan min. 3 tags."); }

        score = Math.min(score, 100);
        $('#berita-seo-score-circle').text(score);
        
        let color = "#ef4444";
        let status = "Perlu Optimasi";
        if (score > 80) { color = "#22c55e"; status = "Sangat Baik"; }
        else if (score > 50) { color = "#f59e0b"; status = "Cukup Baik"; }
        
        $('#berita-seo-score-circle').css({'border-color': color, 'color': color});
        $('#berita-seo-status').text(status).css('color', color);
        $('#berita-seo-tips').text(tips.length > 0 ? tips[0] : "Konten sudah sangat baik!");
    }

    // AI Magic Helper
    $(document).off('click', '#btn-berita-ai-magic').on('click', '#btn-berita-ai-magic', function() {
        let instruksi = $('#berita-ai-custom-prompt').val();
        let command = $('#berita-ai-command').val();
        let perintah = command;
        
        if (instruksi.trim() !== '') {
            perintah = instruksi + ". Dan terapkan tindakan berikut: " + command;
        }

        let judul = $('#berita-title').val();
        let isi = $('#panel-editor-berita').summernote('code');
        
        let btn = $(this);
        let status = $('#berita-ai-status');
        let info = $('#berita-ai-result-info');

        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Thinking...');
        status.text('Working...');

        $.ajax({
            url: '/admin/blog/ai-bantu',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                perintah: perintah,
                judul: judul,
                isi: isi
            },
            success: function(res) {
                btn.prop('disabled', false);
                btn.html('<i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic');
                
                if (res.berhasil) {
                    status.text('Applied!');
                    
                    if (res.data.judul) $('#berita-title').val(res.data.judul);
                    if (res.data.ringkasan) $('#berita-ringkasan').val(res.data.ringkasan);
                    if (res.data.isi) $('#panel-editor-berita').summernote('code', res.data.isi);
                    if (res.data.tags) $('#berita-tags').val(res.data.tags);
                    
                    info.show().html('<strong>Hasil AI:</strong> ' + res.data.alasan);
                    hitungBeritaSeo();
                } else {
                    status.text('Error');
                    alert(res.pesan);
                }
            },
            error: function() {
                btn.prop('disabled', false);
                btn.html('<i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic');
                status.text('Connection Error');
                alert('Terjadi kesalahan koneksi.');
            }
        });
    });

    initBeritaPanelEditor();
})();
</script>
