@extends('admin.layout')

@section('judul', 'Manajemen Menu')

@section('styles')
<style>
    .sortable-ghost {
        opacity: 0.4;
        background-color: var(--primary-light) !important;
        border: 2px dashed var(--primary) !important;
    }
    .menu-item-wrapper {
        cursor: move;
        transition: all 0.2s;
    }
    .menu-item-wrapper:hover {
        border-color: var(--primary) !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05) !important;
    }
    
    .menu-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
    }

    .form-card {
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    @media (max-width: 992px) {
        .menu-container {
            grid-template-columns: 1fr;
        }
        .form-card {
            position: relative;
            top: 0;
        }
    }
</style>
@endsection

@section('konten')
<div class="menu-container">
    <!-- Form Tambah/Edit -->
    <div class="card form-card">
        <h3 id="form-title">Tambah Menu Baru</h3>
        <form action="/admin/menu" method="POST" id="form-menu">
            @csrf
            
            <input type="hidden" name="id" id="menu_id">

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Jenis Menu</label>
                <div style="display: flex; gap: 15px;">
                    <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="radio" name="jenis_menu" value="modul" checked onchange="toggleMenuType()"> Modul Sistem
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="radio" name="jenis_menu" value="custom" onchange="toggleMenuType()"> Tautan Kustom
                    </label>
                </div>
            </div>

            <div id="opsi-modul" style="display: none; margin-bottom: 20px; background: #f1f5f9; padding: 15px; border-radius: 8px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pilih Modul</label>
                @php $activeSlugs = array_map('strtolower', $modulAktif ?? []); @endphp
                <select id="pilih-modul" class="form-control" onchange="updateModuleUrl()" style="width: 100%;">
                    <option value="">-- Pilih Modul --</option>
                    <option value="beranda">Beranda</option>
                    @if(in_array('berita', $activeSlugs))
                        <option value="berita">Berita</option>
                    @endif
                    @if(in_array('artikel', $activeSlugs))
                        <option value="artikel">Artikel</option>
                    @endif
                    @if(in_array('video', $activeSlugs))
                        <option value="video">Video</option>
                    @endif
                    @if(in_array('portofolio', $activeSlugs))
                        <option value="portofolio">Portofolio</option>
                    @endif
                    @if(in_array('kontak', $activeSlugs))
                        <option value="kontak">Kontak</option>
                    @endif
                    <option value="tentang">Tentang Kami</option>
                    <option value="redaksi">Redaksi</option>
                    <option value="kebijakan">Kebijakan Privasi</option>
                    <option value="syarat">Syarat & Ketentuan</option>
                </select>

                <div id="kategori-berita" style="display: none; margin-top: 10px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Kategori Berita</label>
                    <select id="select-kategori-berita" onchange="updateModuleUrl()">
                        <option value="">-- Semua Berita --</option>
                        @foreach($kategoriBerita as $kb)
                            <option value="{{ $kb->slug }}">{{ $kb->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="kategori-artikel" style="display: none; margin-top: 10px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Kategori Artikel</label>
                    <select id="select-kategori-artikel" onchange="updateModuleUrl()">
                        <option value="">-- Semua Artikel --</option>
                        @foreach($kategoriArtikel as $ka)
                            <option value="{{ $ka->slug }}">{{ $ka->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Label Menu</label>
                <input type="text" name="label" id="label-menu" required placeholder="Contoh: Beranda">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">URL / Link</label>
                <input type="text" name="url" id="url-menu" required placeholder="Contoh: /berita">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Posisi Menu</label>
                <select name="posisi" id="posisi_menu" onchange="updateParentOptions()">
                    <option value="header">Main Menu (Navigasi Atas)</option>
                    <option value="footer">Footer (Navigasi Bawah)</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Induk Menu (Opsional)</label>
                <select name="parent_id" id="parent_id">
                    <option value="">-- Tanpa Induk --</option>
                    <!-- Will be populated by JS -->
                </select>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Target</label>
                <select name="target" id="target_menu">
                    <option value="_self">Tab Saat Ini</option>
                    <option value="_blank">Tab Baru</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" id="btn-submit" class="btn" style="flex: 1; justify-content: center;">
                    <i class="fas fa-plus"></i> Simpan Menu
                </button>
                <button type="button" id="btn-cancel" onclick="resetForm()" class="btn" style="flex: 1; justify-content: center; background: #64748b; color: #fff; display: none;">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Struktur Menu -->
    <div id="menu-structure">
        <!-- Section: Header Menu -->
        <div class="card">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <i class="fas fa-bars" style="color: #4e73df; font-size: 1.2rem;"></i>
                <h3 style="margin-bottom: 0;">Top Navigation (Main Menu)</h3>
                <span class="badge" style="background: #ebf1ff; color: #4e73df; font-weight: 800;">MAIN MENU</span>
            </div>
            
            <div id="header-menu-list" style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid var(--border); min-height: 50px;">
                @forelse($headerMenus as $menu)
                    @include('menu::item', ['item' => $menu])
                @empty
                    <p style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada menu header.</p>
                @endforelse
            </div>
        </div>

        <!-- Section: Footer Menu -->
        <div class="card">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <i class="fas fa-shoe-prints" style="color: #f59e0b; font-size: 1.2rem;"></i>
                <h3 style="margin-bottom: 0;">Footer Navigation (Quick Links)</h3>
                <span class="badge" style="background: #fff7ed; color: #c2410c; font-weight: 800;">FOOTER</span>
            </div>
            
            <div id="footer-menu-list" style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid var(--border); min-height: 50px;">
                @forelse($footerMenus as $menu)
                    @include('menu::item', ['item' => $menu])
                @empty
                    <p style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada menu footer.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    // Data for dynamic select
    const headerParents = @json($headerMenus->map(fn($m) => ['id' => $m->id, 'label' => $m->label]));
    const footerParents = @json($footerMenus->map(fn($m) => ['id' => $m->id, 'label' => $m->label]));

    // Sorting Logic
    document.addEventListener('DOMContentLoaded', function() {
        const headerList = document.getElementById('header-menu-list');
        const footerList = document.getElementById('footer-menu-list');

        if (headerList) {
            new Sortable(headerList, {
                animation: 150,
                handle: '.fa-grip-vertical',
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    updateOrder('header');
                }
            });
        }

        if (footerList) {
            new Sortable(footerList, {
                animation: 150,
                handle: '.fa-grip-vertical',
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    updateOrder('footer');
                }
            });
        }
    });

    async function updateOrder(posisi) {
        const list = document.getElementById(posisi + '-menu-list');
        const items = list.querySelectorAll(':scope > .menu-item-wrapper');
        const orders = {};
        
        items.forEach((item, index) => {
            const id = item.getAttribute('data-id');
            if (id) {
                orders[id] = index + 1;
            }
        });

        if (Object.keys(orders).length === 0) return;

        // Visual feedback
        list.style.opacity = '0.5';
        list.style.pointerEvents = 'none';

        try {
            const response = await fetch('/admin/menu/urutan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ urutan: orders })
            });

            const data = await response.json();
            
            if (data.success) {
                console.log('Order updated mapping:', orders);
            } else {
                throw new Error(data.message || 'Gagal menyimpan urutan');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal: ' + error.message);
        } finally {
            list.style.opacity = '1';
            list.style.pointerEvents = 'auto';
        }
    }

    function updateParentOptions() {
        const posisi = document.getElementById('posisi_menu').value;
        const parentSelect = document.getElementById('parent_id');
        const currentVal = parentSelect.value;
        
        parentSelect.innerHTML = '<option value="">-- Tanpa Induk --</option>';
        
        const source = posisi === 'header' ? headerParents : footerParents;
        source.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.text = p.label;
            parentSelect.add(opt);
        });
        
        parentSelect.value = currentVal;
    }

    function toggleMenuType() {
        const type = document.querySelector('input[name="jenis_menu"]:checked').value;
        const modOptions = document.getElementById('opsi-modul');
        const urlInput = document.getElementById('url-menu');

        if (type === 'modul') {
            modOptions.style.display = 'block';
            urlInput.readOnly = true;
            urlInput.style.backgroundColor = '#f1f5f9';
        } else {
            modOptions.style.display = 'none';
            urlInput.readOnly = false;
            urlInput.style.backgroundColor = '#fff';
        }
    }

    function updateModuleUrl() {
        const modul = document.getElementById('pilih-modul').value;
        const urlInput = document.getElementById('url-menu');
        const labelInput = document.getElementById('label-menu');
        const katBerita = document.getElementById('kategori-berita');
        const katArtikel = document.getElementById('kategori-artikel');
        
        katBerita.style.display = 'none';
        katArtikel.style.display = 'none';

        if (modul === 'beranda') { urlInput.value = '/'; labelInput.value = 'Beranda'; }
        else if (modul === 'kontak') { urlInput.value = '/kontak'; labelInput.value = 'Kontak'; }
        else if (modul === 'video') { urlInput.value = '/video'; labelInput.value = 'Video'; }
        else if (modul === 'portofolio') { urlInput.value = '/portofolio'; labelInput.value = 'Portofolio'; }
        else if (modul === 'tentang') { urlInput.value = '/tentang-kami'; labelInput.value = 'Tentang Kami'; }
        else if (modul === 'redaksi') { urlInput.value = '/redaksi'; labelInput.value = 'Redaksi'; }
        else if (modul === 'kebijakan') { urlInput.value = '/kebijakan'; labelInput.value = 'Kebijakan Privasi'; }
        else if (modul === 'syarat') { urlInput.value = '/syarat'; labelInput.value = 'Syarat & Ketentuan'; }
        else if (modul === 'berita') {
            katBerita.style.display = 'block';
            const slug = document.getElementById('select-kategori-berita').value;
            urlInput.value = slug ? '/berita/kategori/' + slug : '/berita';
            labelInput.value = slug ? document.getElementById('select-kategori-berita').selectedOptions[0].text : 'Berita';
        }
        else if (modul === 'artikel') {
            katArtikel.style.display = 'block';
            const slug = document.getElementById('select-kategori-artikel').value;
            urlInput.value = slug ? '/artikel/kategori/' + slug : '/artikel';
            labelInput.value = slug ? document.getElementById('select-kategori-artikel').selectedOptions[0].text : 'Artikel';
        }
    }

    function editMenu(btn) {
        const id = btn.getAttribute('data-id');
        const label = btn.getAttribute('data-label');
        const url = btn.getAttribute('data-url');
        const parent = btn.getAttribute('data-parent');
        const target = btn.getAttribute('data-target');
        const posisi = btn.getAttribute('data-posisi');

        document.getElementById('menu_id').value = id;
        document.getElementById('label-menu').value = label;
        document.getElementById('url-menu').value = url;
        document.getElementById('posisi_menu').value = posisi;
        updateParentOptions();
        document.getElementById('parent_id').value = parent || '';
        document.getElementById('target_menu').value = target;

        document.getElementById('form-title').innerText = 'Edit Menu';
        document.getElementById('form-menu').action = '/admin/menu/ubah/' + id;
        document.getElementById('btn-submit').innerHTML = '<i class="fas fa-save"></i> Perbarui Menu';
        document.getElementById('btn-cancel').style.display = 'block';

        document.querySelector('input[name="jenis_menu"][value="custom"]').checked = true;
        toggleMenuType();
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function resetForm() {
        document.getElementById('menu_id').value = '';
        document.getElementById('form-menu').reset();
        document.getElementById('form-title').innerText = 'Tambah Menu Baru';
        document.getElementById('form-menu').action = '/admin/menu';
        document.getElementById('btn-submit').innerHTML = '<i class="fas fa-plus"></i> Simpan Menu';
        document.getElementById('btn-cancel').style.display = 'none';
        updateParentOptions();
        toggleMenuType();
    }

    // Auto-slug Logic
    function slugify(text) {
        return '/' + text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }

    document.getElementById('label-menu').addEventListener('input', function() {
        const type = document.querySelector('input[name="jenis_menu"]:checked').value;
        const urlInput = document.getElementById('url-menu');
        
        if (type === 'custom') {
            urlInput.value = slugify(this.value);
        }
    });

    // Init
    updateParentOptions();
    toggleMenuType();
</script>
@endsection
