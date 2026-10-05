<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Organization Profile - Eventora
    </title>

    <style>

        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f4f6fb;

            color: #172033;
        }


        /* =========================================
           MAIN
        ========================================== */

        .admin-main {

            margin-left: 260px;

            min-height: 100vh;

            padding: 30px;

        }


        /* =========================================
           MOBILE HEADER
        ========================================== */

        .mobile-header {

            display: none;

            height: 58px;

            background: white;

            align-items: center;

            gap: 15px;

            padding: 0 16px;

            margin-bottom: 22px;

            border-radius: 14px;

            box-shadow:
                0 5px 20px rgba(
                    0,
                    0,
                    0,
                    .05
                );

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
           TOPBAR
        ========================================== */

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

        }


        .topbar-left p {

            margin: 0;

            color: #667085;

            font-size: 14px;

        }


        .topbar-actions {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .admin-badge {

            background: white;

            padding: 11px 16px;

            border-radius: 12px;

            box-shadow:
                0 5px 20px rgba(
                    0,
                    0,
                    0,
                    .05
                );

            font-size: 13px;

            font-weight: 700;

        }


        .dashboard-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            min-height: 42px;

            padding: 0 15px;

            background: #ffffff;

            border: 1px solid #dce2ec;

            border-radius: 10px;

            color: #344054;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            transition: .2s;

        }


        .dashboard-btn:hover {

            border-color: #6366f1;

            color: #4f46e5;

            background: #f8f8ff;

            transform: translateY(-1px);

        }


        /* =========================================
           SUCCESS
        ========================================== */

        .success-message {

            margin-bottom: 20px;

            padding: 14px 17px;

            border-radius: 12px;

            background: #ecfdf3;

            border: 1px solid #abefc6;

            color: #027a48;

            font-size: 14px;

            font-weight: 600;

        }


        /* =========================================
           ERROR
        ========================================== */

        .error-message {

            margin-bottom: 20px;

            padding: 14px 17px;

            border-radius: 12px;

            background: #fff1f1;

            border: 1px solid #ffd0d0;

            color: #b42318;

            font-size: 13px;

            line-height: 1.55;

        }


        /* =========================================
           PROFILE HERO
        ========================================== */

        .profile-hero {

            position: relative;

            overflow: hidden;

            min-height: 270px;

            border-radius: 22px;

            margin-bottom: 25px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #4f46e5
                );

            box-shadow:
                0 15px 35px
                rgba(
                    79,
                    70,
                    229,
                    .20
                );

        }


        .cover-image {

            position: absolute;

            inset: 0;

            width: 100%;

            height: 100%;

            object-fit: cover;

        }


        .hero-overlay {

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(
                        17,
                        24,
                        39,
                        .78
                    ),
                    rgba(
                        79,
                        70,
                        229,
                        .20
                    )
                );

        }


        .hero-content {

            position: absolute;

            left: 30px;

            right: 30px;

            bottom: 28px;

            display: flex;

            align-items: center;

            gap: 20px;

            color: white;

        }


        .logo-box {

            width: 132px;

            height: 132px;

            padding: 5px;

            flex-shrink: 0;

            background: white;

            border-radius: 20px;

            box-shadow:
                0 8px 25px
                rgba(
                    0,
                    0,
                    0,
                    .22
                );

        }


        .logo-box img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            border-radius: 15px;

        }

        .admin-profile-avatar {
            position: relative;
            display: grid;
            width: 104px;
            height: 104px;
            flex: 0 0 104px;
            place-items: center;
            overflow: hidden;
            border: 3px solid #fff;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            color: white;
            font-size: 38px;
            font-weight: 800;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .18);
        }

        .admin-profile-avatar img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
        }

        .admin-account-profile {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 18px;
            margin: 18px 0 20px;
            padding: 18px;
            border: 1px solid #e7e8f3;
            border-radius: 14px;
            background: #fff;
        }

        .admin-account-profile strong,
        .admin-account-profile span {
            display: block;
        }

        .admin-account-profile strong {
            margin-bottom: 5px;
            color: #172033;
            font-size: 18px;
        }

        .admin-account-profile span {
            color: #667085;
            font-size: 13px;
            overflow-wrap: anywhere;
        }


        .logo-placeholder {

            width: 100%;

            height: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 15px;

            background: #111827;

            color: white;

            font-size: 38px;

            font-weight: 800;

        }


        .hero-info h2 {

            margin: 0 0 8px;

            font-size: 29px;

        }


        .hero-info p {

            margin: 0;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .88
                );

            font-size: 14px;

        }


        /* =========================================
           HERO BUTTONS
        ========================================== */

        .hero-buttons {

            display: flex;

            flex-wrap: wrap;

            gap: 9px;

            margin-top: 18px;

        }


        .edit-profile-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 11px 18px;

            border-radius: 10px;

            background: white;

            color: #4f46e5;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            transition: .2s;

        }


        .edit-profile-btn:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 20px
                rgba(
                    0,
                    0,
                    0,
                    .15
                );

        }


        /* =========================================
           INFORMATION CARD
        ========================================== */

        .profile-card {

            background: white;

            border-radius: 20px;

            padding: 26px;

            margin-bottom: 25px;

            box-shadow:
                0 7px 25px
                rgba(
                    0,
                    0,
                    0,
                    .05
                );

        }


        .card-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 20px;

        }


        .card-header-left {

            display: flex;

            align-items: center;

            gap: 13px;

        }


        .card-icon {

            width: 46px;

            height: 46px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            background: #f0edff;

            font-size: 21px;

            flex-shrink: 0;

        }


        .card-header h2 {

            margin: 0 0 4px;

            font-size: 21px;

        }


        .card-header p {

            margin: 0;

            color: #7b8494;

            font-size: 12px;

        }


        .info-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 15px;

        }


        .info-item {

            padding: 17px;

            background: #f8f9fc;

            border-radius: 13px;

            border: 1px solid #edf0f5;

        }


        .info-item.full {

            grid-column: 1 / -1;

        }


        .info-item small {

            display: block;

            color: #98a2b3;

            font-size: 11px;

            margin-bottom: 7px;

            text-transform: uppercase;

            letter-spacing: .4px;

        }


        .info-item strong {

            display: block;

            font-size: 14px;

            color: #172033;

            word-break: break-word;

        }


        .description {

            line-height: 1.6;

            color: #475467 !important;

            font-weight: normal !important;

        }


        /* =========================================
           STATUS
        ========================================== */

        .status-badge {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 6px 12px;

            border-radius: 20px;

            background: #ecfdf3;

            color: #027a48;

            font-size: 12px;

            font-weight: 700;

        }


        .status-pending {

            background: #fffaeb;

            color: #b54708;

        }


        .status-rejected {

            background: #fff1f1;

            color: #b42318;

        }


        /* =========================================
           NOT PROVIDED
        ========================================== */

        .not-provided {

            color: #98a2b3 !important;

            font-weight: normal !important;

        }


        /* =========================================
           ADMIN ACCOUNT
        ========================================== */

        .admin-account-card {

            background:
                linear-gradient(
                    135deg,
                    #fbfaff,
                    #f8f9ff
                );

        }


        .admin-account-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    3,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 15px;

        }


        .admin-account-item {

            padding: 17px;

            border-radius: 13px;

            background: #ffffff;

            border: 1px solid #e7e8f3;

        }


        .admin-account-item small {

            display: block;

            margin-bottom: 7px;

            color: #98a2b3;

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .5px;

        }


        .admin-account-item strong {

            display: block;

            color: #172033;

            font-size: 13px;

            word-break: break-word;

        }


        .admin-role {

            color: #4f46e5 !important;

        }


        /* =========================================
           SECURITY
        ========================================== */

        .security-actions {

            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 15px;

        }


        .security-action {

            display: flex;

            align-items: center;

            gap: 13px;

            padding: 17px;

            border-radius: 14px;

            text-decoration: none;

            transition: .2s;

        }


        .change-password-action {

            background: #f5f8ff;

            border: 1px solid #dbe4ff;

        }


        .forgot-password-action {

            background: #fafbfc;

            border: 1px solid #e5e9ef;

        }


        .security-action:hover {

            transform:
                translateY(-2px);

        }


        .change-password-action:hover {

            border-color: #9fb1ee;

            background: #f0f4ff;

        }


        .forgot-password-action:hover {

            border-color: #c3cad6;

            background: #f8f9fb;

        }


        .security-action-icon {

            width: 44px;

            height: 44px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border-radius: 11px;

            background: #ffffff;

            font-size: 20px;

        }


        .security-action strong {

            display: block;

            margin-bottom: 4px;

            color: #172033;

            font-size: 14px;

        }


        .security-action span {

            display: block;

            color: #7b8494;

            font-size: 11px;

            line-height: 1.5;

        }


        .security-arrow {

            margin-left: auto;

            color: #667085;

            font-size: 18px;

            flex-shrink: 0;

        }


        /* =========================================
           BOTTOM ACTIONS
        ========================================== */

        .bottom-actions {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 5px;

            padding-bottom: 25px;

        }


        .bottom-btn {

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


        .edit-bottom-btn {

            background: #6366f1;

            color: #ffffff;

        }


        .edit-bottom-btn:hover {

            background: #4f46e5;

            transform:
                translateY(-1px);

        }


        .back-bottom-btn {

            background: #ffffff;

            border: 1px solid #dce2ec;

            color: #475467;

        }


        .back-bottom-btn:hover {

            border-color: #6366f1;

            color: #4f46e5;

        }


        /* =========================================
           RESPONSIVE
        ========================================== */

        @media (max-width: 1000px) {

            .admin-account-grid {

                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );

            }

        }


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


            .topbar-actions {

                width: 100%;

                flex-direction: column;

                align-items: stretch;

            }


            .admin-badge,
            .dashboard-btn {

                width: 100%;

                text-align: center;

            }


            .profile-hero {

                min-height: 350px;

                border-radius: 18px;

            }


            .hero-content {

                left: 20px;

                right: 20px;

                bottom: 22px;

                align-items: flex-start;

                flex-direction: column;

            }


            .logo-box {

                width: 92px;

                height: 92px;

            }

            .admin-profile-avatar {
                width: 88px;
                height: 88px;
                flex-basis: 88px;
            }


            .hero-info h2 {

                font-size: 23px;

            }


            .info-grid {

                grid-template-columns: 1fr;

            }


            .info-item.full {

                grid-column: auto;

            }


            .admin-account-grid {

                grid-template-columns: 1fr;

            }


            .security-actions {

                grid-template-columns: 1fr;

            }


            .profile-card {

                padding: 20px;

            }

        }


        @media (max-width: 480px) {

            .admin-main {

                padding: 12px;

            }


            .profile-card {

                padding: 18px;

            }


            .profile-hero {

                min-height: 340px;

            }


            .hero-info h2 {

                font-size: 21px;

            }


            .hero-buttons {

                width: 100%;

            }


            .edit-profile-btn {

                width: 100%;

            }


            .bottom-actions {

                flex-direction: column;

            }


            .bottom-btn {

                width: 100%;

            }

        }

    </style>

</head>


<body>


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    @include('organization_admin.sidebar')


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="admin-main">


        {{-- =================================================
             MOBILE HEADER
        ================================================== --}}

        <div class="mobile-header">

            <button
                type="button"
                class="mobile-menu-button"
                onclick="openAdminSidebar()"
            >
                ☰
            </button>

            <strong>
                Eventora
            </strong>

        </div>


        {{-- =================================================
             TOPBAR
        ================================================== --}}

        <div class="topbar">

            <div class="topbar-left">

                <h1>
                    Organization Profile
                </h1>

                <p>
                    Manage your organization and admin account information.
                </p>

            </div>


            <div class="topbar-actions">

                <a
                    href="{{ route('organization.admin.dashboard') }}"
                    class="dashboard-btn"
                >
                    🏠 Dashboard
                </a>


                <div class="admin-badge">
                    👤 Organization Admin
                </div>

            </div>

        </div>


        {{-- =================================================
             SUCCESS MESSAGE
        ================================================== --}}

        @if(session('success'))

            <div class="success-message">

                ✓ {{ session('success') }}

            </div>

        @endif


        {{-- =================================================
             ERROR MESSAGE
        ================================================== --}}

        @if($errors->any())

            <div class="error-message">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- =================================================
             PROFILE HERO
        ================================================== --}}

        <section class="profile-hero">


            @if($organization->cover_image)

                <img
                    src="{{ asset(
                        'storage/' .
                        $organization->cover_image
                    ) }}"
                    class="cover-image"
                    alt="Organization Cover"
                >

            @endif


            <div class="hero-overlay"></div>


            <div class="hero-content">


                <div class="logo-box">

                    @if($organization->logo)

                        <img
                            src="{{ asset(
                                'storage/' .
                                $organization->logo
                            ) }}"
                            alt="{{ $organization->name }} Logo"
                        >

                    @else

                        <div class="logo-placeholder">

                            {{
                                strtoupper(
                                    substr(
                                        $organization->name,
                                        0,
                                        1
                                    )
                                )
                            }}

                        </div>

                    @endif

                </div>


                <div class="hero-info">

                    <h2>
                        {{ $organization->name }}
                    </h2>


                    <p>

                        🏷️ {{ $organization->type }}

                        @if($organization->city)

                            &nbsp; • &nbsp;

                            📍 {{ $organization->city }}

                        @endif

                    </p>


                    <div class="hero-buttons">

                        <a
                            href="{{ route(
                                'organization.admin.profile.edit'
                            ) }}"
                            class="edit-profile-btn"
                        >
                            ✏️ Edit Profile
                        </a>

                    </div>

                </div>


            </div>


        </section>


        {{-- =================================================
             ADMIN ACCOUNT
        ================================================== --}}

        <section class="profile-card admin-account-card">


            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-icon">
                        👤
                    </div>

                    <div>

                        <h2>
                            Admin Account
                        </h2>

                        <p>
                            Your Organization Admin login information.
                        </p>

                    </div>

                </div>

            </div>


            <div class="admin-account-grid">

                <div class="admin-account-profile">
                    <div class="admin-profile-avatar">
                        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        @if(auth()->user()->profilePhotoUrl())
                            <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="{{ auth()->user()->name }} profile photo" referrerpolicy="no-referrer" onerror="this.remove()">
                        @endif
                    </div>
                    <div>
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <div class="admin-account-item">

                    <small>
                        Admin Name
                    </small>

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                </div>


                <div class="admin-account-item">

                    <small>
                        Login Email
                    </small>

                    <strong>
                        {{ auth()->user()->email }}
                    </strong>

                </div>


                <div class="admin-account-item">

                    <small>
                        Account Role
                    </small>

                    <strong class="admin-role">
                        Organization Admin
                    </strong>

                </div>

            </div>


        </section>


        {{-- =================================================
             ORGANIZATION INFORMATION
        ================================================== --}}

        <section class="profile-card">


            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-icon">
                        🏢
                    </div>

                    <div>

                        <h2>
                            Organization Information
                        </h2>

                        <p>
                            Information about your organization.
                        </p>

                    </div>

                </div>

            </div>


            <div class="info-grid">


                {{-- ORGANIZATION NAME --}}

                <div class="info-item">

                    <small>
                        Organization Name
                    </small>

                    <strong>
                        {{ $organization->name }}
                    </strong>

                </div>


                {{-- ORGANIZATION TYPE --}}

                <div class="info-item">

                    <small>
                        Organization Type
                    </small>

                    <strong>
                        {{ $organization->type }}
                    </strong>

                </div>


                {{-- ORGANIZATION EMAIL --}}

                <div class="info-item">

                    <small>
                        Organization Email
                    </small>

                    @if($organization->email)

                        <strong>
                            {{ $organization->email }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            Not provided
                        </strong>

                    @endif

                </div>


                {{-- PHONE --}}

                <div class="info-item">

                    <small>
                        Phone
                    </small>

                    @if($organization->phone)

                        <strong>
                            {{ $organization->phone }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            Not provided
                        </strong>

                    @endif

                </div>


                {{-- DESCRIPTION --}}

                <div class="info-item full">

                    <small>
                        Description
                    </small>

                    @if($organization->description)

                        <strong class="description">
                            {{ $organization->description }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            No description provided
                        </strong>

                    @endif

                </div>


                {{-- ADDRESS --}}

                <div class="info-item full">

                    <small>
                        Address
                    </small>

                    @if($organization->address)

                        <strong>
                            {{ $organization->address }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            Not provided
                        </strong>

                    @endif

                </div>


                {{-- CITY --}}

                <div class="info-item">

                    <small>
                        City
                    </small>

                    @if($organization->city)

                        <strong>
                            {{ $organization->city }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            Not provided
                        </strong>

                    @endif

                </div>


                {{-- STATE --}}

                <div class="info-item">

                    <small>
                        State
                    </small>

                    @if($organization->state)

                        <strong>
                            {{ $organization->state }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            Not provided
                        </strong>

                    @endif

                </div>


                {{-- WEBSITE --}}

                <div class="info-item full">

                    <small>
                        Website
                    </small>

                    @if($organization->website)

                        <strong>
                            {{ $organization->website }}
                        </strong>

                    @else

                        <strong class="not-provided">
                            Not provided
                        </strong>

                    @endif

                </div>


                {{-- STATUS --}}

                <div class="info-item">

                    <small>
                        Organization Status
                    </small>

                    <strong>

                        @if($organization->status === 'approved')

                            <span class="status-badge">
                                ● Approved
                            </span>

                        @elseif($organization->status === 'pending')

                            <span class="status-badge status-pending">
                                ● Pending
                            </span>

                        @else

                            <span class="status-badge status-rejected">
                                ● {{ ucfirst(
                                    $organization->status
                                ) }}
                            </span>

                        @endif

                    </strong>

                </div>

            </div>


        </section>


        {{-- =================================================
             SECURITY
        ================================================== --}}

        <section class="profile-card">


            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-icon">
                        🔐
                    </div>

                    <div>

                        <h2>
                            Account Security
                        </h2>

                        <p>
                            Manage your Organization Admin password.
                        </p>

                    </div>

                </div>

            </div>


            <div class="security-actions">


                {{-- CHANGE PASSWORD --}}

                <a
                    href="{{ route(
                        'organization.admin.password.change'
                    ) }}"
                    class="security-action change-password-action"
                >

                    <div class="security-action-icon">
                        🔐
                    </div>


                    <div>

                        <strong>
                            Change Password
                        </strong>

                        <span>
                            Enter your current password, then set a new password.
                        </span>

                    </div>


                    <div class="security-arrow">
                        →
                    </div>

                </a>


                {{-- FORGOT PASSWORD --}}

                <a
                    href="{{ route(
                        'organization.admin.password.forgot'
                    ) }}"
                    class="security-action forgot-password-action"
                >

                    <div class="security-action-icon">
                        📧
                    </div>


                    <div>

                        <strong>
                            Forgot Password
                        </strong>

                        <span>
                            Send OTP directly to your registered login email.
                        </span>

                    </div>


                    <div class="security-arrow">
                        →
                    </div>

                </a>

            </div>


        </section>


        {{-- =================================================
             BOTTOM ACTIONS
        ================================================== --}}

        <div class="bottom-actions">

            <a
                href="{{ route(
                    'organization.admin.profile.edit'
                ) }}"
                class="bottom-btn edit-bottom-btn"
            >
                ✏️ Edit Organization
            </a>


            <a
                href="{{ route(
                    'organization.admin.dashboard'
                ) }}"
                class="bottom-btn back-bottom-btn"
            >
                ← Dashboard
            </a>

        </div>


    </main>


    <script>

        /*
        |--------------------------------------------------------------------------
        | Mobile Sidebar
        |--------------------------------------------------------------------------
        */

        function openAdminSidebar()
        {
            if (
                typeof window.openAdminSidebar ===
                'function'
            ) {

                window.openAdminSidebar();

            }
        }

    </script>

</body>

</html>