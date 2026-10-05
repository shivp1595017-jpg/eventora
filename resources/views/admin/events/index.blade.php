@extends('layouts.admin')

@section('title', 'Events - Eventora')
@section('heading', 'Events')
@section('description', 'Create and manage events across all approved Eventora organizations.')

@section('content')
<style>.page-actions{display:flex;justify-content:flex-end;margin-bottom:14px}.primary-action{display:inline-flex;align-items:center;gap:7px;padding:10px 15px;border-radius:10px;background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff;text-decoration:none;font-size:11px;font-weight:800;box-shadow:0 8px 20px rgba(108,99,255,.18)}.primary-action:hover{transform:translateY(-1px)}</style>
<div class="page-actions"><a href="{{ route('admin.events.create') }}" class="primary-action">+ Create Event</a></div>
<form id="filterForm" action="{{ route('admin.events.index') }}" method="GET" class="toolbar">
    <input class="search" type="search" name="q" value="{{ request('q') }}" placeholder="Search event, organization, city, venue..." autocomplete="off">
    <select class="filter" name="status">
        <option value="">All Status</option>
        @foreach(['draft','pending','approved','rejected','cancelled'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <select class="filter" name="category">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
        @endforeach
    </select>
    <select class="filter" name="city">
        <option value="">All Cities</option>
        @foreach($cities as $city)
            <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
        @endforeach
    </select>
    <input class="filter" type="date" name="date_from" value="{{ request('date_from') }}">
    <input class="filter" type="date" name="date_to" value="{{ request('date_to') }}">
    <button type="submit">Search</button>
    <button type="button" class="clear-btn" data-clear>Clear</button>
    <div class="export-group">
        @foreach(['xlsx'=>'Excel','csv'=>'CSV','pdf'=>'PDF'] as $format => $label)
            <a class="export-btn" data-export-base="{{ route('admin.export',['resource'=>'events','format'=>$format]) }}" href="{{ route('admin.export',['resource'=>'events','format'=>$format]) }}">{{ $label }}</a>
        @endforeach
        <a class="export-btn" data-export-base="{{ route('admin.print', ['resource' => 'events']) }}" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'events'])) }}">Print</a>
    </div>
</form>
<div id="dataArea">@include('admin.partials.events-table')</div>
@endsection
