@extends('admin.layout')

@section('judul', 'Import dari WordPress')

@section('konten')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 25px;">
        <h3>Import Konten WordPress</h3>
        <p style="color: #64748b; font-size: 0.9rem;">Masukan URL blog WordPress Anda untuk mengimport kategori dan berita secara otomatis melalui REST API.</p>
    </div>

    <form action="/admin/berita/import-wp" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">URL WordPress</label>
            <input type="url" name="url" placeholder="https://bloganda.com" required 
                style="width: 100%; padding: 10px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;"
                value="{{ old('url') }}">
            @error('url')
                <small style="color: #ef4444; margin-top: 5px; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div style="padding: 15px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; margin-bottom: 25px;">
            <div style="display: flex; gap: 12px;">
                <i class="fas fa-info-circle" style="color: #d97706; margin-top: 3px;"></i>
                <div style="font-size: 0.85rem; color: #92400e;">
                    <strong>Penting:</strong>
                    <ul style="margin: 5px 0 0 15px; padding: 0;">
                        <li>Pastikan REST API WordPress aktif (bawaan WordPress baru aktif).</li>
                        <li>Proses ini akan mengunduh gambar utama ke server Anda.</li>
                        <li>Jika berita dengan slug yang sama sudah ada, berita tersebut akan dilewati.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="/admin/berita" class="btn" style="background: #94a3b8; flex: 1; text-align: center;">Batal</a>
            <button type="submit" class="btn" style="flex: 2;">
                <i class="fas fa-download"></i> Mulai Import
            </button>
        </div>
    </form>
</div>
@endsection
