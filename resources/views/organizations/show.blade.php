<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $organization->name }} | Eventora
    </title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        :root {

            --bg: #080b14;
            --bg2: #0d1220;

            --surface: #111827;
            --surface2: #151d2d;

            --text: #f8fafc;
            --muted: #9ca8bb;

            --border: #263044;

            --primary: #7c5cff;
            --primary2: #5b4df7;

            --shadow:
                rgba(0,0,0,.35);

        }

        html[data-theme="light"] {

            --bg: #f7f8fc;
            --bg2: #ffffff;

            --surface: #ffffff;
            --surface2: #f1f3f8;

            --text: #111827;
            --muted: #667085;

            --border: #e2e6ef;

            --shadow:
                rgba(30,40,70,.10);

        }

        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: var(--bg);

            color: var(--text);

            line-height: 1.6;

        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
        }

        .container {

            width: 90%;

            max-width: 1200px;

            margin: auto;

        }


        /* ================= NAVBAR ================= */

        .navbar {

            position: sticky;

            top: 0;

            z-index: 999;

            background:
                rgba(8,11,20,.88);

            border-bottom:
                1px solid var(--border);

            backdrop-filter:
                blur(14px);

        }

        html[data-theme="light"] .navbar {

            background:
                rgba(255,255,255,.90);

        }

        .nav-container {

            min-height: 76px;

            display: flex;

            align-items: center;

            gap: 25px;

        }

        .logo {

            font-size: 28px;

            font-weight: 900;

            color: var(--primary);

            letter-spacing: -1.5px;

            margin-right: auto;

        }

        .logo span {
            color: var(--text);
        }

        .nav-links {

            display: flex;

            align-items: center;

            gap: 5px;

            list-style: none;

        }

        .nav-link {

            padding: 10px 14px;

            border-radius: 9px;

            color: var(--muted);

            font-size: 14px;

            font-weight: 700;

        }

        .nav-link:hover {

            color: var(--text);

            background: var(--surface2);

        }

        .nav-link.active {

            color: white;

            background: var(--primary);

        }

        .nav-right {

            display: flex;

            gap: 9px;

        }

        .theme-btn,
        .menu-btn {

            width: 42px;

            height: 42px;

            border:
                1px solid var(--border);

            border-radius: 10px;

            background: var(--surface);

            color: var(--text);

            cursor: pointer;

            font-size: 18px;

        }

        .menu-btn {
            display: none;
        }


        /* ================= PROFILE ================= */

        .profile-section {

            padding:
                75px 0 45px;

            background:
                radial-gradient(
                    circle at 50% 0%,
                    rgba(124,92,255,.18),
                    transparent 45%
                ),
                var(--bg);

        }

        .profile-card {

            display: grid;

            grid-template-columns:
                250px 1fr;

            gap: 40px;

            align-items: center;

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 22px;

            padding: 30px;

            box-shadow:
                0 20px 50px var(--shadow);

        }

        .profile-logo {

            width: 200px;

            height: 200px;

            margin: auto;

            border-radius: 20px;

            background:
                linear-gradient(
                    135deg,
                    #5b4df7,
                    #00a9d6
                );

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

            color: white;

            font-size: 70px;

            font-weight: 900;

        }

        .profile-logo img {

            width: 100%;

            height: 100%;

            object-fit: cover;

        }

        .profile-type {

            display: inline-block;

            padding: 5px 9px;

            border-radius: 5px;

            background:
                rgba(124,92,255,.12);

            color: #a99aff;

            font-size: 11px;

            font-weight: 900;

            text-transform: uppercase;

        }

        .profile-content h1 {

            font-size:
                clamp(32px,5vw,52px);

            line-height: 1.1;

            margin: 12px 0 10px;

        }

        .profile-location {

            color: var(--muted);

            margin-bottom: 15px;

        }

        .profile-description {

            color: var(--muted);

            max-width: 750px;

        }


        /* ================= EVENTS ================= */

        .events-section {

            padding:
                70px 0 90px;

        }

        .section-heading {

            margin-bottom: 35px;

        }

        .section-heading h2 {

            font-size: 34px;

            margin-bottom: 7px;

        }

        .section-heading p {

            color: var(--muted);

        }

        .events-grid {

            display: grid;

            grid-template-columns:
                repeat(3,1fr);

            gap: 22px;

        }

        .event-card {

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 17px;

            overflow: hidden;

            transition: .3s;

        }

        .event-card:hover {

            transform:
                translateY(-6px);

            border-color:
                rgba(124,92,255,.55);

            box-shadow:
                0 20px 45px var(--shadow);

        }

        .event-cover {

            height: 180px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 50px;

            background:
                linear-gradient(
                    135deg,
                    #5b4df7,
                    #00a9d6
                );

            position: relative;

        }

        .event-date {

            position: absolute;

            top: 13px;

            left: 13px;

            background: white;

            color: #111827;

            padding: 7px 10px;

            border-radius: 8px;

            text-align: center;

            line-height: 1.1;

        }

        .event-date strong {

            display: block;

            font-size: 17px;

        }

        .event-date small {

            font-size: 9px;

            font-weight: 800;

        }

        .event-content {

            padding: 19px;

        }

        .event-tag {

            display: inline-block;

            padding: 4px 8px;

            border-radius: 5px;

            background:
                rgba(124,92,255,.12);

            color: #a99aff;

            font-size: 10px;

            font-weight: 900;

            text-transform: uppercase;

        }

        .event-content h3 {

            font-size: 18px;

            margin:
                11px 0 6px;

        }

        .event-info {

            color: var(--muted);

            font-size: 13px;

            margin-bottom: 14px;

        }

        .event-bottom {

            border-top:
                1px solid var(--border);

            padding-top: 13px;

            display: flex;

            align-items: center;

            justify-content: space-between;

        }

        .event-price {

            font-weight: 900;

        }

        .view-event {

            color: #a99aff;

            font-size: 13px;

            font-weight: 800;

        }


        /* ================= EMPTY ================= */

        .empty-state {

            text-align: center;

            padding: 70px 20px;

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 18px;

        }

        .empty-state p {

            color: var(--muted);

            margin-top: 5px;

        }


        /* ================= FOOTER ================= */

        footer {

            background: #050810;

            border-top:
                1px solid #1d2637;

            padding:
                55px 0 25px;

        }

        .footer-grid {

            display: grid;

            grid-template-columns:
                1.5fr 1fr 1fr 1fr;

            gap: 35px;

            padding-bottom: 40px;

        }

        .footer-text {

            color: #8f9aad;

            max-width: 330px;

            font-size: 13px;

            margin-top: 12px;

        }

        .footer-column h4 {

            color: white;

            margin-bottom: 13px;

        }

        .footer-column a {

            display: block;

            color: #8f9aad;

            font-size: 13px;

            margin-bottom: 8px;

        }

        .footer-column a:hover {
            color: white;
        }

        .footer-bottom {

            border-top:
                1px solid #1d2637;

            padding-top: 20px;

            text-align: center;

            color: #737e91;

            font-size: 12px;

        }


        /* ================= RESPONSIVE ================= */

        @media (max-width: 1050px) {

            .events-grid {

                grid-template-columns:
                    repeat(2,1fr);

            }

            .footer-grid {

                grid-template-columns:
                    repeat(2,1fr);

            }

        }

        @media (max-width: 850px) {

            .nav-links {

                display: none;

                position: absolute;

                top: 76px;

                left: 0;

                right: 0;

                padding: 15px 5%;

                flex-direction: column;

                align-items: stretch;

                background: var(--bg2);

                border-bottom:
                    1px solid var(--border);

            }

            .nav-links.show {
                display: flex;
            }

            .menu-btn {
                display: block;
            }

            .profile-card {

                grid-template-columns: 1fr;

                text-align: center;

            }

        }

        @media (max-width: 600px) {

            .container {
                width: 92%;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                padding: 22px;
            }

        }

        html[data-theme="light"] footer {

            background: #111827;

            border-top-color: #263044;

        }

    </style>

</head>


<body>


    <!-- ================= NAVBAR ================= -->

    @include('layouts.navbar')


    <!-- ================= ORGANIZATION PROFILE ================= -->

    <section class="profile-section">

        <div class="container">

            <div class="profile-card">


                <!-- LOGO -->

                <div class="profile-logo">

                    @if($organization->logo)

                        <img
                            src="{{ asset('storage/' . $organization->logo) }}"
                            alt="{{ $organization->name }}"
                        >

                    @else

                        {{ strtoupper(
                            substr($organization->name, 0, 1)
                        ) }}

                    @endif

                </div>


                <!-- INFORMATION -->

                <div class="profile-content">

                    <span class="profile-type">
                        {{ $organization->type }}
                    </span>


                    <h1>
                        {{ $organization->name }}
                    </h1>


                    <div class="profile-location">

                        📍

                        {{ $organization->city
                            ?? 'Location not available' }}

                        @if($organization->state)

                            ,
                            {{ $organization->state }}

                        @endif

                    </div>


                    <p class="profile-description">

                        {{ $organization->description
                            ?? 'This organization hosts events on Eventora.' }}

                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= EVENTS ================= -->

    <section class="events-section">

        <div class="container">


            <div class="section-heading">

                <h2>
                    Upcoming Events
                </h2>

                <p>
                    Events organized by
                    {{ $organization->name }}
                </p>

            </div>


            @if($events->count())

                <div class="events-grid">

                    @foreach($events as $event)

                        <a
                            href="{{ route('events.show', $event->slug) }}"
                            class="event-card"
                        >

                            <div class="event-cover">

                                🎫


                                <div class="event-date">

                                    <strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                    </strong>

                                    <small>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                                    </small>

                                </div>

                            </div>


                            <div class="event-content">

                                <span class="event-tag">

                                    {{ $event->category
                                        ?? 'Event' }}

                                </span>


                                <h3>
                                    {{ $event->title }}
                                </h3>


                                <div class="event-info">

                                    📍
                                    {{ $event->venue
                                        ?? 'Venue not available' }}

                                    @if($event->city)

                                        , {{ $event->city }}

                                    @endif

                                    <br>

                                    🕐

                                    @if($event->event_time)

                                        {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}

                                    @else

                                        Time not available

                                    @endif

                                </div>


                                <div class="event-bottom">

                                    <span class="event-price">

                                        @if($event->ticket_price > 0)

                                            ₹{{ number_format($event->ticket_price, 2) }}

                                        @else

                                            Free

                                        @endif

                                    </span>


                                    <span class="view-event">

                                        View Event →

                                    </span>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="empty-state">

                    <h2>
                        No Upcoming Events
                    </h2>

                    <p>
                        This organization currently has
                        no upcoming approved events.
                    </p>

                </div>

            @endif

        </div>

    </section>


    <!-- ================= FOOTER ================= -->

    @include('layouts.footer')


    <!-- ================= JAVASCRIPT ================= -->

    <script>

        function toggleMenu() {

            const navLinks =
                document.getElementById("navLinks");

            if (navLinks) {

                navLinks.classList.toggle("show");

            }

        }


        const html =
            document.documentElement;


        function setTheme(theme) {

            html.setAttribute(
                "data-theme",
                theme
            );

            localStorage.setItem(
                "eventora-theme",
                theme
            );

            const button =
                document.getElementById("themeButton");

            if (button) {

                button.textContent =
                    theme === "light"
                        ? "☀️"
                        : "🌙";

            }

        }


        function toggleTheme() {

            const current =
                html.getAttribute("data-theme")
                || "dark";

            setTheme(
                current === "dark"
                    ? "light"
                    : "dark"
            );

        }


        const savedTheme =
            localStorage.getItem("eventora-theme")
            || "dark";

        setTheme(savedTheme);

    </script>


</body>

</html>