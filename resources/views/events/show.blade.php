<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $event->title }} - Eventora</title>

    @php
        $eventDate = $event->event_date
            ? \Carbon\Carbon::parse($event->event_date)
            : null;

        $eventDateTime = null;

        if ($event->event_date && $event->event_time) {
            $eventDateTime = \Carbon\Carbon::parse(
                $event->event_date . ' ' . $event->event_time
            );
        } elseif ($event->event_date) {
            $eventDateTime = $eventDate->copy()->endOfDay();
        }

        $isPast = $eventDateTime
            ? $eventDateTime->isPast()
            : false;

        $isSoldOut = $event->available_seats !== null
            && (int) $event->available_seats <= 0;

        $isAlreadyBooked = false;

        if (auth()->check()) {
            $isAlreadyBooked = $event->bookings()
                ->where('user_id', auth()->id())
                ->exists();
        }

        $relatedEvents = $relatedEvents ?? collect();

        $relatedEvents = $relatedEvents
            ->where('id', '!=', $event->id)
            ->take(4);
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
            --danger: #ef4444;
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
            background: var(--bg);
            color: var(--text);
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: min(1180px, 92%);
            margin: auto;
        }

        /* =========================
           PAGE
        ========================= */

        .event-page {
            padding: 42px 0 80px;
        }

        .breadcrumb {
            margin-bottom: 25px;
            color: var(--muted);
            font-size: 14px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .breadcrumb a {
            color: var(--primary);
            transition: .2s;
        }

        .breadcrumb a:hover {
            opacity: .8;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 25px;
            color: var(--muted);
            font-size: 14px;
            transition: .2s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        /* =========================
           HERO
        ========================= */

        .event-hero {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 35px;
            align-items: stretch;
        }

        .event-banner {
            min-height: 430px;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid var(--border);
            background:
                linear-gradient(135deg, #111a32, #1a1240);
            position: relative;
        }

        .event-banner img {
            width: 100%;
            height: 100%;
            min-height: 430px;
            object-fit: cover;
            display: block;
        }

        .banner-placeholder {
            height: 100%;
            min-height: 430px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 70px;
            font-weight: 800;
            background:
                radial-gradient(circle at 30% 30%, #4f46e5, transparent 35%),
                radial-gradient(circle at 80% 70%, #7c3aed, transparent 35%),
                #101827;
            color: #ffffff;
        }

        .event-info {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 32px;
            display: flex;
            flex-direction: column;
        }

        .category {
            display: inline-flex;
            width: fit-content;
            padding: 7px 13px;
            border-radius: 20px;
            background: rgba(108, 99, 255, .14);
            color: #8b82ff;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .event-info h1 {
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.15;
            margin-bottom: 18px;
            word-break: break-word;
        }

        .organization {
            color: var(--muted);
            margin-bottom: 25px;
        }

        .organization a {
            color: var(--primary);
            font-weight: 600;
        }

        .event-meta {
            display: grid;
            gap: 15px;
            margin-bottom: 28px;
        }

        .meta-item {
            display: flex;
            gap: 13px;
            align-items: flex-start;
        }

        .meta-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            flex-shrink: 0;
            font-size: 17px;
        }

        .meta-content small {
            display: block;
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .meta-content strong {
            font-size: 14px;
            word-break: break-word;
        }

        /* =========================
           PRICE
        ========================= */

        .price-box {
            border-top: 1px solid var(--border);
            padding-top: 22px;
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .price-label {
            color: var(--muted);
            font-size: 13px;
        }

        .price {
            font-size: 28px;
            font-weight: 800;
        }

        .free {
            color: var(--success);
        }

        .available-seat-number {
            font-size: 22px;
            font-weight: 800;
        }

        .seat-warning {
            color: var(--warning);
        }

        .seat-danger {
            color: var(--danger);
        }

        /* =========================
           BUTTONS
        ========================= */

        .book-btn {
            display: flex;
            width: 100%;
            min-height: 52px;
            margin-top: 20px;
            padding: 15px 20px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary2)
            );
            color: white;
            font-size: 15px;
            font-weight: 700;
            text-align: center;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .25s;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(108, 99, 255, .25);
        }

        .book-btn.disabled {
            background: #64748b;
            cursor: not-allowed;
            box-shadow: none;
            opacity: .85;
        }

        .book-btn.disabled:hover {
            transform: none;
        }

        .book-btn.success {
            background: linear-gradient(
                135deg,
                #16a34a,
                #22c55e
            );
        }

        .book-btn.danger {
            background: linear-gradient(
                135deg,
                #dc2626,
                #ef4444
            );
        }

        .login-note {
            margin-top: 10px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }

        /* =========================
           STATUS MESSAGE
        ========================= */

        .event-status {
            margin-top: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 13px;
            text-align: center;
            font-weight: 600;
            border: 1px solid var(--border);
            background: var(--card2);
        }

        .event-status.success {
            color: var(--success);
            border-color: rgba(34, 197, 94, .25);
            background: rgba(34, 197, 94, .08);
        }

        .event-status.warning {
            color: var(--warning);
            border-color: rgba(245, 158, 11, .25);
            background: rgba(245, 158, 11, .08);
        }

        .event-status.danger {
            color: var(--danger);
            border-color: rgba(239, 68, 68, .25);
            background: rgba(239, 68, 68, .08);
        }

        /* =========================
           CONTENT
        ========================= */

        .event-content {
            display: grid;
            grid-template-columns: 1.5fr .7fr;
            gap: 30px;
            margin-top: 35px;
        }

        .content-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
        }

        .content-card h2 {
            margin-bottom: 18px;
            font-size: 23px;
        }

        .description {
            color: var(--muted);
            white-space: pre-line;
            line-height: 1.85;
            font-size: 15px;
        }

        .side-card {
            height: fit-content;
        }

        .side-card h3 {
            margin-bottom: 18px;
            font-size: 19px;
        }

        .seat-info {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 13px 0;
            border-bottom: 1px solid var(--border);
        }

        .seat-info:last-child {
            border-bottom: none;
        }

        .seat-info span:first-child {
            color: var(--muted);
        }

        .seat-info strong {
            text-align: right;
        }

        /* =========================
           ORGANIZATION CARD
        ========================= */

        .organization-card {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--border);
        }

        .organization-card-title {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 9px;
        }

        .organization-card-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .organization-card-link {
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
           RELATED EVENTS
        ========================= */

        .related-section {
            margin-top: 55px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 22px;
        }

        .section-heading h2 {
            font-size: 28px;
            line-height: 1.2;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
            margin-top: 5px;
        }

        .view-all {
            color: var(--primary);
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .related-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            transition: .25s;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, .16);
        }

        .related-image {
            height: 175px;
            background:
                linear-gradient(135deg, #111a32, #1a1240);
            overflow: hidden;
        }

        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .related-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: 800;
            color: white;
            background:
                radial-gradient(
                    circle at 20% 20%,
                    #4f46e5,
                    transparent 40%
                ),
                radial-gradient(
                    circle at 80% 80%,
                    #7c3aed,
                    transparent 40%
                ),
                #101827;
        }

        .related-body {
            padding: 17px;
        }

        .related-category {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 15px;
            background: rgba(108, 99, 255, .12);
            color: #8b82ff;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .related-title {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 9px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-info {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .related-bottom {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: center;
            padding-top: 12px;
            margin-top: 10px;
            border-top: 1px solid var(--border);
        }

        .related-price {
            font-size: 14px;
            font-weight: 800;
        }

        .related-link {
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
        }

        .no-related {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 25px;
            color: var(--muted);
            text-align: center;
        }

        /* =========================
           LIGHT MODE
        ========================= */

        html[data-theme="light"] .event-banner {
            background: #e8edff;
        }

        html[data-theme="light"] .banner-placeholder {
            background:
                radial-gradient(
                    circle at 30% 30%,
                    #c7d2fe,
                    transparent 35%
                ),
                radial-gradient(
                    circle at 80% 70%,
                    #ddd6fe,
                    transparent 35%
                ),
                #eef2ff;
            color: #4338ca;
        }

        html[data-theme="light"] .related-placeholder {
            background:
                radial-gradient(
                    circle at 20% 20%,
                    #c7d2fe,
                    transparent 40%
                ),
                radial-gradient(
                    circle at 80% 80%,
                    #ddd6fe,
                    transparent 40%
                ),
                #eef2ff;
            color: #4338ca;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1050px) {
            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 850px) {
            .event-hero,
            .event-content {
                grid-template-columns: 1fr;
            }

            .event-banner,
            .banner-placeholder,
            .event-banner img {
                min-height: 300px;
            }
        }

        @media (max-width: 600px) {
            .event-page {
                padding-top: 25px;
            }

            .event-info,
            .content-card {
                padding: 22px;
            }

            .event-info h1 {
                font-size: 30px;
            }

            .price-box {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
            }

            .related-grid {
                grid-template-columns: 1fr;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .view-all {
                margin-top: -8px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <main class="event-page">

        <div class="container">

            {{-- BACK --}}
            <a
                href="{{ route('events.index') }}"
                class="back-link"
            >
                ← Back to Events
            </a>

            {{-- BREADCRUMB --}}
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>

                <span>/</span>

                <a href="{{ route('events.index') }}">
                    Events
                </a>

                <span>/</span>

                <a href="{{ route('organizations.show', $event->organization->slug) }}">
                    {{ $event->organization->name }}
                </a>

                <span>/</span>

                <span>{{ $event->title }}</span>
            </div>

            {{-- EVENT HERO --}}
            <section class="event-hero">

                {{-- BANNER --}}
                <div class="event-banner">

                    @if($event->banner)

                        <img
                            src="{{ asset('storage/' . $event->banner) }}"
                            alt="{{ $event->title }}"
                        >

                    @else

                        <div class="banner-placeholder">
                            {{ strtoupper(substr($event->title, 0, 1)) }}
                        </div>

                    @endif

                </div>

                {{-- EVENT INFO --}}
                <div class="event-info">

                    @if($event->category)

                        <span class="category">
                            {{ $event->category }}
                        </span>

                    @endif

                    <h1>{{ $event->title }}</h1>

                    <div class="organization">
                        Organized by

                        <a
                            href="{{ route('organizations.show', $event->organization->slug) }}"
                        >
                            {{ $event->organization->name }}
                        </a>
                    </div>

                    {{-- EVENT META --}}
                    <div class="event-meta">

                        @if($event->event_date)

                            <div class="meta-item">

                                <div class="meta-icon">
                                    📅
                                </div>

                                <div class="meta-content">

                                    <small>Date</small>

                                    <strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                    </strong>

                                </div>

                            </div>

                        @endif

                        @if($event->event_time)

                            <div class="meta-item">

                                <div class="meta-icon">
                                    ⏰
                                </div>

                                <div class="meta-content">

                                    <small>Time</small>

                                    <strong>
                                        {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                                    </strong>

                                </div>

                            </div>

                        @endif

                        @if($event->venue)

                            <div class="meta-item">

                                <div class="meta-icon">
                                    📍
                                </div>

                                <div class="meta-content">

                                    <small>Venue</small>

                                    <strong>
                                        {{ $event->venue }}
                                    </strong>

                                </div>

                            </div>

                        @endif

                        @if($event->city)

                            <div class="meta-item">

                                <div class="meta-icon">
                                    🌍
                                </div>

                                <div class="meta-content">

                                    <small>City</small>

                                    <strong>
                                        {{ $event->city }}
                                    </strong>

                                </div>

                            </div>

                        @endif

                    </div>

                    {{-- PRICE + SEATS --}}
                    <div class="price-box">

                        <div>

                            <div class="price-label">
                                Ticket Price
                            </div>

                            <div
                                class="price {{ $event->ticket_price == 0 ? 'free' : '' }}"
                            >

                                @if($event->ticket_price > 0)

                                    ₹{{ number_format($event->ticket_price, 2) }}

                                @else

                                    FREE

                                @endif

                            </div>

                        </div>

                        <div>

                            <div class="price-label">
                                Availability
                            </div>

                            <div
                                class="
                                    available-seat-number
                                    {{
                                        $isSoldOut
                                            ? 'seat-danger'
                                            : (
                                                $event->available_seats !== null
                                                && $event->available_seats <= 10
                                                    ? 'seat-warning'
                                                    : ''
                                            )
                                    }}
                                "
                            >

                                @if($event->available_seats === null)

                                    Unlimited

                                @elseif($isSoldOut)

                                    Sold Out

                                @else

                                    {{ $event->available_seats }}

                                    {{ $event->available_seats == 1 ? 'seat' : 'seats' }}

                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- BOOKING BUTTON STATE --}}
                    @auth

                        @if($isAlreadyBooked)

                            <div class="event-status success">
                                ✓ You have already booked this event.
                            </div>

                            <a
                                href="{{ route('bookings.index') }}"
                                class="book-btn success"
                            >
                                View My Bookings
                            </a>

                        @elseif($isPast)

                            <div class="event-status danger">
                                This event has already ended.
                            </div>

                            <div class="book-btn disabled">
                                Booking Closed
                            </div>

                        @elseif($isSoldOut)

                            <div class="event-status danger">
                                Sorry, this event is sold out.
                            </div>

                            <div class="book-btn disabled">
                                Sold Out
                            </div>

                        @else

                            <a
                                href="{{ route('bookings.create', $event->slug) }}"
                                class="book-btn"
                            >
                                Book Now — 1 Ticket
                            </a>

                            <div class="login-note">
                                One registered Eventora account can book only one ticket.
                            </div>

                        @endif

                    @else

                        @if($isPast)

                            <div class="event-status danger">
                                This event has already ended.
                            </div>

                            <div class="book-btn disabled">
                                Booking Closed
                            </div>

                        @elseif($isSoldOut)

                            <div class="event-status danger">
                                This event is currently sold out.
                            </div>

                            <div class="book-btn disabled">
                                Sold Out
                            </div>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="book-btn"
                            >
                                Login to Book
                            </a>

                            <div class="login-note">
                                Please login to continue with your booking.
                            </div>

                        @endif

                    @endauth

                </div>

            </section>

            {{-- DESCRIPTION + DETAILS --}}
            <section class="event-content">

                {{-- ABOUT --}}
                <div class="content-card">

                    <h2>
                        About This Event
                    </h2>

                    <div class="description">

                        @if($event->description)

                            {{ $event->description }}

                        @else

                            Event description will be available soon.

                        @endif

                    </div>

                    {{-- ORGANIZATION --}}
                    <div class="organization-card">

                        <div class="organization-card-title">
                            Organized By
                        </div>

                        <div class="organization-card-name">
                            {{ $event->organization->name }}
                        </div>

                        <a
                            href="{{ route('organizations.show', $event->organization->slug) }}"
                            class="organization-card-link"
                        >
                            View Organization →
                        </a>

                    </div>

                </div>

                {{-- EVENT DETAILS --}}
                <div class="content-card side-card">

                    <h3>
                        Event Details
                    </h3>

                    @if($event->total_seats !== null)

                        <div class="seat-info">

                            <span>
                                Total Seats
                            </span>

                            <strong>
                                {{ $event->total_seats }}
                            </strong>

                        </div>

                    @endif

                    <div class="seat-info">

                        <span>
                            Available
                        </span>

                        <strong>

                            @if($event->available_seats === null)

                                Unlimited

                            @elseif($isSoldOut)

                                <span class="seat-danger">
                                    Sold Out
                                </span>

                            @else

                                {{ $event->available_seats }}

                            @endif

                        </strong>

                    </div>

                    <div class="seat-info">

                        <span>
                            Event Status
                        </span>

                        <strong>

                            @if($isPast)

                                <span class="seat-danger">
                                    Completed
                                </span>

                            @elseif($isSoldOut)

                                <span class="seat-danger">
                                    Sold Out
                                </span>

                            @else

                                <span class="free">
                                    Upcoming
                                </span>

                            @endif

                        </strong>

                    </div>

                    <div class="seat-info">

                        <span>
                            Ticket
                        </span>

                        <strong>

                            @if($event->ticket_price > 0)

                                ₹{{ number_format($event->ticket_price, 2) }}

                            @else

                                <span class="free">
                                    Free
                                </span>

                            @endif

                        </strong>

                    </div>

                    <div class="seat-info">

                        <span>
                            Organization
                        </span>

                        <strong>
                            {{ $event->organization->name }}
                        </strong>

                    </div>

                </div>

            </section>

            {{-- RELATED EVENTS --}}
            <section class="related-section">

                <div class="section-heading">

                    <div>

                        <h2>
                            Related Events
                        </h2>

                        <p>
                            More upcoming events you may be interested in.
                        </p>

                    </div>

                    <a
                        href="{{ route('events.index') }}"
                        class="view-all"
                    >
                        View All Events →
                    </a>

                </div>

                @if($relatedEvents->count())

                    <div class="related-grid">

                        @foreach($relatedEvents as $relatedEvent)

                            @php
                                $relatedSoldOut =
                                    $relatedEvent->available_seats !== null
                                    && (int) $relatedEvent->available_seats <= 0;
                            @endphp

                            <a
                                href="{{ route('events.show', $relatedEvent->slug) }}"
                                class="related-card"
                            >

                                {{-- IMAGE --}}
                                <div class="related-image">

                                    @if($relatedEvent->banner)

                                        <img
                                            src="{{ asset('storage/' . $relatedEvent->banner) }}"
                                            alt="{{ $relatedEvent->title }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="related-placeholder">
                                            {{ strtoupper(substr($relatedEvent->title, 0, 1)) }}
                                        </div>

                                    @endif

                                </div>

                                {{-- BODY --}}
                                <div class="related-body">

                                    @if($relatedEvent->category)

                                        <span class="related-category">
                                            {{ $relatedEvent->category }}
                                        </span>

                                    @endif

                                    <div class="related-title">
                                        {{ $relatedEvent->title }}
                                    </div>

                                    @if($relatedEvent->event_date)

                                        <div class="related-info">
                                            📅
                                            {{ \Carbon\Carbon::parse($relatedEvent->event_date)->format('d M Y') }}
                                        </div>

                                    @endif

                                    @if($relatedEvent->city)

                                        <div class="related-info">
                                            📍
                                            {{ $relatedEvent->city }}
                                        </div>

                                    @endif

                                    <div class="related-bottom">

                                        <div class="related-price">

                                            @if($relatedEvent->ticket_price > 0)

                                                ₹{{ number_format($relatedEvent->ticket_price, 2) }}

                                            @else

                                                <span class="free">
                                                    FREE
                                                </span>

                                            @endif

                                        </div>

                                        <div class="related-link">

                                            @if($relatedSoldOut)

                                                Sold Out

                                            @else

                                                View Event →

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </a>

                        @endforeach

                    </div>

                @else

                    <div class="no-related">
                        No related upcoming events available at the moment.
                    </div>

                @endif

            </section>

        </div>

    </main>

    @include('layouts.footer')

    <script>
        const html = document.documentElement;

        const savedTheme =
            localStorage.getItem('eventora-theme') || 'dark';

        html.setAttribute('data-theme', savedTheme);
    </script>

</body>
</html>