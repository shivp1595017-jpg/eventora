<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Participants - Eventora</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #1f2937;
        }

        .admin-main {
            margin-left: 260px;
            padding: 30px;
        }

        .mobile-header {
            display: none;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .topbar h1 {
            font-size: 28px;
            font-weight: 700;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-top: 6px;
        }

        .admin-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 9px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .page-card {
            background: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .page-header h2 {
            font-size: 20px;
        }

        .participant-count {
            color: #6b7280;
            font-size: 14px;
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

        th {
            background: #f8fafc;
            color: #64748b;
            font-size: 13px;
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover {
            background: #fafbff;
        }

        .participant-name {
            font-weight: 700;
        }

        .participant-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 190px;
        }

        .participant-avatar {
            position: relative;
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            overflow: hidden;
            border-radius: 50%;
            background: linear-gradient(135deg, #6c63ff, #8b5cf6);
            color: white;
            font-size: 16px;
            font-weight: 800;
        }

        .participant-avatar img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
        }

        .email {
            color: #6b7280;
            font-size: 13px;
            margin-top: 4px;
        }

        .event-name {
            font-weight: 600;
        }

        .booking-number {
            color: #4f46e5;
            font-weight: 600;
            font-size: 13px;
        }

        .tickets {
            font-weight: 600;
        }

        .amount {
            font-weight: 700;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-icon {
            font-size: 55px;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #6b7280;
        }

        .pagination {
            margin-top: 22px;
        }

        @media (max-width: 900px) {

            .admin-main {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: white;
                padding: 15px 20px;
                margin: -20px -20px 25px;
                box-shadow: 0 2px 10px rgba(0,0,0,.05);
            }

            .mobile-header h2 {
                font-size: 20px;
            }

            .menu-btn {
                border: none;
                background: #4f46e5;
                color: white;
                width: 42px;
                height: 42px;
                border-radius: 10px;
                font-size: 20px;
                cursor: pointer;
            }
        }

        @media (max-width: 600px) {

            .admin-main {
                padding: 15px;
            }

            .mobile-header {
                margin: -15px -15px 20px;
            }

            .topbar {
                align-items: flex-start;
                gap: 12px;
            }

            .topbar h1 {
                font-size: 23px;
            }

            .admin-badge {
                font-size: 12px;
                padding: 7px 10px;
            }

            .page-card {
                padding: 15px;
                border-radius: 14px;
            }
        }
    </style>
</head>

<body>

    @include('organization_admin.sidebar')

    <main class="admin-main">

        <div class="mobile-header">
            <button class="menu-btn" onclick="openAdminSidebar()">☰</button>
            <h2>Eventora</h2>
        </div>

        <div class="topbar">

            <div>
                <h1>👥 Participants</h1>

                <p class="subtitle">
                    View participants registered for your events
                </p>
            </div>

            <div class="admin-badge">
                Organization Admin
            </div>

        </div>

        <form method="GET" action="{{ route('organization.admin.participants.index') }}" data-live-search style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search booking, participant, email or event" style="flex:1;min-width:220px;padding:11px;border:1px solid #dce2ec;border-radius:9px">
            <button type="submit" style="padding:10px 14px;border:0;border-radius:9px;background:#6c63ff;color:#fff;font-weight:700">Search</button>
            @include('organization_admin.partials.export-toolbar', ['exportResource' => 'participants'])
        </form>

        <div class="page-card">

            <div class="page-header">

                <h2>All Participants</h2>

                <div class="participant-count">
                    {{ $participants->total() }} participants
                </div>

            </div>

            @if($participants->count() > 0)

                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>
                                <th>Participant</th>
                                <th>Event</th>
                                <th>Booking</th>
                                <th>Tickets</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Registered</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($participants as $participant)

                                <tr>

                                    {{-- Participant --}}
                                    <td>
                                        <div class="participant-cell">
                                            <div class="participant-avatar">
                                                <span>{{ strtoupper(substr($participant->user?->name ?? 'G', 0, 1)) }}</span>
                                                @if($participant->user?->profilePhotoUrl())
                                                    <img src="{{ $participant->user->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="participant-name">
                                                    {{ $participant->user->name ?? 'Guest User' }}
                                                </div>

                                                <div class="email">
                                                    {{ $participant->user->email ?? '-' }}
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    {{-- Event --}}
                                    <td>

                                        <div class="event-name">
                                            {{ $participant->event->title ?? 'Event Deleted' }}
                                        </div>

                                    </td>

                                    {{-- Booking Number --}}
                                    <td>

                                        <div class="booking-number">
                                            {{ $participant->booking_number }}
                                        </div>

                                    </td>

                                    {{-- Tickets --}}
                                    <td>

                                        <span class="tickets">
                                            {{ $participant->quantity }}
                                        </span>

                                    </td>

                                    {{-- Amount --}}
                                    <td>

                                        <span class="amount">
                                            ₹{{ number_format($participant->total_amount, 2) }}
                                        </span>

                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        @if($participant->booking_status === 'confirmed')

                                            <span class="status confirmed">
                                                ✓ Confirmed
                                            </span>

                                        @elseif($participant->booking_status === 'cancelled')

                                            <span class="status cancelled">
                                                ✕ Cancelled
                                            </span>

                                        @else

                                            <span class="status pending">
                                                ⏳ Pending
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Registered Date --}}
                                    <td>

                                        {{ $participant->created_at->format('d M Y') }}

                                        <div class="email">
                                            {{ $participant->created_at->format('h:i A') }}
                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="pagination">
                    {{ $participants->links() }}
                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        👥
                    </div>

                    <h3>No Participants Yet</h3>

                    <p>
                        Participants registered for your events will appear here.
                    </p>

                </div>

            @endif

        </div>

    </main>

</body>
@include('organization_admin.partials.live-search')
</html>
