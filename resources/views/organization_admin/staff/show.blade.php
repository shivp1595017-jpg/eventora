@include('organization_admin.sidebar')

<div class="staff-profile-page">

    <div class="staff-profile-container">

        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="profile-header">

            <div>

                <div class="breadcrumb">
                    Organization Admin / Staff & Access / Profile
                </div>

                <h1>
                    Staff Profile
                </h1>

                <p>
                    View staff account information, organization access
                    and security details.
                </p>

            </div>


            <div class="header-actions">

                <a
                    href="{{ route('organization.admin.staff.index') }}"
                    class="back-btn"
                >
                    ← Back to Staff
                </a>

            </div>

        </div>



        <!-- =====================================================
             PROFILE TOP CARD
        ====================================================== -->

        <section class="profile-main-card">

            <div class="profile-main-left">

                <div class="staff-avatar">

                    {{ strtoupper(
                        substr(
                            $staff->name,
                            0,
                            1
                        )
                    ) }}

                </div>


                <div class="profile-main-info">

                    <h2>
                        {{ $staff->name }}
                    </h2>


                    <div class="role-badge">
                        {{ $staff->role }}
                    </div>


                    <p>
                        {{ $staff->organization->name ?? 'Organization' }}
                    </p>

                </div>

            </div>


            <div class="status-wrapper">

                @if($staff->status === 'active')

                    <span class="status-badge active">
                        ● Active
                    </span>

                @else

                    <span class="status-badge inactive">
                        ● Inactive
                    </span>

                @endif

            </div>

        </section>



        <!-- =====================================================
             STAFF INFORMATION
        ====================================================== -->

        <section class="info-card">

            <div class="section-heading">

                <div class="section-icon">
                    👤
                </div>

                <div>

                    <h2>
                        Staff Information
                    </h2>

                    <p>
                        Basic information about this staff member.
                    </p>

                </div>

            </div>


            <div class="info-grid">


                <div class="info-item">

                    <span class="info-label">
                        Name
                    </span>

                    <strong class="info-value">
                        {{ $staff->name }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Role
                    </span>

                    <strong class="info-value">
                        {{ $staff->role }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Login Email
                    </span>

                    <strong class="info-value email-value">
                        {{ $staff->user->email ?? $staff->email }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Mobile
                    </span>

                    <strong class="info-value">
                        {{ $staff->mobile ?: 'Not provided' }}
                    </strong>

                </div>


                <div class="info-item full-width">

                    <span class="info-label">
                        Organization
                    </span>

                    <strong class="info-value">
                        {{ $staff->organization->name ?? 'Not available' }}
                    </strong>

                </div>

            </div>

        </section>



        <!-- =====================================================
             ORGANIZATION UNITS
        ====================================================== -->

        <section class="info-card">

            <div class="section-heading">

                <div class="section-icon">
                    🏢
                </div>

                <div>

                    <h2>
                        Organization Units
                    </h2>

                    <p>
                        Units assigned to this staff member.
                    </p>

                </div>

            </div>


            @if($staff->organizationUnits->count())

                <div class="tag-list">

                    @foreach($staff->organizationUnits as $unit)

                        <div class="assignment-tag">

                            <span class="tag-icon">
                                🏢
                            </span>

                            <span>
                                {{ $unit->name }}
                            </span>

                        </div>

                    @endforeach

                </div>

            @elseif($staff->organizationUnit)

                <div class="tag-list">

                    <div class="assignment-tag">

                        <span class="tag-icon">
                            🏢
                        </span>

                        <span>
                            {{ $staff->organizationUnit->name }}
                        </span>

                    </div>

                </div>

            @else

                <div class="empty-box">
                    No organization units assigned.
                </div>

            @endif

        </section>



        <!-- =====================================================
             ASSIGNED EVENTS
        ====================================================== -->

        <section class="info-card">

            <div class="section-heading">

                <div class="section-icon">
                    📅
                </div>

                <div>

                    <h2>
                        Assigned Events
                    </h2>

                    <p>
                        Events assigned to this staff member.
                    </p>

                </div>

            </div>


            @if($staff->events->count())

                <div class="event-list">

                    @foreach($staff->events as $event)

                        <div class="event-item">

                            <div class="event-item-icon">
                                🎫
                            </div>


                            <div class="event-item-content">

                                <strong>
                                    {{ $event->title }}
                                </strong>


                                <div class="event-meta">

                                    @if($event->event_date)

                                        <span>
                                            📅
                                            {{ \Illuminate\Support\Carbon::parse($event->event_date)->format('d M Y') }}
                                        </span>

                                    @endif


                                    @if($event->event_time)

                                        <span>
                                            🕒
                                            {{ \Illuminate\Support\Carbon::parse($event->event_time)->format('h:i A') }}
                                        </span>

                                    @endif


                                    @if($event->venue)

                                        <span>
                                            📍
                                            {{ $event->venue }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty-box">
                    No events assigned to this staff member.
                </div>

            @endif

        </section>



        <!-- =====================================================
             ADDED BY
        ====================================================== -->

        <section class="info-card">

            <div class="section-heading">

                <div class="section-icon">
                    ➕
                </div>

                <div>

                    <h2>
                        Staff Added By
                    </h2>

                    <p>
                        Information about the user who created this staff account.
                    </p>

                </div>

            </div>


            @if($staff->createdBy)

                <div class="added-by-card">

                    <div class="added-avatar">

                        {{ strtoupper(
                            substr(
                                $staff->createdBy->name,
                                0,
                                1
                            )
                        ) }}

                    </div>


                    <div class="added-info">

                        <strong>
                            {{ $staff->createdBy->name }}
                        </strong>


                        <span>
                            Organization Admin
                        </span>


                        <small>
                            {{ $staff->createdBy->email }}
                        </small>

                    </div>


                    <div class="added-date">

                        <span>
                            Added Date
                        </span>

                        <strong>
                            {{ $staff->created_at
                                ? $staff->created_at->format('d M Y')
                                : 'Not available'
                            }}
                        </strong>

                    </div>

                </div>

            @else

                <div class="empty-box">
                    Added By information is not available for this staff record.
                </div>

            @endif

        </section>



        <!-- =====================================================
             SECURITY
        ====================================================== -->

        <section class="info-card security-card">

            <div class="section-heading">

                <div class="section-icon security-icon">
                    🔐
                </div>

                <div>

                    <h2>
                        Account Security
                    </h2>

                    <p>
                        Manage this account's password security.
                    </p>

                </div>

            </div>


            <div class="security-actions">


                <!-- =================================================
                     CHANGE PASSWORD
                ================================================== -->

                <a
                    href="{{ route('organization.admin.password.change') }}"
                    class="security-action primary-action"
                >

                    <div class="security-action-icon">
                        🔐
                    </div>


                    <div>

                        <strong>
                            Change Password
                        </strong>

                        <small>
                            Change your current password using
                            the existing password.
                        </small>

                    </div>


                    <span class="action-arrow">
                        →
                    </span>

                </a>



                <!-- =================================================
                     FORGOT PASSWORD
                ================================================== -->

                <a
                    href="{{ route('organization.admin.password.forgot') }}"
                    class="security-action secondary-action"
                >

                    <div class="security-action-icon">
                        📧
                    </div>


                    <div>

                        <strong>
                            Forgot Password
                        </strong>

                        <small>
                            Send an OTP directly to the registered
                            login email and reset the password.
                        </small>

                    </div>


                    <span class="action-arrow">
                        →
                    </span>

                </a>

            </div>

        </section>



        <!-- =====================================================
             BOTTOM ACTIONS
        ====================================================== -->

        <div class="bottom-actions">

            <a
                href="{{ route(
                    'organization.admin.staff.edit',
                    $staff->id
                ) }}"
                class="edit-btn"
            >
                ✏️ Edit Staff
            </a>


            <a
                href="{{ route(
                    'organization.admin.staff.index'
                ) }}"
                class="back-bottom-btn"
            >
                ← Staff List
            </a>

        </div>

    </div>

</div>


<style>

/* ============================================================
   BASE
============================================================ */

* {
    box-sizing: border-box;
}


body {
    margin: 0;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background: #f5f7fb;
}


/* ============================================================
   PAGE
============================================================ */

.staff-profile-page {

    margin-left: 260px;

    min-height: 100vh;

    padding: 35px;

    background: #f5f7fb;

}


.staff-profile-container {

    width: min(
        1100px,
        100%
    );

    margin: auto;

}


/* ============================================================
   HEADER
============================================================ */

.profile-header {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;

}


.breadcrumb {

    margin-bottom: 8px;

    color: #7b8494;

    font-size: 12px;

}


.profile-header h1 {

    margin: 0 0 7px;

    color: #172033;

    font-size: 30px;

    font-weight: 800;

}


.profile-header p {

    margin: 0;

    color: #7a8495;

    font-size: 14px;

}


.header-actions {

    display: flex;

    gap: 10px;

}


.back-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 42px;

    padding: 0 16px;

    border: 1px solid #d8dee8;

    border-radius: 10px;

    background: #ffffff;

    color: #344054;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    transition: .2s;

}


.back-btn:hover {

    border-color: #5979e8;

    color: #3158d8;

    background: #f8faff;

}


/* ============================================================
   MAIN PROFILE CARD
============================================================ */

.profile-main-card {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding: 27px;

    margin-bottom: 22px;

    border: 1px solid #e1e6ee;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #fafbff
        );

    box-shadow:
        0 8px 28px rgba(16,24,40,.05);

}


.profile-main-left {

    display: flex;

    align-items: center;

    gap: 18px;

    min-width: 0;

}


.staff-avatar {

    width: 70px;

    height: 70px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #6c63ff,
            #8b5cf6
        );

    color: #ffffff;

    font-size: 26px;

    font-weight: 800;

    box-shadow:
        0 10px 26px rgba(108,99,255,.23);

}


.profile-main-info {

    min-width: 0;

}


.profile-main-info h2 {

    margin: 0 0 7px;

    color: #172033;

    font-size: 23px;

    font-weight: 800;

    word-break: break-word;

}


.profile-main-info p {

    margin: 9px 0 0;

    color: #7a8495;

    font-size: 13px;

}


.role-badge {

    display: inline-flex;

    align-items: center;

    padding: 6px 10px;

    border-radius: 999px;

    background: #eef3ff;

    border: 1px solid #d7e0ff;

    color: #3158d8;

    font-size: 11px;

    font-weight: 800;

}


.status-wrapper {

    flex-shrink: 0;

}


.status-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 8px 12px;

    border-radius: 999px;

    font-size: 12px;

    font-weight: 700;

}


.status-badge.active {

    background: #ecfdf3;

    border: 1px solid #b7ebca;

    color: #027a48;

}


.status-badge.inactive {

    background: #fff1f1;

    border: 1px solid #ffd0d0;

    color: #b42318;

}


/* ============================================================
   INFO CARD
============================================================ */

.info-card {

    padding: 25px;

    margin-bottom: 20px;

    border: 1px solid #e1e6ee;

    border-radius: 18px;

    background: #ffffff;

    box-shadow:
        0 7px 25px rgba(16,24,40,.04);

}


.section-heading {

    display: flex;

    align-items: center;

    gap: 13px;

    padding-bottom: 20px;

    margin-bottom: 20px;

    border-bottom: 1px solid #edf0f5;

}


.section-icon {

    width: 46px;

    height: 46px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #eef3ff;

    font-size: 21px;

}


.section-heading h2 {

    margin: 0 0 4px;

    color: #172033;

    font-size: 18px;

    font-weight: 800;

}


.section-heading p {

    margin: 0;

    color: #7b8494;

    font-size: 12px;

}


/* ============================================================
   INFORMATION GRID
============================================================ */

.info-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 18px;

}


.info-item {

    padding: 15px;

    border: 1px solid #edf0f5;

    border-radius: 12px;

    background: #fafbfc;

}


.info-item.full-width {

    grid-column: 1 / -1;

}


.info-label {

    display: block;

    margin-bottom: 7px;

    color: #7b8494;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .4px;

}


.info-value {

    color: #172033;

    font-size: 14px;

    font-weight: 700;

}


.email-value {

    word-break: break-word;

}


/* ============================================================
   TAGS
============================================================ */

.tag-list {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

}


.assignment-tag {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 9px 12px;

    border-radius: 10px;

    background: #f5f8ff;

    border: 1px solid #dbe4ff;

    color: #344054;

    font-size: 13px;

    font-weight: 700;

}


.tag-icon {

    font-size: 15px;

}


/* ============================================================
   EVENTS
============================================================ */

.event-list {

    display: grid;

    gap: 11px;

}


.event-item {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 14px;

    border: 1px solid #edf0f5;

    border-radius: 12px;

    background: #fafbfc;

    transition: .2s;

}


.event-item:hover {

    border-color: #d4dcf8;

    background: #fbfcff;

}


.event-item-icon {

    width: 40px;

    height: 40px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #eef3ff;

    font-size: 18px;

}


.event-item-content {

    min-width: 0;

    flex: 1;

}


.event-item-content strong {

    display: block;

    margin-bottom: 7px;

    color: #172033;

    font-size: 14px;

    word-break: break-word;

}


.event-meta {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

    color: #7b8494;

    font-size: 11px;

}


/* ============================================================
   EMPTY
============================================================ */

.empty-box {

    padding: 18px;

    border: 1px dashed #d9dee8;

    border-radius: 12px;

    text-align: center;

    background: #fafbfc;

    color: #7b8494;

    font-size: 13px;

}


/* ============================================================
   ADDED BY
============================================================ */

.added-by-card {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 16px;

    border: 1px solid #e6eaf1;

    border-radius: 14px;

    background: #fafbfc;

}


.added-avatar {

    width: 50px;

    height: 50px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #4567dd,
            #6c63ff
        );

    color: #ffffff;

    font-size: 18px;

    font-weight: 800;

}


.added-info {

    min-width: 0;

    flex: 1;

}


.added-info strong {

    display: block;

    margin-bottom: 3px;

    color: #172033;

    font-size: 14px;

}


.added-info span {

    display: block;

    margin-bottom: 3px;

    color: #3158d8;

    font-size: 11px;

    font-weight: 700;

}


.added-info small {

    display: block;

    color: #7b8494;

    font-size: 11px;

    word-break: break-word;

}


.added-date {

    min-width: 120px;

    text-align: right;

}


.added-date span {

    display: block;

    margin-bottom: 4px;

    color: #8a94a6;

    font-size: 10px;

    text-transform: uppercase;

}


.added-date strong {

    color: #344054;

    font-size: 12px;

}


/* ============================================================
   SECURITY
============================================================ */

.security-icon {

    background: #f4efff;

}


.security-actions {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;

}


.security-action {

    position: relative;

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 16px;

    border-radius: 13px;

    text-decoration: none;

    transition: .2s;

}


.primary-action {

    background: #f5f8ff;

    border: 1px solid #dbe4ff;

}


.secondary-action {

    background: #fafbfc;

    border: 1px solid #e5e9ef;

}


.security-action:hover {

    transform: translateY(-2px);

}


.primary-action:hover {

    border-color: #9fb1ee;

    background: #f0f4ff;

}


.secondary-action:hover {

    border-color: #bfc7d5;

    background: #f8f9fb;

}


.security-action-icon {

    width: 40px;

    height: 40px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #ffffff;

    font-size: 18px;

}


.security-action strong {

    display: block;

    margin-bottom: 4px;

    color: #172033;

    font-size: 14px;

}


.security-action small {

    display: block;

    max-width: 330px;

    color: #7b8494;

    font-size: 11px;

    line-height: 1.45;

}


.action-arrow {

    margin-left: auto;

    color: #667085;

    font-size: 18px;

    flex-shrink: 0;

}


/* ============================================================
   BOTTOM ACTIONS
============================================================ */

.bottom-actions {

    display: flex;

    justify-content: flex-end;

    gap: 10px;

    padding: 5px 0 25px;

}


.edit-btn,
.back-bottom-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 44px;

    padding: 0 17px;

    border-radius: 10px;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    transition: .2s;

}


.edit-btn {

    background: #4567dd;

    color: #ffffff;

}


.edit-btn:hover {

    background: #3657c8;

    transform: translateY(-1px);

}


.back-bottom-btn {

    background: #ffffff;

    border: 1px solid #d8dee8;

    color: #475467;

}


.back-bottom-btn:hover {

    border-color: #9fb1ee;

    color: #3158d8;

}


/* ============================================================
   RESPONSIVE
============================================================ */

@media (max-width: 1050px) {

    .staff-profile-page {

        margin-left: 0;

        padding: 24px;

    }

}


@media (max-width: 800px) {

    .profile-header {

        flex-direction: column;

    }


    .header-actions {

        width: 100%;

    }


    .back-btn {

        width: 100%;

    }


    .profile-main-card {

        align-items: flex-start;

        flex-direction: column;

    }


    .status-wrapper {

        width: 100%;

    }


    .security-actions {

        grid-template-columns: 1fr;

    }

}


@media (max-width: 600px) {

    .staff-profile-page {

        padding: 18px;

    }


    .profile-header h1 {

        font-size: 26px;

    }


    .profile-main-card {

        padding: 21px;

    }


    .profile-main-left {

        align-items: flex-start;

    }


    .staff-avatar {

        width: 58px;

        height: 58px;

        font-size: 22px;

    }


    .profile-main-info h2 {

        font-size: 19px;

    }


    .info-card {

        padding: 20px;

    }


    .info-grid {

        grid-template-columns: 1fr;

    }


    .info-item.full-width {

        grid-column: auto;

    }


    .added-by-card {

        align-items: flex-start;

        flex-wrap: wrap;

    }


    .added-date {

        width: 100%;

        min-width: auto;

        text-align: left;

        padding-left: 64px;

    }


    .bottom-actions {

        flex-direction: column;

    }


    .edit-btn,
    .back-bottom-btn {

        width: 100%;

    }

}

</style>