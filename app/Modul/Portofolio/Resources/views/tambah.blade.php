@extends('admin.layout')

@section('judul', 'Tambah Portofolio')

@section('konten')
<style>
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background: var(--bg-body);
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .upload-area:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }
    .upload-area i {
        font-size: 2.5rem;
        color: var(--text-muted);
        margin-bottom: 15px;
        display: block;
    }
    .upload-area input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }
    .preview-container {
        display: none;
        margin-top: 15px;
    }
    .preview-image {
        max-width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--border);
    }
    .date-input-wrapper {
        position: relative;
    }
    .date-input-wrapper i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }
</style>

<div class="card" style="max-width: 900px;">
    <h3>Tambah Proyek Baru</h3>
    <form action="/admin/portofolio/tambah" method="POST" enctype="multipart/form-data" style="margin-top: 25px;">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Proyek</label>
                <input type="text" name="judul" required placeholder="Contoh: Redesign Website PT. ABC">
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Kategori</label>
                <input type="text" name="kategori" placeholder="Contoh: Web Development, UI/UX">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Klien</label>
                <input type="text" name="klien" placeholder="Nama Perusahaan atau Individu">
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">URL Proyek (Link)</label>
                <input type="url" name="url" placeholder="https://example.com">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Deskripsi Proyek</label>
            <textarea name="deskripsi" style="height: 120px;" placeholder="Jelaskan tentang proyek ini..."></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tags (Pisahkan dengan koma)</label>
            <input type="text" name="tags" placeholder="Contoh: Web, Design, Laravel, SEO">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Gambar / Cover</label>
                <div class="upload-area" id="dropArea">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p id="uploadText">Klik atau seret gambar ke sini</p>
                    <input type="file" name="gambar" id="imageInput" required accept="image/*">
                    <div class="preview-container" id="previewContainer">
                        <img id="previewImage" class="preview-image" src="#" alt="Preview">
                    </div>
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tanggal Selesai</label>
                <div class="date-input-wrapper">
                    <input type="date" name="tanggal">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div style="margin-top: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Urutan Tampilan</label>
                    <input type="number" name="urutan" value="0">
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn">Simpan Portofolio</button>
            <a href="/admin/portofolio" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const uploadText = document.getElementById('uploadText');
    const uploadIcon = document.querySelector('.upload-area i');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                uploadText.textContent = file.name;
                uploadIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop logic
    const dropArea = document.getElementById('dropArea');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
    });

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        imageInput.files = files;
        
        // Trigger change event to show preview
        const event = new Event('change');
        imageInput.dispatchEvent(event);
    }
</script>
@endsection
