<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Organization Admin Dashboard - Eventora</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6fb;
            color: #172033;
        }

        /* =========================================
           MAIN CONTENT
        ========================================= */

        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }


        /* =========================================
           MOBILE HEADER
        ========================================= */

        .mobile-header {
            display: none;

            height: 58px;
            background: white;

            align-items: center;
            gap: 15px;

            padding: 0 16px;
            margin-bottom: 22px;

            border-radius: 14px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .mobile-header strong {
            font-size: 20px;
        }

        .mobile-menu-button {
            width: 40px;
            height: 40px;

            border: none;
            border-radius: 10px;

            background: #6366f1;
            color: white;

            font-size: 21px;

            cursor: pointer;
        }


        /* =========================================
           TOP HEADER
        ========================================= */

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;
        }

        .topbar-left h1 {
            margin: 0 0 7px;

            font-size: 29px;
            line-height: 1.2;
        }

        .topbar-left p {
            margin: 0;

            color: #667085;
            font-size: 14px;
        }

        .admin-badge {
            background: white;

            padding: 11px 16px;

            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);

            font-size: 13px;
            font-weight: 700;

            white-space: nowrap;
        }


        /* =========================================
           ORGANIZATION CARD
        ========================================= */

        .organization-card {
            position: relative;

            overflow: hidden;

            background: linear-gradient(
                135deg,
                #6366f1 0%,
                #4f46e5 100%
            );

            color: white;

            border-radius: 22px;

            padding: 30px;

            margin-bottom: 25px;

            box-shadow:
                0 15px 35px rgba(79, 70, 229, 0.20);
        }

        .organization-card::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.08);

            right: -60px;
            top: -70px;
        }

        .organization-card::before {
            content: "";

            position: absolute;

            width: 120px;
            height: 120px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.05);

            right: 100px;
            bottom: -80px;
        }

        .organization-content {
            position: relative;
            z-index: 2;
        }

        .organization-label {
            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 1px;

            opacity: 0.75;

            margin-bottom: 8px;
        }

        .organization-name {
            margin: 0 0 8px;

            font-size: 28px;

            line-height: 1.2;
        }

        .organization-details {
            display: flex;

            flex-wrap: wrap;

            gap: 10px 20px;

            color: rgba(255, 255, 255, 0.9);

            font-size: 14px;
        }

        .organization-status {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            margin-top: 18px;

            padding: 7px 13px;

            border-radius: 20px;

            background: white;

            color: #4f46e5;

            font-size: 12px;

            font-weight: 700;
        }


        /* =========================================
           STATS
        ========================================= */

        .stats-grid {
            display: grid;

            grid-template-columns: repeat(4, minmax(0, 1fr));

            gap: 18px;

            margin-bottom: 30px;
        }

        .stat-card {
            background: white;

            border-radius: 18px;

            padding: 21px;

            box-shadow:
                0 7px 25px rgba(0, 0, 0, 0.05);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-top {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 16px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #eef2ff;

            font-size: 21px;
        }

        .stat-arrow {
            color: #98a2b3;

            font-size: 15px;
        }

        .stat-card h3 {
            margin: 0;

            font-size: 27px;
        }

        .stat-card p {
            margin: 5px 0 0;

            color: #667085;

            font-size: 13px;
        }


        /* =========================================
           SECTION HEADER
        ========================================= */

        .section-header {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 15px;
        }

        .section-header h2 {
            margin: 0;

            font-size: 21px;
        }

        .view-link {
            color: #6366f1;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;
        }

        .view-link:hover {
            text-decoration: underline;
        }


        /* =========================================
           QUICK ACTIONS
        ========================================= */

        .actions-grid {
            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));

            gap: 18px;

            margin-bottom: 30px;
        }

        .action-card {
            display: block;

            background: white;

            padding: 22px;

            border-radius: 18px;

            text-decoration: none;

            color: #172033;

            box-shadow:
                0 7px 25px rgba(0, 0, 0, 0.05);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .action-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 12px 30px rgba(0, 0, 0, 0.09);
        }

        .action-icon {
            width: 48px;
            height: 48px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #eef2ff;

            border-radius: 13px;

            font-size: 23px;

            margin-bottom: 15px;
        }

        .action-card h3 {
            margin: 0 0 7px;

            font-size: 16px;
        }

        .action-card p {
            margin: 0;

            color: #667085;

            font-size: 13px;

            line-height: 1.5;
        }


        /* =========================================
           ORGANIZATION INFORMATION
        ========================================= */

        .info-card {
            background: white;

            border-radius: 18px;

            padding: 24px;

            box-shadow:
                0 7px 25px rgba(0, 0, 0, 0.05);

            margin-bottom: 30px;
        }

        .info-grid {
            display: grid;

            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 18px;

            margin-top: 18px;
        }

        .info-item {
            padding: 15px;

            background: #f8f9fc;

            border-radius: 12px;
        }

        .info-item small {
            display: block;

            color: #98a2b3;

            font-size: 11px;

            margin-bottom: 5px;
        }

        .info-item strong {
            display: block;

            font-size: 14px;

            word-break: break-word;
        }


        /* =========================================
           EMPTY ORGANIZATION
        ========================================= */

        .empty-card {
            background: white;

            border-radius: 20px;

            padding: 45px 25px;

            text-align: center;

            box-shadow:
                0 7px 25px rgba(0, 0, 0, 0.05);
        }

        .empty-icon {
            font-size: 45px;

            margin-bottom: 15px;
        }

        .empty-card h2 {
            margin: 0 0 8px;
        }

        .empty-card p {
            margin: 0;

            color: #667085;
        }


        /* =========================================
           TABLET
        ========================================= */

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .actions-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 768px) {

            .admin-main {
                margin-left: 0;

                padding: 15px;
            }

            .mobile-header {
                display: flex;
            }

            .topbar {
                align-items: flex-start;

                flex-direction: column;

                margin-bottom: 20px;
            }

            .topbar-left h1 {
                font-size: 24px;
            }

            .admin-badge {
                width: 100%;

                text-align: center;
            }

            .organization-card {
                padding: 23px;

                border-radius: 18px;
            }

            .organization-name {
                font-size: 23px;
            }

            .stats-grid {
                grid-template-columns: 1fr;

                gap: 13px;
            }

            .actions-grid {
                grid-template-columns: 1fr;

                gap: 13px;
            }

            .info-grid {
                grid-template-columns: 1fr;

                gap: 12px;
            }

        }


        /* =========================================
           SMALL MOBILE
        ========================================= */

        @media (max-width: 480px) {

            .admin-main {
                padding: 12px;
            }

            .mobile-header {
                margin-bottom: 17px;
            }

            .topbar-left h1 {
                font-size: 21px;
            }

            .organization-card {
                padding: 20px;
            }

            .organization-name {
                font-size: 21px;
            }

            .organization-details {
                flex-direction: column;

                gap: 6px;
            }

            .stat-card {
                padding: 18px;
            }

            .action-card {
                padding: 19px;
            }

            .info-card {
                padding: 18px;
            }

        }

    </style>

</head>


<body>


    {{-- =========================================
         RESPONSIVE SIDEBAR
    ========================================== --}}

    @include('organization_admin.sidebar')


    {{-- =========================================
         MAIN CONTENT
    ========================================== --}}

    <main class="admin-main">


        {{-- Mobile Header --}}

        <div class="mobile-header">

            <button
                type="button"
                class="mobile-menu-button"
                onclick="openAdminSidebar()"
                aria-label="Open Menu"
            >
                ☰
            </button>

            <strong>
                Eventora
            </strong>

        </div>


        {{-- =========================================
             TOPBAR
        ========================================== --}}

        <div class="topbar">

            <div class="topbar-left">

                <h1>
                    Organization Dashboard
                </h1>

                <p>
                    Welcome back,
                    <strong>{{ auth()->user()->name }}</strong>
                </p>

            </div>


            <div class="admin-badge">
                👤 Organization Admin
            </div>

        </div>


        {{-- =========================================
             ORGANIZATION
        ========================================== --}}

        @if($organization)

            <section class="organization-card">

                <div class="organization-content">

                    <div class="organization-label">
                        Your Organization
                    </div>

                    <h2 class="organization-name">
                        🏢 {{ $organization->name }}
                    </h2>

                    <div class="organization-details">

                        <span>
                            🏷️ {{ $organization->type }}
                        </span>

                        <span>
                            📍 {{ $organization->city ?? 'Location not provided' }}
                        </span>

                        @if($organization->email)
                            <span>
                                ✉️ {{ $organization->email }}
                            </span>
                        @endif

                    </div>

                    <span class="organization-status">
                        ● {{ ucfirst($organization->status) }}
                    </span>

                </div>

            </section>


            {{-- =========================================
                 STATISTICS
            ========================================== --}}

            <div class="stats-grid">


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-icon">
                            🎫
                        </div>

                        <span class="stat-arrow">
                            →
                        </span>

                    </div>

                   <h3>
    {{ $totalEvents }}
</h3>

                    <p>
                        Total Events
                    </p>

                </div>


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-icon">
                            📋
                        </div>

                        <span class="stat-arrow">
                            →
                        </span>

                    </div>

                  <h3>
    {{ $totalBookings }}
</h3>

                    <p>
                        Total Bookings
                    </p>

                </div>


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-icon">
                            👥
                        </div>

                        <span class="stat-arrow">
                            →
                        </span>

                    </div>

                   <h3>
    {{ $totalParticipants }}
</h3>

                    <p>
                        Participants
                    </p>

                </div>


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-icon">
                            💰
                        </div>

                        <span class="stat-arrow">
                            →
                        </span>

                    </div>

                   <h3>
    ₹{{ number_format($totalRevenue, 2) }}
</h3>

                    <p>
                        Total Revenue
                    </p>

                </div>

            </div>


           {{-- =========================================
     QUICK ACTIONS
========================================= --}}

<div class="section-header">

    <h2>
        Quick Actions
    </h2>

    <a
        href="{{ route('organization.admin.events.index') }}"
        class="view-link"
    >
        View All
    </a>

</div>


<div class="actions-grid">


    {{-- CREATE EVENT --}}

    <a
        href="{{ route('organization.admin.events.create') }}"
        class="action-card"
    >

        <div class="action-icon">
            ➕
        </div>

        <h3>
            Create Event
        </h3>

        <p>
            Create and publish a new event for your organization.
        </p>

    </a>


    {{-- MANAGE EVENTS --}}

    <a
        href="{{ route('organization.admin.events.index') }}"
        class="action-card"
    >

        <div class="action-icon">
            🎫
        </div>

        <h3>
            Manage Events
        </h3>

        <p>
            View, edit and manage all your organization's events.
        </p>

    </a>


    {{-- BOOKINGS --}}

    <a
        href="{{ route('organization.admin.bookings.index') }}"
        class="action-card"
    >

        <div class="action-icon">
            📋
        </div>

        <h3>
            View Bookings
        </h3>

        <p>
            Check bookings and registration information.
        </p>

    </a>


    {{-- PARTICIPANTS --}}

    <a
        href="{{ route('organization.admin.participants.index') }}"
        class="action-card"
    >

        <div class="action-icon">
            👥
        </div>

        <h3>
            Participants
        </h3>

        <p>
            View participants registered for your events.
        </p>

    </a>


    {{-- TICKET VERIFICATION --}}

    <a
        href="{{ route('organization.admin.ticket.verification') }}"
        class="action-card"
    >

        <div class="action-icon">
            ✅
        </div>

        <h3>
            Ticket Verification
        </h3>

        <p>
            Search or scan participant tickets and verify them instantly.
        </p>

    </a>


    {{-- ORGANIZATION PROFILE --}}

    <a
        href="{{ route('organization.admin.profile') }}"
        class="action-card"
    >

        <div class="action-icon">
            🏢
        </div>

        <h3>
            Organization Profile
        </h3>

        <p>
            Manage your organization's profile and information.
        </p>

    </a>


    {{-- SETTINGS --}}

    <a
        href="{{ route('organization.admin.settings') }}"
        class="action-card"
    >

        <div class="action-icon">
            ⚙️
        </div>

        <h3>
            Settings
        </h3>

        <p>
            Manage account and organization settings.
        </p>

    </a>


</div>


            {{-- =========================================
                 ORGANIZATION INFORMATION
            ========================================== --}}

            <div class="section-header">

                <h2>
                    Organization Information
                </h2>

            </div>


            <div class="info-card">

                <div class="info-grid">


                    <div class="info-item">

                        <small>
                            Organization Name
                        </small>

                        <strong>
                            {{ $organization->name }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <small>
                            Organization Type
                        </small>

                        <strong>
                            {{ $organization->type }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <small>
                            Email
                        </small>

                        <strong>
                            {{ $organization->email ?? 'Not provided' }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <small>
                            Phone
                        </small>

                        <strong>
                            {{ $organization->phone ?? 'Not provided' }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <small>
                            City
                        </small>

                        <strong>
                            {{ $organization->city ?? 'Not provided' }}
                        </strong>

                    </div>


                    <div class="info-item">

                        <small>
                            Status
                        </small>

                        <strong>
                            {{ ucfirst($organization->status) }}
                        </strong>

                    </div>

                </div>

            </div>


        @else


            {{-- =========================================
                 NO ORGANIZATION
            ========================================== --}}

            <div class="empty-card">

                <div class="empty-icon">
                    🏢
                </div>

                <h2>
                    No Organization Found
                </h2>

                <p>
                    Your account is not currently connected
                    to an organization.
                </p>

            </div>


        @endif


    </main>


</body>

</html>