@extends('admin.layout')

@section('judul', 'Ticket Categories')

@section('konten')
<div style="display: grid; grid-template-columns: 350px 1fr; gap: 25px;">
    <!-- Form Tambah/Edit -->
    <div class="card">
        <h3><i class="fas fa-plus-circle"></i> Add Category</h3>
        <form action="/admin/tiket/kategori" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category Name</label>
                <input type="text" name="nama" id="tambah_nama" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;" oninput="autoSlug(this.value,'tambah_slug')">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Slug <small style="color:#94a3b8; font-weight:400;">(auto-generated / editable)</small></label>
                <input type="text" name="slug" id="tambah_slug" placeholder="auto-generated from name" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: monospace; font-size: 0.875rem;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Parent Category (Optional)</label>
                <select name="parent_id" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="">-- No Parent (Root Category) --</option>
                    @foreach($categories->where('parent_id', null) as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->nama }}</option>
                    @endforeach
                </select>
                <small style="color: #64748b;">Select a parent to make this a sub-category.</small>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
                <textarea name="deskripsi" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Sort Order</label>
                <input type="number" name="urutan" value="0" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="aktif" checked value="1">
                    <span style="font-weight: 600;">Active</span>
                </label>
            </div>

            <button type="submit" class="btn" style="width: 100%;"><i class="fas fa-save"></i> Save Category</button>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;"><i class="fas fa-list"></i> Categories & Sub-Categories</h3>
        </div>

        @if(session('berhasil'))
            <div style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #b2f5ea;">
                {{ session('berhasil') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #fff5f5; color: #c53030; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #feb2b2;">
                {{ session('error') }}
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px;">Name</th>
                        <th style="padding: 12px;">Parent</th>
                        <th style="padding: 12px;">Slug</th>
                        <th style="padding: 12px;">Order</th>
                        <th style="padding: 12px;">Status</th>
                        <th style="padding: 12px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr style="border-bottom: 1px solid #e2e8f0; {{ $cat->parent_id ? 'background:#fafbfc;' : '' }}">
                        <td style="padding: 12px;">
                            @if($cat->parent_id)
                                <span style="color:#cbd5e1; margin-right:4px;">↳</span>
                                <span style="font-weight: 500; color:#475569;">{{ $cat->nama }}</span>
                            @else
                                <span style="font-weight: 700; color:#1e293b;">{{ $cat->nama }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            @if($cat->parent_id)
                                <span style="background:#eef2ff; color:#6366f1; padding:2px 8px; border-radius:4px; font-size:0.8rem;">{{ $cat->parent->nama ?? '-' }}</span>
                            @else
                                <span style="color:#94a3b8; font-size:0.85rem;">—</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <code style="background:#f1f5f9; color:#475569; padding:2px 6px; border-radius:4px; font-size:0.8rem;">{{ $cat->slug }}</code>
                        </td>
                        <td style="padding: 12px;">{{ $cat->urutan }}</td>
                        <td style="padding: 12px;">
                            @if($cat->aktif)
                                <span style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">Active</span>
                            @else
                                <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 5px;">
                                <button onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->nama) }}', '{{ $cat->slug }}', '{{ $cat->parent_id }}', '{{ addslashes($cat->deskripsi ?? '') }}', {{ $cat->urutan }}, {{ $cat->aktif ? 1 : 0 }})" style="border: none; background: #eef2ff; color: #6366f1; width: 28px; height: 28px; border-radius: 6px; cursor: pointer;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="/admin/tiket/kategori/hapus/{{ $cat->id }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    <button type="submit" style="border: none; background: #fef2f2; color: #ef4444; width: 28px; height: 28px; border-radius: 6px; cursor: pointer;" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: #94a3b8;">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="width: 400px; margin: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Edit Category</h3>
            <button onclick="document.getElementById('modalEdit').style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form id="formEdit" action="" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category Name</label>
                <input type="text" id="edit_nama" name="nama" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;" oninput="if(!document.getElementById('edit_slug_manual').checked){ autoSlug(this.value,'edit_slug'); }">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">
                    Slug <small style="color:#94a3b8; font-weight:400;">(auto-generated / editable)</small>
                </label>
                <div style="display:flex; gap:8px; align-items:center;">
                    <input type="text" id="edit_slug" name="slug" style="flex:1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: monospace; font-size: 0.875rem;">
                    <label style="display:flex; align-items:center; gap:5px; font-size:0.8rem; cursor:pointer; white-space:nowrap;">
                        <input type="checkbox" id="edit_slug_manual"> Manual
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Parent Category (Optional)</label>
                <select id="edit_parent_id" name="parent_id" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="">-- No Parent (Root Category) --</option>
                    @foreach($categories->where('parent_id', null) as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Sort Order</label>
                <input type="number" id="edit_urutan" name="urutan" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" id="edit_aktif" name="aktif" value="1">
                    <span style="font-weight: 600;">Active</span>
                </label>
            </div>

            <button type="submit" class="btn" style="width: 100%;"><i class="fas fa-save"></i> Update Category</button>
        </form>
    </div>
</div>

<script>
function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}

function autoSlug(value, targetId) {
    const el = document.getElementById(targetId);
    if (el) el.value = slugify(value);
}

function editCategory(id, nama, slug, parentId, deskripsi, urutan, aktif) {
    const modal = document.getElementById('modalEdit');
    const form = document.getElementById('formEdit');

    form.action = '/admin/tiket/kategori/update/' + id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_parent_id').value = parentId || '';
    document.getElementById('edit_deskripsi').value = deskripsi || '';
    document.getElementById('edit_urutan').value = urutan || 0;
    document.getElementById('edit_aktif').checked = aktif == 1;
    document.getElementById('edit_slug_manual').checked = false;

    modal.style.display = 'flex';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('modalEdit');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
@endsection
