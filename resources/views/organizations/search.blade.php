<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Organizations | Eventora
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

            --shadow: rgba(
                0,
                0,
                0,
                .35
            );

        }


        html[data-theme="light"] {

            --bg: #f7f8fc;

            --bg2: #ffffff;

            --surface: #ffffff;

            --surface2: #f1f3f8;

            --text: #111827;

            --muted: #667085;

            --border: #e2e6ef;

            --shadow: rgba(
                30,
                40,
                70,
                .10
            );

        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                var(--bg);

            color:
                var(--text);

            line-height: 1.6;

            transition:
                background .3s,
                color .3s;

        }


        a {

            text-decoration: none;

            color: inherit;

        }


        button,
        input {

            font-family: inherit;

        }


        .container {

            width: 90%;

            max-width: 1200px;

            margin: auto;

        }


        /* =========================================
           PAGE HEADER
        ========================================= */

        .page-header {

            padding:
                80px 0 42px;

            text-align:
                center;

            background:

                radial-gradient(
                    circle at 50% 0%,
                    rgba(
                        124,
                        92,
                        255,
                        .18
                    ),
                    transparent 45%
                ),

                var(--bg);

        }


        .page-header h1 {

            font-size:
                clamp(
                    35px,
                    5vw,
                    55px
                );

            margin-bottom:
                10px;

        }


        .page-header p {

            color:
                var(--muted);

            max-width:
                650px;

            margin:
                auto;

        }


        /* =========================================
           BECOME ORGANIZER
        ========================================= */

        .organizer-section {

            padding:
                0 0 28px;

        }


        .organizer-card {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap: 25px;

            padding:
                22px 24px;

            border-radius:
                18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(
                        124,
                        92,
                        255,
                        .13
                    ),
                    rgba(
                        91,
                        77,
                        247,
                        .07
                    )
                );

            border:
                1px solid
                rgba(
                    124,
                    92,
                    255,
                    .32
                );

            box-shadow:
                0 12px 35px
                var(--shadow);

        }


        .organizer-left {

            display:
                flex;

            align-items:
                center;

            gap: 15px;

            flex: 1;

        }


        .organizer-icon {

            width: 52px;

            height: 52px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            flex-shrink: 0;

            border-radius:
                14px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            font-size: 24px;

            box-shadow:
                0 9px 22px
                rgba(
                    124,
                    92,
                    255,
                    .25
                );

        }


        .organizer-text h2 {

            margin:
                0 0 4px;

            font-size:
                18px;

        }


        .organizer-text p {

            margin: 0;

            color:
                var(--muted);

            font-size:
                13px;

            line-height:
                1.5;

        }


        .organizer-button {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap: 7px;

            padding:
                11px 17px;

            border-radius:
                9px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            color:
                #ffffff;

            font-size:
                13px;

            font-weight:
                800;

            white-space:
                nowrap;

            transition:
                .25s;

            box-shadow:
                0 8px 22px
                rgba(
                    124,
                    92,
                    255,
                    .20
                );

        }


        .organizer-button:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 28px
                rgba(
                    124,
                    92,
                    255,
                    .30
                );

        }


        /* =========================================
           SEARCH
        ========================================= */

        .search-section {

            padding-bottom:
                55px;

        }


        .search-box {

            display:
                flex;

            gap: 10px;

            background:
                var(--surface);

            border:
                1px solid var(--border);

            padding: 9px;

            border-radius:
                14px;

            box-shadow:
                0 15px 40px
                var(--shadow);

        }


        .search-input {

            flex: 1;

            border: none;

            outline: none;

            background:
                transparent;

            color:
                var(--text);

            padding:
                13px;

            font-size:
                14px;

        }


        .search-input::placeholder {

            color:
                var(--muted);

        }


        .search-button {

            border: none;

            padding:
                0 25px;

            border-radius:
                9px;

            background:
                var(--primary);

            color:
                white;

            font-weight:
                800;

            cursor:
                pointer;

            transition:
                .2s;

        }


        .search-button:hover {

            background:
                var(--primary2);

            transform:
                translateY(-1px);

        }


        /* =========================================
           ORGANIZATIONS
        ========================================= */

        .organizations-section {

            padding:
                0 0 90px;

        }


        .organizations-grid {

            display:
                grid;

            grid-template-columns:
                repeat(
                    3,
                    1fr
                );

            gap:
                22px;

        }


        .organization-card {

            background:
                var(--surface);

            border:
                1px solid var(--border);

            border-radius:
                18px;

            overflow:
                hidden;

            transition:
                .3s;

            box-shadow:
                0 10px 30px
                var(--shadow);

        }


        .organization-card:hover {

            transform:
                translateY(-6px);

            border-color:
                rgba(
                    124,
                    92,
                    255,
                    .55
                );

            box-shadow:
                0 20px 45px
                var(--shadow);

        }


        .organization-cover {

            height:
                190px;

            position:
                relative;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                linear-gradient(
                    135deg,
                    #5b4df7,
                    #00a9d6
                );

        }


        .organization-type {

            position:
                absolute;

            top:
                14px;

            left:
                14px;

            background:
                rgba(
                    0,
                    0,
                    0,
                    .55
                );

            color:
                white;

            padding:
                6px 10px;

            border-radius:
                7px;

            font-size:
                11px;

            font-weight:
                800;

        }


        .organization-logo {

            width:
                95px;

            height:
                95px;

            border-radius:
                50%;

            background:
                white;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            overflow:
                hidden;

            border:
                4px solid
                rgba(
                    255,
                    255,
                    255,
                    .35
                );

            box-shadow:
                0 12px 30px
                rgba(
                    0,
                    0,
                    0,
                    .25
                );

        }


        .organization-logo img {

            width:
                100%;

            height:
                100%;

            object-fit:
                cover;

        }


        .organization-initial {

            color:
                #5b4df7;

            font-size:
                35px;

            font-weight:
                900;

        }


        .organization-content {

            padding:
                20px;

        }


        .organization-tag {

            display:
                inline-block;

            padding:
                4px 8px;

            border-radius:
                5px;

            background:
                rgba(
                    124,
                    92,
                    255,
                    .12
                );

            color:
                #a99aff;

            font-size:
                10px;

            font-weight:
                900;

            text-transform:
                uppercase;

        }


        .organization-content h2 {

            font-size:
                20px;

            margin:
                10px 0 5px;

        }


        .organization-location {

            color:
                var(--muted);

            font-size:
                13px;

            margin-bottom:
                12px;

        }


        .organization-description {

            color:
                var(--muted);

            font-size:
                13px;

            display:
                -webkit-box;

            -webkit-line-clamp:
                3;

            -webkit-box-orient:
                vertical;

            overflow:
                hidden;

            margin-bottom:
                17px;

        }


        .organization-bottom {

            border-top:
                1px solid var(--border);

            padding-top:
                14px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                10px;

        }


        .event-count {

            color:
                var(--muted);

            font-size:
                12px;

        }


        .view-organization {

            color:
                #a99aff;

            font-size:
                13px;

            font-weight:
                800;

        }


        /* =========================================
           EMPTY
        ========================================= */

        .empty-state {

            text-align:
                center;

            padding:
                70px 20px;

            background:
                var(--surface);

            border:
                1px solid var(--border);

            border-radius:
                18px;

        }


        .empty-state h2 {

            margin-bottom:
                8px;

        }


        .empty-state p {

            color:
                var(--muted);

        }


        /* =========================================
           FOOTER
        ========================================= */

        footer {

            background:
                #050810;

            border-top:
                1px solid #1d2637;

            padding:
                55px 0 25px;

        }


        .footer-grid {

            display:
                grid;

            grid-template-columns:
                1.5fr 1fr 1fr 1fr;

            gap:
                35px;

            padding-bottom:
                40px;

        }


        .footer-text {

            color:
                #8f9aad;

            max-width:
                330px;

            font-size:
                13px;

            margin-top:
                12px;

        }


        .footer-column h4 {

            margin-bottom:
                13px;

            color:
                white;

        }


        .footer-column a {

            display:
                block;

            color:
                #8f9aad;

            font-size:
                13px;

            margin-bottom:
                8px;

        }


        .footer-column a:hover {

            color:
                white;

        }


        .footer-bottom {

            border-top:
                1px solid #1d2637;

            padding-top:
                20px;

            text-align:
                center;

            color:
                #737e91;

            font-size:
                12px;

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 1050px) {

            .organizations-grid {

                grid-template-columns:
                    repeat(
                        2,
                        1fr
                    );

            }


            .footer-grid {

                grid-template-columns:
                    repeat(
                        2,
                        1fr
                    );

            }

        }


        @media (max-width: 850px) {

            .nav-links {

                display:
                    none;

                position:
                    absolute;

                top:
                    76px;

                left:
                    0;

                right:
                    0;

                padding:
                    15px 5%;

                flex-direction:
                    column;

                align-items:
                    stretch;

                background:
                    var(--bg2);

                border-bottom:
                    1px solid var(--border);

            }


            .nav-links.show {

                display:
                    flex;

            }


            .menu-btn {

                display:
                    block;

            }


            .organizer-card {

                flex-direction:
                    column;

                align-items:
                    stretch;

            }


            .organizer-left {

                align-items:
                    flex-start;

            }


            .organizer-button {

                width:
                    100%;

                text-align:
                    center;

            }

        }


        @media (max-width: 600px) {

            .container {

                width:
                    92%;

            }


            .page-header {

                padding:
                    60px 0 35px;

            }


            .search-box {

                flex-direction:
                    column;

            }


            .search-button {

                padding:
                    12px;

            }


            .organizations-grid {

                grid-template-columns:
                    1fr;

            }


            .footer-grid {

                grid-template-columns:
                    1fr;

            }


            .organizer-card {

                padding:
                    18px;

            }


            .organizer-icon {

                width:
                    46px;

                height:
                    46px;

                font-size:
                    21px;

            }


            .organizer-text h2 {

                font-size:
                    16px;

            }

        }


        /* =========================================
           LIGHT FOOTER
        ========================================= */

        html[data-theme="light"]
        footer {

            background:
                #111827;

            border-top-color:
                #263044;

        }

    </style>

</head>


<body>


    <!-- ================= NAVBAR ================= -->

    @include('layouts.navbar')


    <!-- ================= HEADER ================= -->

    <section class="page-header">

        <div class="container">

            <h1>
                Find Organizations
            </h1>


            <p>

                Discover schools, colleges, companies,
                NGOs and other organizations hosting events
                on Eventora.

            </p>

        </div>

    </section>


    <!-- ================= BECOME ORGANIZER ================= -->

    <section class="organizer-section">

        <div class="container">


            <div class="organizer-card">


                <div class="organizer-left">


                    <div class="organizer-icon">
                        🎤
                    </div>


                    <div class="organizer-text">

                        <h2>
                            Want to host events on Eventora?
                        </h2>


                        <p>
                            Create your organization and start hosting
                            events for your audience.
                        </p>

                    </div>


                </div>


                <a
                    href="{{ route('organizations.create') }}"
                    class="organizer-button"
                >
                    Become an Organizer →
                </a>


            </div>


        </div>

    </section>


    <!-- ================= SEARCH ================= -->

    <section class="search-section">

        <div class="container">


            <form
                action="{{ route('organizations.search') }}"
                method="GET"
                class="search-box"
            >


                <input
                    type="text"
                    name="q"
                    value="{{ $query ?? '' }}"
                    class="search-input"
                    placeholder="Search organization, city or type..."
                >


                <button
                    type="submit"
                    class="search-button"
                >
                    Search
                </button>


            </form>


        </div>

    </section>


    <!-- ================= ORGANIZATIONS ================= -->

    <section class="organizations-section">

        <div class="container">


            @if($organizations->count())


                <div class="organizations-grid">


                    @foreach($organizations as $organization)


                        <a
                            href="{{ route(
                                'organizations.show',
                                $organization->slug
                            ) }}"
                            class="organization-card"
                        >


                            <div class="organization-cover">


                                <span class="organization-type">

                                    {{ $organization->type }}

                                </span>


                                <div class="organization-logo">


                                    @if($organization->logo)


                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $organization->logo
                                            ) }}"
                                            alt="{{ $organization->name }}"
                                        >


                                    @else


                                        <span class="organization-initial">

                                            {{
                                                strtoupper(
                                                    substr(
                                                        $organization->name,
                                                        0,
                                                        1
                                                    )
                                                )
                                            }}

                                        </span>


                                    @endif


                                </div>


                            </div>


                            <div class="organization-content">


                                <span class="organization-tag">
                                    Organization
                                </span>


                                <h2>

                                    {{ $organization->name }}

                                </h2>


                                <div class="organization-location">

                                    📍

                                    {{
                                        $organization->city
                                        ?? 'Location not available'
                                    }}


                                    @if($organization->state)

                                        ,
                                        {{ $organization->state }}

                                    @endif

                                </div>


                                <p class="organization-description">

                                    {{
                                        $organization->description
                                        ??
                                        'Discover events and activities organized by this organization.'
                                    }}

                                </p>


                                <div class="organization-bottom">


                                    <span class="event-count">

                                        🎟️

                                        {{ $organization->events_count }}

                                        {{
                                            $organization->events_count == 1
                                                ? 'Event'
                                                : 'Events'
                                        }}

                                    </span>


                                    <span class="view-organization">

                                        View Organization →

                                    </span>


                                </div>


                            </div>


                        </a>


                    @endforeach


                </div>


            @else


                <div class="empty-state">


                    <h2>
                        No organizations found
                    </h2>


                    <p>

                        Try searching with another organization
                        name, city or organization type.

                    </p>


                </div>


            @endif


        </div>

    </section>


    <!-- ================= FOOTER ================= -->

    @include('layouts.footer')


    <!-- ================= JAVASCRIPT ================= -->

    <script>


        /* =========================
           MOBILE MENU
        ========================== */

        function toggleMenu() {

            const navLinks =
                document.getElementById(
                    "navLinks"
                );


            if (navLinks) {

                navLinks.classList.toggle(
                    "show"
                );

            }

        }


        /* =========================
           THEME
        ========================== */

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
                document.getElementById(
                    "themeButton"
                );


            if (button) {

                button.textContent =
                    theme === "light"
                        ? "☀️"
                        : "🌙";

            }

        }


        function toggleTheme() {

            const current =
                html.getAttribute(
                    "data-theme"
                ) || "dark";


            setTheme(

                current === "dark"
                    ? "light"
                    : "dark"

            );

        }


        const savedTheme =
            localStorage.getItem(
                "eventora-theme"
            ) || "dark";


        setTheme(savedTheme);

    </script>


</body>

</html>