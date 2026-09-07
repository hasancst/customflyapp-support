<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Status Updated</title>
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
        .button:hover {
            background-color: #0369a1;
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
    @php
        $statusMap = ['terbuka' => 'Open', 'proses' => 'In Progress', 'selesai' => 'Resolved', 'ditutup' => 'Closed'];
        $oldStatusLabel = $statusMap[$statusLama] ?? ucfirst($statusLama);
        $newStatusLabel = $statusMap[$statusBaru] ?? ucfirst($statusBaru);
    @endphp

    <div class="container">
        <div class="header">
            <h1>🔄 Ticket Status Updated</h1>
        </div>

        @if(!empty($isForCustomer))
            <p>Hello <strong>{{ $tiket->nama ?? 'Customer' }}</strong>,</p>
            <p>The status of your ticket <strong>{{ $tiket->no_tiket }}</strong> has been updated:</p>
        @else
            <p>Hello Admin,</p>
            <p>The status of the following ticket has been updated:</p>
        @endif

        <div class="status-card">
            <span class="status-badge status-{{ $statusLama }}">{{ $oldStatusLabel }}</span>
            <span class="arrow">➔</span>
            <span class="status-badge status-{{ $statusBaru }}">{{ $newStatusLabel }}</span>
            <p style="margin: 10px 0 0 0; color: #64748b; font-size: 13px;">
                @if($statusBaru === 'proses')
                    Your ticket is being reviewed and processed by our technical support team.
                @elseif($statusBaru === 'selesai')
                    Your ticket has been marked as resolved. Please let us know if you still need assistance.
                @elseif($statusBaru === 'ditutup')
                    This ticket is now closed.
                @else
                    Your ticket is open and queued for review.
                @endif
            </p>
        </div>

        <div class="info-row">
            <div class="info-label">Ticket ID</div>
            <div class="info-value"><strong>{{ $tiket->no_tiket }}</strong></div>
        </div>

        <div class="info-row">
            <div class="info-label">Subject</div>
            <div class="info-value">{{ $tiket->judul }}</div>
        </div>

        @if($tiket->tiketKategori)
        <div class="info-row">
            <div class="info-label">Category</div>
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
                View Ticket Details →
            </a>
        </div>
        @else
        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 12px; margin-top: 15px; color: #0369a1; font-size: 13px;">
            💡 <strong>Note:</strong> You can track or respond to this ticket anytime through our support app.
        </div>
        @endif

        <div class="footer">
            <p>This is an automated notification from the support system.<br>
            Please do not reply directly to this email address.</p>
            <p style="margin-top: 10px;">
                <small>Updated at: {{ now()->format('M d, Y H:i') }} UTC</small>
            </p>
        </div>
    </div>
</body>
</html>
