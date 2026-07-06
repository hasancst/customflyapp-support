@extends('admin.layout')

@section('judul', 'Manajemen Client')

@section('konten')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;"><i class="fas fa-users"></i> Daftar Client</h2>
        <a href="/admin/client/tambah" class="btn"><i class="fas fa-plus"></i> Tambah Client</a>
    </div>

    @if(session('berhasil'))
        <div style="background: #e6fffa; color: #234e52; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #b2f5ea;">
            {{ session('berhasil') }}
        </div>
    @endif

    @if(session('gagal'))
        <div style="background: #fff5f5; color: #c53030; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #feb2b2;">
            {{ session('gagal') }}
        </div>
    @endif

    <!-- Filter -->
    <div style="margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form action="/admin/client" method="GET" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 250px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600; color: #64748b;">Cari Client</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau shop ID..." style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600; color: #64748b;">App</label>
                <select name="app" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;">
                    <option value="">-- Semua App --</option>
                    <option value="Uploadfly" {{ request('app') == 'Uploadfly' ? 'selected' : '' }}>Uploadfly</option>
                    <option value="IMCST" {{ request('app') == 'IMCST' ? 'selected' : '' }}>IMCST</option>
                    <option value="Amazonify" {{ request('app') == 'Amazonify' ? 'selected' : '' }}>Amazonify</option>
                </select>
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.85rem; font-weight: 600; color: #64748b;">Status</label>
                <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            
            <button type="submit" class="btn"><i class="fas fa-search"></i> Cari</button>

            @if(request('search') || request('app') || request('status'))
                <a href="/admin/client" class="btn" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 1200px;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px;">Name</th>
                    <th style="padding: 15px;">Email</th>
                    <th style="padding: 15px;">Shop ID</th>
                    <th style="padding: 15px;">App</th>
                    <th style="padding: 15px;">Plan</th>
                    <th style="padding: 15px;">Trial</th>
                    <th style="padding: 15px;">Country</th>
                    <th style="padding: 15px;">Phone</th>
                    <th style="padding: 15px;">Join Date</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; font-weight: 600;">{{ $client->name }}</td>
                    <td style="padding: 15px;">{{ $client->email }}</td>
                    <td style="padding: 15px; font-family: monospace; color: #6366f1;">{{ $client->shop_id ?? '-' }}</td>
                    <td style="padding: 15px;">
                        @if($client->app)
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                                {{ $client->app }}
                            </span>
                        @else
                            <span style="color: #94a3b8;">-</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">{{ $client->plan ?? '-' }}</td>
                    <td style="padding: 15px;">
                        @if(!$client->trial_used)
                            <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                                Belum trial
                            </span>
                        @elseif($client->trial_ends_at && $client->trial_ends_at->isFuture())
                            @php $sisaHari = (int) now()->diffInDays($client->trial_ends_at, false); @endphp
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                                    Aktif — {{ $sisaHari }} hari lagi
                                </span>
                                <button
                                    onclick="bukaModalExtend({{ $client->id }}, '{{ addslashes($client->name) }}')"
                                    style="background: #dbeafe; color: #1e40af; border: none; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;"
                                >
                                    Extend
                                </button>
                            </div>
                        @else
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                                    Berakhir {{ $client->trial_ends_at ? $client->trial_ends_at->format('d M Y') : '-' }}
                                </span>
                                <button
                                    onclick="bukaModalExtend({{ $client->id }}, '{{ addslashes($client->name) }}')"
                                    style="background: #f1f5f9; color: #64748b; border: none; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;"
                                >
                                    Extend
                                </button>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if($client->country)
                            <span class="flag-icon flag-icon-{{ strtolower($client->country) }}" style="margin-right: 5px;"></span>
                            {{ $client->country }}
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 15px;">{{ $client->phone ?? '-' }}</td>
                    <td style="padding: 15px; font-size: 0.85rem; color: #64748b;">
                        {{ $client->created_at->format('d M Y') }}
                    </td>
                    <td style="padding: 15px;">
                        @php
                            $statusColors = [
                                'active' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                'inactive' => ['bg' => '#f1f5f9', 'text' => '#475569'],
                                'suspended' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                            ];
                            $color = $statusColors[$client->status] ?? $statusColors['inactive'];
                        @endphp
                        <span style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                            {{ $client->status }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/client/edit/{{ $client->id }}" style="color: #6366f1; background: #eef2ff; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/client/hapus/{{ $client->id }}" method="POST" onsubmit="return confirm('Hapus client ini?')">
                                @csrf
                                <button type="submit" style="color: #ef4444; background: #fef2f2; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="padding: 50px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                        Belum ada data client.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 25px;">
        {{ $clients->links() }}
    </div>
</div>
{{-- Modal Extend Trial --}}
<div id="modal-extend" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; padding: 32px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="margin: 0 0 8px; font-size: 1.1rem;">Extend Trial</h3>
        <p id="modal-extend-nama" style="margin: 0 0 24px; color: #64748b; font-size: 0.9rem;"></p>
        <form id="form-extend" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem;">Tambah berapa hari?</label>
                <input
                    type="number"
                    name="days"
                    value="7"
                    min="1"
                    max="365"
                    style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 1rem; box-sizing: border-box;"
                    required
                />
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="tutupModalExtend()" style="padding: 10px 20px; background: #f1f5f9; color: #64748b; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 20px; background: #6366f1; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 700;">
                    Extend Trial
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalExtend(clientId, clientName) {
    document.getElementById('modal-extend-nama').textContent = 'Client: ' + clientName;
    document.getElementById('form-extend').action = '/admin/client/' + clientId + '/extend-trial';
    var modal = document.getElementById('modal-extend');
    modal.style.display = 'flex';
}
function tutupModalExtend() {
    document.getElementById('modal-extend').style.display = 'none';
}
document.getElementById('modal-extend').addEventListener('click', function(e) {
    if (e.target === this) tutupModalExtend();
});
</script>
@endsection
