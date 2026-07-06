@extends('admin.layout')

@section('judul', 'Ubah Iklan')

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
        margin-top: 15px;
    }
    .preview-image {
        max-width: 100%;
        height: 150px;
        object-fit: contain;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: #f8f8f8;
    }
</style>

<div class="card">
    <form action="/admin/iklan/ubah/{{ $iklan->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Iklan</label>
            <input type="text" name="judul" value="{{ $iklan->judul }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Posisi</label>
                <select name="posisi" required style="width: 100%;">
                    @foreach(['header', 'sidebar_top', 'sidebar_bottom', 'article_middle', 'footer'] as $p)
                        <option value="{{ $p }}" {{ $iklan->posisi == $p ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $p)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Jenis Iklan</label>
                <select name="jenis" id="jenis-iklan" required style="width: 100%;">
                    <option value="gambar" {{ $iklan->jenis == 'gambar' ? 'selected' : '' }}>Gambar / Banner</option>
                    <option value="script" {{ $iklan->jenis == 'script' ? 'selected' : '' }}>Kode HTML / Script</option>
                </select>
            </div>
        </div>

        <div id="field-gambar" style="margin-bottom: 20px; display: {{ $iklan->jenis == 'gambar' ? 'block' : 'none' }};">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Upload Banner</label>
            <div class="upload-area" id="dropArea">
                <i class="fas fa-image" style="display: none;"></i>
                <p id="uploadText">{{ $iklan->jenis == 'gambar' ? basename($iklan->konten) : 'Klik atau seret banner iklan ke sini' }}</p>
                <input type="file" name="gambar" id="imageInput" accept="image/*">
                <div class="preview-container" id="previewContainer" style="display: {{ $iklan->jenis == 'gambar' ? 'block' : 'none' }};">
                    <img id="previewImage" class="preview-image" src="{{ $iklan->jenis == 'gambar' ? '/storage/'.$iklan->konten : '#' }}" alt="Preview">
                </div>
            </div>
            <small style="color: var(--text-muted); display: block; margin-top: 10px;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            
            <div style="margin-top: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Link Tujuan (Opsional)</label>
                <input type="url" name="link" value="{{ $iklan->link }}" placeholder="https://...">
            </div>
        </div>

        <div id="field-script" style="margin-bottom: 20px; display: {{ $iklan->jenis == 'script' ? 'block' : 'none' }};">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Kode Script (HTML/JS)</label>
            <textarea name="script" rows="6" style="font-family: monospace;">{{ $iklan->jenis == 'script' ? $iklan->konten : '' }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="aktif" value="1" {{ $iklan->aktif ? 'checked' : '' }}>
                <span style="font-weight: 600;">Aktifkan Iklan Ini</span>
            </label>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn"><i class="fas fa-save"></i> Perbarui Iklan</button>
            <a href="/admin/iklan" class="btn" style="background: #94a3b8;">Batal</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('jenis-iklan').addEventListener('change', function() {
        if (this.value === 'gambar') {
            document.getElementById('field-gambar').style.display = 'block';
            document.getElementById('field-script').style.display = 'none';
        } else {
            document.getElementById('field-gambar').style.display = 'none';
            document.getElementById('field-script').style.display = 'block';
        }
    });

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
                if(uploadIcon) uploadIcon.style.display = 'none';
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
