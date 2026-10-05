@include('organization_admin.sidebar')

<div class="staff-page">

    <!-- ===================================================== -->
    <!-- PAGE HEADER -->
    <!-- ===================================================== -->

    <div class="page-header">

        <div>

            <div class="page-breadcrumb">
                Organization Admin / Staff & Access / Create Staff
            </div>

            <h1 class="page-title">
                Add New Staff
            </h1>

            <p class="page-subtitle">
                Create a staff account and assign units, events and permissions.
            </p>

        </div>


        <a
            href="{{ route('organization.admin.staff.index') }}"
            class="back-btn"
        >
            ← Back to Staff
        </a>

    </div>


    <!-- ===================================================== -->
    <!-- VALIDATION ERRORS -->
    <!-- ===================================================== -->

    @if($errors->any())

        <div class="alert alert-error">

            <div class="alert-icon">
                ⚠️
            </div>

            <div>

                <strong>
                    Please fix the following errors:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    <!-- ===================================================== -->
    <!-- SUCCESS MESSAGE -->
    <!-- ===================================================== -->

    @if(session('success'))

        <div class="alert alert-success">

            <div class="alert-icon">
                ✓
            </div>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    <!-- ===================================================== -->
    <!-- ERROR MESSAGE -->
    <!-- ===================================================== -->

    @if(session('error'))

        <div class="alert alert-error">

            <div class="alert-icon">
                ⚠️
            </div>

            <div>
                {{ session('error') }}
            </div>

        </div>

    @endif


    <!-- ===================================================== -->
    <!-- CREATE STAFF FORM -->
    <!-- ===================================================== -->

    <form
        action="{{ route('organization.admin.staff.store') }}"
        method="POST"
        id="staffForm"
    >

        @csrf


        <!-- ================================================= -->
        <!-- STAFF INFORMATION -->
        <!-- ================================================= -->

        <div class="form-card">

            <div class="card-header">

                <div class="header-icon">
                    👤
                </div>

                <div>

                    <h2>
                        Staff Information
                    </h2>

                    <p>
                        Enter the basic information of the staff member.
                    </p>

                </div>

            </div>


            <div class="form-grid">


                <!-- =========================================== -->
                <!-- FULL NAME -->
                <!-- =========================================== -->

                <div class="form-group">

                    <label for="name">

                        Full Name

                        <span>*</span>

                    </label>


                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter full name"
                        required
                    >

                </div>


                <!-- =========================================== -->
                <!-- EMAIL -->
                <!-- =========================================== -->

                <div class="form-group">

                    <label for="email">

                        Email Address

                        <span>*</span>

                    </label>


                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter email address"
                        required
                    >


                    <small>
                        Password setup link will be sent to this email.
                    </small>

                </div>


                <!-- =========================================== -->
                <!-- MOBILE -->
                <!-- =========================================== -->

                <div class="form-group">

                    <label for="mobile">
                        Mobile Number
                    </label>


                    <input
                        type="text"
                        id="mobile"
                        name="mobile"
                        value="{{ old('mobile') }}"
                        placeholder="Enter mobile number"
                    >

                </div>


                <!-- =========================================== -->
                <!-- ROLE -->
                <!-- =========================================== -->

                <div class="form-group">

                    <label for="role">

                        Staff Role

                        <span>*</span>

                    </label>


                    @php

                        $staffRoles = [

                            'HOD',
                            'Faculty',
                            'Teacher',
                            'Coordinator',
                            'Manager',
                            'Team Lead',
                            'HR',
                            'Staff',
                            'Volunteer',
                            'Event Manager',
                            'Other',

                        ];

                    @endphp


                    <select
                        id="role"
                        name="role"
                        required
                    >

                        <option value="">
                            Select Staff Role
                        </option>


                        @foreach($staffRoles as $staffRole)

                            <option
                                value="{{ $staffRole }}"
                                {{ old('role') === $staffRole ? 'selected' : '' }}
                            >
                                {{ $staffRole }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- ================================================= -->
                <!-- ORGANIZATION UNITS -->
                <!-- ================================================= -->

                @php

                    $oldUnitIds =
                        old(
                            'organization_unit_ids',
                            []
                        );

                @endphp


                <div class="form-group full-width">

                    <label>
                        Organization Units
                    </label>


                    <div
                        class="multi-dropdown"
                        data-dropdown
                    >

                        <button
                            type="button"
                            class="multi-dropdown-button"
                            data-dropdown-button
                        >

                            <span
                                data-dropdown-label
                            >
                                Select Organization Units
                            </span>


                            <span class="dropdown-arrow">
                                ▼
                            </span>

                        </button>


                        <div
                            class="multi-dropdown-menu"
                            data-dropdown-menu
                        >

                            @forelse($units as $unit)

                                <label class="multi-option">

                                    <input
                                        type="checkbox"
                                        name="organization_unit_ids[]"
                                        value="{{ $unit->id }}"
                                        class="unit-dropdown-checkbox"
                                        {{ in_array($unit->id, $oldUnitIds) ? 'checked' : '' }}
                                    >


                                    <div class="option-text">

                                        <strong>
                                            {{ $unit->name }}
                                        </strong>

                                        <small>
                                            Organization Unit
                                        </small>

                                    </div>

                                </label>

                            @empty

                                <div class="dropdown-empty">
                                    No active organization units available.
                                </div>

                            @endforelse

                        </div>

                    </div>


                    <small>
                        Select one or more organization units.
                    </small>

                </div>


                <!-- ================================================= -->
                <!-- EVENTS -->
                <!-- ================================================= -->

                @php

                    $oldEventIds =
                        old(
                            'event_ids',
                            []
                        );

                @endphp


                <div class="form-group full-width">

                    <label>
                        Events
                    </label>


                    <div
                        class="multi-dropdown"
                        data-dropdown
                        data-dropdown-type="events"
                    >

                        <button
                            type="button"
                            class="multi-dropdown-button"
                            data-dropdown-button
                        >

                            <span
                                data-dropdown-label
                            >
                                Select Events
                            </span>


                            <span class="dropdown-arrow">
                                ▼
                            </span>

                        </button>


                        <div
                            class="multi-dropdown-menu"
                            data-dropdown-menu
                        >

                            @forelse($events as $event)

                                <label class="multi-option">

                                    <input
                                        type="checkbox"
                                        name="event_ids[]"
                                        value="{{ $event->id }}"
                                        class="event-dropdown-checkbox"
                                        {{ in_array($event->id, $oldEventIds) ? 'checked' : '' }}
                                    >


                                    <div class="option-text">

                                        <strong>
                                            {{ $event->title }}
                                        </strong>


                                        <small>

                                            @if($event->event_date)

                                                {{ \Illuminate\Support\Carbon::parse($event->event_date)->format('d M Y') }}

                                            @endif


                                            @if($event->event_time)

                                                •
                                                {{ \Illuminate\Support\Carbon::parse($event->event_time)->format('h:i A') }}

                                            @endif

                                        </small>

                                    </div>

                                </label>

                            @empty

                                <div class="dropdown-empty">
                                    No events available for this organization.
                                </div>

                            @endforelse

                        </div>

                    </div>


                    <small>
                        Select the events this staff member should have access to.
                    </small>

                </div>


                <!-- =========================================== -->
                <!-- STATUS -->
                <!-- =========================================== -->

                <div class="form-group">

                    <label for="status">

                        Status

                        <span>*</span>

                    </label>


                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="active"
                            {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>


                        <option
                            value="inactive"
                            {{ old('status') === 'inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- STAFF ACCESS -->
        <!-- ================================================= -->

        @php

            $permissionList = [

                'view_events' => [
                    'title' => 'View Events',
                    'description' => 'View organization events and event details.',
                    'icon' => '📅',
                ],

                'create_events' => [
                    'title' => 'Create Events',
                    'description' => 'Create new events for the organization.',
                    'icon' => '➕',
                ],

                'manage_events' => [
                    'title' => 'Manage Events',
                    'description' => 'Edit and delete organization events.',
                    'icon' => '📝',
                ],

                'view_bookings' => [
                    'title' => 'View Bookings',
                    'description' => 'View event bookings and details.',
                    'icon' => '🎟️',
                ],

                'manage_bookings' => [
                    'title' => 'Manage Bookings',
                    'description' => 'Confirm or cancel event bookings.',
                    'icon' => '✅',
                ],

                'view_participants' => [
                    'title' => 'View Participants',
                    'description' => 'View event participant information.',
                    'icon' => '👥',
                ],

                'verify_tickets' => [
                    'title' => 'Verify Tickets',
                    'description' => 'Verify event tickets.',
                    'icon' => '🔎',
                ],

                'manage_staff' => [
                    'title' => 'Manage Staff',
                    'description' => 'Add, edit and manage staff members.',
                    'icon' => '🧑‍💼',
                ],

            ];


            $oldPermissions =
                old(
                    'permissions',
                    []
                );

        @endphp


        <div class="form-card access-card">


            <div class="card-header access-header">


                <div class="header-left">

                    <div class="header-icon access-icon">
                        🔐
                    </div>


                    <div>

                        <h2>
                            Staff Access
                        </h2>

                        <p>
                            Select the permissions this staff member should have.
                        </p>

                    </div>

                </div>


                <!-- SELECT ALL -->

                <label
                    class="select-all-box"
                    for="selectAllPermissions"
                >

                    <input
                        type="checkbox"
                        id="selectAllPermissions"
                    >

                    <span>
                        Select All
                    </span>

                </label>

            </div>


            <!-- PERMISSION STATUS -->

            <div class="select-status-row">

                <span id="permissionCount">
                    0 permissions selected
                </span>


                <button
                    type="button"
                    id="clearAllPermissions"
                    class="clear-btn"
                >
                    Clear All
                </button>

            </div>


            <!-- PERMISSION GRID -->

            <div class="permissions-grid">

                @foreach($permissionList as $permission => $permissionData)

                    <label
                        class="permission-card"
                        for="permission_{{ $permission }}"
                    >

                        <input
                            type="checkbox"
                            id="permission_{{ $permission }}"
                            name="permissions[]"
                            value="{{ $permission }}"
                            class="permission-checkbox"
                            {{ in_array($permission, $oldPermissions, true) ? 'checked' : '' }}
                        >


                        <div class="permission-icon">
                            {{ $permissionData['icon'] }}
                        </div>


                        <div class="permission-content">

                            <strong>
                                {{ $permissionData['title'] }}
                            </strong>


                            <small>
                                {{ $permissionData['description'] }}
                            </small>

                        </div>


                        <div class="permission-check">
                            ✓
                        </div>

                    </label>

                @endforeach

            </div>

        </div>


        <!-- ================================================= -->
        <!-- INFORMATION BOX -->
        <!-- ================================================= -->

        <div class="info-box">

            <div class="info-icon">
                ℹ️
            </div>


            <div>

                <strong>
                    Staff Access Information
                </strong>


                <p>
                    Staff members use the same Organization Admin Panel.
                    Their available menu options and actions depend on the
                    permissions selected above.
                </p>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- FORM ACTIONS -->
        <!-- ================================================= -->

        <div class="form-actions">

            <a
                href="{{ route('organization.admin.staff.index') }}"
                class="cancel-btn"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="save-btn"
            >

                <span>
                    ✓
                </span>

                Create Staff

            </button>

        </div>


    </form>

</div>



<style>

/* =========================================================
   BASE
   ========================================================= */

* {
    box-sizing: border-box;
}


body {

    margin: 0;

    background: #f5f7fb;

    font-family:
        Inter,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;
}


/* =========================================================
   PAGE
   ========================================================= */

.staff-page {

    margin-left: 260px;

    min-height: 100vh;

    padding: 35px;

    background: #f5f7fb;

}


/* =========================================================
   PAGE HEADER
   ========================================================= */

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 20px;

    margin-bottom: 28px;

}


.page-breadcrumb {

    color: #7b8494;

    font-size: 13px;

    margin-bottom: 8px;

}


.page-title {

    margin: 0;

    color: #172033;

    font-size: 30px;

    font-weight: 800;

    letter-spacing: -0.4px;

}


.page-subtitle {

    margin: 7px 0 0;

    color: #737d8f;

    font-size: 14px;

}


.back-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 11px 18px;

    border-radius: 10px;

    background: #ffffff;

    color: #344054;

    border: 1px solid #dfe4ec;

    text-decoration: none;

    font-size: 14px;

    font-weight: 600;

    white-space: nowrap;

    transition: 0.2s ease;

}


.back-btn:hover {

    background: #eef3ff;

    color: #3158d8;

    border-color: #cbd7ff;

}


/* =========================================================
   ALERTS
   ========================================================= */

.alert {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 15px 18px;

    border-radius: 12px;

    margin-bottom: 20px;

    font-size: 14px;

}


.alert-error {

    background: #fff1f1;

    border: 1px solid #ffd0d0;

    color: #b42318;

}


.alert-success {

    background: #ecfdf3;

    border: 1px solid #b7ebca;

    color: #027a48;

}


.alert-icon {

    font-size: 18px;

    line-height: 1;

}


.alert ul {

    margin: 8px 0 0 18px;

    padding: 0;

}


/* =========================================================
   FORM CARD
   ========================================================= */

.form-card {

    background: #ffffff;

    border: 1px solid #e5e9f0;

    border-radius: 18px;

    padding: 26px;

    margin-bottom: 22px;

    box-shadow:
        0 6px 25px rgba(16,24,40,0.04);

}


.card-header {

    display: flex;

    align-items: center;

    gap: 14px;

    padding-bottom: 22px;

    margin-bottom: 22px;

    border-bottom: 1px solid #edf0f5;

}


.header-icon {

    width: 48px;

    height: 48px;

    border-radius: 14px;

    background: #eef3ff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;

    flex-shrink: 0;

}


.card-header h2 {

    margin: 0 0 4px;

    color: #172033;

    font-size: 18px;

    font-weight: 750;

}


.card-header p {

    margin: 0;

    color: #7a8495;

    font-size: 13px;

}


/* =========================================================
   FORM GRID
   ========================================================= */

.form-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 20px;

}


.form-group {

    display: flex;

    flex-direction: column;

    min-width: 0;

}


.full-width {

    grid-column: 1 / -1;

}


.form-group > label {

    font-size: 13px;

    font-weight: 700;

    color: #344054;

    margin-bottom: 8px;

}


.form-group > label span {

    color: #d92d20;

}


.form-group input[type="text"],
.form-group input[type="email"],
.form-group select {

    width: 100%;

    height: 48px;

    padding: 0 14px;

    border: 1px solid #d8dee8;

    border-radius: 10px;

    outline: none;

    background: #ffffff;

    color: #172033;

    font-size: 14px;

    transition: 0.2s ease;

}


.form-group input[type="text"]:focus,
.form-group input[type="email"]:focus,
.form-group select:focus {

    border-color: #5979e8;

    box-shadow:
        0 0 0 3px rgba(89,121,232,0.10);

}


.form-group input::placeholder {

    color: #98a2b3;

}


.form-group > small {

    margin-top: 6px;

    color: #8a94a6;

    font-size: 11px;

    line-height: 1.4;

}


/* =========================================================
   MULTI SELECT DROPDOWN
   ========================================================= */

.multi-dropdown {

    position: relative;

    width: 100%;

}


.multi-dropdown-button {

    width: 100%;

    min-height: 48px;

    padding: 0 14px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 12px;

    border: 1px solid #d8dee8;

    border-radius: 10px;

    background: #ffffff;

    color: #667085;

    font-size: 14px;

    text-align: left;

    cursor: pointer;

    transition: 0.2s ease;

}


.multi-dropdown-button:hover {

    border-color: #9fb1ee;

}


.multi-dropdown-button.has-selection {

    color: #172033;

}


.multi-dropdown.open
.multi-dropdown-button {

    border-color: #5979e8;

    box-shadow:
        0 0 0 3px rgba(89,121,232,0.10);

}


.dropdown-arrow {

    color: #667085;

    font-size: 10px;

    flex-shrink: 0;

    transition: 0.2s ease;

}


.multi-dropdown.open
.dropdown-arrow {

    transform: rotate(180deg);

}


/* =========================================================
   DROPDOWN MENU
   ========================================================= */

.multi-dropdown-menu {

    position: absolute;

    left: 0;

    right: 0;

    top: calc(100% + 7px);

    z-index: 1000;

    display: none;

    max-height: 280px;

    overflow-y: auto;

    padding: 7px;

    background: #ffffff;

    border: 1px solid #dfe4ec;

    border-radius: 12px;

    box-shadow:
        0 14px 32px rgba(16,24,40,0.14);

}


.multi-dropdown.open
.multi-dropdown-menu {

    display: block;

}


/* =========================================================
   DROPDOWN OPTION
   ========================================================= */

.multi-option {

    display: flex;

    align-items: flex-start;

    gap: 10px;

    padding: 11px 12px;

    border-radius: 9px;

    cursor: pointer;

    transition: 0.15s ease;

}


.multi-option:hover {

    background: #f5f8ff;

}


.multi-option input {

    width: 17px;

    height: 17px;

    margin-top: 2px;

    flex-shrink: 0;

    cursor: pointer;

    accent-color: #4567dd;

}


.option-text {

    min-width: 0;

    flex: 1;

}


.option-text strong {

    display: block;

    color: #172033;

    font-size: 13px;

    font-weight: 700;

    line-height: 1.35;

}


.option-text small {

    display: block;

    margin-top: 3px;

    color: #7b8494;

    font-size: 11px;

}


.dropdown-empty {

    padding: 18px 12px;

    color: #7b8494;

    text-align: center;

    font-size: 12px;

}


/* =========================================================
   DROPDOWN SCROLLBAR
   ========================================================= */

.multi-dropdown-menu::-webkit-scrollbar {

    width: 6px;

}


.multi-dropdown-menu::-webkit-scrollbar-track {

    background: transparent;

}


.multi-dropdown-menu::-webkit-scrollbar-thumb {

    background: #cfd4dc;

    border-radius: 10px;

}


/* =========================================================
   STAFF ACCESS
   ========================================================= */

.access-header {

    justify-content: space-between;

}


.header-left {

    display: flex;

    align-items: center;

    gap: 14px;

}


.access-icon {

    background: #f0fdf4;

}


.select-all-box {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 10px 14px;

    border: 1px solid #cfd8ef;

    border-radius: 10px;

    cursor: pointer;

    color: #3158d8;

    background: #f8faff;

    font-size: 13px;

    font-weight: 700;

    white-space: nowrap;

    transition: 0.2s ease;

}


.select-all-box:hover {

    border-color: #8ea4ed;

    background: #eef3ff;

}


.select-all-box input {

    width: 17px;

    height: 17px;

    cursor: pointer;

    accent-color: #4567dd;

}


/* =========================================================
   PERMISSION STATUS
   ========================================================= */

.select-status-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 17px;

}


#permissionCount {

    color: #667085;

    font-size: 13px;

    font-weight: 600;

}


.clear-btn {

    border: 0;

    background: transparent;

    color: #d92d20;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    padding: 5px 0;

}


.clear-btn:hover {

    text-decoration: underline;

}


/* =========================================================
   PERMISSIONS GRID
   ========================================================= */

.permissions-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;

}


.permission-card {

    position: relative;

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 17px;

    border: 1px solid #e0e5ec;

    border-radius: 14px;

    background: #ffffff;

    cursor: pointer;

    transition: 0.2s ease;

}


.permission-card:hover {

    border-color: #9fb1ee;

    background: #fbfcff;

    transform: translateY(-1px);

}


.permission-card.selected {

    border-color: #5979e8;

    background: #f5f8ff;

    box-shadow:
        0 4px 14px rgba(49,88,216,0.07);

}


.permission-card > input {

    width: 18px;

    height: 18px;

    margin-top: 2px;

    flex-shrink: 0;

    cursor: pointer;

    accent-color: #4567dd;

}


.permission-icon {

    width: 38px;

    height: 38px;

    border-radius: 10px;

    background: #f2f4f7;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    font-size: 18px;

}


.permission-content {

    min-width: 0;

    padding-right: 25px;

}


.permission-content strong {

    display: block;

    color: #172033;

    font-size: 14px;

    margin-bottom: 5px;

}


.permission-content small {

    display: block;

    color: #7b8494;

    font-size: 11px;

    line-height: 1.5;

}


.permission-check {

    position: absolute;

    top: 15px;

    right: 15px;

    width: 21px;

    height: 21px;

    border-radius: 50%;

    background: #4567dd;

    color: #ffffff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 11px;

    font-weight: 800;

    opacity: 0;

    transform: scale(0.7);

    transition: 0.2s ease;

}


.permission-card.selected
.permission-check {

    opacity: 1;

    transform: scale(1);

}


/* =========================================================
   INFO BOX
   ========================================================= */

.info-box {

    display: flex;

    align-items: flex-start;

    gap: 13px;

    padding: 17px 19px;

    background: #f8faff;

    border: 1px solid #dce5ff;

    border-radius: 14px;

    margin-bottom: 24px;

}


.info-icon {

    font-size: 18px;

    line-height: 1.4;

}


.info-box strong {

    display: block;

    color: #344054;

    font-size: 13px;

    margin-bottom: 4px;

}


.info-box p {

    margin: 0;

    color: #667085;

    font-size: 12px;

    line-height: 1.5;

}


/* =========================================================
   ACTION BUTTONS
   ========================================================= */

.form-actions {

    display: flex;

    justify-content: flex-end;

    gap: 12px;

    padding-bottom: 25px;

}


.cancel-btn,
.save-btn {

    min-width: 120px;

    height: 46px;

    padding: 0 20px;

    border-radius: 10px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    text-decoration: none;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.2s ease;

}


.cancel-btn {

    background: #ffffff;

    color: #475467;

    border: 1px solid #d8dee8;

}


.cancel-btn:hover {

    background: #f8f9fb;

}


.save-btn {

    border: 0;

    background: #4567dd;

    color: #ffffff;

    box-shadow:
        0 6px 15px rgba(69,103,221,0.20);

}


.save-btn:hover {

    background: #3657c8;

    transform: translateY(-1px);

}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1000px) {

    .staff-page {

        margin-left: 0;

        padding: 24px;

    }

}


@media (max-width: 768px) {

    .staff-page {

        padding: 18px;

    }


    .page-header {

        flex-direction: column;

    }


    .back-btn {

        width: 100%;

    }


    .form-card {

        padding: 20px;

        border-radius: 15px;

    }


    .form-grid {

        grid-template-columns: 1fr;

    }


    .permissions-grid {

        grid-template-columns: 1fr;

    }


    .access-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .header-left {

        width: 100%;

    }


    .select-all-box {

        width: 100%;

        justify-content: center;

    }


    .form-actions {

        flex-direction: column-reverse;

    }


    .cancel-btn,
    .save-btn {

        width: 100%;

    }

}


@media (max-width: 480px) {

    .page-title {

        font-size: 24px;

    }


    .header-icon {

        width: 42px;

        height: 42px;

        font-size: 18px;

    }

}

</style>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =================================================
           MULTI SELECT DROPDOWNS
           ================================================= */

        const dropdowns =
            document.querySelectorAll(
                '[data-dropdown]'
            );


        dropdowns.forEach(
            function (dropdown) {


                const button =
                    dropdown.querySelector(
                        '[data-dropdown-button]'
                    );


                const label =
                    dropdown.querySelector(
                        '[data-dropdown-label]'
                    );


                const checkboxes =
                    dropdown.querySelectorAll(
                        'input[type="checkbox"]'
                    );


                const isEvents =
                    dropdown.dataset.dropdownType ===
                    'events';


                function updateDropdownLabel() {


                    const selectedNames = [];


                    checkboxes.forEach(
                        function (checkbox) {

                            if (!checkbox.checked) {
                                return;
                            }


                            const option =
                                checkbox.closest(
                                    '.multi-option'
                                );


                            if (!option) {
                                return;
                            }


                            const strong =
                                option.querySelector(
                                    '.option-text strong'
                                );


                            if (strong) {

                                selectedNames.push(
                                    strong.textContent.trim()
                                );

                            }

                        }
                    );


                    if (
                        selectedNames.length ===
                        0
                    ) {

                        label.textContent =
                            isEvents
                                ? 'Select Events'
                                : 'Select Organization Units';


                        button.classList.remove(
                            'has-selection'
                        );


                        return;
                    }


                    if (
                        selectedNames.length ===
                        1
                    ) {

                        label.textContent =
                            selectedNames[0];

                    } else {

                        label.textContent =
                            selectedNames.length +
                            (
                                isEvents
                                    ? ' events selected'
                                    : ' units selected'
                            );

                    }


                    button.classList.add(
                        'has-selection'
                    );

                }


                button.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();


                        dropdowns.forEach(
                            function (other) {

                                if (
                                    other !==
                                    dropdown
                                ) {

                                    other.classList.remove(
                                        'open'
                                    );

                                }

                            }
                        );


                        dropdown.classList.toggle(
                            'open'
                        );

                    }
                );


                checkboxes.forEach(
                    function (checkbox) {

                        checkbox.addEventListener(
                            'change',
                            updateDropdownLabel
                        );

                    }
                );


                updateDropdownLabel();

            }
        );


        /* =================================================
           CLOSE DROPDOWNS ON OUTSIDE CLICK
           ================================================= */

        document.addEventListener(
            'click',
            function () {

                dropdowns.forEach(
                    function (dropdown) {

                        dropdown.classList.remove(
                            'open'
                        );

                    }
                );

            }
        );


        /* =================================================
           STAFF PERMISSIONS
           ================================================= */

        const selectAll =
            document.getElementById(
                'selectAllPermissions'
            );


        const clearAll =
            document.getElementById(
                'clearAllPermissions'
            );


        const permissionCheckboxes =
            document.querySelectorAll(
                '.permission-checkbox'
            );


        const permissionCount =
            document.getElementById(
                'permissionCount'
            );


        function updatePermissionState() {


            let checkedCount = 0;


            permissionCheckboxes.forEach(
                function (checkbox) {


                    const card =
                        checkbox.closest(
                            '.permission-card'
                        );


                    if (checkbox.checked) {

                        checkedCount++;

                        if (card) {

                            card.classList.add(
                                'selected'
                            );

                        }

                    } else {

                        if (card) {

                            card.classList.remove(
                                'selected'
                            );

                        }

                    }

                }
            );


            permissionCount.textContent =
                checkedCount +
                ' permission' +
                (
                    checkedCount === 1
                        ? ''
                        : 's'
                ) +
                ' selected';


            selectAll.checked =
                permissionCheckboxes.length >
                    0 &&
                checkedCount ===
                    permissionCheckboxes.length;


            selectAll.indeterminate =
                checkedCount > 0 &&
                checkedCount <
                    permissionCheckboxes.length;

        }


        /* =================================================
           SELECT ALL
           ================================================= */

        selectAll.addEventListener(
            'change',
            function () {


                permissionCheckboxes.forEach(
                    function (checkbox) {

                        checkbox.checked =
                            selectAll.checked;

                    }
                );


                updatePermissionState();

            }
        );


        /* =================================================
           INDIVIDUAL PERMISSION
           ================================================= */

        permissionCheckboxes.forEach(
            function (checkbox) {

                checkbox.addEventListener(
                    'change',
                    updatePermissionState
                );

            }
        );


        /* =================================================
           CLEAR ALL
           ================================================= */

        clearAll.addEventListener(
            'click',
            function () {


                permissionCheckboxes.forEach(
                    function (checkbox) {

                        checkbox.checked =
                            false;

                    }
                );


                selectAll.checked =
                    false;


                selectAll.indeterminate =
                    false;


                updatePermissionState();

            }
        );


        /* =================================================
           INITIAL PERMISSION STATE
           ================================================= */

        updatePermissionState();

    }
);

</script>