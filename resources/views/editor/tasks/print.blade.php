<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mingguan Engagement Konten</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .empty-state {
            text-align: center;
            padding: 20px;
            color: #777;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .signature-space {
            margin-top: 60px;
        }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            @page { size: landscape; margin: 10mm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #0d6efd; color: white; border: none; border-radius: 4px; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>

    <div class="header">
        <h2>Laporan Mingguan Engagement Konten</h2>
        <p>
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="20%">Topik / Pillar</th>
                <th width="12%">Tanggal Posting</th>
                <th width="9%">Views</th>
                <th width="9%">Likes</th>
                <th width="9%">Comments</th>
                <th width="9%">Shares</th>
                <th width="9%">ER (%)</th>
                <th width="9%">ES</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                @php
                    $a = $task->analytics;
                    $views = $a ? $a->views : 0;
                    $likes = $a ? $a->likes : 0;
                    $comments = $a ? $a->comments : 0;
                    $shares = $a ? $a->shares : 0;
                    $er = $a ? $a->engagement_rate : 0;
                    $es = $a ? $a->engagement_score : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $task->topic }}</strong><br>
                        <span style="font-size: 10px; color: #666;">{{ $task->pillar }}</span>
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($task->posting_date)->format('d M Y') }}</td>
                    <td class="text-right">{{ number_format($views) }}</td>
                    <td class="text-right">{{ number_format($likes) }}</td>
                    <td class="text-right">{{ number_format($comments) }}</td>
                    <td class="text-right">{{ number_format($shares) }}</td>
                    <td class="text-right">{{ number_format($er, 2) }}%</td>
                    <td class="text-right">{{ number_format($es) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="empty-state">Tidak ada data konten yang dipublish pada rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <br>
        <p>Mengetahui,</p>
        <div class="signature-space">
            <p><strong>( ______________________ )</strong></p>
            <p>Editor / Penanggung Jawab</p>
        </div>
    </div>

</body>
</html>
