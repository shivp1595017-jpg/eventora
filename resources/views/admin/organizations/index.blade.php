@extends('layouts.admin')
@section('title', 'Organizations - Eventora')
@section('heading', 'Organizations')
@section('description', 'Review, search and manage Eventora organizations.')
@section('content')
<style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        :root {

            --bg: #070b14;
            --sidebar: #0b1220;
            --card: #0e1524;
            --card2: #111b2d;

            --text: #ffffff;
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
            --sidebar: #ffffff;
            --card: #ffffff;
            --card2: #f7f8fb;

            --text: #172033;
            --muted: #687386;

            --border: #dce2ec;

        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

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

            font-family: inherit;

        }


        /* =====================================================
           ALERTS
        ====================================================== */

        .alert {

            padding:
                13px 16px;

            border-radius: 11px;

            margin-bottom: 18px;

            font-size: 13px;

            border: 1px solid;

        }


        .alert-success {

            background:
                rgba(34,197,94,.09);

            border-color:
                rgba(34,197,94,.25);

            color: #6fe497;

        }


        .alert-error {

            background:
                rgba(239,68,68,.09);

            border-color:
                rgba(239,68,68,.25);

            color: #ff8585;

        }


        .alert-warning {

            background:
                rgba(245,158,11,.09);

            border-color:
                rgba(245,158,11,.25);

            color: #f7c55f;

        }


        /* =====================================================
           STATISTICS
        ====================================================== */

        .stats {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;

            margin-bottom: 22px;

        }


        .stat-card {

            padding: 19px;

            border-radius: 15px;

            background: var(--card);

            border:
                1px solid var(--border);

        }


        .stat-label {

            color: var(--muted);

            font-size: 11px;

            margin-bottom: 7px;

        }


        .stat-value {

            font-size: 26px;

            font-weight: 800;

        }


        .stat-card.pending {

            border-color:
                rgba(245,158,11,.22);

        }


        .stat-card.approved {

            border-color:
                rgba(34,197,94,.22);

        }


        .stat-card.rejected {

            border-color:
                rgba(239,68,68,.22);

        }


        /* =====================================================
           FILTER CARD
        ====================================================== */

        .filter-card {

            padding: 14px;

            background: var(--card);

            border:
                1px solid var(--border);

            border-radius: 15px;

            margin-bottom: 18px;

        }


        .filter-row {

            display: grid;

            grid-template-columns:
                minmax(250px, 1fr)
                190px
                190px
                auto;

            gap: 10px;

            align-items: center;

        }


        .search-box {

            position: relative;

        }


        .search-box input {

            width: 100%;

            min-height: 42px;

            padding:
                0 14px 0 42px;

            border-radius: 9px;

            border:
                1px solid var(--border);

            background: var(--card2);

            color: var(--text);

            outline: none;

            font-size: 13px;

        }


        .search-box input:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(108,99,255,.08);

        }


        .search-icon {

            position: absolute;

            left: 14px;

            top: 50%;

            transform:
                translateY(-50%);

            color: var(--muted);

            font-size: 15px;

        }


        .filter-select {

            width: 100%;

            min-height: 42px;

            padding:
                0 12px;

            border-radius: 9px;

            border:
                1px solid var(--border);

            background: var(--card2);

            color: var(--text);

            outline: none;

            font-size: 12px;

        }


        .filter-select:focus {

            border-color:
                var(--primary);

        }


        .clear-btn {

            min-height: 42px;

            padding:
                0 15px;

            border-radius: 9px;

            border:
                1px solid var(--border);

            background: var(--card2);

            color: var(--text);

            cursor: pointer;

            font-size: 12px;

            font-weight: 700;

        }


        .clear-btn:hover {

            color: var(--primary);

            border-color:
                var(--primary);

        }


        .filter-info {

            display: flex;

            align-items: center;

            justify-content:
                space-between;

            gap: 15px;

            margin-top: 12px;

            color: var(--muted);

            font-size: 11px;

        }


        .live-indicator {

            display: inline-flex;

            align-items: center;

            gap: 6px;

        }


        .live-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: var(--success);

            box-shadow:
                0 0 0 4px
                rgba(34,197,94,.08);

        }


        /* =====================================================
           TABLE
        ====================================================== */

        .table-card {

            background: var(--card);

            border:
                1px solid var(--border);

            border-radius: 17px;

            overflow: hidden;

        }


        .table-wrapper {

            width: 100%;

            overflow-x: auto;

        }


        table {

            width: 100%;

            min-width: 1120px;

            table-layout: fixed;

            border-collapse:
                collapse;

        }


        th {

            padding:
                14px 17px;

            text-align: left;

            background: var(--card2);

            color: var(--muted);

            border-bottom:
                1px solid var(--border);

            text-transform:
                uppercase;

            letter-spacing: .5px;

            font-size: 10px;

        }


        td {

            padding:
                17px;

            border-bottom:
                1px solid var(--border);

            vertical-align:
                middle;

            font-size: 12px;

            overflow-wrap: anywhere;

        }


        tbody tr:hover {

            background:
                rgba(108,99,255,.025);

        }


        tbody tr:last-child td {

            border-bottom: none;

        }


        .org-cell {

            min-width: 190px;

        }


        .org-name {

            font-size: 13px;

            font-weight: 800;

            margin-bottom: 4px;

        }


        .org-email {

            color: var(--muted);

            font-size: 10px;

            word-break:
                break-word;

        }


        .type-badge {

            display: inline-flex;

            padding:
                5px 9px;

            border-radius: 15px;

            background:
                rgba(108,99,255,.10);

            color: #aaa4ff;

            font-size: 10px;

            font-weight: 700;

        }


        .contact {

            line-height: 1.6;

        }


        .contact div:first-child {

            font-weight: 600;

        }


        .contact div:last-child {

            color: var(--muted);

            font-size: 10px;

        }


        .location {

            color: var(--muted);

            line-height: 1.7;

        }


        .date {

            font-weight: 600;

        }


        .date small {

            display: block;

            color: var(--muted);

            font-size: 10px;

            margin-top: 2px;

        }


        .admin-info {

            line-height: 1.5;

        }


        .admin-name {

            font-weight: 700;

        }


        .admin-email {

            color: var(--muted);

            font-size: 10px;

            word-break:
                break-word;

        }


        .no-admin {

            color: var(--muted);

            font-size: 10px;

        }


        /* =====================================================
           STATUS
        ====================================================== */

        .status {

            display: inline-flex;

            align-items: center;

            padding:
                6px 10px;

            border-radius: 20px;

            text-transform:
                capitalize;

            font-size: 10px;

            font-weight: 800;

        }


        .status-pending {

            background:
                rgba(245,158,11,.12);

            color: #f7c45d;

        }


        .status-approved {

            background:
                rgba(34,197,94,.12);

            color: #6fe497;

        }


        .status-rejected {

            background:
                rgba(239,68,68,.12);

            color: #ff8585;

        }


        /* =====================================================
           EVENTS COUNT
        ====================================================== */

        .event-count {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 30px;

            height: 27px;

            padding: 0 8px;

            border-radius: 8px;

            background: var(--card2);

            border:
                1px solid var(--border);

            color: var(--text);

            font-size: 11px;

            font-weight: 800;

        }


        /* =====================================================
           ACTIONS
        ====================================================== */

        .actions {

            display: flex;

            gap: 7px;

            align-items: center;

            flex-wrap: wrap;

        }


        .action-form {

            display: inline;

        }


        .action-btn {

            min-height: 34px;

            padding:
                0 10px;

            border-radius: 8px;

            border: none;

            cursor: pointer;

            font-size: 10px;

            font-weight: 800;

        }


        .approve-btn {

            background:
                rgba(34,197,94,.12);

            color: #68df8c;

            border:
                1px solid
                rgba(34,197,94,.18);

        }


        .approve-btn:hover {

            background:
                rgba(34,197,94,.19);

        }


        .reject-btn {

            background:
                rgba(239,68,68,.10);

            color: #ff8585;

            border:
                1px solid
                rgba(239,68,68,.17);

        }


        .reject-btn:hover {

            background:
                rgba(239,68,68,.17);

        }


        .approved-action {

            color: #68df8c;

            font-size: 10px;

            font-weight: 800;

        }


        .no-action {

            color: var(--muted);

            font-size: 10px;

        }


        .view-link {

            display: inline-flex;

            align-items: center;

            min-height: 34px;

            padding:
                0 10px;

            border-radius: 8px;

            border:
                1px solid var(--border);

            color: var(--primary);

            font-size: 10px;

            font-weight: 800;

        }


        .view-link:hover {

            border-color:
                var(--primary);

        }


        /* =====================================================
           EMPTY
        ====================================================== */

        .empty-state {

            padding:
                70px 20px;

            text-align: center;

        }


        .empty-icon {

            font-size: 45px;

            margin-bottom: 12px;

        }


        .empty-state h2 {

            font-size: 19px;

            margin-bottom: 6px;

        }


        .empty-state p {

            color: var(--muted);

            font-size: 12px;

        }


        /* =====================================================
           PAGINATION
        ====================================================== */

        .pagination-wrapper {

            padding:
                17px;

            border-top:
                1px solid var(--border);

        }


        .pagination-wrapper nav {

            display: flex;

            justify-content:
                center;

        }


        .pagination-wrapper svg {

            width: 15px;

            height: 15px;

        }


        .pagination-wrapper nav > div:first-child {

            display: none;

        }


        .pagination-wrapper nav > div:last-child {

            display: flex;

            align-items: center;

            gap: 4px;

            flex-wrap: wrap;

            justify-content:
                center;

        }


        .pagination-wrapper a,
        .pagination-wrapper span {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 35px;

            height: 35px;

            padding:
                0 10px;

            border-radius: 8px;

            background: var(--card2);

            border:
                1px solid var(--border);

            color: var(--muted);

            font-size: 11px;

            font-weight: 700;

        }


        .pagination-wrapper a:hover {

            border-color:
                var(--primary);

            color: var(--primary);

        }


        .pagination-wrapper span[aria-current="page"] {

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            border-color:
                transparent;

            color: #ffffff;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1150px) {

            .stats {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .filter-row {

                grid-template-columns:
                    1fr 1fr;

            }

        }


                            
        .organization-admin-page{display:grid;gap:18px}
        .organization-admin-page .org-page-heading{display:flex;align-items:center;justify-content:space-between;gap:16px}
        .organization-admin-page .org-page-heading p{color:var(--muted);font-size:12px;margin-top:4px}
        .organization-admin-page .table-wrapper{width:100%;overflow-x:auto}
        .organization-admin-page .table-wrapper table{width:100%;min-width:1120px;table-layout:fixed}
        .organization-admin-page td{overflow-wrap:anywhere}
        @media(max-width:1150px){.organization-admin-page .stats{grid-template-columns:repeat(2,minmax(0,1fr))}.organization-admin-page .filter-row{grid-template-columns:repeat(2,minmax(0,1fr))}.organization-admin-page .search-box{grid-column:1/-1}}
        @media(max-width:600px){.organization-admin-page .stats{grid-template-columns:1fr}.organization-admin-page .filter-row{grid-template-columns:1fr}.organization-admin-page .search-box{grid-column:auto}.organization-admin-page .filter-info{align-items:flex-start;flex-direction:column}.organization-admin-page .org-page-heading{align-items:stretch;flex-direction:column}}
</style>
<div class="organization-admin-page">
@if(session('success'))

            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-error">
                ✕ {{ session('error') }}
            </div>

        @endif


        @if(session('warning'))

            <div class="alert alert-warning">
                ⚠ {{ session('warning') }}
            </div>

        @endif


        {{-- =================================================
             STATISTICS
        ================================================== --}}

        <section class="stats">


            <div class="stat-card">

                <div class="stat-label">
                    Total Organizations
                </div>

                <div class="stat-value">
                    {{ $totalOrganizations }}
                </div>

            </div>


            <div class="stat-card pending">

                <div class="stat-label">
                    Pending Review
                </div>

                <div class="stat-value">
                    {{ $pendingOrganizations }}
                </div>

            </div>


            <div class="stat-card approved">

                <div class="stat-label">
                    Approved
                </div>

                <div class="stat-value">
                    {{ $approvedOrganizations }}
                </div>

            </div>


            <div class="stat-card rejected">

                <div class="stat-label">
                    Rejected
                </div>

                <div class="stat-value">
                    {{ $rejectedOrganizations }}
                </div>

            </div>


        </section>


        {{-- =================================================
             FILTERS
        ================================================== --}}

        <section class="filter-card">


            <div class="filter-row">


                {{-- SEARCH --}}

                <div class="search-box">

                    <span class="search-icon">
                        🔎
                    </span>

                    <input
                        type="search"
                        id="organizationSearch"
                        value="{{ request('search') }}"
                        placeholder="Search name, email, phone, city, state..."
                        autocomplete="off"
                    >

                </div>


                {{-- STATUS --}}

                <select
                    id="statusFilter"
                    class="filter-select"
                >

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="pending"
                        @selected(request('status') === 'pending')
                    >
                        Pending
                    </option>

                    <option
                        value="approved"
                        @selected(request('status') === 'approved')
                    >
                        Approved
                    </option>

                    <option
                        value="rejected"
                        @selected(request('status') === 'rejected')
                    >
                        Rejected
                    </option>

                </select>


                {{-- TYPE --}}

                <select
                    id="typeFilter"
                    class="filter-select"
                >

                    <option value="">
                        All Types
                    </option>

                    @foreach($organizationTypes as $organizationType)

                        <option
                            value="{{ $organizationType }}"
                            @selected(request('type') === $organizationType)
                        >
                            {{ $organizationType }}
                        </option>

                    @endforeach

                </select>


                {{-- CLEAR --}}

                <button
                    type="button"
                    id="clearFilters"
                    class="clear-btn"
                >
                    Clear
                </button>


            </div>


            <div class="filter-info">


                <div id="resultCount">

                    Showing
                    {{ $organizations->firstItem() ?? 0 }}
                    -
                    {{ $organizations->lastItem() ?? 0 }}
                    of
                    {{ $organizations->total() }}
                    organizations

                </div>


                <div class="live-indicator">

                    <span class="live-dot"></span>

                    Live search & filters

                </div>

                <div style="display:flex;gap:6px;flex-wrap:wrap">
                    @foreach(['xlsx' => 'Excel', 'csv' => 'CSV', 'pdf' => 'PDF'] as $format => $label)
                        <a class="export-btn" data-export-base="{{ route('admin.organizations.export', ['format' => $format]) }}" href="{{ route('admin.organizations.export', array_merge(request()->query(), ['format' => $format])) }}">{{ $label }}</a>
                    @endforeach
                    <a class="export-btn" data-export-base="{{ route('admin.print', ['resource' => 'organizations']) }}" href="{{ route('admin.print', array_merge(request()->query(), ['resource' => 'organizations'])) }}">Print</a>
                </div>


            </div>


        </section>


        {{-- =================================================
             ORGANIZATION TABLE
        ================================================== --}}

        <section class="table-card">


            @if($organizations->count())


                <div class="table-wrapper">


                    <table>


                        <thead>

                            <tr>

                                <th>
                                    Organization
                                </th>

                                <th>
                                    Type
                                </th>

                                <th>
                                    Contact
                                </th>

                                <th>
                                    Location
                                </th>

                                <th>
                                    Admin Account
                                </th>

                                <th>
                                    Events
                                </th>

                                <th>
                                    Registered
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody id="organizationsTableBody">


                            @foreach($organizations as $organization)


                                <tr>


                                    {{-- ORGANIZATION --}}

                                    <td>

                                        <div class="org-cell">

                                            <div class="org-name">

                                                {{ $organization->name }}

                                            </div>


                                            <div class="org-email">

                                                {{
                                                    $organization->email
                                                    ?? 'No email provided'
                                                }}

                                            </div>

                                        </div>

                                    </td>


                                    {{-- TYPE --}}

                                    <td>

                                        <span class="type-badge">

                                            {{
                                                $organization->type
                                                ?: 'Organization'
                                            }}

                                        </span>

                                    </td>


                                    {{-- CONTACT --}}

                                    <td>

                                        <div class="contact">

                                            <div>

                                                {{
                                                    $organization->phone
                                                    ?? 'No phone'
                                                }}

                                            </div>

                                            <div>

                                                {{
                                                    $organization->website
                                                    ?? 'No website'
                                                }}

                                            </div>

                                        </div>

                                    </td>


                                    {{-- LOCATION --}}

                                    <td>

                                        <div class="location">

                                            {{
                                                $organization->city
                                                ?? 'N/A'
                                            }}

                                        </div>

                                        <div class="location">

                                            {{
                                                $organization->state
                                                ?? ''
                                            }}

                                        </div>

                                    </td>


                                    {{-- ADMIN --}}

                                    <td>

                                        @if($organization->user)

                                            <div class="admin-info">

                                                <div class="admin-name">

                                                    {{
                                                        $organization->user->name
                                                    }}

                                                </div>

                                                <div class="admin-email">

                                                    {{
                                                        $organization->user->email
                                                    }}

                                                </div>

                                            </div>

                                        @else

                                            <div class="no-admin">
                                                No admin account
                                            </div>

                                        @endif

                                    </td>


                                    {{-- EVENTS --}}

                                    <td>

                                        <span class="event-count">

                                            {{ $organization->events_count }}

                                        </span>

                                    </td>


                                    {{-- REGISTERED --}}

                                    <td>

                                        <div class="date">

                                            {{
                                                optional(
                                                    $organization->created_at
                                                )->format('d M Y')
                                            }}

                                            <small>

                                                {{
                                                    optional(
                                                        $organization->created_at
                                                    )->format('h:i A')
                                                }}

                                            </small>

                                        </div>

                                    </td>


                                    {{-- STATUS --}}

                                    <td>

                                        @php

                                            $status =
                                                $organization->status
                                                ?: 'pending';

                                        @endphp


                                        <span
                                            class="
                                                status
                                                status-{{ $status }}
                                            "
                                        >

                                            {{ $status }}

                                        </span>

                                    </td>


                                    {{-- ACTION --}}

                                    <td>


                                        <div class="actions">


                                            {{-- PUBLIC VIEW --}}

                                            @if(
                                                Route::has(
                                                    'organizations.show'
                                                ) &&
                                                $organization->slug
                                            )

                                                <a
                                                    href="{{
                                                        route(
                                                            'organizations.show',
                                                            $organization->slug
                                                        )
                                                    }}"
                                                    class="view-link"
                                                >
                                                    View
                                                </a>

                                            @endif


                                            {{-- PENDING --}}

                                            @if($organization->status === 'pending')


                                                <form
                                                    method="POST"
                                                    action="{{
                                                        route(
                                                            'admin.organizations.approve',
                                                            $organization
                                                        )
                                                    }}"
                                                    class="action-form"
                                                    onsubmit="
                                                        return confirm(
                                                            'Approve this organization and create/activate its Organization Admin account?'
                                                        );
                                                    "
                                                >

                                                    @csrf

                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="
                                                            action-btn
                                                            approve-btn
                                                        "
                                                    >
                                                        ✓ Approve
                                                    </button>

                                                </form>


                                                <form
                                                    method="POST"
                                                    action="{{
                                                        route(
                                                            'admin.organizations.reject',
                                                            $organization
                                                        )
                                                    }}"
                                                    class="action-form"
                                                    onsubmit="
                                                        return confirm(
                                                            'Reject this organization registration?'
                                                        );
                                                    "
                                                >

                                                    @csrf

                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="
                                                            action-btn
                                                            reject-btn
                                                        "
                                                    >
                                                        ✕ Reject
                                                    </button>

                                                </form>


                                            {{-- REJECTED --}}

                                            @elseif(
                                                $organization->status === 'rejected'
                                            )


                                                <form
                                                    method="POST"
                                                    action="{{
                                                        route(
                                                            'admin.organizations.approve',
                                                            $organization
                                                        )
                                                    }}"
                                                    class="action-form"
                                                    onsubmit="
                                                        return confirm(
                                                            'Re-approve this organization and create/activate its Organization Admin account?'
                                                        );
                                                    "
                                                >

                                                    @csrf

                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="
                                                            action-btn
                                                            approve-btn
                                                        "
                                                    >
                                                        ↻ Approve
                                                    </button>

                                                </form>


                                                <span class="no-action">
                                                    Rejected
                                                </span>


                                            {{-- APPROVED --}}

                                            @elseif(
                                                $organization->status === 'approved'
                                            )

                                                <span class="approved-action">
                                                    ✓ Approved
                                                </span>


                                            @else

                                                <span class="no-action">
                                                    No action
                                                </span>

                                            @endif


                                        </div>

                                    </td>


                                </tr>


                            @endforeach


                        </tbody>


                    </table>


                </div>


            @else


                <div class="empty-state">

                    <div class="empty-icon">
                        🏢
                    </div>

                    <h2>
                        No Organizations Found
                    </h2>

                    <p>
                        No organization matches the current search or filters.
                    </p>

                </div>


            @endif


            {{-- PAGINATION --}}

            <div
                id="paginationWrapper"
                class="pagination-wrapper"
            >

                {{ $organizations->links() }}

            </div>


        </section>


    <script>

    /*
    |--------------------------------------------------------------------------
    | Live Search / Filters
    |--------------------------------------------------------------------------
    */

    const searchInput =
        document.getElementById(
            'organizationSearch'
        );

    const statusFilter =
        document.getElementById(
            'statusFilter'
        );

    const typeFilter =
        document.getElementById(
            'typeFilter'
        );

    const clearFilters =
        document.getElementById(
            'clearFilters'
        );

    const tableBody =
        document.getElementById(
            'organizationsTableBody'
        );

    const paginationWrapper =
        document.getElementById(
            'paginationWrapper'
        );

    const resultCount =
        document.getElementById(
            'resultCount'
        );


    let searchTimer = null;

    let activeRequest = null;


    /*
    |--------------------------------------------------------------------------
    | Current URL Parameters
    |--------------------------------------------------------------------------
    */

    function buildUrl() {

        const url =
            new URL(
                '{{ route('admin.organizations.index') }}',
                window.location.origin
            );


        const search =
            searchInput.value.trim();

        const status =
            statusFilter.value;

        const type =
            typeFilter.value;


        if (search !== '') {

            url.searchParams.set(
                'search',
                search
            );

        }


        if (status !== '') {

            url.searchParams.set(
                'status',
                status
            );

        }


        if (type !== '') {

            url.searchParams.set(
                'type',
                type
            );

        }


        return url;

    }


    /*
    |--------------------------------------------------------------------------
    | Sync Controls From URL
    |--------------------------------------------------------------------------
    */

    function syncControls(url) {

        searchInput.value =
            url.searchParams.get(
                'search'
            ) || '';

        statusFilter.value =
            url.searchParams.get(
                'status'
            ) || '';

        typeFilter.value =
            url.searchParams.get(
                'type'
            ) || '';

    }


    /*
    |--------------------------------------------------------------------------
    | Live Load
    |--------------------------------------------------------------------------
    */

    async function loadOrganizations(
        targetUrl,
        pushState = true
    ) {

        document.querySelectorAll('[data-export-base]').forEach(function (link) {
            const exportUrl = new URL(link.dataset.exportBase, window.location.origin);
            targetUrl.searchParams.forEach(function (value, key) {
                exportUrl.searchParams.set(key, value);
            });
            link.href = exportUrl.toString();
        });

        if (
            activeRequest &&
            typeof activeRequest.abort === 'function'
        ) {

            activeRequest.abort();

        }


        const controller =
            new AbortController();

        activeRequest =
            controller;


        try {

            const response =
                await fetch(
                    targetUrl.toString(),
                    {
                        method: 'GET',

                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'text/html'
                        },

                        signal:
                            controller.signal
                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Unable to load organizations.'
                );

            }


            const htmlText =
                await response.text();


            const parser =
                new DOMParser();


            const documentData =
                parser.parseFromString(
                    htmlText,
                    'text/html'
                );


            const newBody =
                documentData.querySelector(
                    '#organizationsTableBody'
                );


            const newPagination =
                documentData.querySelector(
                    '#paginationWrapper'
                );


            const newResultCount =
                documentData.querySelector(
                    '#resultCount'
                );


            /*
            |--------------------------------------------------------------------------
            | Replace Table
            |--------------------------------------------------------------------------
            */

            if (newBody && tableBody) {

                tableBody.innerHTML =
                    newBody.innerHTML;

            }


            /*
            |--------------------------------------------------------------------------
            | Replace Pagination
            |--------------------------------------------------------------------------
            */

            if (
                newPagination &&
                paginationWrapper
            ) {

                paginationWrapper.innerHTML =
                    newPagination.innerHTML;

            }


            /*
            |--------------------------------------------------------------------------
            | Replace Result Count
            |--------------------------------------------------------------------------
            */

            if (
                newResultCount &&
                resultCount
            ) {

                resultCount.textContent =
                    newResultCount.textContent;

            }


            /*
            |--------------------------------------------------------------------------
            | URL
            |--------------------------------------------------------------------------
            */

            if (pushState) {

                window.history.pushState(
                    {},
                    '',
                    targetUrl.toString()
                );

            }


            bindPagination();


        } catch (error) {

            if (
                error.name !==
                'AbortError'
            ) {

                console.error(
                    error
                );

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Run Filters
    |--------------------------------------------------------------------------
    */

    function runFilters() {

        const url =
            buildUrl();

        url.searchParams.delete(
            'page'
        );

        loadOrganizations(
            url,
            true
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Search Debounce
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener(
        'input',
        function () {

            clearTimeout(
                searchTimer
            );

            searchTimer =
                setTimeout(
                    function () {

                        runFilters();

                    },
                    350
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Select Filters
    |--------------------------------------------------------------------------
    */

    statusFilter.addEventListener(
        'change',
        function () {

            runFilters();

        }
    );


    typeFilter.addEventListener(
        'change',
        function () {

            runFilters();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Clear
    |--------------------------------------------------------------------------
    */

    clearFilters.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            statusFilter.value = '';

            typeFilter.value = '';

            runFilters();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    function bindPagination() {

        if (!paginationWrapper) {
            return;
        }


        paginationWrapper
            .querySelectorAll('a')
            .forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function (event) {

                            event.preventDefault();

                            const url =
                                new URL(
                                    link.href,
                                    window.location.origin
                                );

                            loadOrganizations(
                                url,
                                true
                            );

                        }
                    );

                }
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Browser Back / Forward
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'popstate',
        function () {

            const url =
                new URL(
                    window.location.href
                );

            syncControls(
                url
            );

            loadOrganizations(
                url,
                false
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Pagination Binding
    |--------------------------------------------------------------------------
    */

    bindPagination();

</script>
</div>
@endsection
