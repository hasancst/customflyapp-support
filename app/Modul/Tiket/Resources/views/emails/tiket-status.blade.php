<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Tiket</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #0284c7;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .status-card {
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-terbuka { background-color: #fef3c7; color: #92400e; }
        .status-proses { background-color: #dbeafe; color: #1e40af; }
        .status-selesai { background-color: #dcfce7; color: #166534; }
        .status-ditutup { background-color: #e2e8f0; color: #475569; }
        .arrow {
            display: inline-block;
            margin: 0 10px;
            color: #94a3b8;
            font-size: 18px;
            font-weight: bold;
        }
        .info-row {
            margin: 15px 0;
            padding: 10px;
            background-color: #F9FAFB;
            border-left: 4px solid #0284c7;
            border-radius: 4px;
        }
        .info-label {
            font-weight: 600;
            color: #6B7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            color: #111827;
            font-size: 14px;
            margin-top: 4px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0284c7;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            color: #6B7280;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Status Tiket Telah Diperbarui</h1>
        </div>

        @if(!empty($isForCustomer))
            <p>Halo <strong>{{ $tiket->nama ?? 'Pelanggan' }}</strong>,</p>
            <p>Status tiket Anda dengan nomor <strong>{{ $tiket->no_tiket }}</strong> telah diperbarui:</p>
        @else
            <p>Halo Admin,</p>
            <p>Status tiket berikut telah diperbarui:</p>
        @endif

        <div class="status-card">
            <span class="status-badge status-{{ $statusLama }}">{{ ucfirst($statusLama) }}</span>
            <span class="arrow">➔</span>
            <span class="status-badge status-{{ $statusBaru }}">{{ ucfirst($statusBaru) }}</span>
            <p style="margin: 10px 0 0 0; color: #64748b; font-size: 13px;">
                @if($statusBaru === 'proses')
                    Tiket sedang ditinjau dan ditangani oleh tim teknis kami.
                @elseif($statusBaru === 'selesai')
                    Tiket telah diselesaikan. Silakan beri tahu kami jika Anda masih memerlukan bantuan.
                @elseif($statusBaru === 'ditutup')
                    Tiket telah ditutup.
                @else
                    Tiket berstatus terbuka dan menunggu antrean tindak lanjut.
                @endif
            </p>
        </div>

        <div class="info-row">
            <div class="info-label">Nomor Tiket</div>
            <div class="info-value"><strong>{{ $tiket->no_tiket }}</strong></div>
        </div>

        <div class="info-row">
            <div class="info-label">Judul Tiket</div>
            <div class="info-value">{{ $tiket->judul }}</div>
        </div>

        @if($tiket->tiketKategori)
        <div class="info-row">
            <div class="info-label">Kategori</div>
            <div class="info-value">
                @if($tiket->tiketKategori->parent)
                    {{ $tiket->tiketKategori->parent->nama }} › 
                @endif
                {{ $tiket->tiketKategori->nama }}
            </div>
        </div>
        @endif

        @if(empty($isForCustomer))
        <div style="text-align: center;">
            <a href="{{ url('/admin/tiket/detail/' . $tiket->id) }}" class="button">
                Lihat Detail Tiket →
            </a>
        </div>
        @else
        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 12px; margin-top: 15px; color: #0369a1; font-size: 13px;">
            💡 <strong>Info:</strong> Anda dapat memantau atau merespons tiket ini langsung melalui aplikasi support / Shopify App kami.
        </div>
        @endif

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari sistem tiket.<br>
            Harap jangan balas email ini.</p>
            <p style="margin-top: 10px;">
                <small>Waktu update: {{ now()->format('d/m/Y H:i') }} WIB</small>
            </p>
        </div>
    </div>
</body>
</html>
