@extends('admin.layout')

@section('judul', 'Ubah FAQ')

@section('konten')
<div class="card" style="max-width: 800px;">
    <h3>Ubah FAQ</h3>
    <form action="/admin/faq/ubah/{{ $item->id }}" method="POST" style="margin-top: 25px;">
        @csrf
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pertanyaan</label>
            <input type="text" name="pertanyaan" value="{{ $item->pertanyaan }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Jawaban</label>
            <textarea name="jawaban" style="height: 150px;" required>{{ $item->jawaban }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Urutan</label>
                <input type="number" name="urutan" value="{{ $item->urutan }}">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Status</label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; margin-top: 10px;">
                    <input type="checkbox" name="aktif" value="1" {{ $item->aktif ? 'checked' : '' }}>
                    <strong>Aktifkan FAQ</strong>
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn">Perbarui FAQ</button>
            <a href="/admin/faq" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>
@endsection
