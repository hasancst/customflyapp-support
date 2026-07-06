<div class="ai-assistant-card" style="margin-bottom: 25px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 20px; border-radius: 12px; border: none; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); color: white; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(255,255,255,0.1); transform: rotate(15deg); pointer-events: none;">
        <i class="fas fa-robot"></i>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; position: relative;">
        <label style="font-weight: 700; display: flex; align-items: center; gap: 10px; font-size: 1.1rem;"><i class="fas fa-sparkles"></i> AI KB Assistant</label>
        <span id="ai-status" style="font-size: 0.7rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); padding: 2px 10px; border-radius: 20px; backdrop-filter: blur(5px);">Ready</span>
    </div>
    <div style="margin-bottom: 12px; position: relative;">
        <label style="display: block; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; color: rgba(255,255,255,0.9);">Instruksi Khusus (Opsional):</label>
        <textarea id="ai-custom-prompt" rows="2" placeholder="Contoh: Gunakan gaya bahasa santai, buat panduan teknis..." 
            style="width: 100%; padding: 12px; border-radius: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2); color: white; font-size: 0.85rem; resize: none; transition: all 0.3s; font-family: inherit; outline: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);"></textarea>
        <style>
            #ai-custom-prompt::placeholder { color: rgba(255,255,255,0.6); }
            #ai-custom-prompt:focus { background: rgba(0,0,0,0.3) !important; border-color: rgba(255,255,255,0.5) !important; }
        </style>
    </div>
    <div style="margin-bottom: 18px; position: relative;">
        <label style="display: block; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; color: rgba(255,255,255,0.9);">Pilih Tindakan:</label>
        <select id="ai-command" style="width: 100%; padding: 12px; border-radius: 10px; background: white; border: none; color: #1e1b4b; font-size: 0.9rem; cursor: pointer; font-weight: 600; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%234f46e5%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
            <option value="Tulis ulang artikel ini agar menjadi panduan yang lebih jelas dan profesional.">Optimasi Panduan</option>
            <option value="Buat panduan lengkap (Knowledge Base) berdasarkan judul yang saya tulis, sertakan langkah-langkah yang mudah diikuti.">Buat Panduan dari Judul</option>
            <option value="Perbaiki tata bahasa, ejaan, dan buat formatnya lebih rapi dengan poin-poin.">Perbaiki Format & Tata Bahasa</option>
            <option value="Tambahkan konten tambahan yang relevan untuk memperdalam panduan ini.">Perdalam Materi</option>
        </select>
    </div>
    <button type="button" id="btn-ai-magic" style="width: 100%; background: white; color: #4f46e5; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <i class="fas fa-wand-magic-sparkles"></i> Jalankan AI Magic
    </button>
    <div id="ai-result-info" style="margin-top: 15px; font-size: 0.75rem; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 10px; border-left: 4px solid #fff; display: none; line-height: 1.5;">
    </div>
</div>

<script>
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

        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Sedang Berpikir...');
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
                btn.html('<i class="fas fa-wand-magic-sparkles"></i> Jalankan AI Magic');
                
                if (res.berhasil) {
                    status.text('Applied!');
                    
                    if (res.data.judul) $('input[name="judul"]').val(res.data.judul);
                    if (res.data.isi) $('#summernote').summernote('code', res.data.isi);
                    if (res.data.tags) $('input[name="tags"]').val(res.data.tags);
                    
                    info.show().html('<strong>Hasil AI:</strong> ' + res.data.alasan);
                } else {
                    status.text('Error');
                    alert(res.pesan);
                }
            },
            error: function() {
                btn.prop('disabled', false);
                btn.html('<i class="fas fa-wand-magic-sparkles"></i> Jalankan AI Magic');
                status.text('Connection Error');
                alert('Terjadi kesalahan koneksi ke server.');
            }
        });
    });
</script>
