@extends('layouts.admin')

@section('title', 'Payments - Eventora')
@section('heading', 'Payments')
@section('description', 'Review Razorpay payment records stored against Eventora bookings.')

@section('content')
<form id="filterForm" action="{{ route('admin.payments.index') }}" method="GET" class="toolbar">
    <input class="search" type="search" name="search" value="{{ request('search', request('q')) }}" placeholder="Search payment ID, order ID, user, event..." autocomplete="off">
    <select class="filter" name="payment_status">
        <option value="">All Status</option>
        @foreach(['pending','paid','failed','refunded'] as $status)
            <option value="{{ $status }}" @selected(request('payment_status') === $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <input class="filter" type="date" name="date_from" value="{{ request('date_from') }}">
    <input class="filter" type="date" name="date_to" value="{{ request('date_to') }}">
    <button type="submit">Search</button>
    <button type="button" class="clear-btn" data-clear>Clear</button>
    <div class="export-group">
        @foreach(['xlsx'=>'Excel','csv'=>'CSV','pdf'=>'PDF'] as $format => $label)
            <a class="export-btn" data-export-base="{{ route('admin.export',['resource'=>'payments','format'=>$format]) }}" href="{{ route('admin.export',['resource'=>'payments','format'=>$format]) }}">{{ $label }}</a>
        @endforeach
        <a class="export-btn" data-export-base="{{ route('admin.print', ['resource' => 'payments']) }}" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'payments'])) }}">Print</a>
    </div>
</form>
<div id="dataArea">@include('admin.partials.payments-table')</div>
@endsection
