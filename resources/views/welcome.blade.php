<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Eventora | Discover Events</title>


    <style>

        /* =====================================================
           RESET
           ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        /* =====================================================
           THEME VARIABLES
           ===================================================== */

        :root {

            --bg: #080b14;
            --bg2: #0d1220;

            --card: #111827;
            --card2: #151d2d;

            --text: #f8fafc;
            --muted: #9ca8bb;

            --border: #263044;

            --primary: #7c5cff;
            --primary2: #5b4df7;

            --white: #ffffff;

            --shadow:
                rgba(0, 0, 0, .35);

        }


        html[data-theme="light"] {

            --bg: #f7f8fc;
            --bg2: #ffffff;

            --card: #ffffff;
            --card2: #f1f3f8;

            --text: #111827;
            --muted: #667085;

            --border: #e2e6ef;

            --shadow:
                rgba(30, 40, 70, .10);

        }


        /* =====================================================
           BODY
           ===================================================== */

        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                var(--bg);

            color:
                var(--text);

            line-height:
                1.6;

            transition:
                background .3s,
                color .3s;

        }


        a {

            text-decoration:
                none;

            color:
                inherit;

        }


        button,
        input {

            font-family:
                inherit;

        }


        .container {

            width:
                90%;

            max-width:
                1200px;

            margin:
                auto;

        }


        /* =====================================================
           NAVBAR
           ===================================================== */

        .navbar {

            position:
                sticky;

            top:
                0;

            z-index:
                999;

            background:
                rgba(8, 11, 20, .88);

            border-bottom:
                1px solid var(--border);

            backdrop-filter:
                blur(14px);

        }


        html[data-theme="light"] .navbar {

            background:
                rgba(255, 255, 255, .90);

        }


        .nav-container {

            min-height:
                76px;

            display:
                flex;

            align-items:
                center;

            gap:
                25px;

        }


        .logo {

            font-size:
                28px;

            font-weight:
                900;

            color:
                var(--primary);

            letter-spacing:
                -1.5px;

            margin-right:
                auto;

        }


        .logo span {

            color:
                var(--text);

        }


        .nav-links {

            display:
                flex;

            align-items:
                center;

            gap:
                5px;

            list-style:
                none;

        }


        .nav-link {

            padding:
                10px 14px;

            border-radius:
                9px;

            color:
                var(--muted);

            font-size:
                14px;

            font-weight:
                700;

            transition:
                .25s;

        }


        .nav-link:hover {

            color:
                var(--text);

            background:
                var(--card2);

        }


        .nav-link.active {

            color:
                white;

            background:
                var(--primary);

            box-shadow:
                0 7px 22px
                rgba(124, 92, 255, .30);

        }


        .nav-link.active:hover {

            color:
                white;

            background:
                var(--primary2);

        }


        /* RIGHT SIDE */

        .nav-right {

            display:
                flex;

            align-items:
                center;

            gap:
                9px;

        }


        .theme-btn,
        .menu-btn {

            width:
                42px;

            height:
                42px;

            border:
                1px solid var(--border);

            border-radius:
                10px;

            background:
                var(--card);

            color:
                var(--text);

            cursor:
                pointer;

            font-size:
                18px;

            transition:
                .25s;

        }


        .theme-btn:hover,
        .menu-btn:hover {

            border-color:
                var(--primary);

            color:
                var(--primary);

        }


        .login-btn {

            padding:
                10px 16px;

            border:
                1px solid var(--border);

            border-radius:
                9px;

            color:
                var(--text);

            font-size:
                14px;

            font-weight:
                700;

        }


        .login-btn:hover {

            border-color:
                var(--primary);

            color:
                var(--primary);

        }


        .signup-btn {

            padding:
                11px 17px;

            border-radius:
                9px;

            background:
                var(--primary);

            color:
                white;

            font-size:
                14px;

            font-weight:
                700;

        }


        .signup-btn:hover {

            background:
                var(--primary2);

        }


        .menu-btn {

            display:
                none;

        }


        /* =====================================================
           HERO
           ===================================================== */

        .hero {

            position:
                relative;

            overflow:
                hidden;

            padding:
                95px 0 100px;

            background:

                radial-gradient(
                    circle at 85% 20%,
                    rgba(124, 92, 255, .20),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 5% 85%,
                    rgba(0, 200, 255, .10),
                    transparent 30%
                ),

                var(--bg);

        }


        .hero-grid {

            display:
                grid;

            grid-template-columns:
                1.08fr .92fr;

            gap:
                70px;

            align-items:
                center;

        }


        .badge {

            display:
                inline-flex;

            padding:
                7px 13px;

            border-radius:
                30px;

            background:
                rgba(124, 92, 255, .13);

            border:
                1px solid
                rgba(124, 92, 255, .28);

            color:
                #a99aff;

            font-size:
                12px;

            font-weight:
                800;

            margin-bottom:
                20px;

        }


        .hero h1 {

            font-size:
                clamp(44px, 6vw, 72px);

            line-height:
                1.03;

            letter-spacing:
                -3px;

            margin-bottom:
                22px;

        }


        .hero h1 span {

            color:
                var(--primary);

        }


        .hero-text {

            color:
                var(--muted);

            max-width:
                590px;

            font-size:
                17px;

            margin-bottom:
                30px;

        }


        .hero-buttons {

            display:
                flex;

            gap:
                12px;

            flex-wrap:
                wrap;

        }


        .primary-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                13px 21px;

            border-radius:
                10px;

            background:
                var(--primary);

            color:
                white;

            font-weight:
                800;

            transition:
                .25s;

            box-shadow:
                0 12px 28px
                rgba(124, 92, 255, .25);

        }


        .primary-btn:hover {

            transform:
                translateY(-2px);

            background:
                var(--primary2);

        }


        .secondary-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                13px 21px;

            border-radius:
                10px;

            border:
                1px solid var(--border);

            color:
                var(--text);

            background:
                var(--card);

            font-weight:
                800;

        }


        .secondary-btn:hover {

            border-color:
                var(--primary);

            color:
                var(--primary);

        }


        /* =====================================================
           HERO EVENT CARD
           ===================================================== */

        .hero-card {

            background:
                var(--card);

            border:
                1px solid var(--border);

            padding:
                14px;

            border-radius:
                22px;

            box-shadow:
                0 25px 70px
                var(--shadow);

        }


        .hero-image {

            height:
                300px;

            border-radius:
                16px;

            display:
                flex;

            justify-content:
                center;

            align-items:
                center;

            text-align:
                center;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    #5b4df7,
                    #00a9d6
                );

            position:
                relative;

            overflow:
                hidden;

        }


        .hero-image::before,
        .hero-image::after {

            content:
                "";

            position:
                absolute;

            border-radius:
                50%;

            border:
                30px solid
                rgba(255,255,255,.10);

        }


        .hero-image::before {

            width:
                230px;

            height:
                230px;

            right:
                -70px;

            top:
                -90px;

        }


        .hero-image::after {

            width:
                180px;

            height:
                180px;

            left:
                -60px;

            bottom:
                -80px;

        }


        .hero-image-content {

            position:
                relative;

            z-index:
                2;

        }


        .hero-icon {

            font-size:
                55px;

            margin-bottom:
                8px;

        }


        .hero-image h3 {

            font-size:
                25px;

        }


        .hero-card-info {

            padding:
                18px 5px 4px;

        }


        .hero-card-title {

            display:
                flex;

            justify-content:
                space-between;

            gap:
                15px;

        }


        .hero-card-title h3 {

            font-size:
                19px;

        }


        .price {

            color:
                #9c8dff;

            font-weight:
                900;

            white-space:
                nowrap;

        }


        .meta {

            color:
                var(--muted);

            font-size:
                13px;

            margin-top:
                4px;

        }


        /* =====================================================
           SEARCH
           ===================================================== */

        .search-wrapper {

            margin-top:
                -30px;

            position:
                relative;

            z-index:
                10;

        }


        .search-box {

            display:
                flex;

            gap:
                10px;

            background:
                var(--card);

            border:
                1px solid var(--border);

            padding:
                9px;

            border-radius:
                14px;

            box-shadow:
                0 15px 40px
                var(--shadow);

        }


        .search-input {

            flex:
                1;

            border:
                none;

            outline:
                none;

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

            border:
                none;

            padding:
                0 24px;

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

        }


        /* =====================================================
           SECTIONS
           ===================================================== */

        .section {

            padding:
                90px 0;

        }


        .section-dark {

            background:
                var(--bg2);

        }


        .section-heading {

            text-align:
                center;

            max-width:
                650px;

            margin:
                0 auto 45px;

        }


        .small-title {

            color:
                var(--primary);

            font-size:
                12px;

            font-weight:
                900;

            text-transform:
                uppercase;

            letter-spacing:
                1.5px;

            margin-bottom:
                8px;

        }


        .section-heading h2 {

            font-size:
                38px;

            line-height:
                1.2;

            margin-bottom:
                10px;

        }


        .section-heading p {

            color:
                var(--muted);

        }


        /* =====================================================
           EVENT CARDS
           ===================================================== */

        .events-grid {

            display:
                grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap:
                22px;

        }


        .event-card {

            background:
                var(--card);

            border:
                1px solid var(--border);

            border-radius:
                17px;

            overflow:
                hidden;

            transition:
                .3s;

        }


        .event-card:hover {

            transform:
                translateY(-6px);

            border-color:
                rgba(124, 92, 255, .55);

            box-shadow:
                0 20px 45px
                var(--shadow);

        }


        .event-cover {

            height:
                185px;

            position:
                relative;

            display:
                flex;

            justify-content:
                center;

            align-items:
                center;

            color:
                white;

            font-size:
                48px;

        }


        .cover-one {

            background:
                linear-gradient(
                    135deg,
                    #5b4df7,
                    #8d7dff
                );

        }


        .cover-two {

            background:
                linear-gradient(
                    135deg,
                    #007c9c,
                    #18c6e7
                );

        }


        .cover-three {

            background:
                linear-gradient(
                    135deg,
                    #dc5a17,
                    #f5ad2b
                );

        }


        .date {

            position:
                absolute;

            top:
                13px;

            left:
                13px;

            background:
                white;

            color:
                #111827;

            border-radius:
                8px;

            padding:
                6px 10px;

            text-align:
                center;

            line-height:
                1.1;

        }


        .date strong {

            display:
                block;

            font-size:
                17px;

        }


        .date small {

            font-size:
                9px;

            font-weight:
                800;

        }


        .event-content {

            padding:
                19px;

        }


        .tag {

            display:
                inline-block;

            padding:
                4px 8px;

            border-radius:
                5px;

            background:
                rgba(124, 92, 255, .12);

            color:
                #a99aff;

            font-size:
                10px;

            font-weight:
                900;

            text-transform:
                uppercase;

        }


        .event-content h3 {

            font-size:
                18px;

            margin:
                11px 0 6px;

        }


        .location {

            color:
                var(--muted);

            font-size:
                13px;

            margin-bottom:
                14px;

        }


        .event-bottom {

            border-top:
                1px solid var(--border);

            padding-top:
                13px;

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;

        }


        .event-price {

            font-weight:
                900;

        }


        .view-event {

            color:
                #a99aff;

            font-size:
                13px;

            font-weight:
                800;

        }


        /* =====================================================
           CATEGORIES
           ===================================================== */

        .categories {

            display:
                grid;

            grid-template-columns:
                repeat(6, 1fr);

            gap:
                15px;

        }


        .category {

            background:
                var(--card);

            border:
                1px solid var(--border);

            border-radius:
                14px;

            padding:
                24px 10px;

            text-align:
                center;

            transition:
                .25s;

        }


        .category:hover {

            transform:
                translateY(-4px);

            border-color:
                var(--primary);

        }


        .category-icon {

            font-size:
                30px;

            margin-bottom:
                8px;

        }


        .category h4 {

            font-size:
                13px;

        }


        /* =====================================================
           STEPS
           ===================================================== */

        .steps {

            display:
                grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap:
                25px;

        }


        .step {

            text-align:
                center;

            padding:
                25px;

        }


        .step-number {

            width:
                55px;

            height:
                55px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin:
                0 auto 16px;

            border-radius:
                50%;

            background:
                rgba(124,92,255,.13);

            border:
                1px solid
                rgba(124,92,255,.25);

            color:
                #a99aff;

            font-weight:
                900;

        }


        .step h3 {

            margin-bottom:
                7px;

        }


        .step p {

            color:
                var(--muted);

            font-size:
                14px;

        }


        /* =====================================================
           CTA
           ===================================================== */

        .cta {

            background:
                radial-gradient(
                    circle at 20% 20%,
                    rgba(124,92,255,.35),
                    transparent 30%
                ),
                #111827;

            border:
                1px solid #293348;

            border-radius:
                24px;

            text-align:
                center;

            padding:
                60px 25px;

        }


        .cta h2 {

            font-size:
                38px;

            margin-bottom:
                10px;

            color:
                #ffffff;

        }


        .cta p {

            color:
                #cbd5e1;

            max-width:
                600px;

            margin:
                0 auto 25px;

        }


        /* =====================================================
           FOOTER
           ===================================================== */

        /*
           Footer HTML is now in:

           resources/views/layouts/footer.blade.php

           Only CSS is kept here.
        */


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
                #ffffff;

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

            transition:
                .25s;

        }


        .footer-column a:hover {

            color:
                #ffffff;

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


        /* =====================================================
           LIGHT THEME - FOOTER
           ===================================================== */

        html[data-theme="light"] footer {

            background:
                #ffffff;

            color:
                #111827;

            border-top:
                1px solid #e2e6ef;

        }


        html[data-theme="light"] footer .logo {

            color:
                #7c5cff;

        }


        html[data-theme="light"] footer .logo span {

            color:
                #111827;

        }


        html[data-theme="light"] footer h4 {

            color:
                #111827;

        }


        html[data-theme="light"] footer .footer-text {

            color:
                #667085;

        }


        html[data-theme="light"] footer .footer-column a {

            color:
                #667085;

        }


        html[data-theme="light"] footer .footer-column a:hover {

            color:
                #7c5cff;

        }


        html[data-theme="light"] footer .footer-bottom {

            color:
                #667085;

            border-top:
                1px solid #e2e6ef;

        }


        /* =====================================================
           LIGHT THEME - CTA
           ===================================================== */

        html[data-theme="light"] .cta {

            background:
                #ffffff;

            color:
                #111827;

            border:
                1px solid #e2e6ef;

            box-shadow:
                0 15px 40px
                rgba(30, 40, 70, 0.08);

        }


        html[data-theme="light"] .cta h2 {

            color:
                #111827;

        }


        html[data-theme="light"] .cta p {

            color:
                #667085;

        }


        html[data-theme="light"] .cta .primary-btn {

            background:
                #7c5cff;

            color:
                #ffffff;

        }


        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 1050px) {

            .nav-links {

                gap:
                    0;

            }


            .nav-link {

                padding:
                    9px 10px;

            }


            .events-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }


            .categories {

                grid-template-columns:
                    repeat(3, 1fr);

            }


            .footer-grid {

                grid-template-columns:
                    repeat(2, 1fr);

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


            .nav-link {

                display:
                    block;

            }


            .login-btn,
            .signup-btn {

                display:
                    none;

            }


            .menu-btn {

                display:
                    block;

            }


            .hero-grid {

                grid-template-columns:
                    1fr;

            }


            .hero {

                padding-top:
                    70px;

            }


            .hero-card {

                max-width:
                    650px;

                margin:
                    auto;

            }


            .steps {

                grid-template-columns:
                    1fr;

            }

        }


        @media (max-width: 600px) {

            .container {

                width:
                    92%;

            }


            .logo {

                font-size:
                    24px;

            }


            .hero h1 {

                font-size:
                    45px;

                letter-spacing:
                    -2px;

            }


            .search-box {

                flex-direction:
                    column;

            }


            .search-button {

                padding:
                    12px;

            }


            .events-grid {

                grid-template-columns:
                    1fr;

            }


            .categories {

                grid-template-columns:
                    repeat(2, 1fr);

            }


            .section {

                padding:
                    65px 0;

            }


            .section-heading h2 {

                font-size:
                    30px;

            }


            .cta h2 {

                font-size:
                    30px;

            }


            .footer-grid {

                grid-template-columns:
                    1fr;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         NAVBAR
         ===================================================== -->

    @include('layouts.navbar')


    <!-- =====================================================
         HERO
         ===================================================== -->

    <section class="hero">

        <div class="container hero-grid">


            <!-- HERO LEFT -->

            <div>

                <div class="badge">

                    ✦ Your gateway to amazing experiences

                </div>


                <h1>

                    Discover.

                    <span>
                        Book.
                    </span>

                    Experience.

                </h1>


                <p class="hero-text">

                    Find exciting events, discover new experiences
                    and book your tickets easily with Eventora.

                </p>


                <div class="hero-buttons">

                    <a
                        href="#events"
                        class="primary-btn"
                    >
                        Explore Events →
                    </a>


                    <a
                        href="#how-it-works"
                        class="secondary-btn"
                    >
                        How It Works
                    </a>

                </div>

            </div>


            <!-- HERO RIGHT -->

            <div>

                <div class="hero-card">


                    <div class="hero-image">

                        <div class="hero-image-content">

                            <div class="hero-icon">
                                🎟️
                            </div>

                            <h3>
                                Live Events
                            </h3>

                            <p>
                                Memories start here
                            </p>

                        </div>

                    </div>


                    <div class="hero-card-info">

                        <div class="hero-card-title">

                            <h3>
                                Tech & Innovation Summit
                            </h3>

                            <div class="price">
                                ₹499
                            </div>

                        </div>


                        <div class="meta">

                            📍 Ahmedabad
                            &nbsp; • &nbsp;
                            📅 25 Oct 2026

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         SEARCH
         ===================================================== -->

    <div class="container search-wrapper">

        <div class="search-box">


            <input
                type="text"
                class="search-input"
                placeholder="Search events, cities or categories..."
            >


            <button class="search-button">

                Search

            </button>

        </div>

    </div>


    <!-- =====================================================
         EVENTS
         ===================================================== -->

    <section
        class="section"
        id="events"
    >

        <div class="container">


            <div class="section-heading">

                <div class="small-title">
                    Featured Events
                </div>


                <h2>
                    Find Your Next Experience
                </h2>


                <p>
                    Explore popular events and create
                    unforgettable memories.
                </p>

            </div>


            <div class="events-grid">


                <!-- EVENT 1 -->

                <div class="event-card">


                    <div class="event-cover cover-one">

                        <div class="date">

                            <strong>
                                18
                            </strong>

                            <small>
                                OCT
                            </small>

                        </div>


                        🎵

                    </div>


                    <div class="event-content">


                        <span class="tag">
                            Music
                        </span>


                        <h3>
                            Live Music Festival
                        </h3>


                        <div class="location">
                            📍 Surat, Gujarat
                        </div>


                        <div class="event-bottom">

                            <div class="event-price">
                                From ₹299
                            </div>


                            <a
                                href="{{ route('events.index') }}"
                                class="view-event"
                            >
                                View Event →
                            </a>

                        </div>

                    </div>

                </div>


                <!-- EVENT 2 -->

                <div class="event-card">


                    <div class="event-cover cover-two">

                        <div class="date">

                            <strong>
                                25
                            </strong>

                            <small>
                                OCT
                            </small>

                        </div>


                        💻

                    </div>


                    <div class="event-content">


                        <span class="tag">
                            Technology
                        </span>


                        <h3>
                            Tech & Innovation Summit
                        </h3>


                        <div class="location">
                            📍 Ahmedabad, Gujarat
                        </div>


                        <div class="event-bottom">

                            <div class="event-price">
                                From ₹499
                            </div>


                            <a
                                href="{{ route('events.index') }}"
                                class="view-event"
                            >
                                View Event →
                            </a>

                        </div>

                    </div>

                </div>


                <!-- EVENT 3 -->

                <div class="event-card">


                    <div class="event-cover cover-three">

                        <div class="date">

                            <strong>
                                02
                            </strong>

                            <small>
                                NOV
                            </small>

                        </div>


                        🎨

                    </div>


                    <div class="event-content">


                        <span class="tag">
                            Art
                        </span>


                        <h3>
                            Creative Art Workshop
                        </h3>


                        <div class="location">
                            📍 Vadodara, Gujarat
                        </div>


                        <div class="event-bottom">

                            <div class="event-price">
                                From ₹199
                            </div>


                            <a
                                href="{{ route('events.index') }}"
                                class="view-event"
                            >
                                View Event →
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CATEGORIES
         ===================================================== -->

    <section
        class="section section-dark"
        id="categories"
    >

        <div class="container">


            <div class="section-heading">

                <div class="small-title">
                    Explore Categories
                </div>


                <h2>
                    Something For Everyone
                </h2>


                <p>
                    Choose your favorite category and discover
                    amazing events.
                </p>

            </div>


            <div class="categories">


                <div class="category">

                    <div class="category-icon">
                        🎵
                    </div>

                    <h4>
                        Music
                    </h4>

                </div>


                <div class="category">

                    <div class="category-icon">
                        💻
                    </div>

                    <h4>
                        Technology
                    </h4>

                </div>


                <div class="category">

                    <div class="category-icon">
                        🎨
                    </div>

                    <h4>
                        Art
                    </h4>

                </div>


                <div class="category">

                    <div class="category-icon">
                        🏆
                    </div>

                    <h4>
                        Sports
                    </h4>

                </div>


                <div class="category">

                    <div class="category-icon">
                        🎓
                    </div>

                    <h4>
                        Education
                    </h4>

                </div>


                <div class="category">

                    <div class="category-icon">
                        💼
                    </div>

                    <h4>
                        Business
                    </h4>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         HOW IT WORKS
         ===================================================== -->

    <section
        class="section"
        id="how-it-works"
    >

        <div class="container">


            <div class="section-heading">

                <div class="small-title">
                    Simple Process
                </div>


                <h2>
                    How Eventora Works
                </h2>


                <p>
                    Booking your next event is quick and simple.
                </p>

            </div>


            <div class="steps">


                <!-- STEP 1 -->

                <div class="step">

                    <div class="step-number">
                        01
                    </div>


                    <h3>
                        Discover
                    </h3>


                    <p>
                        Browse events and find something you love.
                    </p>

                </div>


                <!-- STEP 2 -->

                <div class="step">

                    <div class="step-number">
                        02
                    </div>


                    <h3>
                        Book
                    </h3>


                    <p>
                        Select your ticket and complete your booking.
                    </p>

                </div>


                <!-- STEP 3 -->

                <div class="step">

                    <div class="step-number">
                        03
                    </div>


                    <h3>
                        Experience
                    </h3>


                    <p>
                        Get your ticket and enjoy the event.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         ABOUT / CTA
         ===================================================== -->

    <section
        class="section section-dark"
        id="about"
    >

        <div class="container">


            <div class="cta">

                <h2>
                    Your Next Great Experience Awaits.
                </h2>


                <p>
                    Eventora makes discovering and booking
                    events simple, fast and enjoyable.
                </p>


                <a
                    href="#events"
                    class="primary-btn"
                >
                    Explore Events
                </a>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FOOTER
         ===================================================== -->

    @include('layouts.footer')


    <!-- =====================================================
         JAVASCRIPT
         ===================================================== -->

    <script>


        /* =====================================================
           MOBILE MENU
           ===================================================== */

        function toggleMenu() {

            const navLinks =
                document.getElementById("navLinks");


            if (navLinks) {

                navLinks.classList.toggle("show");

            }

        }


        /* =====================================================
           THEME
           ===================================================== */

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


            const themeButton =
                document.getElementById(
                    "themeButton"
                );


            if (themeButton) {

                if (theme === "dark") {

                    themeButton.innerHTML =
                        "☀️";

                    themeButton.title =
                        "Switch to Light Mode";

                } else {

                    themeButton.innerHTML =
                        "🌙";

                    themeButton.title =
                        "Switch to Dark Mode";

                }

            }

        }


        function toggleTheme() {

            const currentTheme =
                html.getAttribute(
                    "data-theme"
                ) || "dark";


            if (currentTheme === "dark") {

                setTheme("light");

            } else {

                setTheme("dark");

            }

        }


        /* Load saved theme */

        const savedTheme =
            localStorage.getItem(
                "eventora-theme"
            );


        if (savedTheme) {

            setTheme(savedTheme);

        } else {

            setTheme("dark");

        }


        /* =====================================================
           ACTIVE NAVIGATION
           ===================================================== */

        const navLinks =
            document.querySelectorAll(
                ".nav-link"
            );


        const sectionIds = [

            "events",
            "categories",
            "how-it-works",
            "about",
            "contact"

        ];


        function setActiveMenu(
            sectionName
        ) {

            navLinks.forEach(
                function(link) {

                    link.classList.remove(
                        "active"
                    );


                    if (
                        link.getAttribute(
                            "data-section"
                        ) === sectionName
                    ) {

                        link.classList.add(
                            "active"
                        );

                    }

                }
            );

        }


        /* =====================================================
           NAVIGATION CLICK
           ===================================================== */

        navLinks.forEach(
            function(link) {

                link.addEventListener(
                    "click",
                    function() {

                        const section =
                            link.getAttribute(
                                "data-section"
                            );


                        if (section) {

                            setActiveMenu(
                                section
                            );

                        }


                        const menu =
                            document.getElementById(
                                "navLinks"
                            );


                        if (menu) {

                            menu.classList.remove(
                                "show"
                            );

                        }

                    }
                );

            }
        );


        /* =====================================================
           ACTIVE MENU ON SCROLL
           ===================================================== */

        function updateActiveMenu() {

            const scrollPosition =
                window.scrollY + 180;


            let activeSection =
                "home";


            sectionIds.forEach(
                function(id) {

                    const section =
                        document.getElementById(
                            id
                        );


                    if (!section) {

                        return;

                    }


                    const sectionTop =
                        section.offsetTop;


                    if (
                        scrollPosition >=
                        sectionTop
                    ) {

                        activeSection =
                            id;

                    }

                }
            );


            /* Top of page = Dashboard */

            if (
                window.scrollY < 150
            ) {

                activeSection =
                    "home";

            }


            setActiveMenu(
                activeSection
            );

        }


        window.addEventListener(
            "scroll",
            updateActiveMenu
        );


        window.addEventListener(
            "load",
            updateActiveMenu
        );


        updateActiveMenu();


    </script>


</body>

</html>
