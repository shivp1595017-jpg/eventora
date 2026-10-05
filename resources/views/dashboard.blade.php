<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Eventora</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #0b0f19;
            color: #ffffff;
            min-height: 100vh;
        }

        .dashboard-page {
            width: min(1200px, calc(100% - 40px));
            margin: auto;
            padding: 45px 0 70px;
        }


        /* =========================================
           WELCOME
        ========================================= */

        .welcome-box {
            position: relative;
            overflow: hidden;
            padding: 42px;
            border-radius: 24px;
            background: linear-gradient(
                135deg,
                #352a86,
                #171d3b 72%
            );
            border: 1px solid rgba(167, 139, 250, .35);
            margin-bottom: 28px;
            box-shadow: 0 18px 48px rgba(33, 24, 100, .24);
        }

        .welcome-box::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            right: -55px;
            top: -105px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 50%;
            box-shadow: 0 0 0 28px rgba(255, 255, 255, .035), 0 0 0 58px rgba(255, 255, 255, .025);
        }

        .welcome-box h1 {
            position: relative;
            z-index: 1;
            font-size: clamp(28px, 4vw, 38px);
            margin-bottom: 10px;
        }

        .welcome-box h1 span {
            color: #c4baff;
        }

        .welcome-box p {
            position: relative;
            z-index: 1;
            max-width: 620px;
            color: #d0cbed;
            line-height: 1.7;
            font-size: 15px;
        }


        /* =========================================
           DASHBOARD GRID
        ========================================= */

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            padding: 26px;
            background: linear-gradient(155deg, #151c2d, #101624);
            border: 1px solid #29344c;
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .12);
            transition: transform .25s, border-color .25s, box-shadow .25s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            border-color: #6d5dfc;
            box-shadow: 0 18px 36px rgba(0, 0, 0, .2);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(109, 93, 252, 0.15);
            font-size: 21px;
            margin-bottom: 20px;
        }

        .dashboard-card h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .dashboard-card p {
            color: #8995aa;
            font-size: 14px;
            line-height: 1.6;
        }


        /* =========================================
           ACTIONS
        ========================================= */

        .dashboard-actions {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .action-box {
            background: #111725;
            border: 1px solid #29344c;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .1);
        }

        .action-box h2 {
            font-size: 21px;
            margin-bottom: 8px;
        }

        .action-box p {
            color: #8995aa;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }


        /* =========================================
           BUTTON
        ========================================= */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            text-decoration: none;

            padding: 11px 18px;

            border-radius: 9px;

            font-size: 14px;
            font-weight: 700;

            transition: 0.2s;

            border: none;

            cursor: pointer;
        }

        .btn-primary {
            background: #6d5dfc;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #5848eb;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #20283a;
            color: #ffffff;
            border: 1px solid #303a52;
        }

        .btn-secondary:hover {
            border-color: #6d5dfc;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: rgba(180, 35, 24, .15);
            border: 1px solid rgba(248, 113, 113, .3);
            color: #fda4af;
        }

        .btn-danger:hover {
            background: #b42318;
            color: #ffffff;
            transform: translateY(-1px);
        }


        /* =========================================
           PROFILE
        ========================================= */

        .profile-box {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info strong {
            display: block;
            margin-bottom: 7px;
        }

        .profile-info span {
            color: #8995aa;
            font-size: 14px;
            word-break: break-word;
        }


        /* =========================================
           ACCOUNT ACTIONS
        ========================================= */

        .account-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .account-actions .btn {
            flex: 1;
            min-width: 130px;
        }


        /* =========================================
           LIGHT MODE
        ========================================= */

        html[data-theme="light"] body {
            background: #f5f7fb;
            color: #172033;
        }

        html[data-theme="light"] .welcome-box {
            background: linear-gradient(135deg, #352a86, #171d3b 72%);
            border-color: rgba(109, 93, 252, .35);
        }

        html[data-theme="light"] .welcome-box h1,
        html[data-theme="light"] .welcome-box h1 span {
            color: #ffffff;
        }

        html[data-theme="light"] .welcome-box p {
            color: #d0cbed;
        }

        html[data-theme="light"] .dashboard-card,
        html[data-theme="light"] .action-box {
            background: #ffffff;
            border-color: #e1e6ef;
            box-shadow:
                0 8px 25px rgba(20, 30, 50, 0.05);
        }

        html[data-theme="light"] .dashboard-card:hover {
            border-color: #6d5dfc;
        }

        html[data-theme="light"] .dashboard-card,
        html[data-theme="light"] .action-box {
            box-shadow: 0 10px 28px rgba(20, 30, 50, .07);
        }

        html[data-theme="light"] .dashboard-card p,
        html[data-theme="light"] .action-box p,
        html[data-theme="light"] .profile-info span {
            color: #687386;
        }

        html[data-theme="light"] .btn-secondary {
            background: #eef1f6;
            color: #172033;
            border-color: #dce2ec;
        }

        html[data-theme="light"] .btn-secondary:hover {
            background: #f0efff;
            border-color: #6d5dfc;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 800px) {

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-actions {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 550px) {

            .dashboard-page {
                width: calc(100% - 28px);
                padding-top: 30px;
            }

            .welcome-box {
                padding: 25px;
            }

            .welcome-box h1 {
                font-size: 26px;
            }

            .buttons {
                flex-direction: column;
            }

            .account-actions {
                flex-direction: column;
            }

            .account-actions .btn {
                width: 100%;
            }

            .btn {
                width: 100%;
            }

        }
    </style>
</head>

<body>

    @include('layouts.navbar')


    <main class="dashboard-page">


        <!-- =========================================
             WELCOME
        ========================================= -->

        <section class="welcome-box">

            <h1>
                Welcome,
                <span>{{ auth()->user()->name }}</span> 👋
            </h1>

            <p>
                Manage your Eventora account, explore events,
                book tickets and view your bookings from one place.
            </p>

        </section>


        <!-- =========================================
             DASHBOARD CARDS
        ========================================= -->

        <section class="dashboard-grid">


            <!-- MY BOOKINGS -->

            <div class="dashboard-card">

                <div class="card-icon">
                    🎫
                </div>

                <h3>
                    My Bookings
                </h3>

                <p>
                    View your registered events and booking details.
                </p>

                <br>

                <a
                    href="{{ route('bookings.index') }}"
                    class="btn btn-primary"
                >
                    View Bookings
                </a>

            </div>


            <!-- EXPLORE EVENTS -->

            <div class="dashboard-card">

                <div class="card-icon">
                    🎉
                </div>

                <h3>
                    Explore Events
                </h3>

                <p>
                    Discover upcoming events and find something
                    interesting to attend.
                </p>

                <br>

                <a
                    href="{{ route('events.index') }}"
                    class="btn btn-secondary"
                >
                    Explore Events
                </a>

            </div>


            <!-- ORGANIZATIONS -->

            <div class="dashboard-card">

                <div class="card-icon">
                    🏫
                </div>

                <h3>
                    Organizations
                </h3>

                <p>
                    Find colleges, schools, companies and other
                    event organizations.
                </p>

                <br>

                <a
                    href="{{ route('organizations.search') }}"
                    class="btn btn-secondary"
                >
                    Find Organizations
                </a>

            </div>

        </section>


        <!-- =========================================
             QUICK ACTIONS + ACCOUNT
        ========================================= -->

        <section class="dashboard-actions">


            <!-- QUICK ACTIONS -->

            <div class="action-box">

                <h2>
                    Quick Actions
                </h2>

                <p>
                    Quickly access the most important Eventora
                    features from here.
                </p>


                <div class="buttons">

                    <a
                        href="{{ route('home') }}"
                        class="btn btn-primary"
                    >
                        Browse Events
                    </a>


                    <a
                        href="{{ route('bookings.index') }}"
                        class="btn btn-secondary"
                    >
                        My Bookings
                    </a>


                    <a
                        href="{{ route('organizations.search') }}"
                        class="btn btn-secondary"
                    >
                        Organizations
                    </a>

                </div>

            </div>


            <!-- MY ACCOUNT -->

            <div class="action-box profile-box">

                <div>

                    <h2>
                        My Account
                    </h2>

                    <br>


                    <!-- NAME -->

                    <div class="profile-info">

                        <strong>
                            Name
                        </strong>

                        <span>
                            {{ auth()->user()->name }}
                        </span>

                    </div>


                    <!-- EMAIL -->

                    <div class="profile-info">

                        <strong>
                            Email
                        </strong>

                        <span>
                            {{ auth()->user()->email }}
                        </span>

                    </div>


                    <!-- ACCOUNT BUTTONS -->

                    <div class="account-actions">


                        <!-- EDIT PROFILE -->

                        <a
                            href="{{ route('profile.show') }}"
                            class="btn btn-primary"
                        >
                            👤 View Profile
                        </a>


                        <!-- CHANGE PASSWORD -->

                        <a
                            href="{{ route('profile.edit') }}#update-password"
                            class="btn btn-secondary"
                        >
                            🔐 Change Password
                        </a>


                        <!-- FORGOT PASSWORD -->

                        <a
                            href="{{ route('password.request') }}"
                            class="btn btn-secondary"
                        >
                            📧 Forgot Password
                        </a>

                    </div>

                </div>


                <!-- LOGOUT -->

                <div class="buttons">

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            🚪 Logout
                        </button>

                    </form>

                </div>

            </div>

        </section>

    </main>


    @include('layouts.footer')


</body>
</html>
