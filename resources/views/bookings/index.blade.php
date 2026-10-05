<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Bookings - Eventora</title>

    @php

        $upcomingBookings = collect();
        $pastBookings = collect();

        foreach ($bookings as $booking) {

            $eventDateTime = null;

            if (
                $booking->event &&
                $booking->event->event_date
            ) {

                $eventDateTime = \Carbon\Carbon::parse(
                    $booking->event->event_date .
                    ' ' .
                    ($booking->event->event_time ?? '23:59:59')
                );

            }

            if (
                $eventDateTime &&
                $eventDateTime->isFuture() &&
                $booking->booking_status !== 'cancelled'
            ) {

                $upcomingBookings->push($booking);

            } else {

                $pastBookings->push($booking);

            }

        }

    @endphp

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #070b14;
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
            --card: #ffffff;
            --card2: #f8faff;
            --text: #111827;
            --muted: #64748b;
            --border: #dce2ec;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .page-wrapper {
            width: min(1200px, 92%);
            margin: 45px auto 80px;
        }

        /* =========================
           HEADER
        ========================= */

        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 34px;
            margin-bottom: 7px;
        }

        .page-title p {
            color: var(--muted);
            font-size: 14px;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 38px;
        }

        .summary-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 17px;
            padding: 22px;
        }

        .summary-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 7px;
        }

        .summary-value {
            font-size: 26px;
            font-weight: 800;
        }

        .summary-card.primary {
            border-color: rgba(108, 99, 255, .30);
            background:
                linear-gradient(
                    135deg,
                    rgba(108, 99, 255, .12),
                    var(--card)
                );
        }

        .summary-card.success {
            border-color: rgba(34, 197, 94, .25);
        }

        .summary-card.warning {
            border-color: rgba(245, 158, 11, .25);
        }

        /* =========================
           SECTION
        ========================= */

        .booking-section {
            margin-top: 40px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 15px;
            margin-bottom: 18px;
        }

        .section-heading h2 {
            font-size: 24px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 12px;
        }

        /* =========================
           GRID
        ========================= */

        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .booking-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 19px;
            overflow: hidden;
            transition: .25s;
        }

        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(0, 0, 0, .13);
            border-color: rgba(108, 99, 255, .55);
        }

        .card-top {
            padding: 24px;
            background:
                linear-gradient(
                    135deg,
                    #18233b,
                    #101625
                );
        }

        .card-top h3 {
            font-size: 21px;
            line-height: 1.35;
            margin-bottom: 9px;
        }

        .organization {
            color: #9ca8bd;
            font-size: 13px;
        }

        .card-body {
            padding: 22px 24px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            color: var(--muted);
            font-size: 13px;
        }

        .value {
            text-align: right;
            font-weight: 600;
            font-size: 13px;
            word-break: break-word;
        }

        /* =========================
           STATUS
        ========================= */

        .status {
            display: inline-flex;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status.paid,
        .status.confirmed {
            background: rgba(34, 197, 94, .14);
            color: #69e394;
        }

        .status.pending {
            background: rgba(245, 158, 11, .14);
            color: #ffc65c;
        }

        .status.failed,
        .status.cancelled {
            background: rgba(239, 68, 68, .14);
            color: #ff8585;
        }

        /* =========================
           FOOTER ACTIONS
        ========================= */

        .card-footer {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 18px 24px;
            border-top: 1px solid var(--border);
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 13px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
            text-align: center;
        }

        .action-primary {
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary2)
            );
            color: #ffffff;
        }

        .action-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 17px rgba(108, 99, 255, .22);
        }

        .action-secondary {
            background: var(--card2);
            border: 1px solid var(--border);
            color: var(--text);
        }

        .action-secondary:hover {
            border-color: var(--primary);
        }

        .action-success {
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(34, 197, 94, .25);
            color: var(--success);
        }

        .action-warning {
            background: rgba(245, 158, 11, .12);
            border: 1px solid rgba(245, 158, 11, .25);
            color: var(--warning);
        }

        .action-danger {
            background: rgba(239, 68, 68, .10);
            border: 1px solid rgba(239, 68, 68, .20);
            color: var(--danger);
        }

        .full-action {
            grid-column: 1 / -1;
        }

        /* =========================
           EMPTY
        ========================= */

        .empty {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 55px 25px;
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 13px;
        }

        .empty h2 {
            margin-bottom: 7px;
            font-size: 23px;
        }

        .empty p {
            color: var(--muted);
            margin-bottom: 20px;
            font-size: 14px;
        }

        .browse-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary2)
            );
            color: #ffffff;
            padding: 12px 21px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        /* =========================
           LIGHT MODE
        ========================= */

        html[data-theme="light"] body {
            background: #f5f7fb;
            color: #172033;
        }

        html[data-theme="light"] .summary-card,
        html[data-theme="light"] .booking-card,
        html[data-theme="light"] .empty {
            background: #ffffff;
            border-color: #e1e6ef;
            box-shadow: 0 8px 25px rgba(20, 30, 50, .05);
        }

        html[data-theme="light"] .card-top {
            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f5f3ff
                );
            border-bottom: 1px solid #e1e6ef;
        }

        html[data-theme="light"] .card-top h3,
        html[data-theme="light"] .page-title h1,
        html[data-theme="light"] .summary-value,
        html[data-theme="light"] .section-heading h2 {
            color: #172033;
        }

        html[data-theme="light"] .organization,
        html[data-theme="light"] .page-title p {
            color: #687386;
        }

        html[data-theme="light"] .info-row {
            border-bottom-color: #e1e6ef;
        }

        html[data-theme="light"] .label {
            color: #687386;
        }

        html[data-theme="light"] .value {
            color: #172033;
        }

        html[data-theme="light"] .card-footer {
            border-top-color: #e1e6ef;
        }

        html[data-theme="light"] .action-secondary {
            background: #f7f8fb;
            border-color: #e1e6ef;
            color: #172033;
        }

        html[data-theme="light"] .empty p,
        html[data-theme="light"] .section-heading p {
            color: #687386;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .bookings-grid {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 600px) {

            .page-wrapper {
                width: 94%;
                margin-top: 25px;
            }

            .page-title h1 {
                font-size: 28px;
            }

            .card-top,
            .card-body {
                padding: 20px;
            }

            .card-footer {
                padding: 16px 20px;
                grid-template-columns: 1fr;
            }

            .full-action {
                grid-column: auto;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

        }

    </style>

</head>


<body>

    @include('layouts.navbar')


    <main class="page-wrapper">

        {{-- PAGE HEADER --}}

        <div class="page-title">

            <h1>
                My Bookings
            </h1>

            <p>
                Manage your event registrations, payments and tickets.
            </p>

        </div>


        {{-- SUMMARY --}}

        <div class="summary-grid">

            <div class="summary-card primary">

                <div class="summary-label">
                    Total Bookings
                </div>

                <div class="summary-value">
                    {{ $bookings->count() }}
                </div>

            </div>


            <div class="summary-card success">

                <div class="summary-label">
                    Upcoming
                </div>

                <div class="summary-value">
                    {{ $upcomingBookings->count() }}
                </div>

            </div>


            <div class="summary-card warning">

                <div class="summary-label">
                    Past / Other
                </div>

                <div class="summary-value">
                    {{ $pastBookings->count() }}
                </div>

            </div>

        </div>


        {{-- UPCOMING --}}

        <section class="booking-section">

            <div class="section-heading">

                <div>

                    <h2>
                        Upcoming Events
                    </h2>

                    <p>
                        Your active and upcoming registrations.
                    </p>

                </div>

            </div>


            @if($upcomingBookings->count())

                <div class="bookings-grid">

                    @foreach($upcomingBookings as $booking)

                        @php

                            $paymentStatus =
                                strtolower(
                                    $booking->payment_status ?? 'pending'
                                );

                            $bookingStatus =
                                strtolower(
                                    $booking->booking_status ?? 'pending'
                                );

                        @endphp


                        <article class="booking-card">

                            <div class="card-top">

                                <h3>
                                    {{ $booking->event->title }}
                                </h3>

                                <div class="organization">

                                    🏢
                                    {{ $booking->event->organization->name }}

                                </div>

                            </div>


                            <div class="card-body">

                                <div class="info-row">

                                    <span class="label">
                                        Booking Number
                                    </span>

                                    <span class="value">
                                        {{ $booking->booking_number }}
                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Event Date
                                    </span>

                                    <span class="value">

                                        {{
                                            \Carbon\Carbon::parse(
                                                $booking->event->event_date
                                            )->format('d M Y')
                                        }}

                                    </span>

                                </div>


                                @if($booking->event->event_time)

                                    <div class="info-row">

                                        <span class="label">
                                            Event Time
                                        </span>

                                        <span class="value">

                                            {{
                                                \Carbon\Carbon::parse(
                                                    $booking->event->event_time
                                                )->format('h:i A')
                                            }}

                                        </span>

                                    </div>

                                @endif


                                <div class="info-row">

                                    <span class="label">
                                        Venue
                                    </span>

                                    <span class="value">
                                        {{ $booking->event->venue ?? 'Not specified' }}
                                    </span>

                                </div>


                                @if($booking->event->city)

                                    <div class="info-row">

                                        <span class="label">
                                            City
                                        </span>

                                        <span class="value">
                                            {{ $booking->event->city }}
                                        </span>

                                    </div>

                                @endif


                                <div class="info-row">

                                    <span class="label">
                                        Amount
                                    </span>

                                    <span class="value">

                                        ₹{{ number_format(
                                            $booking->total_amount,
                                            2
                                        ) }}

                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Payment
                                    </span>

                                    <span class="value">

                                        <span
                                            class="status {{ $paymentStatus }}"
                                        >
                                            {{ $paymentStatus }}
                                        </span>

                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Booking
                                    </span>

                                    <span class="value">

                                        <span
                                            class="status {{ $bookingStatus }}"
                                        >
                                            {{ $bookingStatus }}
                                        </span>

                                    </span>

                                </div>

                            </div>


                            <div class="card-footer">

                                {{-- PAID / CONFIRMED --}}

                                @if(
                                    $paymentStatus === 'paid' &&
                                    $bookingStatus !== 'cancelled'
                                )

                                    <a
                                        href="{{ route(
                                            'bookings.ticket',
                                            $booking->id
                                        ) }}"
                                        class="action-btn action-success"
                                    >
                                        🎟️ View Ticket
                                    </a>

                                @else

                                    {{-- PAYMENT PENDING / FAILED --}}

                                    @if(
                                        $paymentStatus === 'pending' ||
                                        $paymentStatus === 'failed'
                                    )

                                        <a
                                            href="{{ route(
                                                'bookings.payment',
                                                $booking->id
                                            ) }}"
                                            class="
                                                action-btn
                                                action-warning
                                            "
                                        >
                                            💳
                                            {{
                                                $paymentStatus === 'failed'
                                                    ? 'Retry Payment'
                                                    : 'Complete Payment'
                                            }}
                                        </a>

                                    @else

                                        <span
                                            class="
                                                action-btn
                                                action-danger
                                            "
                                        >
                                            Ticket Unavailable
                                        </span>

                                    @endif

                                @endif


                                <a
                                    href="{{ route(
                                        'events.show',
                                        $booking->event->slug
                                    ) }}"
                                    class="
                                        action-btn
                                        action-secondary
                                    "
                                >
                                    View Event
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="empty">

                    <div class="empty-icon">
                        📅
                    </div>

                    <h2>
                        No Upcoming Bookings
                    </h2>

                    <p>
                        You don't have any upcoming event registrations.
                    </p>

                    <a
                        href="{{ route('events.index') }}"
                        class="browse-btn"
                    >
                        Explore Events
                    </a>

                </div>

            @endif

        </section>


        {{-- PAST / OTHER BOOKINGS --}}

        <section class="booking-section">

            <div class="section-heading">

                <div>

                    <h2>
                        Past & Other Bookings
                    </h2>

                    <p>
                        Previous, cancelled and completed registrations.
                    </p>

                </div>

            </div>


            @if($pastBookings->count())

                <div class="bookings-grid">

                    @foreach($pastBookings as $booking)

                        @php

                            $paymentStatus =
                                strtolower(
                                    $booking->payment_status ?? 'pending'
                                );

                            $bookingStatus =
                                strtolower(
                                    $booking->booking_status ?? 'pending'
                                );

                        @endphp


                        <article class="booking-card">

                            <div class="card-top">

                                <h3>
                                    {{ $booking->event->title }}
                                </h3>

                                <div class="organization">

                                    🏢
                                    {{ $booking->event->organization->name }}

                                </div>

                            </div>


                            <div class="card-body">

                                <div class="info-row">

                                    <span class="label">
                                        Booking Number
                                    </span>

                                    <span class="value">
                                        {{ $booking->booking_number }}
                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Event Date
                                    </span>

                                    <span class="value">

                                        {{
                                            \Carbon\Carbon::parse(
                                                $booking->event->event_date
                                            )->format('d M Y')
                                        }}

                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Amount
                                    </span>

                                    <span class="value">

                                        ₹{{ number_format(
                                            $booking->total_amount,
                                            2
                                        ) }}

                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Payment
                                    </span>

                                    <span class="value">

                                        <span
                                            class="status {{ $paymentStatus }}"
                                        >
                                            {{ $paymentStatus }}
                                        </span>

                                    </span>

                                </div>


                                <div class="info-row">

                                    <span class="label">
                                        Booking
                                    </span>

                                    <span class="value">

                                        <span
                                            class="status {{ $bookingStatus }}"
                                        >
                                            {{ $bookingStatus }}
                                        </span>

                                    </span>

                                </div>

                            </div>


                            <div class="card-footer">

                                @if(
                                    $paymentStatus === 'paid' &&
                                    $bookingStatus !== 'cancelled'
                                )

                                    <a
                                        href="{{ route(
                                            'bookings.ticket',
                                            $booking->id
                                        ) }}"
                                        class="
                                            action-btn
                                            action-success
                                        "
                                    >
                                        🎟️ View Ticket
                                    </a>

                                @else

                                    <span
                                        class="
                                            action-btn
                                            action-danger
                                        "
                                    >
                                        No Ticket
                                    </span>

                                @endif


                                <a
                                    href="{{ route(
                                        'events.show',
                                        $booking->event->slug
                                    ) }}"
                                    class="
                                        action-btn
                                        action-secondary
                                    "
                                >
                                    View Event
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="empty">

                    <div class="empty-icon">
                        🎫
                    </div>

                    <h2>
                        No Past Bookings
                    </h2>

                    <p>
                        Your previous bookings will appear here.
                    </p>

                    <a
                        href="{{ route('events.index') }}"
                        class="browse-btn"
                    >
                        Browse Events
                    </a>

                </div>

            @endif

        </section>

    </main>


    @include('layouts.footer')


    <script>

        const html =
            document.documentElement;

        const savedTheme =
            localStorage.getItem('eventora-theme') || 'dark';

        html.setAttribute(
            'data-theme',
            savedTheme
        );

    </script>

</body>

</html>