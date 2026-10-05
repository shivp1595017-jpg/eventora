<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bookings - Eventora</title>

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

        .booking-count {
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
            min-width: 1050px;
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

        .booking-number {
            font-weight: 700;
            color: #4f46e5;
        }

        .customer-name {
            font-weight: 600;
        }

        .customer-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 190px;
        }

        .customer-avatar {
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

        .customer-avatar img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
        }

        .event-name {
            font-weight: 600;
        }

        .muted {
            color: #6b7280;
            font-size: 13px;
            margin-top: 4px;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-paid,
        .status-confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-failed,
        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .amount {
            font-weight: 700;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-form {
            margin: 0;
        }

        .action-btn {
            border: none;
            color: white;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .confirm-btn {
            background: #16a34a;
        }

        .confirm-btn:hover {
            background: #15803d;
        }

        .cancel-btn {
            background: #dc2626;
        }

        .cancel-btn:hover {
            background: #b91c1c;
        }

        .action-done {
            font-size: 12px;
            font-weight: 600;
        }

        .action-confirmed {
            color: #166534;
        }

        .action-cancelled {
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

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
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
                <h1>📋 Bookings</h1>
                <p class="muted">Manage bookings for your events</p>
            </div>

            <div class="admin-badge">
                Organization Admin
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('organization.admin.bookings.index') }}" data-live-search style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search booking, participant, email or event" style="flex:1;min-width:220px;padding:11px;border:1px solid #dce2ec;border-radius:9px">
            <button type="submit" style="padding:10px 14px;border:0;border-radius:9px;background:#6c63ff;color:#fff;font-weight:700">Search</button>
            @include('organization_admin.partials.export-toolbar', ['exportResource' => 'bookings'])
        </form>

        <div class="page-card">

            <div class="page-header">
                <h2>All Bookings</h2>

                <div class="booking-count">
                    {{ $bookings->total() }} bookings
                </div>
            </div>

            @if($bookings->count() > 0)

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Customer</th>
                                <th>Event</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Booking Status</th>
                                <th>Actions</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($bookings as $booking)

                                <tr>

                                    {{-- Booking Number --}}
                                    <td>
                                        <div class="booking-number">
                                            {{ $booking->booking_number }}
                                        </div>
                                    </td>

                                    {{-- Customer --}}
                                    <td>
                                        <div class="customer-cell">
                                            <div class="customer-avatar">
                                                <span>{{ strtoupper(substr($booking->user?->name ?? 'G', 0, 1)) }}</span>
                                                @if($booking->user?->profilePhotoUrl())
                                                    <img src="{{ $booking->user->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="customer-name">
                                                    {{ $booking->user->name ?? 'Guest User' }}
                                                </div>

                                                <div class="muted">
                                                    {{ $booking->user->email ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Event --}}
                                    <td>
                                        <div class="event-name">
                                            {{ $booking->event->title ?? 'Event Deleted' }}
                                        </div>
                                    </td>

                                    {{-- Quantity --}}
                                    <td>
                                        {{ $booking->quantity }}
                                    </td>

                                    {{-- Amount --}}
                                    <td>
                                        <span class="amount">
                                            ₹{{ number_format($booking->total_amount, 2) }}
                                        </span>
                                    </td>

                                    {{-- Payment Status --}}
                                    <td>

                                        @if($booking->payment_status === 'paid')

                                            <span class="status status-paid">
                                                Paid
                                            </span>

                                        @elseif($booking->payment_status === 'failed')

                                            <span class="status status-failed">
                                                Failed
                                            </span>

                                        @elseif($booking->payment_status === 'refunded')

                                            <span class="status status-cancelled">
                                                Refunded
                                            </span>

                                        @else

                                            <span class="status status-pending">
                                                Pending
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Booking Status --}}
                                    <td>

                                        @if($booking->booking_status === 'confirmed')

                                            <span class="status status-confirmed">
                                                Confirmed
                                            </span>

                                        @elseif($booking->booking_status === 'cancelled')

                                            <span class="status status-cancelled">
                                                Cancelled
                                            </span>

                                        @else

                                            <span class="status status-pending">
                                                Pending
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Actions --}}
                                    <td>

                                        @if($booking->booking_status === 'pending')

                                            <div class="actions">

                                                {{-- Confirm --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('organization.admin.bookings.confirm', $booking) }}"
                                                    class="action-form"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="action-btn confirm-btn"
                                                    >
                                                        ✓ Confirm
                                                    </button>
                                                </form>

                                                {{-- Cancel --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('organization.admin.bookings.cancel', $booking) }}"
                                                    class="action-form"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="action-btn cancel-btn"
                                                    >
                                                        ✕ Cancel
                                                    </button>
                                                </form>

                                            </div>

                                        @elseif($booking->booking_status === 'confirmed')

                                            <span class="action-done action-confirmed">
                                                ✓ Confirmed
                                            </span>

                                        @else

                                            <span class="action-done action-cancelled">
                                                ✕ Cancelled
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        {{ $booking->created_at->format('d M Y') }}

                                        <div class="muted">
                                            {{ $booking->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="pagination">
                    {{ $bookings->links() }}
                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        📋
                    </div>

                    <h3>No Bookings Yet</h3>

                    <p>
                        Bookings for your events will appear here.
                    </p>

                </div>

            @endif

        </div>

    </main>

</body>
@include('organization_admin.partials.live-search')
</html>
