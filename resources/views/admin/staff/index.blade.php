@extends('layouts.admin')
@section('title','Super Admin - Staff & Access')
@section('heading','Organization Staff')
@section('description','Manage Eventora organization staff from the Super Admin panel.')
@section('content')
<style>
    .super-admin-org-staff{display:grid;gap:16px}
    .super-admin-org-staff .toolbar{align-items:stretch;display:grid;grid-template-columns:minmax(0,1fr);}
    .super-admin-org-staff .staff-search-grid{display:grid;grid-template-columns:minmax(220px,1fr) minmax(150px,220px) minmax(130px,170px) auto auto;gap:9px;align-items:center}
    .super-admin-org-staff .staff-search-grid .filter-control{min-height:42px;width:100%}
    .super-admin-org-staff .filter-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap;padding-top:12px;border-top:1px solid var(--border)}
    .super-admin-org-staff .filter-actions .export-buttons{display:flex;gap:7px;flex-wrap:wrap;margin-left:auto}
    .super-admin-org-staff .result-count{color:var(--muted);font-size:11px}
    .super-admin-org-staff .primary-text{font-weight:700;color:var(--text)}
    .super-admin-org-staff .secondary-text{font-size:10px;color:var(--muted);margin-top:3px}
    .super-admin-org-staff .status{display:inline-flex;padding:5px 9px;border-radius:20px;font-size:10px;font-weight:800;text-transform:capitalize}
    .super-admin-org-staff .status.active{background:rgba(34,197,94,.12);color:#6fe195}
    .super-admin-org-staff .status.rejected{background:rgba(239,68,68,.12);color:#ff8686}
    .super-admin-org-staff .actions{display:flex;align-items:center;gap:6px;flex-wrap:wrap}
    .super-admin-org-staff .actions form{margin:0}
    @media(max-width:900px){.super-admin-org-staff .staff-search-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.super-admin-org-staff .staff-search-grid input:first-child{grid-column:1/-1}}
    @media(max-width:560px){.super-admin-org-staff .staff-search-grid{grid-template-columns:1fr}.super-admin-org-staff .staff-search-grid input:first-child{grid-column:auto}.super-admin-org-staff .filter-actions .export-buttons{margin-left:0;width:100%}.super-admin-org-staff .filter-actions>.btn{width:100%;text-align:center}}
</style>
<div class="super-admin-org-staff">
<div class="card">
    <div class="toolbar">
        <form id="staffSearchForm" method="GET" action="{{ route('admin.staff.index') }}">
            <div class="staff-search-grid">
                <input class="filter-control" type="text" name="search" value="{{ request('search') }}" placeholder="Search staff, email, role or organization...">
                <select class="filter-control" name="organization">
                    <option value="">All Organizations</option>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}" @selected(request('organization') == $organization->id)>{{ $organization->name }}</option>
                    @endforeach
                </select>
                <select class="filter-control" name="status">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
                <button class="btn primary" type="submit">Search</button>
                <a class="btn clear-btn" href="{{ route('admin.staff.index') }}">Clear</a>
            </div>
        </form>
        <div class="filter-actions">
            <span class="result-count">{{ $staff->total() }} staff member(s)</span>
            <div class="export-buttons">
                @foreach(['xlsx' => 'Excel', 'csv' => 'CSV', 'pdf' => 'PDF'] as $format => $label)
                    <a class="export-btn" href="{{ route('admin.export', array_merge(request()->query(), ['resource' => 'staff', 'format' => $format])) }}">{{ $label }}</a>
                @endforeach
                <a class="export-btn" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'staff'])) }}">Print</a>
            </div>
            <a class="btn primary" href="{{ route('admin.staff.create') }}">+ Add Staff</a>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Staff</th><th>Organization</th><th>Role</th><th>Status</th><th>Created By</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($staff as $member)
                <tr>
                    <td><div class="primary-text">{{ $member->name }}</div><div class="secondary-text">{{ $member->email }}{{ $member->mobile ? ' · '.$member->mobile : '' }}</div></td>
                    <td><div class="primary-text">{{ $member->organization?->name ?? '—' }}</div><div class="secondary-text">{{ $member->organizationUnit?->name ?? 'No primary unit' }}</div></td>
                    <td><span class="badge">{{ ucwords(str_replace('_',' ',$member->role)) }}</span></td>
                    <td><span class="status {{ $member->status === 'active' ? 'active' : 'rejected' }}">{{ $member->status }}</span></td>
                    <td>{{ $member->createdBy?->name ?? 'System' }}</td>
                    <td><div class="actions">
                        <a class="btn primary" href="{{ route('admin.staff.show',$member->id) }}">View</a>
                        <a class="btn secondary" href="{{ route('admin.staff.edit',$member->id) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.staff.destroy',$member->id) }}" onsubmit="return confirm('Only the Main Super Admin can delete staff. Continue?');">@csrf @method('DELETE')<button class="btn reject" type="submit">Delete</button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty"><div class="empty-icon">👥</div>No staff members found.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-bar">{{ $staff->links() }}</div>
</div>
</div>
<script>
(() => { const form = document.getElementById('staffSearchForm'); let timer; form.querySelectorAll('input,select').forEach(control => control.addEventListener(control.tagName === 'SELECT' ? 'change' : 'input', () => { clearTimeout(timer); timer = setTimeout(() => form.requestSubmit(), 300); })); })();
</script>
@endsection
