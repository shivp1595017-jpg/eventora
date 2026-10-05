@extends('layouts.admin')

@section('title', 'Super Admin Dashboard - Eventora')
@section('heading', 'Super Admin Dashboard')
@section('description', "Monitor Eventora's users, organizations, events, bookings and payments.")

@section('content')

<div class="stats">
    <div class="stat"><small>Organizations</small><strong>{{ $stats['organizations'] }}</strong></div>
    <div class="stat"><small>Users</small><strong>{{ $stats['users'] }}</strong></div>
    <div class="stat"><small>Events</small><strong>{{ $stats['events'] }}</strong></div>
    <div class="stat"><small>Bookings</small><strong>{{ $stats['bookings'] }}</strong></div>
</div>

<div class="quick">
    <a href="{{ route('admin.organizations.index') }}"><div class="icon">🏢</div><h3>Organizations</h3><p>Review registrations and organization status.</p></a>
    <a href="{{ route('admin.events.index') }}"><div class="icon">🎫</div><h3>Events</h3><p>Monitor all events created on Eventora.</p></a>
    <a href="{{ route('admin.users.index') }}"><div class="icon">👥</div><h3>Users</h3><p>Search and inspect user accounts.</p></a>
    <a href="{{ route('admin.bookings.index') }}"><div class="icon">📋</div><h3>Bookings</h3><p>Review booking and payment states.</p></a>
    <a href="{{ route('admin.payments.index') }}"><div class="icon">💳</div><h3>Payments</h3><p>Review Razorpay payment records.</p></a>
</div>

<div class="two-col">
    <section class="panel">
        <div class="panel-head"><h3>Recent Organizations</h3><a href="{{ route('admin.organizations.index') }}">VIEW ALL</a></div>
        @forelse($recentOrganizations as $organization)
            <div class="panel-row">
                <div class="left"><div class="name">{{ $organization->name }}</div><div class="sub">{{ $organization->email ?? 'No email' }}</div></div>
                @php $status = $organization->status ?? 'other'; @endphp
                <div class="right"><span class="badge {{ in_array($status,['approved','pending','rejected']) ? $status : 'other' }}">{{ $status }}</span></div>
            </div>
        @empty
            <div class="empty">No organizations found.</div>
        @endforelse
    </section>

    <section class="panel">
        <div class="panel-head"><h3>Recent Events</h3><a href="{{ route('admin.events.index') }}">VIEW ALL</a></div>
        @forelse($recentEvents as $event)
            <div class="panel-row">
                <div class="left"><div class="name">{{ $event->title }}</div><div class="sub">{{ optional($event->organization)->name ?? 'No organization' }}</div></div>
                @php $status = $event->status ?? 'other'; @endphp
                <div class="right"><span class="badge {{ in_array($status,['approved','pending','rejected','cancelled']) ? $status : 'other' }}">{{ $status }}</span></div>
            </div>
        @empty
            <div class="empty">No events found.</div>
        @endforelse
    </section>
</div>

<div class="stats" style="margin-top:18px;">
    <div class="stat"><small>Organization Admins</small><strong>{{ $stats['organization_admins'] }}</strong></div>
    <div class="stat"><small>Upcoming Events</small><strong>{{ $stats['upcoming_events'] }}</strong></div>
    <div class="stat"><small>Paid Bookings</small><strong>{{ $stats['paid_bookings'] }}</strong></div>
    <div class="stat"><small>Pending Payments</small><strong>{{ $stats['pending_payments'] }}</strong></div>
</div>

@endsection
