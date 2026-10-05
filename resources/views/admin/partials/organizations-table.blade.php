<div class="table-card">
@if($organizations->count())
<div class="table-wrap">
<table>
<thead><tr><th>Organization</th><th>Type</th><th>Contact</th><th>Location</th><th>Admin</th><th>Events</th><th>Status</th><th>Action</th></tr></thead>
<tbody>
@foreach($organizations as $organization)
<tr>
<td><div class="name">{{ $organization->name }}</div><div class="sub">{{ $organization->email ?? 'No email' }}</div></td>
<td>{{ $organization->type }}</td>
<td><div>{{ $organization->phone ?? 'No phone' }}</div></td>
<td><div>{{ $organization->city ?? 'N/A' }}</div><div class="sub">{{ $organization->state ?? '' }}</div></td>
<td><div class="sub">{{ optional($organization->user)->email ?? 'Not linked' }}</div></td>
<td>{{ $organization->events_count }}</td>
<td><span class="badge {{ $organization->status }}">{{ $organization->status }}</span></td>
<td>
<div class="actions">
@if($organization->status !== 'approved')
<form method="POST" action="{{ route('admin.organizations.approve',$organization) }}" onsubmit="return confirm('Approve this organization?');">@csrf @method('PATCH')<button class="action success" type="submit">✓ Approve</button></form>
@endif
@if($organization->status !== 'rejected')
<form method="POST" action="{{ route('admin.organizations.reject',$organization) }}" onsubmit="return confirm('Reject this organization?');">@csrf @method('PATCH')<button class="action danger" type="submit">✕ Reject</button></form>
@endif
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="pagination-wrap">{{ $organizations->links() }}</div>
@else
<div class="empty"><strong>No organizations found.</strong>Try changing the search or filters.</div>
@endif
</div>
