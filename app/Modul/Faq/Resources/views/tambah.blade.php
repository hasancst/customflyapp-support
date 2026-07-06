@extends('admin.layout')

@section('judul', 'Tambah FAQ')

@section('konten')
<div class="card" style="max-width: 800px;">
    <h3>Tambah Pertanyaan Baru</h3>
    <form action="/admin/faq/tambah" method="POST" style="margin-top: 25px;">
        @csrf
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pertanyaan</label>
            <input type="text" name="pertanyaan" required placeholder="Apa itu CMS Rumah Cyber?">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Jawaban</label>
            <textarea name="jawaban" style="height: 150px;" required placeholder="Jelaskan jawaban di sini..."></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Urutan</label>
            <input type="number" name="urutan" value="0">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn">Simpan FAQ</button>
            <a href="/admin/faq" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>
@endsection
