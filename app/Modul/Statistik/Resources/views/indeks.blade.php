@extends('admin.layout')

@section('judul', 'Statistik Pengunjung')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('konten')
<div class="grid-dashboard">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="label">Total Pengunjung</div>
            <div class="value">{{ number_format($totalPengunjung) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #dcfce7; color: #15803d;">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-info">
            <div class="label">Hari Ini</div>
            <div class="value">{{ number_format($totalHariIni) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fef9c3; color: #a16207;">
            <i class="fas fa-calendar-week"></i>
        </div>
        <div class="stat-info">
            <div class="label">Minggu Ini</div>
            <div class="value">{{ number_format($totalMingguIni) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fee2e2; color: #b91c1c;">
            <i class="fas fa-mouse-pointer"></i>
        </div>
        <div class="stat-info">
            <div class="label">Halaman Terpopuler</div>
            <div class="value">{{ $topPages->first()->jumlah ?? 0 }}</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Grafik -->
    <div class="card">
        <h3>Tren Pengunjung (7 Hari Terakhir)</h3>
        <canvas id="visitorChart" height="150"></canvas>
    </div>

    <div style="display: flex; flex-direction: column; gap: 30px;">
        <!-- Halaman Terpopuler -->
        <div class="card" style="margin-bottom: 0;">
            <h3>Halaman Terpopuler</h3>
            <ul style="list-style: none;">
                @foreach($topPages as $page)
                <li style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                    <span style="font-size: 0.9rem; color: var(--text-main); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 150px;" title="{{ $page->url }}">
                        {{ str_replace(url('/'), '', $page->url) ?: '/' }}
                    </span>
                    <span class="badge">{{ $page->jumlah }} klik</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Negara Pengunjung -->
        <div class="card" style="margin-bottom: 0;">
            <h3>Negara Pengunjung</h3>
            <ul style="list-style: none;">
                @foreach($topCountries as $c)
                <li style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($c->kode_negara && $c->kode_negara != '??')
                            <img src="https://flagcdn.com/w20/{{ strtolower($c->kode_negara) }}.png" width="20" alt="{{ $c->negara }}">
                        @else
                            <i class="fas fa-globe" style="color: #94a3b8;"></i>
                        @endif
                        <span style="font-size: 0.9rem; color: var(--text-main);">{{ $c->negara ?? 'Unknown' }}</span>
                    </div>
                    <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $c->jumlah }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    const ctx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($grafikData->pluck('tanggal')->map(fn($t) => date('d M', strtotime($t)))) !!},
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: {!! json_encode($grafikData->pluck('jumlah')) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection
