@extends('layouts.admin')

@section('title', 'Users - Eventora')
@section('heading', 'Users')
@section('description', 'Search and inspect all registered Eventora accounts.')

@section('content')
<form id="filterForm" action="{{ route('admin.users.index') }}" method="GET" class="toolbar">
    <input class="search" type="search" name="q" value="{{ request('q') }}" placeholder="Search name or email..." autocomplete="off">
    <select class="filter" name="role">
        <option value="">All Roles</option>
        @foreach(['user'=>'User','organization_admin'=>'Organization Admin','organization_staff'=>'Organization Staff','super_admin'=>'Super Admin','super_admin_staff'=>'Super Admin Staff'] as $value => $label)
            <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    <button type="submit">Search</button>
    <button type="button" class="clear-btn" data-clear>Clear</button>
    <div class="export-group">
        @foreach(['xlsx'=>'Excel','csv'=>'CSV','pdf'=>'PDF'] as $format => $label)
            <a class="export-btn" data-export-base="{{ route('admin.export',['resource'=>'users','format'=>$format]) }}" href="{{ route('admin.export',['resource'=>'users','format'=>$format]) }}">{{ $label }}</a>
        @endforeach
        <a class="export-btn" data-export-base="{{ route('admin.print', ['resource' => 'users']) }}" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'users'])) }}">Print</a>
    </div>
</form>
<div id="dataArea">@include('admin.partials.users-table')</div>
@endsection
