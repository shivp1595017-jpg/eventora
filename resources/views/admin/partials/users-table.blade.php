<div class="table-card">
@if($users->count())
<div class="table-wrap"><table>
<thead><tr><th>User</th><th>Email</th><th>Role</th><th>Bookings</th><th>Email Verified</th><th>Registered</th></tr></thead>
<tbody>
@foreach($users as $user)
<tr>
<td><div class="user-cell"><div class="user-avatar"><span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>@if($user->profilePhotoUrl())<img src="{{ $user->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">@endif</div><div><div class="name">{{ $user->name }}</div><div class="sub">#{{ $user->id }}</div></div></div></td>
<td><div class="user-email-cell"><div class="email-avatar"><span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>@if($user->profilePhotoUrl())<img src="{{ $user->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">@endif</div><span>{{ $user->email }}</span></div></td>
<td><span class="badge {{ $user->role === 'super_admin' ? 'approved' : ($user->role === 'organization_admin' ? 'other' : 'pending') }}">{{ str_replace('_',' ',$user->role) }}</span></td>
<td>{{ $user->bookings_count }}</td>
<td>{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Not verified' }}</td>
<td>{{ $user->created_at->format('d M Y') }}</td>
</tr>
@endforeach
</tbody></table></div>
<div class="pagination-wrap">{{ $users->links() }}</div>
@else
<div class="empty"><strong>No users found.</strong>Try changing the search or role filter.</div>
@endif
</div>
<style>
    .user-cell{display:flex;align-items:center;gap:11px;min-width:190px}
    .user-avatar{position:relative;display:grid;width:42px;height:42px;flex:0 0 42px;place-items:center;overflow:hidden;border-radius:50%;background:linear-gradient(135deg,#6c63ff,#8b5cf6);color:#fff;font-size:16px;font-weight:800}
    .user-avatar img{position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover}
    .user-email-cell{display:flex;align-items:center;gap:9px;min-width:210px}
    .email-avatar{position:relative;display:grid;width:30px;height:30px;flex:0 0 30px;place-items:center;overflow:hidden;border-radius:50%;background:linear-gradient(135deg,#6c63ff,#8b5cf6);color:#fff;font-size:12px;font-weight:800}
    .email-avatar img{position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover}
</style>
