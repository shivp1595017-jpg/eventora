@csrf
<div class="staff-field-grid">
    <div><label>Name</label><input class="filter-control" name="name" value="{{ old('name',$staff->name ?? '') }}" required></div>
    <div><label>Email</label><input class="filter-control" type="email" name="email" value="{{ old('email',$staff->email ?? '') }}" required></div>
    <div><label>Mobile</label><input class="filter-control" name="mobile" value="{{ old('mobile',$staff->mobile ?? '') }}"></div>
    <div><label>Organization</label><select class="filter-control" name="organization_id" required>
        <option value="">Select Organization</option>
        @foreach($organizations as $organization)<option value="{{ $organization->id }}" @selected(old('organization_id',$staff->organization_id ?? '') == $organization->id)>{{ $organization->name }}</option>@endforeach
    </select></div>
    <div><label>Role</label><select class="filter-control" name="role" required>
        @foreach(['hod'=>'HOD','faculty'=>'Faculty','staff'=>'Staff'] as $value=>$label)<option value="{{ $value }}" @selected(old('role',$staff->role ?? 'staff') === $value)>{{ $label }}</option>@endforeach
    </select></div>
    <div><label>Status</label><select class="filter-control" name="status" required><option value="active" @selected(old('status',$staff->status ?? 'active')==='active')>Active</option><option value="inactive" @selected(old('status',$staff->status ?? '')==='inactive')>Inactive</option></select></div>
</div>
<div style="padding:0 20px 20px">
    <label>Organization Units</label>
    <div class="staff-checkbox-grid staff-unit-grid">
        @php($selectedUnits = old('organization_unit_ids', isset($staff) ? $staff->organizationUnits->pluck('id')->all() : []))
        @foreach($units as $unit)<label style="padding:9px;border:1px solid var(--border);border-radius:8px"><input type="checkbox" name="organization_unit_ids[]" value="{{ $unit->id }}" @checked(in_array($unit->id,$selectedUnits))> {{ $unit->name }} <small style="color:var(--muted)">({{ $unit->organization?->name }})</small></label>@endforeach
    </div>
</div>
<div style="padding:0 20px 20px">
    <label>Assigned Events</label>
    <div class="staff-checkbox-grid staff-event-grid">
        @php($selectedEvents = old('event_ids', isset($staff) ? $staff->events->pluck('id')->all() : []))
        @foreach($events as $event)<label style="padding:9px;border:1px solid var(--border);border-radius:8px"><input type="checkbox" name="event_ids[]" value="{{ $event->id }}" @checked(in_array($event->id,$selectedEvents))> {{ $event->title }} <small style="color:var(--muted)">({{ $event->organization?->name }})</small></label>@endforeach
    </div>
</div>
<div style="padding:0 20px 20px">
    <label>Permissions</label>
    @php($allPermissions=['manage_staff'=>'Manage Staff','view_events'=>'View Events','create_events'=>'Create Events','manage_events'=>'Manage Events','view_bookings'=>'View Bookings','manage_bookings'=>'Manage Bookings','view_participants'=>'View Participants','verify_tickets'=>'Verify Tickets'])
    @php($selectedPermissions=old('permissions',isset($staff)?($staff->permissions??[]):[]))
    <div class="staff-checkbox-grid staff-permission-grid">
        @foreach($allPermissions as $value=>$label)<label style="padding:9px;border:1px solid var(--border);border-radius:8px"><input type="checkbox" name="permissions[]" value="{{ $value }}" @checked(in_array($value,$selectedPermissions))> {{ $label }}</label>@endforeach
    </div>
</div>
<div class="staff-form-actions"><button class="btn primary" type="submit">{{ isset($staff) ? 'Update Staff' : 'Add Staff' }}</button><a class="btn reject" href="{{ route('admin.staff.index') }}">Cancel</a></div>
<style>
    .staff-access-form label{display:block;color:var(--text);font-size:11px;font-weight:700;margin-bottom:7px}
    .staff-access-form .filter-control{margin-top:5px;width:100%;min-height:42px}
    .staff-field-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;padding:20px}
    .staff-checkbox-grid{display:grid;gap:8px;margin-top:8px;padding:0 20px 20px}
    .staff-checkbox-grid label{padding:10px;border:1px solid var(--border);border-radius:9px;background:var(--card2)}
    .staff-unit-grid,.staff-permission-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
    .staff-event-grid{grid-template-columns:repeat(2,minmax(0,1fr));max-height:280px;overflow:auto}
    .staff-form-actions{display:flex;gap:9px;flex-wrap:wrap;padding:0 20px 20px}
    @media(max-width:700px){.staff-field-grid{grid-template-columns:1fr;padding:14px}.staff-checkbox-grid{padding:0 14px 14px}.staff-unit-grid,.staff-permission-grid,.staff-event-grid{grid-template-columns:1fr 1fr}}
</style>
