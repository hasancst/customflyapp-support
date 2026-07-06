@extends('admin.layout')

@section('judul', 'Edit Artikel')

@section('konten')
<div class="card">
    <form action="/admin/artikel/edit/{{ $artikel->id }}" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px;">Judul Artikel</label>
            <input type="text" name="judul" value="{{ $artikel->judul }}" required>
        </div>
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Isi Artikel</label>
            <textarea name="isi" id="summernote" required>{{ $artikel->isi }}</textarea>
        </div>
        <button type="submit" class="btn">Perbarui Artikel</button>
        <a href="/admin/artikel" style="color: #94a3b8; margin-left: 15px; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis isi artikel di sini...',
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
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        uploadImage(files[i]);
                    }
                }
            }
        });
    });

    function uploadImage(file) {
        let data = new FormData();
        data.append("image", file);
        data.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: "{{ route('admin.media.unggah') }}",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function(url) {
                var image = $('<img>').attr('src', url.url);
                $('#summernote').summernote("insertNode", image[0]);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>
<style>
    .note-editor { background: #fff !important; }
    .note-editable { background: #fff !important; color: #333 !important; }
</style>
@endsection
