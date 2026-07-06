@extends('admin.layout')

@section('judul', 'Tambah Artikel Knowledge Base')

@section('konten')
<div class="card">
    <form action="/admin/kb/article/store" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 30px;">
            <div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Artikel</label>
                    <input type="text" name="judul" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Konten Artikel</label>
                    <textarea name="konten" id="summernote" required></textarea>
                </div>
            </div>

            <div>
                @include('knowledgebase::admin.ai_assistant_kb')
                <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; position: sticky; top: 100px;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Kategori</label>
                        <select name="category_id" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Urutan Tampil</label>
                        <input type="number" name="urutan" value="0" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tag (Pisahkan dengan koma)</label>
                        <input type="text" name="tags" placeholder="panduan, help, setup" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="aktif" checked value="1">
                            <span>Publikasikan</span>
                        </label>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-bottom: 10px;">Simpan Artikel</button>
                    <a href="/admin/kb/article" class="btn btn-outline" style="width: 100%; text-align: center;">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis panduan atau dokumentasi di sini...',
            tabsize: 2,
            height: 500,
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
            }
        });
    }
</script>
@endsection
