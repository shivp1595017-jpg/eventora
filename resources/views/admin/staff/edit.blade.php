@extends('layouts.admin')
@section('title','Super Admin - Edit Staff')
@section('heading','Edit Staff')
@section('description','Update staff access, organization, units, events and permissions.')
@section('content')
<div class="card"><form class="staff-access-form" method="POST" action="{{ route('admin.staff.update',$staff->id) }}">@method('PUT') @include('admin.staff.form')</form></div>
@endsection
