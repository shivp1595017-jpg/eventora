@extends('layouts.admin')

@section('title', 'Settings - Eventora')
@section('heading', 'Settings')
@section('description', 'Choose how the Super Admin panel looks on this device.')

@section('content')
<section class="card" style="padding:24px;max-width:720px">
    <h2 style="font-size:16px;margin-bottom:8px">Appearance</h2>
    <p style="color:var(--muted);font-size:12px;margin-bottom:18px">Your theme choice is saved in this browser.</p>
    <label for="adminTheme" style="display:block;font-size:12px;font-weight:700;margin-bottom:8px">Color theme</label>
    <select id="adminTheme" class="filter-control" style="max-width:260px">
        <option value="dark">Dark</option>
        <option value="light">Light</option>
    </select>
</section>
<script>
    (() => {
        const picker = document.getElementById('adminTheme');
        picker.value = localStorage.getItem('eventora-theme') || 'dark';
        picker.addEventListener('change', () => {
            localStorage.setItem('eventora-theme', picker.value);
            document.documentElement.setAttribute('data-theme', picker.value);
        });
    })();
</script>
@endsection
