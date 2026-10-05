<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pending Events | Eventora Admin</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #111827;
        }

        .admin-main {
            margin-left: 270px;
            min-height: 100vh;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 20px;
        }

        .title-area h1 {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .title-area p {
            color: #6b7280;
            font-size: 14px;
        }

        .back-btn {
            text-decoration: none;
            color: #374151;
            background: white;
            border: 1px solid #e5e7eb;
            padding: 11px 16px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .back-btn:hover {
            background: #f9fafb;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .events-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #f9fafb;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            text-align: left;
            padding: 15px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 17px 18px;
            border-bottom: 1px solid #f0f1f3;
            vertical-align: middle;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .event-name {
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .category {
            display: inline-block;
            background: #eff6ff;
            color: #2563eb;
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
        }

        .organization {
            font-weight: 600;
            color: #374151;
        }

        .date {
            color: #374151;
        }

        .location {
            color: #6b7280;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 15px;
            background: #fef3c7;
            color: #92400e;
            font-size: 11px;
            font-weight: 700;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .action-btn {
            border: none;
            border-radius: 7px;
            padding: 8px 11px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .approve-btn {
            background: #dcfce7;
            color: #166534;
        }

        .approve-btn:hover {
            background: #bbf7d0;
        }

        .reject-btn {
            background: #fee2e2;
            color: #991b1b;
        }

        .reject-btn:hover {
            background: #fecaca;
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .empty-state h2 {
            font-size: 20px;
            margin-bottom: 7px;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 14px;
        }

        .pagination {
            padding: 18px;
            border-top: 1px solid #e5e7eb;
        }

        @media (max-width: 900px) {

            .admin-main {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                align-items: flex-start;
            }
        }

        @media (max-width: 600px) {

            .admin-main {
                padding: 15px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .title-area h1 {
                font-size: 23px;
            }

            .back-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="admin-main">

    {{-- Header --}}
    <div class="topbar">

        <div class="title-area">
            <h1>Pending Events</h1>
            <p>Review events submitted by organizations.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            ← Dashboard
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    {{-- Events --}}
    <div class="events-card">

        @if($events->count())

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Organization</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($events as $event)

                            <tr>

                                {{-- Event --}}
                                <td>

                                    <div class="event-name">
                                        {{ $event->title }}
                                    </div>

                                    <span class="category">
                                        {{ $event->category }}
                                    </span>

                                </td>


                                {{-- Organization --}}
                                <td>

                                    <div class="organization">
                                        {{ optional($event->organization)->name ?? 'N/A' }}
                                    </div>

                                </td>


                                {{-- Date --}}
                                <td>

                                    <div class="date">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                    </div>

                                    <div class="location">
                                        {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                                    </div>

                                </td>


                                {{-- Location --}}
                                <td>

                                    <div class="location">
                                        {{ $event->venue }}
                                    </div>

                                    <div class="location">
                                        {{ $event->city }}
                                    </div>

                                </td>


                                {{-- Price --}}
                                <td>

                                    @if($event->ticket_price > 0)

                                        ₹{{ number_format($event->ticket_price, 2) }}

                                    @else

                                        <strong style="color:#059669;">
                                            Free
                                        </strong>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span class="status">
                                        Pending
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="actions">

                                        {{-- Approve --}}
                                        <form
                                            action="{{ route('admin.events.approve', $event) }}"
                                            method="POST"
                                            onsubmit="return confirm('Approve this event?');"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="action-btn approve-btn"
                                            >
                                                ✓ Approve
                                            </button>

                                        </form>


                                        {{-- Reject --}}
                                        <form
                                            action="{{ route('admin.events.reject', $event) }}"
                                            method="POST"
                                            onsubmit="return confirm('Reject this event?');"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="action-btn reject-btn"
                                            >
                                                ✕ Reject
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
            <div class="pagination">

                {{ $events->links() }}

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    🎉
                </div>

                <h2>No Pending Events</h2>

                <p>
                    There are currently no events waiting for approval.
                </p>

            </div>

        @endif

    </div>

</div>

</body>
</html>