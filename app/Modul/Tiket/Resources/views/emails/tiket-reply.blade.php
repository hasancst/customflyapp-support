<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Tiket</title>
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
            background-color: #10B981;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 8px;
        }
        .badge-tinggi {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .badge-sedang {
            background-color: #FEF3C7;
            color: #92400E;
        }
        .badge-rendah {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        .badge-status {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .badge-admin {
            background-color: #EDE9FE;
            color: #5B21B6;
        }
        .badge-customer {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        .info-row {
            margin: 15px 0;
            padding: 10px;
            background-color: #F9FAFB;
            border-left: 4px solid #10B981;
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
        .pesan-box {
            background-color: #F0FDF4;
            border: 2px solid #10B981;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .pesan-box h3 {
            margin-top: 0;
            color: #065F46;
            font-size: 16px;
        }
        .pesan-content {
            color: #374151;
            line-height: 1.8;
            white-space: pre-wrap;
        }
        .pesan-meta {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #BBF7D0;
            color: #6B7280;
            font-size: 13px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #10B981;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #059669;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            color: #6B7280;
            font-size: 12px;
            text-align: center;
        }
        .context-box {
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .context-box h4 {
            margin: 0 0 10px 0;
            color: #6B7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💬 {{ !empty($isForCustomer) ? 'Balasan dari Tim Support' : 'Balasan Baru pada Tiket' }}</h1>
        </div>

        @if(!empty($isForCustomer))
            <p>Halo <strong>{{ $tiket->nama ?? 'Pelanggan' }}</strong>,</p>
            <p>Tim support kami telah memberikan balasan untuk tiket Anda:</p>
        @else
            <p>Halo Admin,</p>
            <p>Ada balasan baru dari pelanggan pada tiket berikut:</p>
        @endif

        <div class="info-row">
            <div class="info-label">Nomor Tiket</div>
            <div class="info-value"><strong>{{ $tiket->no_tiket }}</strong></div>
        </div>

        <div class="info-row">
            <div class="info-label">Judul</div>
            <div class="info-value">{{ $tiket->judul }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Status & Prioritas</div>
            <div class="info-value">
                <span class="badge badge-status">{{ ucfirst($tiket->status) }}</span>
                <span class="badge badge-{{ $tiket->prioritas }}">{{ ucfirst($tiket->prioritas) }}</span>
            </div>
        </div>

        <div class="pesan-box">
            <h3>Isi Balasan:</h3>
            <div class="pesan-content">{{ $pesan->pesan }}</div>
            <div class="pesan-meta">
                <span class="badge {{ $pesan->is_admin ? 'badge-admin' : 'badge-customer' }}">
                    {{ $pesan->is_admin ? 'Tim Support' : 'Pelanggan' }}
                </span>
                <strong>{{ $pesan->nama_pengirim }}</strong> • 
                {{ $pesan->created_at->format('d/m/Y H:i') }} WIB
            </div>
        </div>

        @if(empty($isForCustomer))
        <div class="context-box">
            <h4>Informasi Customer:</h4>
            <div style="color: #374151;">
                <strong>{{ $tiket->nama ?? $tiket->email }}</strong><br>
                <small style="color: #6B7280;">{{ $tiket->email }}</small>
                @if($tiket->shop_id)
                    <br><small style="color: #6B7280;">Shop: {{ $tiket->shop_id }}</small>
                @endif
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/admin/tiket/detail/' . $tiket->id) }}" class="button">
                Lihat & Balas Tiket →
            </a>
        </div>
        @else
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 12px; margin-top: 15px; color: #166534; font-size: 13px;">
            💡 <strong>Info:</strong> Anda dapat melanjutkan percakapan ini langsung melalui antarmuka support/Shopify App kami pada tiket <strong>{{ $tiket->no_tiket }}</strong>.
        </div>
        @endif

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari sistem tiket.<br>
            Harap jangan balas email ini.</p>
            <p style="margin-top: 10px;">
                <small>Balasan diterima pada: {{ $pesan->created_at->format('d/m/Y H:i') }} WIB</small>
            </p>
        </div>
    </div>
</body>
</html>
