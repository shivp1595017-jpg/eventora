@extends('layouts.admin')
@section('title','Super Admin - Add Staff')
@section('heading','Add Staff')
@section('description','Create a staff account and assign organization access.')
@section('content')
<div class="card"><form class="staff-access-form" method="POST" action="{{ route('admin.staff.store') }}">@include('admin.staff.form')</form></div>
@endsection
