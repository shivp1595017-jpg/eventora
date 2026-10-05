@extends('layouts.admin')

@section('title', $event->title . ' - Eventora')
@section('heading', $event->title)
@section('description', 'Event details and management information.')

@section('content')
<style>
.detail-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden}.hero{display:grid;grid-template-columns:280px 1fr;gap:24px;padding:22px}.hero img,.hero-placeholder{width:100%;height:190px;border-radius:12px;object-fit:cover;background:var(--card2);display:flex;align-items:center;justify-content:center;color:var(--muted)}.meta{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}.item{padding:12px;border:1px solid var(--border);border-radius:10px;background:var(--card2)}.item small{display:block;color:var(--muted);font-size:9px;margin-bottom:4px}.item strong{font-size:12px}.description{padding:22px;border-top:1px solid var(--border);color:var(--muted);font-size:12px;line-height:1.7;white-space:pre-line}.actions{display:flex;gap:8px;padding:18px 22px;border-top:1px solid var(--border);flex-wrap:wrap}.btn{padding:9px 14px;border-radius:9px;text-decoration:none;font-size:11px;font-weight:800}.edit{background:rgba(108,99,255,.12);color:#a69fff}.back{border:1px solid var(--border);color:var(--text);background:var(--card2)}.danger{border:0;background:rgba(239,68,68,.12);color:#ff8585;cursor:pointer}@media(max-width:750px){.hero{grid-template-columns:1fr}.meta{grid-template-columns:1fr}}
</style>
<div class="detail-card">
    <div class="hero">
        @if($event->banner)<img src="{{ asset('storage/'.$event->banner) }}" alt="{{ $event->title }}">@else<div class="hero-placeholder">No banner</div>@endif
        <div>
            <div style="display:flex;justify-content:space-between;gap:10px;align-items:center;margin-bottom:15px"><h2 style="font-size:22px">{{ $event->title }}</h2><span class="badge {{ $event->status === 'approved' ? 'approved' : ($event->status === 'cancelled' ? 'cancelled' : 'other') }}">{{ $event->status }}</span></div>
            <div class="meta">
                <div class="item"><small>Organization</small><strong>{{ optional($event->organization)->name ?? 'N/A' }}</strong></div>
                <div class="item"><small>Category</small><strong>{{ $event->category }}</strong></div>
                <div class="item"><small>Date & Time</small><strong>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} · {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</strong></div>
                <div class="item"><small>Venue</small><strong>{{ $event->venue }}, {{ $event->city }}</strong></div>
                <div class="item"><small>Ticket Price</small><strong>{{ $event->ticket_price > 0 ? '₹'.number_format($event->ticket_price,2) : 'FREE' }}</strong></div>
                <div class="item"><small>Seats</small><strong>{{ $event->available_seats === null ? 'Unlimited' : $event->available_seats.' / '.$event->total_seats }}</strong></div>
                <div class="item"><small>Bookings</small><strong>{{ $event->bookings_count }}</strong></div>
                <div class="item"><small>Unit</small><strong>{{ optional($event->organizationUnit)->name ?? 'Organization-wide' }}</strong></div>
            </div>
        </div>
    </div>
    <div class="description">{{ $event->description }}</div>
    <div class="actions">
        <a class="btn back" href="{{ route('admin.events.index') }}">← Back to Events</a>
        <a class="btn edit" href="{{ route('admin.events.edit', $event) }}">Edit Event</a>
        @if($event->bookings_count === 0)
            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event? This cannot be undone.');">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete Event</button></form>
        @endif
    </div>
</div>
@endsection
