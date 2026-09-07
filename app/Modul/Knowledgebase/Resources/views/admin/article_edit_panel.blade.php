<form id="panel-edit-form-kb" action="/admin/kb/article/update/{{ $article->id }}" method="POST" data-panel-form>
    @csrf
    <input type="hidden" name="panel" value="1">

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px;">
        {{-- Left Side: Title & Content --}}
        <div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Judul Artikel</label>
                <input type="text" name="judul" id="kb-title" value="{{ $article->judul }}" required
                    style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Konten Artikel</label>
                <textarea name="konten" id="panel-summernote-kb" required>{{ $article->konten }}</textarea>
            </div>
        </div>

        {{-- Right Side: AI Assistant, SEO Score, & Sidebar Options --}}
        <div>
            {{-- SEO Score Card --}}
            <div class="card" style="margin-bottom: 16px; background: #fdf2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin-bottom: 10px; font-size: 0.85rem; font-weight: 700;"><i class="fas fa-search"></i> SEO Score</h4>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div id="kb-seo-score-circle" style="width: 50px; height: 50px; border-radius: 50%; border: 4px solid #ef4444; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; color: #ef4444; flex-shrink: 0;">
                        0
                    </div>
                    <div>
                        <div id="kb-seo-status" style="font-weight: 600; font-size: 0.8rem; color: #ef4444;">Perlu Optimasi</div>
                        <small style="color: #64748b; display: block; font-size: 0.72rem; line-height: 1.2;" id="kb-seo-tips">Lengkapi konten Anda...</small>
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
                    <span id="kb-ai-status" style="font-size: 0.65rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); padding: 1px 8px; border-radius: 20px;">Ready</span>
                </div>
                <div style="margin-bottom: 10px; position: relative;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 600; margin-bottom: 4px; color: rgba(255,255,255,0.9);">Instruksi Khusus (Opsional):</label>
                    <textarea id="kb-ai-custom-prompt" rows="2" placeholder="Gaya bahasa santai, tambahkan poin teknis..." 
                        style="width: 100%; padding: 8px; border-radius: 8px; background: #ffffff !important; color: #1e293b !important; border: 1px solid #cbd5e1 !important; font-size: 0.8rem; resize: none; outline: none; font-family: inherit;"></textarea>
                </div>
                <div style="margin-bottom: 12px; position: relative;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 600; margin-bottom: 4px; color: rgba(255,255,255,0.9);">Pilih Tindakan Utama:</label>
                    <select id="kb-ai-command" style="width: 100%; padding: 8px; border-radius: 8px; background: white; border: none; color: #1e1b4b; font-size: 0.8rem; cursor: pointer; font-weight: 600;">
                        <option value="Tulis ulang artikel ini agar menjadi panduan yang lebih jelas dan profesional.">Optimasi Panduan</option>
                        <option value="Buat panduan lengkap (Knowledge Base) berdasarkan judul yang saya tulis, sertakan langkah-langkah yang mudah diikuti.">Buat Panduan dari Judul</option>
                        <option value="Perbaiki tata bahasa, ejaan, dan buat formatnya lebih rapi dengan poin-poin.">Perbaiki Format & Tata Bahasa</option>
                    </select>
                </div>
                <button type="button" id="btn-kb-ai-magic" style="width: 100%; background: white; color: #4f46e5; border: none; padding: 10px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.8rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <i class="fas fa-wand-magic-sparkles"></i> Jalankan Magic
                </button>
                <div id="kb-ai-result-info" style="margin-top: 10px; font-size: 0.7rem; background: rgba(0,0,0,0.2); padding: 8px; border-radius: 8px; border-left: 3px solid #fff; display: none; line-height: 1.4;"></div>
            </div>

            {{-- Properties Sidebar --}}
            <div style="background: #f8fafc; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Kategori</label>
                    <select name="category_id" required style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem;">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ $article->category_id == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ $article->urutan }}"
                        style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem;">
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Tags</label>
                    <input type="text" name="tags" id="kb-tags" value="{{ $article->tags }}" placeholder="panduan, help, setup"
                        style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.85rem;">
                </div>
                <div style="margin-bottom: 18px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.85rem;">
                        <input type="checkbox" name="aktif" {{ $article->aktif ? 'checked' : '' }} value="1">
                        <span>Publikasikan</span>
                    </label>
                </div>
                <button type="submit" class="btn" style="width: 100%; justify-content: center; margin-bottom: 8px;">
                    <i class="fas fa-save"></i> Update Artikel
                </button>
            </div>
        </div>
    </div>
</form>

<script>
(function() {
    function initKbPanelEditor() {
        if (typeof $ === 'undefined' || typeof $.fn.summernote === 'undefined') {
            setTimeout(initKbPanelEditor, 100);
            return;
        }
        if ($('#panel-summernote-kb').data('summernote')) return;
        $('#panel-summernote-kb').summernote({
            placeholder: 'Tulis panduan atau dokumentasi di sini...',
            tabsize: 2,
            height: 350,
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
                    hitungKbSeo();
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
                                $('#panel-summernote-kb').summernote("insertNode", image[0]);
                            }
                        });
                    }
                }
            }
        });

        // Event listeners for SEO calculation
        $('#kb-title, #kb-tags').on('input change', function() {
            hitungKbSeo();
        });

        hitungKbSeo();
    }

    function hitungKbSeo() {
        let score = 0;
        let tips = [];
        
        let judul = $('#kb-title').val() || '';
        let isi = $('#panel-summernote-kb').summernote('code').replace(/<[^>]*>/g, '') || '';
        
        // Title Score (30%)
        if (judul.length >= 40 && judul.length <= 70) {
            score += 30;
        } else if (judul.length > 0) {
            score += 10;
            tips.push("Judul idealnya 40-70 karakter.");
        }

        // Content Length (50%)
        let wordCount = isi.trim().split(/\s+/).filter(w => w.length > 0).length;
        if (wordCount >= 300) {
            score += 50;
        } else if (wordCount > 50) {
            score += 20;
            tips.push("Konten minimal 300 kata.");
        } else {
            tips.push("Konten terlalu singkat.");
        }

        // Tags (20%)
        let tags = $('#kb-tags').val() || '';
        let tagCount = tags.split(',').filter(t => t.trim().length > 0).length;
        if (tagCount >= 3) {
            score += 20;
        } else if (tagCount > 0) {
            score += 10;
            tips.push("Gunakan minimal 3 tag.");
        }

        score = Math.min(score, 100);
        $('#kb-seo-score-circle').text(score);
        
        let color = "#ef4444";
        let status = "Perlu Optimasi";
        if (score > 80) {
            color = "#22c55e";
            status = "Sangat Baik";
        } else if (score > 50) {
            color = "#f59e0b";
            status = "Cukup Baik";
        }
        
        $('#kb-seo-score-circle').css({'border-color': color, 'color': color});
        $('#kb-seo-status').text(status).css('color', color);
        $('#kb-seo-tips').text(tips.length > 0 ? tips[0] : "Konten sudah sangat baik!");
    }

    // AI Magic Helper Action
    $(document).off('click', '#btn-kb-ai-magic').on('click', '#btn-kb-ai-magic', function() {
        let instruksi = $('#kb-ai-custom-prompt').val();
        let command = $('#kb-ai-command').val();
        let perintah = command;
        
        if (instruksi.trim() !== '') {
            perintah = instruksi + ". Dan terapkan tindakan berikut: " + command;
        }

        let judul = $('#kb-title').val();
        let isi = $('#panel-summernote-kb').summernote('code');
        
        let btn = $(this);
        let status = $('#kb-ai-status');
        let info = $('#kb-ai-result-info');

        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Thinking...');
        status.text('Working...');

        $.ajax({
            url: '/admin/kb/article/ai-bantu',
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
                    if (res.data.judul) $('#kb-title').val(res.data.judul);
                    if (res.data.isi) $('#panel-summernote-kb').summernote('code', res.data.isi);
                    if (res.data.tags) $('#kb-tags').val(res.data.tags);
                    
                    info.show().html('<strong>Hasil AI:</strong> ' + res.data.alasan);
                    hitungKbSeo();
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

    initKbPanelEditor();
})();
</script>
