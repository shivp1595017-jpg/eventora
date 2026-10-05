<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        @page { size: landscape; margin: 10mm; }
        body { font-family: Arial, Helvetica, sans-serif; color:#111827; margin:0; }
        .head { margin-bottom:14px; }
        h1 { font-size:22px; margin:0 0 4px; }
        p { color:#64748b; font-size:11px; margin:0; }
        table { width:100%; border-collapse:collapse; font-size:9px; }
        th { background:#eef2f7; color:#334155; text-transform:uppercase; font-size:8px; padding:7px; border:1px solid #cbd5e1; text-align:left; }
        td { padding:7px; border:1px solid #dbe1e8; vertical-align:top; }
        tr:nth-child(even) td { background:#f8fafc; }
    </style>
</head>
<body onload="window.print()">
    <div class="head">
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }} · Generated {{ now()->format('d M Y h:i A') }}</p>
    </div>
    <table>
        <thead><tr>@foreach($columns as $column)<th>{{ $column }}</th>@endforeach</tr></thead>
        <tbody>
        @forelse($rows as $row)
            <tr>@foreach($row as $cell)<td>{{ $cell }}</td>@endforeach</tr>
        @empty
            <tr><td colspan="{{ count($columns) }}">No matching records.</td></tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>
