@extends('layouts.admin')

@section('title', 'Create Event - Eventora')
@section('heading', 'Create Event')
@section('description', 'Create a live event for any approved organization.')

@section('content')
<style>
.event-form-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:24px;max-width:1050px;margin:0 auto}.section{margin-bottom:28px}.section:last-child{margin-bottom:0}.section-title{font-size:15px;font-weight:800;margin-bottom:16px;padding-bottom:11px;border-bottom:1px solid var(--border)}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:17px}.form-group{display:flex;flex-direction:column;gap:7px}.full{grid-column:1/-1}.form-group label{font-size:11px;font-weight:800;color:var(--text)}.req{color:#ff6b6b}.form-group input,.form-group select,.form-group textarea{width:100%;border:1px solid var(--border);border-radius:10px;background:var(--card2);color:var(--text);padding:11px 12px;font-size:12px;outline:none}.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(108,99,255,.1)}.form-group textarea{min-height:145px;resize:vertical;line-height:1.5}.help{font-size:10px;color:var(--muted)}.error{font-size:10px;color:#ff8585}.error-box{padding:12px 14px;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.08);color:#ff9b9b;border-radius:10px;margin-bottom:18px;font-size:11px}.actions{display:flex;justify-content:flex-end;gap:9px;border-top:1px solid var(--border);padding-top:20px;margin-top:25px}.btn{display:inline-flex;align-items:center;justify-content:center;padding:10px 16px;border-radius:9px;font-size:11px;font-weight:800;text-decoration:none;cursor:pointer}.btn-cancel{border:1px solid var(--border);color:var(--text);background:var(--card2)}.btn-save{border:0;color:#fff;background:linear-gradient(135deg,var(--primary),var(--primary2))}.unit-notice{padding:11px 12px;border:1px dashed var(--border);border-radius:10px;color:var(--muted);font-size:10px;background:var(--card2)}.banner-preview{display:none;margin-top:7px;width:220px;height:125px;border-radius:10px;overflow:hidden;border:1px solid var(--border)}.banner-preview img{width:100%;height:100%;object-fit:cover}@media(max-width:700px){.form-grid{grid-template-columns:1fr}.full{grid-column:auto}.event-form-card{padding:16px}.actions{flex-direction:column}.btn{width:100%}}
</style>

<div class="event-form-card">
    @if($errors->any())
        <div class="error-box">Please correct the highlighted fields and try again.</div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="section">
            <div class="section-title">Organization & Basic Information</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="organization_id">Organization <span class="req">*</span></label>
                    <select id="organization_id" name="organization_id" required>
                        <option value="">Select approved organization</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}" @selected(old('organization_id') == $organization->id)>{{ $organization->name }}{{ $organization->city ? ' — '.$organization->city : '' }}</option>
                        @endforeach
                    </select>
                    @error('organization_id')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="organization_unit_id">Department / Team / Section</label>
                    <select id="organization_unit_id" name="organization_unit_id">
                        <option value="">General / Organization-wide</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" data-organization="{{ $unit->organization_id }}" @selected(old('organization_unit_id') == $unit->id)>{{ $unit->name }} — {{ optional($unit->organization)->name }}</option>
                        @endforeach
                    </select>
                    <div class="help">Only active units belonging to the selected organization are available.</div>
                    @error('organization_unit_id')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group full">
                    <label for="title">Event Title <span class="req">*</span></label>
                    <input id="title" name="title" value="{{ old('title') }}" placeholder="Enter event title" required>
                    @error('title')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="category">Category <span class="req">*</span></label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        @foreach(['Technology','Cultural','Sports','Workshop','Seminar','Competition','Other'] as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="banner">Event Banner</label>
                    <input id="banner" type="file" name="banner" accept=".jpg,.jpeg,.png,.webp">
                    <div class="help">JPG, JPEG, PNG or WEBP • Maximum 4MB.</div>
                    <div id="bannerPreview" class="banner-preview"><img id="bannerPreviewImage" alt="Banner preview"></div>
                    @error('banner')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group full">
                    <label for="description">Description <span class="req">*</span></label>
                    <textarea id="description" name="description" placeholder="Describe the event" required>{{ old('description') }}</textarea>
                    @error('description')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Date, Time & Location</div>
            <div class="form-grid">
                <div class="form-group"><label for="event_date">Event Date <span class="req">*</span></label><input id="event_date" type="date" name="event_date" value="{{ old('event_date') }}" required>@error('event_date')<div class="error">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label for="event_time">Event Time <span class="req">*</span></label><input id="event_time" type="time" name="event_time" value="{{ old('event_time') }}" required>@error('event_time')<div class="error">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label for="venue">Venue <span class="req">*</span></label><input id="venue" name="venue" value="{{ old('venue') }}" placeholder="Enter venue" required>@error('venue')<div class="error">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label for="city">City <span class="req">*</span></label><input id="city" name="city" value="{{ old('city') }}" placeholder="Enter city" required>@error('city')<div class="error">{{ $message }}</div>@enderror</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Ticket & Seat Availability</div>
            <div class="form-grid">
                <div class="form-group"><label for="ticket_price">Ticket Price <span class="req">*</span></label><input id="ticket_price" type="number" step="0.01" min="0" name="ticket_price" value="{{ old('ticket_price', 0) }}" required>@error('ticket_price')<div class="error">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label for="seat_type">Seat Availability <span class="req">*</span></label><select id="seat_type" name="seat_type" required><option value="limited" @selected(old('seat_type','limited') === 'limited')>Limited Seats</option><option value="unlimited" @selected(old('seat_type') === 'unlimited')>No Limit / Unlimited</option></select></div>
                <div class="form-group" id="totalSeatsGroup"><label for="total_seats">Total Seats <span class="req">*</span></label><input id="total_seats" type="number" min="1" name="total_seats" value="{{ old('total_seats') }}" placeholder="e.g. 100">@error('total_seats')<div class="error">{{ $message }}</div>@enderror</div>
                <div class="form-group"><div class="unit-notice">Events created by Super Admin are <strong>live immediately</strong>. There is no event approval workflow.</div></div>
            </div>
        </div>

        <div class="actions"><a class="btn btn-cancel" href="{{ route('admin.events.index') }}">Cancel</a><button class="btn btn-save" type="submit">Create Event</button></div>
    </form>
</div>

<script>
const org=document.getElementById('organization_id'), unit=document.getElementById('organization_unit_id'), seat=document.getElementById('seat_type'), totalGroup=document.getElementById('totalSeatsGroup'), total=document.getElementById('total_seats');
function filterUnits(){const id=org.value; [...unit.options].forEach(o=>{if(!o.dataset.organization){o.hidden=false;return} o.hidden=!!id && o.dataset.organization!==id; if(o.hidden && o.selected) unit.value='';});}
function seatToggle(){const unlimited=seat.value==='unlimited'; totalGroup.style.display=unlimited?'none':'flex'; total.required=!unlimited; if(unlimited) total.value='';}
org.addEventListener('change',filterUnits); seat.addEventListener('change',seatToggle); filterUnits(); seatToggle();
document.getElementById('banner').addEventListener('change',function(){const file=this.files[0], preview=document.getElementById('bannerPreview'), img=document.getElementById('bannerPreviewImage'); if(!file){preview.style.display='none';return} img.src=URL.createObjectURL(file); preview.style.display='block';});
</script>
@endsection
