@extends('admin.layout')

@section('judul', 'Daftar Artikel Knowledge Base')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;">Artikel KB</h2>
        <a href="/admin/kb/article/create" class="btn"><i class="fas fa-plus"></i> Tambah Artikel</a>
    </div>

    @if(session('berhasil'))
        <div style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

    {{-- Filter Bar --}}
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px 18px; margin-bottom: 22px;">
        <form action="/admin/kb/article" method="GET" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;">

            <div style="flex: 2; min-width: 220px;">
                <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:4px;">Search</label>
                <input type="text" name="cari" id="kb-cari" value="{{ request('cari') }}"
                    placeholder="Search by title or slug..."
                    style="width:100%; padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none;">
            </div>

            <div style="flex: 1; min-width: 160px;">
                <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:4px;">Category</label>
                <select name="category_id" onchange="this.form.submit()"
                    style="width:100%; padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.88rem; background:#fff; outline:none; cursor:pointer;">
                    <option value="">-- All --</option>
                    @foreach($categoryGroups as $parent)
                        @if($parent->children->isEmpty())
                            {{-- Root category with no children — selectable directly --}}
                            <option value="{{ $parent->id }}" {{ request('category_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->nama }}
                            </option>
                        @else
                            {{-- Parent as optgroup label, also selectable --}}
                            <optgroup label="{{ $parent->nama }}">
                                <option value="{{ $parent->id }}" {{ request('category_id') == $parent->id ? 'selected' : '' }}>
                                    All {{ $parent->nama }}
                                </option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;↳ {{ $child->nama }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 130px;">
                <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:4px;">Status</label>
                <select name="status" onchange="this.form.submit()"
                    style="width:100%; padding:7px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.88rem; background:#fff; outline:none; cursor:pointer;">
                    <option value="">-- All --</option>
                    <option value="aktif"  {{ request('status') === 'aktif'  ? 'selected' : '' }}>Aktif</option>
                    <option value="draft"  {{ request('status') === 'draft'  ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div style="display:flex; gap:8px;">
                @if(request('cari') || request('category_id') || request('status'))
                    <a href="/admin/kb/article" class="btn"
                        style="padding:7px 14px; font-size:0.88rem; background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if(request('cari') || request('category_id') || request('status'))
        <div style="margin-top: 10px; font-size: 0.82rem; color: #64748b;">
            Showing <strong>{{ $articles->total() }}</strong> result(s)
            @if(request('cari')) for "<strong>{{ request('cari') }}</strong>"@endif
            @if(request('category_id')) in category <strong>{{ $categoryGroups->flatMap(fn($p) => $p->children->prepend($p))->firstWhere('id', request('category_id'))?->nama }}</strong>@endif
            @if(request('status')) · status: <strong>{{ request('status') }}</strong>@endif
        </div>
        @endif
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px;">Judul</th>
                    <th style="padding: 12px;">Kategori</th>
                    <th style="padding: 12px;">Views</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $a)
                <tr style="border-bottom: 1px solid #f8f9fa;">
                    <td style="padding: 12px;">
                        <strong>{{ $a->judul }}</strong><br>
                        <small style="color: #64748b;">{{ $a->slug }}</small>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 5px; font-size: 12px;">{{ $a->category->nama }}</span>
                    </td>
                    <td style="padding: 12px;">{{ $a->views }}</td>
                    <td style="padding: 12px;">
                        @if($a->aktif)
                            <span style="color: #10b981; font-weight: 700;">Aktif</span>
                        @else
                            <span style="color: #ef4444; font-weight: 700;">Draft</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/kb/article/edit/{{ $a->id }}" class="btn btn-sm" style="padding: 5px 10px; font-size: 12px;">Edit</a>
                            <form action="/admin/kb/article/delete/{{ $a->id }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 5px 10px; border-radius: 5px; font-size: 12px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8;">Belum ada artikel.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px; display: flex; justify-content: center;">
        <div class="pagination-wrapper">
            {{ $articles->links() }}
        </div>
    </div>
</div>

<style>
.pagination-wrapper .pagination {
    display: flex;
    gap: 5px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.pagination-wrapper .page-item .page-link {
    padding: 6px 13px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    background: #fff;
    font-size: 0.85rem;
    text-decoration: none;
    transition: background 0.15s;
}
.pagination-wrapper .page-item .page-link:hover {
    background: #f1f5f9;
}
.pagination-wrapper .page-item.active .page-link {
    background: #6366f1;
    border-color: #6366f1;
    color: #fff;
}
.pagination-wrapper .page-item.disabled .page-link {
    color: #cbd5e1;
    pointer-events: none;
}
</style>

<script>
// Auto-submit search after user stops typing (400ms debounce)
(function () {
    const input = document.getElementById('kb-cari');
    if (!input) return;
    let timer;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => this.form.submit(), 400);
    });
})();
</script>
@endsection
