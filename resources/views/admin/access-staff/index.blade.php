@extends('layouts.admin')
@section('title', 'Super Admin Staff - Eventora')
@section('heading', 'Super Admin Staff')
@section('description', 'Manage platform staff and the sections they can access.')
@section('content')
<style>
    .access-staff-page{display:grid;gap:18px}
    .access-staff-toolbar{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:18px}
    .access-staff-toolbar .search{max-width:360px}
    .access-staff-toolbar .export-group{margin-left:auto}
    .access-staff-form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
    .access-staff-form .filter-control{width:100%;min-height:42px}
    .permission-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:9px;margin:12px 0 18px}
    .permission-option{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid var(--border);border-radius:10px;background:var(--card2);font-size:11px;color:var(--text)}
    .permission-option input{accent-color:var(--primary)}
    .staff-row-permissions{display:grid;grid-template-columns:repeat(2,minmax(125px,1fr));gap:8px}
    .staff-row-permissions label{display:flex;align-items:center;gap:6px;font-size:10px;color:var(--text)}
    .access-staff-page table{min-width:980px}
    .access-staff-page .card{overflow:hidden}
    @media(max-width:650px){.access-staff-form{grid-template-columns:1fr}.access-staff-toolbar .export-group{margin-left:0;width:100%}.access-staff-toolbar .search{max-width:none;width:100%}}
</style>

<div class="access-staff-page">
    <section class="card" style="padding:20px">
        <form id="accessStaffSearchForm" method="GET" action="{{ route('admin.access-staff.index') }}" class="access-staff-toolbar">
            <input class="filter-control search" type="search" name="q" value="{{ request('q') }}" placeholder="Search staff name or email..." autocomplete="off">
            <button class="btn primary" type="submit">Search</button>
            <div class="export-group">
                @foreach(['xlsx' => 'Excel', 'csv' => 'CSV', 'pdf' => 'PDF'] as $format => $label)
                    <a class="export-btn" href="{{ route('admin.export', array_merge(request()->query(), ['resource' => 'admin_staff', 'format' => $format])) }}">{{ $label }}</a>
                @endforeach
                <a class="export-btn" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'admin_staff'])) }}">Print</a>
            </div>
        </form>

        <div class="panel-head" style="padding:0 0 14px;margin-bottom:14px">
            <div><h2 style="font-size:16px">Add Super Admin Staff</h2><p class="sub">Choose the sections this staff account can manage.</p></div>
        </div>
        <form method="POST" action="{{ route('admin.access-staff.store') }}">
            @csrf
            <div class="access-staff-form">
                <input class="filter-control" name="name" value="{{ old('name') }}" placeholder="Full name" required>
                <input class="filter-control" type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required>
            </div>
            <div class="permission-grid">
                @foreach($permissions as $permission)
                    <label class="permission-option"><input type="checkbox" name="admin_permissions[]" value="{{ $permission }}"> {{ ucwords(str_replace('_', ' ', $permission)) }}</label>
                @endforeach
            </div>
            <button class="btn primary" type="submit">Add Staff</button>
        </form>
    </section>

    <section class="card">
        <div class="panel-head"><h2>Existing Super Admin Staff</h2><span class="result-count">{{ $staff->total() }} account(s)</span></div>
        <div class="table-wrap"><table>
            <thead><tr><th>Name and Email</th><th>Permissions</th><th>Save</th><th>Delete</th></tr></thead>
            <tbody>
            @forelse($staff as $member)
                <tr>
                    <td style="min-width:230px">
                        <form id="staff-{{ $member->id }}" method="POST" action="{{ route('admin.access-staff.update', $member) }}">@csrf @method('PATCH')
                            <input class="filter-control" name="name" value="{{ $member->name }}" required style="margin-bottom:7px">
                            <input class="filter-control" type="email" name="email" value="{{ $member->email }}" required>
                        </form>
                    </td>
                    <td><div class="staff-row-permissions">
                        @foreach($permissions as $permission)
                            <label><input form="staff-{{ $member->id }}" type="checkbox" name="admin_permissions[]" value="{{ $permission }}" @checked(in_array($permission, $member->admin_permissions ?? [], true))> {{ ucwords(str_replace('_', ' ', $permission)) }}</label>
                        @endforeach
                    </div></td>
                    <td><button form="staff-{{ $member->id }}" class="btn approve" type="submit">Save</button></td>
                    <td><form method="POST" action="{{ route('admin.access-staff.destroy', $member) }}" onsubmit="return confirm('Delete this Super Admin Staff account?')">@csrf @method('DELETE')<button class="btn reject" type="submit">Delete</button></form></td>
                </tr>
            @empty
                <tr><td colspan="4"><div class="empty"><strong>No staff accounts yet.</strong>Add staff above to delegate admin access.</div></td></tr>
            @endforelse
            </tbody>
        </table></div>
        <div class="pagination-bar">{{ $staff->links() }}</div>
    </section>
</div>
<script>
(() => { const form = document.getElementById('accessStaffSearchForm'); const input = form.querySelector('[name=q]'); let timer; input.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(() => form.requestSubmit(), 300); }); })();
</script>
@endsection
