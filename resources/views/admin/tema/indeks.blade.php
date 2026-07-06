@extends('admin.layout')

@section('judul', 'Manajer Tema')

@section('konten')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Tema Tersedia</h3>
            <button class="btn">
                <i class="fas fa-plus"></i> Unggah Tema ZIP
            </button>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 30px;">
            @foreach($tema as $t)
            <div class="card" style="padding: 0; overflow: hidden; border: {{ $t['aktif'] ? '2px solid var(--primary)' : '1px solid rgba(255,255,255,0.1)' }}">
                <div style="height: 180px; background: #334155; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #64748b;">
                    <i class="fas fa-image"></i>
                </div>
                <div style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div id="display-name-{{ $t['slug'] }}">
                            <h4 style="margin: 0; display: inline-block;">{{ $t['nama'] }}</h4>
                            <button onclick="toggleEdit('{{ $t['slug'] }}')" style="background: none; border: none; color: var(--primary); cursor: pointer; margin-left: 5px;" title="Ubah Nama">
                                <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                            </button>
                            <br>
                            <small style="color: #94a3b8;">Versi {{ $t['versi'] }}</small>
                        </div>
                        <div id="edit-name-{{ $t['slug'] }}" style="display: none;">
                            <form action="/admin/tema/perbarui" method="POST" style="display: flex; gap: 5px;">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $t['slug'] }}">
                                <input type="text" name="nama" value="{{ $t['nama'] }}" style="padding: 5px; border-radius: 5px; border: 1px solid var(--border); font-size: 0.9rem;">
                                <button type="submit" class="btn" style="padding: 5px 10px; font-size: 0.8rem;"><i class="fas fa-check"></i></button>
                                <button type="button" onclick="toggleEdit('{{ $t['slug'] }}')" class="btn" style="padding: 5px 10px; font-size: 0.8rem; background: #94a3b8;"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                        @if($t['aktif'])
                            <span class="badge badge-success">Aktif</span>
                        @endif
                    </div>
                    
                    <div style="margin-top: 20px;">
                        @if(!$t['aktif'])
                        <form action="/admin/tema/aktifkan" method="POST">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $t['slug'] }}">
                            <button class="btn" style="width: 100%;">Gunakan Tema</button>
                        </form>
                        @else
                        <button class="btn" style="width: 100%; background: #94a3b8;" disabled>Tema Aktif</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function toggleEdit(slug) {
        const displayDiv = document.getElementById('display-name-' + slug);
        const editDiv = document.getElementById('edit-name-' + slug);
        
        if (displayDiv.style.display === 'none') {
            displayDiv.style.display = 'block';
            editDiv.style.display = 'none';
        } else {
            displayDiv.style.display = 'none';
            editDiv.style.display = 'block';
        }
    }
</script>
@endsection
