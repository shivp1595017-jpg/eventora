@extends('layouts.admin')
@section('title', 'Ticket Result - Eventora')
@section('heading', 'Ticket Verification Result')
@section('description', $booking ? 'Booking '.$booking->booking_number : 'No booking matched this ticket number.')
@section('content')
<section class="card" style="max-width:760px;padding:24px">
    @if($booking)
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
            <span class="badge {{ $isValid ? 'approved' : 'rejected' }}">{{ $isValid ? 'Valid ticket' : 'Invalid ticket' }}</span>
            <strong>{{ $booking->booking_number }}</strong>
        </div>
        <div class="panel-row" style="align-items:center"><strong>Participant</strong><span style="display:flex;align-items:center;gap:11px"><span style="position:relative;display:grid;width:48px;height:48px;flex:0 0 48px;place-items:center;overflow:hidden;border-radius:50%;background:linear-gradient(135deg,#6c63ff,#8b5cf6);color:#fff;font-weight:800">{{ strtoupper(substr($booking->user?->name ?? 'N', 0, 1)) }}@if($booking->user?->profilePhotoUrl())<img src="{{ $booking->user->profilePhotoUrl() }}" alt="" aria-hidden="true" style="position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover" referrerpolicy="no-referrer" onerror="this.remove()">@endif</span><span>{{ $booking->user?->name ?? 'N/A' }} ({{ $booking->user?->email ?? 'N/A' }})</span></span></div>
        <div class="panel-row"><strong>Event</strong><span>{{ $booking->event?->title ?? 'N/A' }}</span></div>
        <div class="panel-row"><strong>Organization</strong><span>{{ $booking->event?->organization?->name ?? 'N/A' }}</span></div>
        <div class="panel-row"><strong>Payment</strong><span>{{ ucfirst($booking->payment_status) }}</span></div>
        <div class="panel-row"><strong>Booking</strong><span>{{ ucfirst($booking->booking_status) }}</span></div>
        <p style="margin-top:16px;color:var(--muted);font-size:12px">A ticket is valid when payment is paid and booking is confirmed.</p>
    @else
        <span class="badge rejected">Invalid ticket</span>
        <p style="margin-top:14px">Booking not found. Check the ticket number and try again.</p>
    @endif
    <a class="export-btn" style="display:inline-flex;margin-top:18px" href="{{ route('admin.ticket-verification.index') }}">Search another ticket</a>
</section>
@endsection
