@extends('admin.layout')

@section('judul', 'Dashboard')

@section('konten')
    <div class="grid-dashboard">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eef2ff; color: #4338ca;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <p class="label">Berita</p>
                <p class="value">{{ $jumlahBerita ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #ecfdf5; color: #059669;">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <p class="label">Artikel</p>
                <p class="value">{{ $jumlahArtikel ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff7ed; color: #c2410c;">
                <i class="fas fa-cubes"></i>
            </div>
            <div class="stat-info">
                <p class="label">Modul Aktif</p>
                <p class="value">{{ $jumlahModul ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fdf2f8; color: #db2777;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <p class="label">Pengguna</p>
                <p class="value">{{ $jumlahPengguna ?? 1 }}</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px;">
        <div class="card" style="grid-column: span 3;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h3><i class="fas fa-globe-americas" style="color: var(--primary); margin-right: 10px;"></i> Peta Sebaran Pengunjung</h3>
                <span class="badge">Realtime</span>
            </div>
            
            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 20px;">
                <!-- Container Map -->
                <div id="world-map" style="width: 100%; height: 350px;"></div>

                <!-- List Negara -->
                <div style="overflow-y: auto; max-height: 350px;">
                    <h4 style="font-size: 0.9rem; margin-bottom: 15px; color: var(--text-muted);">Top Negara</h4>
                    <ul style="list-style: none;">
                        @forelse($visitorData as $stat)
                            <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px dashed #eee;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span class="flag-icon flag-icon-{{ strtolower($stat->kode_negara) }}" style="border-radius: 4px;"></span>
                                    <span style="font-size: 0.9rem; font-weight: 500;">{{ $stat->negara }}</span>
                                </div>
                                <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $stat->total }}</span>
                            </li>
                        @empty
                            <li style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data pengunjung.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Styles & Scripts for Map -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css" />
            <script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
            <script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var markers = [
                        @foreach($visitorData as $stat)
                            { name: "{{ $stat->negara }}", coords: [0, 0] }, 
                        @endforeach
                    ];

                    var mapData = {
                        @foreach($visitorData as $stat)
                            "{{ strtoupper($stat->kode_negara) }}": {{ $stat->total }},
                        @endforeach
                    };

                    new jsVectorMap({
                        selector: "#world-map",
                        map: "world",
                        zoomButtons: true,
                        visualizeData: {
                            scale: ['#e0e7ff', '#4338ca'],
                            values: mapData
                        },
                        onRegionTooltipShow(event, tooltip, code) {
                            if (mapData[code]) {
                                tooltip.text(tooltip.text() + ' (' + mapData[code] + ' pengunjung)');
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Berita Terpopuler -->
        <div class="card">
            <h3><i class="fas fa-fire" style="color: #ef4444; margin-right: 10px;"></i> Berita Terpopuler</h3>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @forelse($popularPages as $idx => $page)
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <div style="width: 35px; height: 35px; border-radius: 50%; background: {{ $idx == 0 ? '#ef4444' : ($idx == 1 ? '#f97316' : ($idx == 2 ? '#eab308' : '#94a3b8')) }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; flex-shrink: 0;">
                            {{ $idx + 1 }}
                        </div>
                        <div style="overflow: hidden;">
                            <a href="{{ $page->url }}" target="_blank" style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                                {{ $page->judul }}
                            </a>
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 3px;">
                                <i class="fas fa-eye"></i> {{ $page->total }} kali dilihat
                            </p>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                        <i class="fas fa-newspaper" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.3;"></i>
                        <p>Belum ada data kunjungan berita.</p>
                    </div>
                @endforelse
            </div>
            <a href="/admin/statistik" class="btn" style="width: 100%; margin-top: 30px; background: var(--accent); color: var(--primary); text-align: center; justify-content: center;">Lihat Statistik Lengkap</a>
        </div>

        <!-- Aktivitas Terbaru (Re-added) -->
        <div class="card">
            <h3><i class="fas fa-history" style="color: var(--primary); margin-right: 10px;"></i> Aktivitas Terbaru</h3>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <div style="width: 35px; height: 35px; border-radius: 50%; background: #4e73df; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <p style="font-size: 0.9rem; font-weight: 600;">Artikel baru diterbitkan</p>
                        <p style="font-size: 0.75rem; color: var(--text-muted);">2 menit yang lalu</p>
                    </div>
                </div>
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <div style="width: 35px; height: 35px; border-radius: 50%; background: #22c55e; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p style="font-size: 0.9rem; font-weight: 600;">Modul Berita diaktifkan</p>
                        <p style="font-size: 0.75rem; color: var(--text-muted);">1 jam yang lalu</p>
                    </div>
                </div>
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <div style="width: 35px; height: 35px; border-radius: 50%; background: #f59e0b; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                        <i class="fas fa-key"></i>
                    </div>
                    <div>
                        <p style="font-size: 0.9rem; font-weight: 600;">Admin login ke sistem</p>
                        <p style="font-size: 0.75rem; color: var(--text-muted);">Tadi pagi</p>
                    </div>
                </div>
            </div>
            <button class="btn" style="width: 100%; margin-top: 30px; background: var(--accent); color: var(--primary);">Semua Aktivitas</button>
        </div>
    </div>
@endsection
