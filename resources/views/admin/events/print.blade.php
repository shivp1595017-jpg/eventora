<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventora Events Print</title>
    <style>
        body{font-family:Arial,sans-serif;color:#111827;padding:25px}h1{margin:0 0 5px}.muted{color:#6b7280;font-size:13px;margin-bottom:20px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #d1d5db;padding:9px;text-align:left;font-size:12px}th{background:#f3f4f6}@media print{body{padding:0}}
    </style>
</head>
<body>
<h1>Eventora Events</h1>
<div class="muted">Generated {{ now()->format('d M Y, h:i A') }}</div>
<table><thead><tr><th>Event</th><th>Organization</th><th>Date</th><th>Location</th><th>Price</th><th>Bookings</th><th>Status</th></tr></thead><tbody>
@forelse($events as $event)
<tr><td>{{ $event->title }}</td><td>{{ optional($event->organization)->name ?? 'N/A' }}</td><td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} {{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('h:i A') : '' }}</td><td>{{ $event->venue }}, {{ $event->city }}</td><td>{{ $event->ticket_price > 0 ? '₹'.number_format($event->ticket_price,2) : 'FREE' }}</td><td>{{ $event->bookings_count }}</td><td>{{ $event->status }}</td></tr>
@empty
<tr><td colspan="7">No events found.</td></tr>
@endforelse
</tbody></table>
<script>window.addEventListener('load',()=>window.print());</script>
</body>
</html>
