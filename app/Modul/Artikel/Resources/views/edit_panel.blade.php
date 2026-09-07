<form id="panel-edit-form-artikel" action="/admin/artikel/edit/{{ $artikel->id }}" method="POST" data-panel-form>
    @csrf
    <input type="hidden" name="panel" value="1">

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px;">
        {{-- Left Side: Title & Content --}}
        <div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Judul Artikel</label>
                <input type="text" name="judul" id="artikel-title" value="{{ $artikel->judul }}" required
                    style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Isi Artikel</label>
                <textarea name="isi" id="panel-summernote-artikel" required>{{ $artikel->isi }}</textarea>
            </div>
        </div>

        {{-- Right Side: AI, SEO & Actions --}}
        <div>
            {{-- SEO Score Card --}}
            <div class="card" style="margin-bottom: 16px; background: #fdf2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin-bottom: 10px; font-size: 0.85rem; font-weight: 700;"><i class="fas fa-search"></i> SEO Score</h4>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div id="artikel-seo-score-circle" style="width: 50px; height: 50px; border-radius: 50%; border: 4px solid #ef4444; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; color: #ef4444; flex-shrink: 0;">
                        0
                    </div>
                    <div>
                        <div id="artikel-seo-status" style="font-weight: 600; font-size: 0.8rem; color: #ef4444;">Perlu Optimasi</div>
                        <small style="color: #64748b; display: block; font-size: 0.72rem; line-height: 1.2;" id="artikel-seo-tips">Lengkapi konten Anda...</small>
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
                    <span id="artikel-ai-status" style="font-size: 0.65rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); padding: 1px 8px; border-radius: 20px;">Ready</span>
                </div>
                <div style="margin-bottom: 10px; position: relative;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 600; margin-bottom: 4px; color: rgba(255,255,255,0.9);">Instruksi Khusus (Opsional):</label>
                    <textarea id="artikel-ai-custom-prompt" rows="2" placeholder="Gaya bahasa santai, perbanyak data teknis..." 
                        style="width: 100%; padding: 8px; border-radius: 8px; background: #ffffff !important; color: #1e293b !important; border: 1px solid #cbd5e1 !important; font-size: 0.8rem; resize: none; outline: none; font-family: inherit;"></textarea>
                </div>
                <div style="margin-bottom: 12px; position: relative;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 600; margin-bottom: 4px; color: rgba(255,255,255,0.9);">Pilih Tindakan Utama:</label>
                    <select id="artikel-ai-command" style="width: 100%; padding: 8px; border-radius: 8px; background: white; border: none; color: #1e1b4b; font-size: 0.8rem; cursor: pointer; font-weight: 600;">
                        <option value="Tulis ulang artikel ini agar lebih menarik dan profesional.">Tulis Ulang Profesional</option>
                        <option value="Perbaiki tata bahasa, ejaan, dan buat formatnya lebih rapi.">Perbaiki Tata Bahasa</option>
                        <option value="Berikan saran pengembangan konten untuk artikel ini.">Saran Pengembangan</option>
                    </select>
                </div>
                <button type="button" id="btn-artikel-ai-magic" style="width: 100%; background: white; color: #4f46e5; border: none; padding: 10px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.8rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic
                </button>
                <div id="artikel-ai-result-info" style="margin-top: 10px; font-size: 0.7rem; background: rgba(0,0,0,0.2); padding: 8px; border-radius: 8px; border-left: 3px solid #fff; display: none; line-height: 1.4;"></div>
            </div>

            {{-- Actions --}}
            <div style="background: #f8fafc; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 8px;">
                <button type="submit" class="btn" style="width: 100%; justify-content: center;">
                    <i class="fas fa-save"></i> Perbarui Artikel
                </button>
            </div>
        </div>
    </div>
</form>

<script>
(function() {
    function initArtikelPanelEditor() {
        if (typeof $ === 'undefined' || typeof $.fn.summernote === 'undefined') {
            setTimeout(initArtikelPanelEditor, 100); return;
        }
        if ($('#panel-summernote-artikel').data('summernote')) return;
        $('#panel-summernote-artikel').summernote({
            placeholder: 'Tulis isi artikel di sini...',
            tabsize: 2,
            height: 380,
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
                    hitungArtikelSeo();
                },
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        let data = new FormData();
                        data.append("image", files[i]);
                        data.append("_token", "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('admin.media.unggah') }}",
                            cache: false, contentType: false, processData: false,
                            data: data, type: "POST",
                            success: function(url) {
                                var image = $('<img>').attr('src', url.url);
                                $('#panel-summernote-artikel').summernote("insertNode", image[0]);
                            }
                        });
                    }
                }
            }
        });

        // Event listeners for SEO calculation
        $('#artikel-title').on('input change', function() {
            hitungArtikelSeo();
        });

        hitungArtikelSeo();
    }

    function hitungArtikelSeo() {
        let score = 0;
        let tips = [];
        
        let judul = $('#artikel-title').val() || '';
        let isi = $('#panel-summernote-artikel').summernote('code').replace(/<[^>]*>/g, '') || '';
        
        // Title Score (40%)
        if (judul.length >= 40 && judul.length <= 70) {
            score += 40;
        } else if (judul.length > 0) {
            score += 15;
            tips.push("Judul idealnya 40-70 karakter.");
        }

        // Content Length (60%)
        let wordCount = isi.trim().split(/\s+/).filter(w => w.length > 0).length;
        if (wordCount >= 300) {
            score += 60;
        } else if (wordCount > 50) {
            score += 25;
            tips.push("Konten minimal 300 kata.");
        } else {
            tips.push("Konten terlalu singkat.");
        }

        score = Math.min(score, 100);
        $('#artikel-seo-score-circle').text(score);
        
        let color = "#ef4444";
        let status = "Perlu Optimasi";
        if (score > 80) {
            color = "#22c55e";
            status = "Sangat Baik";
        } else if (score > 50) {
            color = "#f59e0b";
            status = "Cukup Baik";
        }
        
        $('#artikel-seo-score-circle').css({'border-color': color, 'color': color});
        $('#artikel-seo-status').text(status).css('color', color);
        $('#artikel-seo-tips').text(tips.length > 0 ? tips[0] : "Konten sudah sangat baik!");
    }

    // AI Magic Helper Action
    $(document).off('click', '#btn-artikel-ai-magic').on('click', '#btn-artikel-ai-magic', function() {
        let instruksi = $('#artikel-ai-custom-prompt').val();
        let command = $('#artikel-ai-command').val();
        let perintah = command;
        
        if (instruksi.trim() !== '') {
            perintah = instruksi + ". Dan terapkan tindakan berikut: " + command;
        }

        let judul = $('#artikel-title').val();
        let isi = $('#panel-summernote-artikel').summernote('code');
        
        let btn = $(this);
        let status = $('#artikel-ai-status');
        let info = $('#artikel-ai-result-info');

        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Thinking...');
        status.text('Working...');

        $.ajax({
            url: '/admin/artikel/ai-bantu',
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
                    if (res.data.judul) $('#artikel-title').val(res.data.judul);
                    if (res.data.isi) $('#panel-summernote-artikel').summernote('code', res.data.isi);
                    
                    info.show().html('<strong>Hasil AI:</strong> ' + res.data.alasan);
                    hitungArtikelSeo();
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

    initArtikelPanelEditor();
})();
</script>
