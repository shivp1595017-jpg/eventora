<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Ticket - {{ $booking->event->title }} | Eventora
    </title>

    @php

        /*
        |--------------------------------------------------------------------------
        | Local QR Code
        |--------------------------------------------------------------------------
        | QR is generated locally using endroid/qr-code.
        | No external QR API is required.
        */

        $qrBuilder = new \Endroid\QrCode\Builder\Builder(
            writer: new \Endroid\QrCode\Writer\SvgWriter(),
            data: $booking->booking_number,
            size: 220,
            margin: 10
        );

        $qrResult = $qrBuilder->build();

        $qrDataUri = $qrResult->getDataUri();

        $eventDateTime = null;

        if (
            $booking->event->event_date
        ) {

            $eventDateTime = \Carbon\Carbon::parse(
                $booking->event->event_date .
                ' ' .
                ($booking->event->event_time ?? '23:59:59')
            );

        }

        $eventCompleted =
            $eventDateTime &&
            $eventDateTime->isPast();

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

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: var(--bg);

            color: var(--text);

            min-height: 100vh;

            line-height: 1.6;

        }

        a {

            text-decoration: none;

            color: inherit;

        }

        .ticket-page {

            width: min(900px, 94%);

            margin: 45px auto 80px;

        }

        /* =========================
           TOP ACTIONS
        ========================= */

        .top-actions {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

            margin-bottom: 18px;

        }

        .back-link {

            color: var(--muted);

            font-size: 14px;

            font-weight: 600;

        }

        .back-link:hover {

            color: var(--primary);

        }

        .print-btn {

            border: 1px solid var(--border);

            background: var(--card);

            color: var(--text);

            padding: 9px 15px;

            border-radius: 9px;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;

        }

        .print-btn:hover {

            border-color: var(--primary);

            transform: translateY(-1px);

        }

        /* =========================
           TICKET
        ========================= */

        .ticket-card {

            background: var(--card);

            border: 1px solid var(--border);

            border-radius: 22px;

            overflow: hidden;

            box-shadow:
                0 20px 60px
                rgba(0, 0, 0, .25);

        }

        /* HEADER */

        .ticket-header {

            padding: 30px 35px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

        }

        .ticket-brand {

            font-size: 26px;

            font-weight: 800;

            color: white;

        }

        .ticket-brand span {

            color: #ded9ff;

        }

        .ticket-label {

            font-size: 12px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1.6px;

            color: white;

            opacity: .9;

        }

        /* BODY */

        .ticket-body {

            padding: 35px;

        }

        .event-title {

            font-size: 31px;

            line-height: 1.25;

            margin-bottom: 8px;

        }

        .organization {

            color: var(--muted);

            font-size: 14px;

            margin-bottom: 28px;

        }

        .ticket-content {

            display: grid;

            grid-template-columns:
                1fr 230px;

            gap: 35px;

            align-items: center;

        }

        /* DETAILS */

        .details {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 16px;

        }

        .detail-box {

            padding: 17px;

            background: var(--card2);

            border: 1px solid var(--border);

            border-radius: 12px;

        }

        .detail-box span {

            display: block;

            color: var(--muted);

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: .4px;

            margin-bottom: 6px;

        }

        .detail-box strong {

            display: block;

            color: var(--text);

            font-size: 14px;

            word-break: break-word;

        }

        .ticket-attendee {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ticket-attendee-avatar {
            position: relative;
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            overflow: hidden;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: #fff;
            font-size: 16px;
            font-weight: 800;
        }

        .ticket-attendee-avatar img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
        }

        .paid {

            color: var(--success) !important;

        }

        .confirmed {

            color: var(--success) !important;

        }

        /* QR */

        .qr-box {

            padding: 15px;

            background: #ffffff;

            border-radius: 16px;

            text-align: center;

            box-shadow:
                0 12px 25px
                rgba(0, 0, 0, .12);

        }

        .qr-box img {

            width: 190px;

            height: 190px;

            display: block;

            margin: auto;

        }

        .qr-box p {

            color: #172033;

            font-size: 12px;

            font-weight: 800;

            margin-top: 10px;

        }

        .qr-number {

            color: #64748b;

            font-size: 10px;

            margin-top: 4px;

            word-break: break-all;

        }

        /* DIVIDER */

        .ticket-divider {

            border-top:
                1px dashed var(--border);

            margin: 30px 0;

        }

        /* BOOKING NUMBER */

        .booking-number {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

        }

        .booking-number span {

            color: var(--muted);

            font-size: 13px;

        }

        .booking-number strong {

            color: var(--primary);

            font-size: 17px;

            letter-spacing: 1.2px;

            word-break: break-all;

        }

        /* NOTICE */

        .ticket-note {

            margin-top: 25px;

            padding: 15px 17px;

            border-radius: 12px;

            background:
                rgba(108, 99, 255, .08);

            border:
                1px solid
                rgba(108, 99, 255, .22);

            color: var(--muted);

            font-size: 12px;

            line-height: 1.7;

        }

        .ticket-note strong {

            color: var(--text);

        }

        .completed-note {

            background:
                rgba(245, 158, 11, .08);

            border-color:
                rgba(245, 158, 11, .22);

        }

        /* FOOTER */

        .ticket-footer {

            padding: 22px 35px;

            border-top:
                1px solid var(--border);

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

        }

        .ticket-footer p {

            color: var(--muted);

            font-size: 11px;

        }

        .my-bookings-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 10px 17px;

            border-radius: 9px;

            background: var(--card2);

            border: 1px solid var(--border);

            color: var(--text);

            font-size: 12px;

            font-weight: 700;

            transition: .2s;

        }

        .my-bookings-btn:hover {

            border-color: var(--primary);

            color: var(--primary);

        }

        /* =========================
           LIGHT
        ========================= */

        html[data-theme="light"] body {

            background: #f5f7fb;

        }

        html[data-theme="light"] .ticket-card {

            background: #ffffff;

            border-color: #e1e6ef;

            box-shadow:
                0 20px 50px
                rgba(20, 30, 50, .08);

        }

        html[data-theme="light"] .detail-box {

            background: #f7f8fb;

            border-color: #e1e6ef;

        }

        html[data-theme="light"] .detail-box strong {

            color: #172033;

        }

        html[data-theme="light"] .ticket-divider {

            border-top-color: #dce2ec;

        }

        html[data-theme="light"] .ticket-note {

            color: #687386;

        }

        html[data-theme="light"] .ticket-note strong {

            color: #172033;

        }

        html[data-theme="light"] .my-bookings-btn {

            background: #f7f8fb;

            border-color: #e1e6ef;

            color: #172033;

        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            body {

                background: white;

                color: #111827;

            }

            .top-actions,
            .ticket-footer,
            nav,
            footer {

                display: none !important;

            }

            .ticket-page {

                width: 100%;

                margin: 0;

            }

            .ticket-card {

                border: 1px solid #ddd;

                box-shadow: none;

            }

        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 750px) {

            .ticket-page {

                width: 94%;

                margin-top: 25px;

            }

            .ticket-content {

                grid-template-columns: 1fr;

            }

            .qr-box {

                width: 230px;

                margin: auto;

            }

        }

        @media (max-width: 600px) {

            .top-actions {

                align-items: flex-start;

            }

            .ticket-header {

                padding: 24px;

                flex-direction: column;

                align-items: flex-start;

            }

            .ticket-body {

                padding: 23px;

            }

            .ticket-footer {

                padding: 20px 23px;

                flex-direction: column;

                align-items: flex-start;

            }

            .details {

                grid-template-columns: 1fr;

            }

            .booking-number {

                flex-direction: column;

                align-items: flex-start;

            }

            .event-title {

                font-size: 27px;

            }

        }

    </style>

</head>


<body>

    @include('layouts.navbar')


    <main class="ticket-page">

        {{-- TOP ACTIONS --}}

        <div class="top-actions">

            <a
                href="{{ route('bookings.index') }}"
                class="back-link"
            >
                ← My Bookings
            </a>

            <button
                type="button"
                class="print-btn"
                onclick="window.print()"
            >
                🖨 Print / Save PDF
            </button>

        </div>


        <div class="ticket-card">

            {{-- HEADER --}}

            <div class="ticket-header">

                <div class="ticket-brand">
                    Event<span>ora</span>
                </div>

                <div class="ticket-label">
                    Confirmed Event Ticket
                </div>

            </div>


            {{-- BODY --}}

            <div class="ticket-body">

                <h1 class="event-title">
                    {{ $booking->event->title }}
                </h1>

                <p class="organization">
                    🏢
                    {{ $booking->event->organization->name }}
                </p>


                <div class="ticket-content">

                    {{-- DETAILS --}}

                    <div class="details">

                        <div class="detail-box">

                            <span>
                                Attendee
                            </span>

                            <div class="ticket-attendee">
                                <div class="ticket-attendee-avatar">
                                    <span>{{ strtoupper(substr($booking->user?->name ?? 'N', 0, 1)) }}</span>
                                    @if($booking->user?->profilePhotoUrl())
                                        <img src="{{ $booking->user->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">
                                    @endif
                                </div>
                                <strong>{{ $booking->user?->name ?? 'N/A' }}</strong>
                            </div>

                        </div>


                        <div class="detail-box">

                            <span>
                                Email
                            </span>

                            <strong>
                                {{ $booking->user->email }}
                            </strong>

                        </div>


                        <div class="detail-box">

                            <span>
                                Event Date
                            </span>

                            <strong>

                                {{
                                    \Carbon\Carbon::parse(
                                        $booking->event->event_date
                                    )->format('d M Y')
                                }}

                            </strong>

                        </div>


                        <div class="detail-box">

                            <span>
                                Event Time
                            </span>

                            <strong>

                                @if($booking->event->event_time)

                                    {{
                                        \Carbon\Carbon::parse(
                                            $booking->event->event_time
                                        )->format('h:i A')
                                    }}

                                @else

                                    Not specified

                                @endif

                            </strong>

                        </div>


                        <div class="detail-box">

                            <span>
                                Venue
                            </span>

                            <strong>

                                {{
                                    $booking->event->venue
                                    ?? 'Not specified'
                                }}

                            </strong>

                        </div>


                        @if($booking->event->city)

                            <div class="detail-box">

                                <span>
                                    City
                                </span>

                                <strong>
                                    {{ $booking->event->city }}
                                </strong>

                            </div>

                        @endif


                        <div class="detail-box">

                            <span>
                                Ticket
                            </span>

                            <strong>
                                1 Ticket
                            </strong>

                        </div>


                        <div class="detail-box">

                            <span>
                                Ticket Price
                            </span>

                            <strong>

                                @if($booking->ticket_price > 0)

                                    ₹{{ number_format(
                                        $booking->ticket_price,
                                        2
                                    ) }}

                                @else

                                    FREE

                                @endif

                            </strong>

                        </div>


                        <div class="detail-box">

                            <span>
                                Payment Status
                            </span>

                            <strong class="paid">

                                {{ ucfirst(
                                    $booking->payment_status
                                ) }}

                            </strong>

                        </div>


                        <div class="detail-box">

                            <span>
                                Booking Status
                            </span>

                            <strong class="confirmed">

                                {{ ucfirst(
                                    $booking->booking_status
                                ) }}

                            </strong>

                        </div>


                        @if($booking->payment_id)

                            <div class="detail-box">

                                <span>
                                    Payment ID
                                </span>

                                <strong>
                                    {{ $booking->payment_id }}
                                </strong>

                            </div>

                        @endif


                        <div class="detail-box">

                            <span>
                                Quantity
                            </span>

                            <strong>
                                1
                            </strong>

                        </div>

                    </div>


                    {{-- QR --}}

                    <div class="qr-box">

                        <img
                            src="{{ $qrDataUri }}"
                            alt="Eventora Ticket QR Code"
                        >

                        <p>
                            Scan Ticket
                        </p>

                        <div class="qr-number">
                            {{ $booking->booking_number }}
                        </div>

                    </div>

                </div>


                {{-- DIVIDER --}}

                <div class="ticket-divider"></div>


                {{-- BOOKING NUMBER --}}

                <div class="booking-number">

                    <span>
                        Booking Number
                    </span>

                    <strong>
                        {{ $booking->booking_number }}
                    </strong>

                </div>


                {{-- NOTE --}}

                @if($eventCompleted)

                    <div class="ticket-note completed-note">

                        <strong>
                            Event Completed:
                        </strong>

                        This ticket is from a completed event.
                        Keep it for your booking history.

                    </div>

                @else

                    <div class="ticket-note">

                        <strong>
                            Important:
                        </strong>

                        Please keep this ticket and QR code
                        available when attending the event.
                        This ticket represents one confirmed
                        registration for the selected event.

                    </div>

                @endif

            </div>


            {{-- FOOTER --}}

            <div class="ticket-footer">

                <p>
                    This ticket is generated by Eventora.
                </p>

                <a
                    href="{{ route('bookings.index') }}"
                    class="my-bookings-btn"
                >
                    My Bookings →
                </a>

            </div>

        </div>

    </main>


    @include('layouts.footer')


    <script>

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

    </script>

</body>

</html>