<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Super Admin - Eventora')</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #070b14;
            --sidebar: #0b1220;
            --card: #0e1524;
            --card2: #111b2d;

            --text: #fff;
            --muted: #94a0b5;
            --border: #202b40;

            --primary: #6c63ff;
            --primary2: #8b5cf6;

            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        html[data-theme="light"] {

            --bg: #f5f7fb;
            --sidebar: #fff;
            --card: #fff;
            --card2: #f7f8fb;

            --text: #172033;
            --muted: #687386;
            --border: #dce2ec;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select {
            font: inherit;
        }

        .admin-shell {
            min-height: 100vh;
            display: flex;
        }

        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {

            width: 245px;

            position: fixed;
            inset: 0 auto 0 0;

            z-index: 100;

            padding: 25px 16px;

            background: var(--sidebar);

            border-right: 1px solid var(--border);

            overflow-y: auto;
            overflow-x: hidden;

            transition:
                width .25s ease,
                transform .25s ease;
        }

        .brand {

            display: block;

            padding: 0 10px 25px;

            font-size: 25px;
            font-weight: 800;
        }

        .brand span {
            color: var(--primary);
        }

        .side-label {

            color: var(--muted);

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 1px;

            padding: 0 10px;

            margin-bottom: 10px;
        }

        .nav {

            display: grid;

            gap: 6px;
        }

        .nav-link {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 11px 12px;

            border-radius: 10px;

            color: var(--muted);

            font-size: 13px;

            font-weight: 700;

            transition: .2s;
        }

        .nav-link:hover {

            background: rgba(108, 99, 255, .10);

            color: var(--text);
        }

        .nav-link.active {

            background: rgba(108, 99, 255, .16);

            color: var(--text);

            border: 1px solid rgba(108, 99, 255, .22);
        }

        .nav-icon {

            width: 25px;

            min-width: 25px;

            text-align: center;

            font-size: 16px;
        }

        .logout-area {

            margin-top: 22px;

            padding-top: 18px;

            border-top: 1px solid var(--border);
        }

        .logout-btn {

            width: 100%;

            border: 1px solid rgba(239, 68, 68, .20);

            background: rgba(239, 68, 68, .07);

            color: #ff8585;

            border-radius: 10px;

            padding: 10px;

            cursor: pointer;

            font-size: 12px;

            font-weight: 800;

            transition: .2s;
        }

        .logout-btn:hover {

            background: rgba(239, 68, 68, .14);
        }

        /* =====================================================
           SIDEBAR MOBILE CONTROLS
        ===================================================== */

        .sidebar-close {
            display: none;

            position: absolute;

            top: 18px;
            right: 14px;

            width: 34px;
            height: 34px;

            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);

            background: var(--card2);

            color: var(--text);

            border-radius: 9px;

            cursor: pointer;

            font-size: 20px;

            line-height: 1;
        }

        .sidebar-overlay {
            display: none;

            position: fixed;

            inset: 0;

            z-index: 90;

            background: rgba(0, 0, 0, .55);

            backdrop-filter: blur(2px);
        }

        .mobile-topbar {
            display: none;
        }

        .menu-btn {

            width: 42px;
            height: 42px;

            border: 1px solid var(--border);

            background: var(--card);

            color: var(--text);

            border-radius: 10px;

            cursor: pointer;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 20px;
        }

        .mobile-brand {

            font-size: 20px;

            font-weight: 800;
        }

        .mobile-brand span {
            color: var(--primary);
        }

        /* =====================================================
           MAIN
        ===================================================== */

        .main {

            margin-left: 245px;

            width: calc(100% - 245px);

            padding: 28px;

            min-width: 0;
        }

        .topbar {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 25px;
        }

        .heading h1 {

            font-size: 29px;

            line-height: 1.2;

            margin-bottom: 6px;
        }

        .heading p {

            color: var(--muted);

            font-size: 13px;
        }

        .admin-user {

            display: flex;

            align-items: center;

            gap: 10px;

            background: var(--card);

            border: 1px solid var(--border);

            border-radius: 12px;

            padding: 8px 11px;
        }

        .avatar {

            width: 38px;
            height: 38px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            color: #fff;

            font-weight: 800;
        }

        .user-name {

            font-size: 12px;

            font-weight: 800;
        }

        .user-role {

            font-size: 10px;

            color: var(--muted);

            text-transform: capitalize;

            margin-top: 2px;
        }

        /* =====================================================
           FLASH
        ===================================================== */

        .flash {

            padding: 13px 15px;

            border-radius: 10px;

            margin-bottom: 18px;

            font-size: 13px;
        }

        .flash.success {

            background: rgba(34, 197, 94, .10);

            color: #69df91;

            border: 1px solid rgba(34, 197, 94, .20);
        }

        .flash.error {

            background: rgba(239, 68, 68, .10);

            color: #ff8e8e;

            border: 1px solid rgba(239, 68, 68, .20);
        }

        /* =====================================================
           CARDS
        ===================================================== */

        .card {

            background: var(--card);

            border: 1px solid var(--border);

            border-radius: 16px;

            overflow: hidden;
        }

        .toolbar {

            padding: 16px;

            border-bottom: 1px solid var(--border);

            display: grid;

            gap: 12px;
        }

        .filter-grid {

            display: grid;

            grid-template-columns: 2fr repeat(4, 1fr);

            gap: 10px;
        }

        .filter-control {

            width: 100%;

            min-height: 40px;

            padding: 9px 11px;

            border-radius: 9px;

            border: 1px solid var(--border);

            background: var(--card2);

            color: var(--text);

            outline: none;
        }

        .filter-control:focus {

            border-color: var(--primary);
        }

        .filter-actions {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 10px;

            flex-wrap: wrap;
        }

        .result-count {

            color: var(--muted);

            font-size: 11px;
        }

        .export-buttons {

            display: flex;

            flex-wrap: wrap;

            gap: 7px;
        }

        .export-btn {

            border: 1px solid var(--border);

            background: var(--card2);

            color: var(--text);

            border-radius: 8px;

            padding: 8px 11px;

            font-size: 11px;

            font-weight: 800;

            cursor: pointer;

            transition: .2s;
        }

        .export-btn:hover {

            border-color: var(--primary);

            color: var(--primary);
        }

        .export-btn.csv {
            color: #60d78a;
        }

        .export-btn.excel {
            color: #76d99b;
        }

        .export-btn.pdf {
            color: #ff8181;
        }

        .export-btn.print {
            color: #a99fff;
        }

        /* =====================================================
           TABLE
        ===================================================== */

        .table-wrap {

            width: 100%;

            overflow-x: auto;

            -webkit-overflow-scrolling: touch;
        }

        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 1050px;
        }

        th {

            background: var(--card2);

            color: var(--muted);

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: .45px;

            text-align: left;

            padding: 12px 13px;

            border-bottom: 1px solid var(--border);

            white-space: nowrap;
        }

        td {

            padding: 13px;

            border-bottom: 1px solid var(--border);

            font-size: 12px;

            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .primary-text {
            font-weight: 800;
        }

        .secondary-text {

            color: var(--muted);

            font-size: 10px;

            margin-top: 3px;
        }

        .status {

            display: inline-flex;

            padding: 5px 8px;

            border-radius: 999px;

            font-size: 9px;

            font-weight: 800;

            text-transform: capitalize;
        }

        .status.approved,
        .status.active,
        .status.paid,
        .status.confirmed {

            background: rgba(34, 197, 94, .12);

            color: #67dc8d;
        }

        .status.pending {

            background: rgba(245, 158, 11, .12);

            color: #f8c55d;
        }

        .status.rejected,
        .status.cancelled,
        .status.failed {

            background: rgba(239, 68, 68, .12);

            color: #ff8585;
        }

        .status.refunded {

            background: rgba(139, 92, 246, .12);

            color: #b59cff;
        }

        .status.other {

            background: rgba(100, 116, 139, .12);

            color: #9aa7b8;
        }

        .badge {

            display: inline-flex;

            padding: 5px 8px;

            border-radius: 999px;

            background: rgba(108, 99, 255, .12);

            color: #a69eff;

            font-size: 9px;

            font-weight: 800;
        }

        .actions {

            display: flex;

            flex-wrap: wrap;

            gap: 6px;
        }

        .btn {

            border: 0;

            border-radius: 7px;

            padding: 7px 9px;

            font-size: 10px;

            font-weight: 800;

            cursor: pointer;
        }

        .btn.approve {

            background: rgba(34, 197, 94, .12);

            color: #66db8b;
        }

        .btn.reject {

            background: rgba(239, 68, 68, .10);

            color: #ff8585;
        }

        /* =====================================================
           EMPTY / PAGINATION
        ===================================================== */

        .empty {

            padding: 55px 20px;

            text-align: center;

            color: var(--muted);
        }

        .empty-icon {

            font-size: 40px;

            margin-bottom: 10px;
        }

        .pagination-bar {

            padding: 14px 16px;

            border-top: 1px solid var(--border);
        }

        .pagination-bar nav {

            display: flex;

            justify-content: center;
        }

        .pagination-bar svg {

            width: 18px;
            height: 18px;
        }

        .pagination-bar a,
        .pagination-bar span {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 34px;

            height: 34px;

            margin: 0 2px;

            border: 1px solid var(--border);

            border-radius: 7px;

            font-size: 11px;

            color: var(--text);

            background: var(--card2);
        }

        .pagination-bar span[aria-current="page"] {

            background: var(--primary);

            border-color: var(--primary);

            color: #fff;
        }

        .pagination-bar span[aria-disabled="true"] {
            opacity: .45;
        }

        /* =====================================================
           DASHBOARD
        ===================================================== */

        .dashboard-grid {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 16px;

            margin-bottom: 24px;
        }

        .stat-card {

            padding: 19px;

            background: var(--card);

            border: 1px solid var(--border);

            border-radius: 16px;
        }

        .stat-label {

            color: var(--muted);

            font-size: 11px;
        }

        .stat-value {

            font-size: 28px;

            font-weight: 800;

            margin-top: 8px;
        }

        .stat-note {

            color: var(--muted);

            font-size: 10px;

            margin-top: 5px;
        }

        .two-col {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 18px;
        }

        .panel-head {

            padding: 17px 18px;

            border-bottom: 1px solid var(--border);

            display: flex;

            justify-content: space-between;

            gap: 10px;

            align-items: center;
        }

        .panel-head h2 {
            font-size: 15px;
        }

        .panel-head a {

            color: var(--primary);

            font-size: 10px;

            font-weight: 800;
        }

        .mini-list {
            display: grid;
        }

        .mini-row {

            padding: 14px 18px;

            border-bottom: 1px solid var(--border);

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 10px;
        }

        .mini-row:last-child {
            border-bottom: 0;
        }

        .mini-main {
            min-width: 0;
        }

        .mini-title {

            font-size: 12px;

            font-weight: 800;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .mini-sub {

            color: var(--muted);

            font-size: 9px;

            margin-top: 3px;
        }

        /* =====================================================
           LIGHT MODE
        ===================================================== */

        html[data-theme="light"] .card,
        html[data-theme="light"] .stat-card,
        html[data-theme="light"] .admin-user {

            box-shadow: 0 8px 22px rgba(20, 30, 50, .04);
        }

        html[data-theme="light"] .nav-link:hover {

            color: #172033;

            background: #f3f1ff;
        }

        html[data-theme="light"] .nav-link.active {

            color: #172033;

            background: #f0edff;

            border-color: #ded9ff;
        }

        /* =====================================================
           NOTIFICATION
        ===================================================== */

        .notification-menu {

            width: 330px;
        }

        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 1100px) {

            .sidebar {
                width: 225px;
            }

            .main {

                margin-left: 225px;

                width: calc(100% - 225px);
            }

            .dashboard-grid {

                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {

                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* =====================================================
           MOBILE SIDEBAR
        ===================================================== */

        @media (max-width: 900px) {

            .sidebar {

                width: 270px;

                max-width: 82vw;

                transform: translateX(-100%);

                transition: transform .25s ease;

                box-shadow: 12px 0 35px rgba(0, 0, 0, .25);
            }

            .sidebar.open {

                transform: translateX(0);
            }

            .sidebar-close {

                display: flex;
            }

            .sidebar-overlay {

                display: none;

                position: fixed;

                inset: 0;

                z-index: 90;

                background: rgba(0, 0, 0, .55);

                backdrop-filter: blur(2px);
            }

            body.sidebar-open {

                overflow: hidden;
            }

            body.sidebar-open .sidebar-overlay {

                display: block;
            }

            .main {

                margin-left: 0;

                width: 100%;

                padding: 20px;
            }

            .mobile-topbar {

                display: flex;

                align-items: center;

                justify-content: space-between;

                gap: 12px;

                margin-bottom: 18px;
            }

            .two-col {

                grid-template-columns: 1fr;
            }
        }

        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 650px) {

            .topbar {

                flex-direction: column;

                align-items: stretch;

                gap: 12px;
            }

            .admin-user {

                width: 100%;
            }

            .filter-grid {

                grid-template-columns: 1fr;
            }

            .dashboard-grid {

                grid-template-columns: 1fr;
            }

            .main {

                padding: 15px;
            }

            .heading h1 {

                font-size: 24px;
            }

            .filter-actions {

                align-items: flex-start;

                flex-direction: column;
            }

            .export-buttons {

                width: 100%;
            }

            .export-btn {

                flex: 1;
            }

            .notification-menu {

                width: min(
                    330px,
                    calc(100vw - 30px)
                ) !important;
            }

            .notification-dropdown {

                right: -5px !important;
            }
        }

    </style>

    @stack('head')

</head>

<body>

<div class="admin-shell">

    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside
        class="sidebar"
        id="adminSidebar"
    >

        <button
            type="button"
            class="sidebar-close"
            id="sidebarClose"
            aria-label="Close sidebar"
        >
            ×
        </button>

        <a
            href="{{ route('admin.dashboard') }}"
            class="brand"
        >
            Event<span>ora</span>
        </a>

        <div class="side-label">
            Super Admin
        </div>

        <nav class="nav">

            {{-- Dashboard --}}

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🏠
                </span>

                <span class="nav-text">
                    Dashboard
                </span>

            </a>


            {{-- Organizations --}}
            @if(auth()->user()->role === 'super_admin' || in_array('organizations', auth()->user()->admin_permissions ?? [], true))

            <a
                href="{{ route('admin.organizations.index') }}"
                class="nav-link {{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🏢
                </span>

                <span class="nav-text">
                    Organizations
                </span>

            </a>
            @endif


            {{-- Events --}}
            @if(auth()->user()->role === 'super_admin' || in_array('events', auth()->user()->admin_permissions ?? [], true))

            <a
                href="{{ route('admin.events.index') }}"
                class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🎫
                </span>

                <span class="nav-text">
                    Events
                </span>

            </a>
            @endif


            {{-- Super Admin Staff accounts --}}
            @if(auth()->user()->role === 'super_admin' || in_array('manage_staff', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.access-staff.index') }}" class="nav-link {{ request()->routeIs('admin.access-staff.*') ? 'active' : '' }}">
                <span class="nav-icon">🛡️</span><span class="nav-text">Super Admin Staff</span>
            </a>
            @endif

            {{-- Organization staff --}}
            @if(auth()->user()->role === 'super_admin' || in_array('manage_staff', auth()->user()->admin_permissions ?? [], true))

            <a
                href="{{ route('admin.staff.index') }}"
                class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    🧑‍💼
                </span>

                <span class="nav-text">
                    Organization Staff
                </span>

            </a>
            @endif


            {{-- Users --}}
            @if(auth()->user()->role === 'super_admin' || in_array('users', auth()->user()->admin_permissions ?? [], true))

            <a
                href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    👥
                </span>

                <span class="nav-text">
                    Users
                </span>

            </a>
            @endif


            {{-- Bookings --}}
            @if(auth()->user()->role === 'super_admin' || in_array('bookings', auth()->user()->admin_permissions ?? [], true))

            <a
                href="{{ route('admin.bookings.index') }}"
                class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    📋
                </span>

                <span class="nav-text">
                    Bookings
                </span>

            </a>
            @endif


            {{-- Payments --}}
            @if(auth()->user()->role === 'super_admin' || in_array('payments', auth()->user()->admin_permissions ?? [], true))

            <a
                href="{{ route('admin.payments.index') }}"
                class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
            >

                <span class="nav-icon">
                    💳
                </span>

                <span class="nav-text">
                    Payments
                </span>

            </a>
            @endif

            @if(auth()->user()->role === 'super_admin' || in_array('settings', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span><span class="nav-text">Settings</span>
            </a>
            @endif

            <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <span class="nav-icon">👤</span><span class="nav-text">Profile</span>
            </a>

        </nav>


        {{-- Logout --}}

        <div class="logout-area">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >
                    Logout
                </button>

            </form>

        </div>

    </aside>


    {{-- Mobile overlay --}}

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <main class="main">


        {{-- Mobile header --}}

        <div class="mobile-topbar">

            <button
                type="button"
                class="menu-btn"
                id="sidebarOpen"
                aria-label="Open sidebar"
            >
                ☰
            </button>


            <a
                href="{{ route('admin.dashboard') }}"
                class="mobile-brand"
            >
                Event<span>ora</span>
            </a>


            {{-- Keeps brand centered --}}

            <div style="width:42px"></div>

        </div>


        {{-- =================================================
             TOP BAR
        ================================================== --}}

        <div class="topbar">

            <div class="heading">

                <h1>
                    @yield(
                        'page_heading',
                        'Super Admin Dashboard'
                    )
                </h1>

                <p>
                    @yield(
                        'page_subheading',
                        'Manage Eventora platform data from one place.'
                    )
                </p>

            </div>


            <div
                style="
                    display:flex;
                    align-items:center;
                    gap:10px;
                "
            >

                {{-- Notifications --}}

                @php

                    $unreadNotificationCount = auth()->user()->unreadNotifications()->count();
                    $recentNotifications = auth()->user()->notifications()->latest()->take(5)->get();

                @endphp


                <div
                    style="
                        position:relative;
                    "
                >

                    <details>

                        <summary
                            style="
                                list-style:none;
                                cursor:pointer;

                                width:40px;
                                height:40px;

                                border:1px solid var(--border);

                                border-radius:10px;

                                background:var(--card);

                                display:flex;
                                align-items:center;
                                justify-content:center;

                                position:relative;
                            "
                        >

                            🔔

                            @if($unreadNotificationCount)

                                <span
                                    style="
                                        position:absolute;
                                        top:-4px;
                                        right:-4px;

                                        background:#ef4444;
                                        color:#fff;

                                        border-radius:99px;

                                        font-size:9px;

                                        padding:3px 5px;
                                    "
                                >
                                    {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                                </span>

                            @endif

                        </summary>


                        <div
                            class="notification-menu"
                            style="
                                position:absolute;
                                right:0;
                                top:48px;

                                width:330px;

                                max-width:calc(100vw - 30px);

                                background:var(--card);

                                border:1px solid var(--border);

                                border-radius:12px;

                                padding:8px;

                                z-index:500;

                                box-shadow:
                                    0 12px 30px
                                    rgba(0,0,0,.25);
                            "
                        >

                            @forelse(
                                $recentNotifications
                                as $notification
                            )

                                <a
                                    href="{{ route(
                                        'admin.notifications.read',
                                        $notification->id
                                    ) }}"
                                    style="
                                        display:block;

                                        padding:10px;

                                        border-radius:8px;

                                        margin-bottom:4px;

                                        background:var(--card2);
                                    "
                                >

                                    <strong
                                        style="
                                            font-size:11px;
                                        "
                                    >
                                        {{
                                            $notification->data['title']
                                            ?? 'Notification'
                                        }}
                                    </strong>


                                    <div
                                        style="
                                            font-size:10px;

                                            color:var(--muted);

                                            margin-top:3px;
                                        "
                                    >
                                        {{
                                            $notification->data['message']
                                            ?? ''
                                        }}
                                    </div>

                                </a>

                            @empty

                                <div
                                    style="
                                        padding:14px;

                                        color:var(--muted);

                                        font-size:11px;
                                    "
                                >
                                    No new notifications.
                                </div>

                            @endforelse

                        </div>

                    </details>

                </div>


                {{-- Admin profile --}}

                <div class="admin-user">

                    <div class="avatar">

                        {{
                            strtoupper(
                                substr(
                                    auth()->user()->name,
                                    0,
                                    1
                                )
                            )
                        }}

                    </div>


                    <div>

                        <div class="user-name">

                            {{ auth()->user()->name }}

                        </div>


                        <div class="user-role">

                            {{
                                str_replace(
                                    '_',
                                    ' ',
                                    auth()->user()->role
                                )
                            }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             FLASH MESSAGES
        ================================================== --}}

        @if(session('success'))

            <div class="flash success">

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="flash error">

                {{ session('error') }}

            </div>

        @endif


        @if($errors->any())

            <div class="flash error">

                {{ $errors->first() }}

            </div>

        @endif


        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}

        @yield('content')

    </main>

</div>


<script>

    /* =====================================================
       RESPONSIVE SIDEBAR
    ===================================================== */

    (function () {

        const sidebar =
            document.getElementById(
                'adminSidebar'
            );

        const sidebarOpen =
            document.getElementById(
                'sidebarOpen'
            );

        const sidebarClose =
            document.getElementById(
                'sidebarClose'
            );

        const sidebarOverlay =
            document.getElementById(
                'sidebarOverlay'
            );


        function openSidebar() {

            if (!sidebar) {
                return;
            }

            sidebar.classList.add('open');

            document.body.classList.add(
                'sidebar-open'
            );
        }


        function closeSidebar() {

            if (!sidebar) {
                return;
            }

            sidebar.classList.remove(
                'open'
            );

            document.body.classList.remove(
                'sidebar-open'
            );
        }


        /* Open */

        if (sidebarOpen) {

            sidebarOpen.addEventListener(
                'click',
                openSidebar
            );

        }


        /* Close */

        if (sidebarClose) {

            sidebarClose.addEventListener(
                'click',
                closeSidebar
            );

        }


        /* Overlay click */

        if (sidebarOverlay) {

            sidebarOverlay.addEventListener(
                'click',
                closeSidebar
            );

        }


        /* Menu click */

        document
            .querySelectorAll(
                '.sidebar .nav-link'
            )
            .forEach(function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        if (
                            window.innerWidth <= 900
                        ) {

                            closeSidebar();

                        }

                    }
                );

            });


        /* Escape key */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape'
                ) {

                    closeSidebar();

                }

            }
        );


        /* Resize */

        window.addEventListener(
            'resize',
            function () {

                if (
                    window.innerWidth > 900
                ) {

                    closeSidebar();

                }

            }
        );

    })();


    /* =====================================================
       THEME
    ===================================================== */

    (function () {

        const html =
            document.documentElement;

        const savedTheme =
            localStorage.getItem(
                'eventora-theme'
            ) || 'dark';

        html.setAttribute(
            'data-theme',
            savedTheme
        );

    })();


    /* =====================================================
       LIVE FILTER / SEARCH
    ===================================================== */

    (function () {

        const form =
            document.getElementById(
                'adminFilterForm'
            );

        const resultsRegion =
            document.getElementById(
                'resultsRegion'
            );


        function currentUrl() {

            const url =
                new URL(
                    window.location.href
                );


            if (!form) {
                return url;
            }


            const formData =
                new FormData(form);


            url.search = '';


            for (
                const [key, value]
                of formData.entries()
            ) {

                const v =
                    String(value).trim();


                if (v !== '') {

                    url.searchParams.set(
                        key,
                        v
                    );

                }

            }


            return url;
        }


        async function load(
            url,
            push = true
        ) {

            if (!resultsRegion) {
                return;
            }


            resultsRegion.style.opacity =
                '.55';


            try {

                const response =
                    await fetch(
                        url.toString(),
                        {
                            headers: {
                                'X-Requested-With':
                                    'XMLHttpRequest',

                                'Accept':
                                    'text/html'
                            }
                        }
                    );


                if (!response.ok) {

                    throw new Error(
                        'Request failed'
                    );

                }


                const htmlText =
                    await response.text();


                const parser =
                    new DOMParser();


                const doc =
                    parser.parseFromString(
                        htmlText,
                        'text/html'
                    );


                const newRegion =
                    doc.getElementById(
                        'resultsRegion'
                    );


                if (!newRegion) {

                    throw new Error(
                        'Results region not found'
                    );

                }


                resultsRegion.replaceWith(
                    newRegion
                );


                if (push) {

                    window.history.replaceState(
                        {},
                        '',
                        url.toString()
                    );

                }

            }
            catch (error) {

                console.error(error);

                window.location.href =
                    url.toString();

            }
            finally {

                const latest =
                    document.getElementById(
                        'resultsRegion'
                    );


                if (latest) {

                    latest.style.opacity =
                        '1';

                }

            }

        }


        if (form) {

            let timer = null;


            form.addEventListener(
                'input',
                function (event) {

                    if (
                        event.target.matches(
                            '[data-live-search]'
                        )
                    ) {

                        clearTimeout(timer);


                        timer =
                            setTimeout(
                                function () {

                                    load(
                                        currentUrl()
                                    );

                                },
                                300
                            );

                    }

                }
            );


            form.addEventListener(
                'change',
                function (event) {

                    if (
                        event.target.matches(
                            'select, input[type="date"]'
                        )
                    ) {

                        load(
                            currentUrl()
                        );

                    }

                }
            );


            form.addEventListener(
                'submit',
                function (event) {

                    event.preventDefault();

                    load(
                        currentUrl()
                    );

                }
            );


            form.addEventListener(
                'reset',
                function () {

                    setTimeout(
                        function () {

                            load(
                                new URL(
                                    window.location.pathname,
                                    window.location.origin
                                )
                            );

                        },
                        0
                    );

                }
            );

        }


        /* =================================================
           PAGINATION / EXPORT
        ================================================= */

        document.addEventListener(
            'click',
            function (event) {

                const paginationLink =
                    event.target.closest(
                        '#resultsRegion .pagination-bar a'
                    );


                if (paginationLink) {

                    event.preventDefault();


                    load(
                        new URL(
                            paginationLink.href
                        )
                    );


                    return;
                }


                const exportLink =
                    event.target.closest(
                        '[data-export-base]'
                    );


                if (exportLink) {

                    event.preventDefault();


                    const url =
                        new URL(
                            exportLink.dataset.exportBase,
                            window.location.origin
                        );


                    if (form) {

                        const formData =
                            new FormData(form);


                        for (
                            const [key, value]
                            of formData.entries()
                        ) {

                            const v =
                                String(value).trim();


                            if (v !== '') {

                                url.searchParams.set(
                                    key,
                                    v
                                );

                            }

                        }

                    }


                    if (
                        exportLink.dataset.exportAction
                        === 'print'
                    ) {

                        window.open(
                            url.toString(),
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }
                    else {

                        window.location.href =
                            url.toString();

                    }

                }

            }
        );


        /* Browser back/forward */

        window.addEventListener(
            'popstate',
            function () {

                const url =
                    new URL(
                        window.location.href
                    );


                load(
                    url,
                    false
                );


                if (!form) {
                    return;
                }


                for (
                    const control
                    of form.elements
                ) {

                    if (!control.name) {
                        continue;
                    }


                    control.value =
                        url.searchParams.get(
                            control.name
                        ) || '';

                }

            }
        );

    })();

</script>


@stack('scripts')

</body>

</html>
