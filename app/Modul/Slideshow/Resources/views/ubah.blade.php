@extends('admin.layout')

@section('judul', 'Ubah Slideshow')

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
        height: 250px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--border);
    }
</style>

<div class="card" style="max-width: 800px;">
    <h3>Ubah Slide</h3>
    <form action="/admin/slideshow/ubah/{{ $slide->id }}" method="POST" enctype="multipart/form-data" style="margin-top: 25px;">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul</label>
            <input type="text" name="judul" value="{{ $slide->judul }}" required style="width: 100%;">
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Deskripsi</label>
            <textarea name="deskripsi" style="width: 100%; height: 80px;">{{ $slide->deskripsi }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Badge 1 (Floating)</label>
                <input type="text" name="badge_1" value="{{ $slide->badge_1 }}">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Badge 2 (Floating)</label>
                <input type="text" name="badge_2" value="{{ $slide->badge_2 }}">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Gambar (Biarkan kosong jika tidak ingin mengubah)</label>
            <div class="upload-area" id="dropArea">
                <i class="fas fa-cloud-upload-alt" style="display: none;"></i>
                <p id="uploadText">{{ basename($slide->gambar) }}</p>
                <input type="file" name="gambar" id="imageInput" accept="image/*">
                <div class="preview-container" id="previewContainer">
                    @php
                        $imgPath = (strpos($slide->gambar, 'http') === 0) ? $slide->gambar : '/storage/' . $slide->gambar;
                    @endphp
                    <img id="previewImage" class="preview-image" src="{{ $imgPath }}" alt="Preview">
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Link URL (Optional)</label>
            <input type="text" name="url" value="{{ $slide->url }}" style="width: 100%;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Urutan</label>
            <input type="number" name="urutan" value="{{ $slide->urutan }}" style="width: 100%;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="aktif" value="1" {{ $slide->aktif ? 'checked' : '' }}>
                <strong>Aktifkan Slide</strong>
            </label>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn">Perbarui Slideshow</button>
            <a href="/admin/slideshow" class="btn" style="background: #64748b;">Batal</a>
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
