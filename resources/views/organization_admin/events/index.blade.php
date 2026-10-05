@include('organization_admin.sidebar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Events | Eventora Admin</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .admin-main {
            margin-left: 270px;
            min-height: 100vh;
            padding: 30px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
        }

        .page-title h1 {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .page-title p {
            color: #6b7280;
            font-size: 14px;
        }

        .add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 20px;
            background: #111827;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .add-btn:hover {
            background: #374151;
            transform: translateY(-1px);
        }

        .success-message {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .event-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        thead {
            background: #f9fafb;
        }

        th {
            text-align: left;
            padding: 16px 18px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px 18px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .event-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .event-image {
            width: 64px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: #e5e7eb;
            flex-shrink: 0;
        }

        .event-placeholder {
            width: 64px;
            height: 48px;
            border-radius: 8px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 20px;
            flex-shrink: 0;
        }

        .event-name {
            font-weight: 600;
            color: #111827;
            max-width: 230px;
        }

        .event-category {
            color: #6b7280;
            font-size: 12px;
            margin-top: 4px;
        }

        .date-text {
            font-weight: 600;
            color: #374151;
        }

        .venue-text {
            color: #4b5563;
        }

        .price {
            font-weight: 700;
            color: #111827;
        }

        .free {
            color: #059669;
        }

        /*
        |--------------------------------------------------------------------------
        | Seats
        |--------------------------------------------------------------------------
        */

        .seat-count {
            font-weight: 600;
            color: #111827;
        }

        .seat-total {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .unlimited-seats {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-draft {
            background: #e5e7eb;
            color: #374151;
        }

        .status-cancelled {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background: white;
            cursor: pointer;
            transition: 0.2s;
            font-size: 14px;
        }

        .view-btn {
            color: #2563eb;
        }

        .view-btn:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .edit-btn {
            color: #d97706;
        }

        .edit-btn:hover {
            background: #fffbeb;
            border-color: #fde68a;
        }

        .delete-btn {
            color: #dc2626;
        }

        .delete-btn:hover {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .empty-state {
            padding: 70px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 8px;
            color: #111827;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 22px;
        }

        .pagination-wrapper {
            padding: 18px;
            border-top: 1px solid #e5e7eb;
        }

        .mobile-menu-btn {
            display: none;
            width: 42px;
            height: 42px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            font-size: 20px;
        }

        @media (max-width: 900px) {

            .admin-main {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-menu-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                align-items: flex-start;
            }

            .page-title h1 {
                font-size: 24px;
            }

            .add-btn {
                padding: 11px 15px;
            }
        }

        @media (max-width: 600px) {

            .admin-main {
                padding: 16px;
            }

            .topbar {
                flex-wrap: wrap;
            }

            .page-title {
                flex: 1;
            }

            .page-title h1 {
                font-size: 22px;
            }

            .page-title p {
                font-size: 13px;
            }

            .add-btn {
                width: 100%;
                justify-content: center;
            }

            .event-card {
                border-radius: 12px;
            }
        }
    </style>
</head>

<body>

<div class="admin-main">

    {{-- Top Header --}}
    <div class="topbar">

        <div style="display:flex;align-items:center;gap:12px;">

            <button
                class="mobile-menu-btn"
                onclick="openAdminSidebar()"
                type="button"
            >
                ☰
            </button>

            <div class="page-title">
                <h1>Events</h1>
                <p>Manage events created by your organization.</p>
            </div>

        </div>

        <a
            href="{{ route('organization.admin.events.create') }}"
            class="add-btn"
        >
            <span>＋</span>
            Add Event
        </a>

    </div>


    <form method="GET" action="{{ route('organization.admin.events.index') }}" data-live-search style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search title, category, city or venue" style="flex:1;min-width:220px;padding:11px;border:1px solid #dce2ec;border-radius:9px">
        <button class="add-btn" type="submit">Search</button>
        @include('organization_admin.partials.export-toolbar', ['exportResource' => 'events'])
    </form>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    {{-- Events --}}
    <div class="event-card">

        @if($events->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th>Price</th>
                            <th>Seats</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($events as $event)

                            <tr>

                                {{-- Event --}}
                                <td>

                                    <div class="event-info">

                                        @if($event->banner)

                                            <img
                                                src="{{ asset('storage/' . $event->banner) }}"
                                                alt="{{ $event->title }}"
                                                class="event-image"
                                            >

                                        @else

                                            <div class="event-placeholder">
                                                🎫
                                            </div>

                                        @endif

                                        <div>

                                            <div class="event-name">
                                                {{ $event->title }}
                                            </div>

                                            <div class="event-category">
                                                {{ $event->category }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Date --}}
                                <td>

                                    <div class="date-text">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                    </div>

                                    <div style="font-size:12px;color:#6b7280;margin-top:4px;">
                                        {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                                    </div>

                                </td>


                                {{-- Venue --}}
                                <td>

                                    <div class="venue-text">
                                        {{ $event->venue }}
                                    </div>

                                    <div style="font-size:12px;color:#9ca3af;margin-top:4px;">
                                        {{ $event->city }}
                                    </div>

                                </td>


                                {{-- Price --}}
                                <td>

                                    @if($event->ticket_price > 0)

                                        <span class="price">
                                            ₹{{ number_format($event->ticket_price, 2) }}
                                        </span>

                                    @else

                                        <span class="price free">
                                            Free
                                        </span>

                                    @endif

                                </td>


                                {{-- Seats --}}
                                <td>

                                    @if(is_null($event->total_seats))

                                        <span class="unlimited-seats">
                                            ∞ Unlimited
                                        </span>

                                    @else

                                        <div class="seat-count">
                                            {{ $event->available_seats }}
                                        </div>

                                        <div class="seat-total">
                                            / {{ $event->total_seats }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span class="status status-{{ $event->status }}">
                                        {{ $event->status }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="actions">

                                        <a
                                            href="{{ route('organization.admin.events.show', $event) }}"
                                            class="action-btn view-btn"
                                            title="View"
                                        >
                                            👁
                                        </a>

                                        <a
                                            href="{{ route('organization.admin.events.edit', $event) }}"
                                            class="action-btn edit-btn"
                                            title="Edit"
                                        >
                                            ✏
                                        </a>

                                        <form
                                            action="{{ route('organization.admin.events.destroy', $event) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this event?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete-btn"
                                                title="Delete"
                                            >
                                                🗑
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($events->hasPages())

                <div class="pagination-wrapper">
                    {{ $events->links() }}
                </div>

            @endif


        @else

            {{-- Empty State --}}

            <div class="empty-state">

                <div class="empty-icon">
                    🎫
                </div>

                <h3>No Events Yet</h3>

                <p>
                    Your organization has not created any events yet.
                </p>

                <a
                    href="{{ route('organization.admin.events.create') }}"
                    class="add-btn"
                >
                    ＋ Create Your First Event
                </a>

            </div>

        @endif

    </div>

</div>

</body>
@include('organization_admin.partials.live-search')
</html>
