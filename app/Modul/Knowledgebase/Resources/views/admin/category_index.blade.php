@extends('admin.layout')

@section('judul', 'Kategori Knowledge Base')

@section('konten')
<div style="display: grid; grid-template-columns: 400px 1fr; gap: 30px;">
    <div>
        <div class="card">
            <h3 style="margin-bottom: 20px;">Tambah Kategori</h3>
            <form action="/admin/kb/category" method="POST">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Nama Kategori</label>
                    <input type="text" name="nama" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Induk Kategori (Opsional)</label>
                    <select name="parent_id" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Ikon (FontAwesome)</label>
                    <input type="text" name="ikon" placeholder="fas fa-book">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Urutan</label>
                    <input type="number" name="urutan" value="0">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3"></textarea>
                </div>
                <button type="submit" class="btn" style="width: 100%;">Tambah Kategori</button>
            </form>
        </div>
    </div>

    <div>
        <div class="card">
            <h3 style="margin-bottom: 25px;">Daftar Kategori</h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid #eee;">
                            <th style="padding: 12px;">Ikon</th>
                            <th style="padding: 12px;">Nama</th>
                            <th style="padding: 12px;">Urutan</th>
                            <th style="padding: 12px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $c)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td style="padding: 12px;"><i class="{{ $c->ikon }}"></i></td>
                            <td style="padding: 12px;">
                                <strong>{{ $c->nama }}</strong><br>
                                <small style="color: #64748b;">{{ $c->slug }}</small>
                                @if($c->parent)
                                    <br><small style="color: var(--primary);">Induk: {{ $c->parent->nama }}</small>
                                @endif
                            </td>
                            <td style="padding: 12px;">{{ $c->urutan }}</td>
                            <td style="padding: 12px;">
                                <div style="display: flex; gap: 8px;">
                                    <button class="btn btn-sm" onclick="editCat({{ $c->id }}, '{{ $c->nama }}', '{{ $c->ikon }}', '{{ $c->urutan }}', '{{ $c->deskripsi }}', '{{ $c->parent_id }}')" style="padding: 5px 10px; font-size: 12px;">Edit</button>
                                    <form action="/admin/kb/category/delete/{{ $c->id }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 5px 10px; border-radius: 5px; font-size: 12px; cursor: pointer;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit (Simple implementation) -->
<div id="editModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center;">
    <div class="card" style="width: 400px;">
        <h3 style="margin-bottom: 20px;">Edit Kategori</h3>
        <form id="editForm" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Nama Kategori</label>
                <input type="text" name="nama" id="edit_nama" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Induk Kategori</label>
                <select name="parent_id" id="edit_parent_id" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                    <option value="">-- Tidak Ada --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Ikon</label>
                <input type="text" name="ikon" id="edit_ikon">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Urutan</label>
                <input type="number" name="urutan" id="edit_urutan">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn" style="flex: 1;">Update</button>
                <button type="button" onclick="closeModal()" class="btn btn-outline" style="flex: 1;">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editCat(id, nama, ikon, urutan, desk, parent) {
        document.getElementById('editForm').action = '/admin/kb/category/update/' + id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_ikon').value = ikon;
        document.getElementById('edit_urutan').value = urutan;
        document.getElementById('edit_deskripsi').value = desk;
        document.getElementById('edit_parent_id').value = parent || '';
        
        // Prevent category from being its own parent
        const parentSelect = document.getElementById('edit_parent_id');
        Array.from(parentSelect.options).forEach(option => {
            if (option.value == id) {
                option.disabled = true;
                option.style.color = '#cbd5e1';
            } else {
                option.disabled = false;
                option.style.color = '';
            }
        });
        
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

<style>
    input, textarea { width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; transition: 0.3s; }
    input:focus, textarea:focus { border-color: var(--primary); }
</style>
@endsection
