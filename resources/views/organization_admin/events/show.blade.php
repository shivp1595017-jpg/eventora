@include('organization_admin.sidebar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $event->title }} | Eventora Admin</title>

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
            margin-bottom: 25px;
        }

        .title-section {
            display: flex;
            align-items: center;
            gap: 12px;
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

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn,
        .edit-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 16px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .back-btn {
            background: white;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .back-btn:hover {
            background: #f9fafb;
        }

        .edit-btn {
            background: #111827;
            color: white;
            border: 1px solid #111827;
        }

        .edit-btn:hover {
            background: #374151;
        }

        .event-card {
            max-width: 1100px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .banner {
            width: 100%;
            height: 360px;
            background: #e5e7eb;
            overflow: hidden;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 70px;
            color: #9ca3af;
            background: #f3f4f6;
        }

        .event-content {
            padding: 30px;
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .event-title-area {
            flex: 1;
        }

        .category {
            display: inline-flex;
            padding: 6px 11px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .event-title {
            font-size: 30px;
            line-height: 1.25;
            color: #111827;
            margin-bottom: 10px;
        }

        .event-location {
            color: #6b7280;
            font-size: 14px;
        }

        .status {
            display: inline-flex;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            white-space: nowrap;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .info-card {
            padding: 18px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .info-icon {
            font-size: 21px;
            margin-bottom: 10px;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .unlimited {
            color: #2563eb;
        }

        .free {
            color: #059669;
        }

        .section {
            padding-top: 25px;
            border-top: 1px solid #e5e7eb;
        }

        .section h2 {
            font-size: 19px;
            color: #111827;
            margin-bottom: 12px;
        }

        .description {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .organization-box {
            margin-top: 25px;
            padding: 18px;
            border-radius: 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .organization-box-title {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .organization-name {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .bottom-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .delete-form {
            margin: 0;
        }

        .delete-btn {
            padding: 11px 16px;
            border-radius: 9px;
            background: white;
            border: 1px solid #fecaca;
            color: #dc2626;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #fef2f2;
        }

        @media (max-width: 1000px) {

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
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

            .banner {
                height: 300px;
            }
        }

        @media (max-width: 600px) {

            .admin-main {
                padding: 16px;
            }

            .topbar {
                flex-wrap: wrap;
            }

            .page-title h1 {
                font-size: 22px;
            }

            .page-title p {
                font-size: 13px;
            }

            .top-actions {
                width: 100%;
            }

            .back-btn,
            .edit-btn {
                flex: 1;
                justify-content: center;
            }

            .event-card {
                border-radius: 12px;
            }

            .banner {
                height: 210px;
            }

            .event-content {
                padding: 20px;
            }

            .event-header {
                flex-direction: column;
            }

            .event-title {
                font-size: 24px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .bottom-actions {
                flex-direction: column;
            }

            .delete-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="admin-main">

    {{-- Top Header --}}
    <div class="topbar">

        <div class="title-section">

            <button
                class="mobile-menu-btn"
                onclick="openAdminSidebar()"
                type="button"
            >
                ☰
            </button>

            <div class="page-title">
                <h1>Event Details</h1>
                <p>View complete information about this event.</p>
            </div>

        </div>

        <div class="top-actions">

            <a
                href="{{ route('organization.admin.events.index') }}"
                class="back-btn"
            >
                ← Back
            </a>

            <a
                href="{{ route('organization.admin.events.edit', $event) }}"
                class="edit-btn"
            >
                ✏ Edit Event
            </a>

        </div>

    </div>


    {{-- Event Card --}}
    <div class="event-card">

        {{-- Banner --}}
        <div class="banner">

            @if($event->banner)

                <img
                    src="{{ asset('storage/' . $event->banner) }}"
                    alt="{{ $event->title }}"
                >

            @else

                <div class="banner-placeholder">
                    🎫
                </div>

            @endif

        </div>


        <div class="event-content">

            {{-- Event Header --}}
            <div class="event-header">

                <div class="event-title-area">

                    <span class="category">
                        {{ $event->category }}
                    </span>

                    <h2 class="event-title">
                        {{ $event->title }}
                    </h2>

                    <div class="event-location">
                        📍 {{ $event->venue }}, {{ $event->city }}
                    </div>

                </div>


                {{-- Status --}}
                <span class="status status-{{ $event->status }}">
                    {{ $event->status }}
                </span>

            </div>


            {{-- Event Information --}}
            <div class="info-grid">

                {{-- Date --}}
                <div class="info-card">

                    <div class="info-icon">
                        📅
                    </div>

                    <div class="info-label">
                        Event Date
                    </div>

                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                    </div>

                </div>


                {{-- Time --}}
                <div class="info-card">

                    <div class="info-icon">
                        🕐
                    </div>

                    <div class="info-label">
                        Event Time
                    </div>

                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                    </div>

                </div>


                {{-- Price --}}
                <div class="info-card">

                    <div class="info-icon">
                        💰
                    </div>

                    <div class="info-label">
                        Ticket Price
                    </div>

                    <div class="info-value {{ $event->ticket_price == 0 ? 'free' : '' }}">

                        @if($event->ticket_price > 0)

                            ₹{{ number_format($event->ticket_price, 2) }}

                        @else

                            Free

                        @endif

                    </div>

                </div>


                {{-- Seats --}}
                <div class="info-card">

                    <div class="info-icon">
                        👥
                    </div>

                    <div class="info-label">
                        Seat Availability
                    </div>

                    <div class="info-value">

                        @if(is_null($event->total_seats))

                            <span class="unlimited">
                                ∞ Unlimited
                            </span>

                        @else

                            {{ $event->available_seats }}
                            / {{ $event->total_seats }}

                        @endif

                    </div>

                </div>

            </div>


            {{-- Description --}}
            <div class="section">

                <h2>
                    About This Event
                </h2>

                <div class="description">
                    {{ $event->description }}
                </div>

            </div>


            {{-- Organization --}}
            <div class="organization-box">

                <div class="organization-box-title">
                    ORGANIZATION
                </div>

                <div class="organization-name">

                    {{ optional($event->organization)->name ?? 'Organization' }}

                </div>

            </div>


            {{-- Bottom Actions --}}
            <div class="bottom-actions">

                <form
                    action="{{ route('organization.admin.events.destroy', $event) }}"
                    method="POST"
                    class="delete-form"
                    onsubmit="return confirm('Are you sure you want to delete this event?');"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="delete-btn"
                    >
                        🗑 Delete Event
                    </button>

                </form>

                <a
                    href="{{ route('organization.admin.events.edit', $event) }}"
                    class="edit-btn"
                >
                    ✏ Edit Event
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>