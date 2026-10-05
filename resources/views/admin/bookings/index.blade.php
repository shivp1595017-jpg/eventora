@extends('layouts.admin')

@section('title', 'Bookings - Eventora')
@section('heading', 'Bookings')
@section('description', 'Review every booking and its payment state across Eventora.')

@section('content')
<form id="filterForm" action="{{ route('admin.bookings.index') }}" method="GET" class="toolbar">
    <input class="search" type="search" name="q" value="{{ request('q') }}" placeholder="Search booking, user, event, payment ID..." autocomplete="off">
    <select class="filter" name="payment_status">
        <option value="">All Payments</option>
        @foreach(['pending','paid','failed','refunded'] as $status)
            <option value="{{ $status }}" @selected(request('payment_status') === $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <select class="filter" name="booking_status">
        <option value="">All Bookings</option>
        @foreach(['pending','confirmed','cancelled'] as $status)
            <option value="{{ $status }}" @selected(request('booking_status') === $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <input class="filter" type="date" name="date_from" value="{{ request('date_from') }}">
    <input class="filter" type="date" name="date_to" value="{{ request('date_to') }}">
    <button type="submit">Search</button>
    <button type="button" class="clear-btn" data-clear>Clear</button>
    <div class="export-group">
        @foreach(['xlsx'=>'Excel','csv'=>'CSV','pdf'=>'PDF'] as $format => $label)
            <a class="export-btn" data-export-base="{{ route('admin.export',['resource'=>'bookings','format'=>$format]) }}" href="{{ route('admin.export',['resource'=>'bookings','format'=>$format]) }}">{{ $label }}</a>
        @endforeach
        <a class="export-btn" data-export-base="{{ route('admin.print', ['resource' => 'bookings']) }}" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'bookings'])) }}">Print</a>
    </div>
</form>
<div id="dataArea">@include('admin.partials.bookings-table')</div>
@endsection
