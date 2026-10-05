@extends('layouts.admin')
@section('title','Super Admin - Staff Profile')
@section('heading','Staff Profile')
@section('description','View staff account and assigned access.')
@section('content')
<div class="card" style="padding:24px">
    <div class="two-col">
        <div><div class="secondary-text">Name</div><div class="primary-text">{{ $staff->name }}</div><br><div class="secondary-text">Email</div><div>{{ $staff->email }}</div><br><div class="secondary-text">Mobile</div><div>{{ $staff->mobile ?: '—' }}</div></div>
        <div><div class="secondary-text">Organization</div><div class="primary-text">{{ $staff->organization?->name }}</div><br><div class="secondary-text">Role / Status</div><div>{{ ucfirst($staff->role) }} · {{ ucfirst($staff->status) }}</div><br><div class="secondary-text">Created By</div><div>{{ $staff->createdBy?->name ?? 'System' }}</div></div>
    </div>
    <hr style="border-color:var(--border);margin:24px 0">
    <div class="two-col"><div><div class="secondary-text">Units</div><div style="margin-top:8px">@forelse($staff->organizationUnits as $unit)<span class="badge">{{ $unit->name }}</span> @empty — @endforelse</div></div><div><div class="secondary-text">Events</div><div style="margin-top:8px">@forelse($staff->events as $event)<span class="badge">{{ $event->title }}</span> @empty — @endforelse</div></div></div>
    <div style="margin-top:22px"><div class="secondary-text">Permissions</div><div style="margin-top:8px">@forelse($staff->permissions ?? [] as $permission)<span class="badge">{{ ucwords(str_replace('_',' ',$permission)) }}</span> @empty — @endforelse</div></div>
    <div style="margin-top:24px;display:flex;gap:8px"><a class="btn approve" href="{{ route('admin.staff.edit',$staff->id) }}">Edit</a><form method="POST" action="{{ route('admin.staff.destroy',$staff->id) }}" onsubmit="return confirm('Delete this staff member permanently?');">@csrf @method('DELETE')<button class="btn reject">Delete</button></form><a class="btn" href="{{ route('admin.staff.index') }}">Back</a></div>
</div>
@endsection
