<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Reset Password - Eventora
    </title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        :root {

            --bg: #070b14;

            --card: #0e1524;

            --card-2: #111a2b;

            --text: #ffffff;

            --muted: #8f9aad;

            --border: #202b40;

            --primary: #6c63ff;

            --primary-2: #8b5cf6;

            --input: #0a101d;

        }


        html[data-theme="light"] {

            --bg: #f5f7fb;

            --card: #ffffff;

            --card-2: #f8faff;

            --text: #111827;

            --muted: #667085;

            --border: #dce2ec;

            --input: #f8fafc;

        }


        body {

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 10% 20%,
                    rgba(
                        108,
                        99,
                        255,
                        .14
                    ),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 80%,
                    rgba(
                        139,
                        92,
                        246,
                        .12
                    ),
                    transparent 28%
                ),
                var(--bg);

            color: var(--text);

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            display: flex;

            flex-direction: column;

        }


        a {

            text-decoration: none;

            color: inherit;

        }


        /* =====================================================
           NAVBAR
        ====================================================== */

        .navbar {

            width: 100%;

            border-bottom:
                1px solid var(--border);

            background:
                rgba(
                    7,
                    11,
                    20,
                    .78
                );

            backdrop-filter: blur(14px);

            position: sticky;

            top: 0;

            z-index: 1000;

        }


        html[data-theme="light"]
        .navbar {

            background:
                rgba(
                    255,
                    255,
                    255,
                    .88
                );

        }


        .nav-container {

            width:
                min(
                    1180px,
                    92%
                );

            margin: auto;

            min-height: 76px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

        }


        .logo {

            font-size: 25px;

            font-weight: 800;

            letter-spacing: -.7px;

            color: var(--text);

            flex-shrink: 0;

        }


        .logo span {

            color:
                var(--primary);

        }


        .nav-links {

            list-style: none;

            display: flex;

            align-items: center;

            gap: 4px;

            margin-left: auto;

        }


        .nav-links a {

            color: var(--muted);

            font-size: 13px;

            font-weight: 600;

            padding:
                9px 11px;

            border-radius: 8px;

            transition: .25s;

        }


        .nav-links a:hover {

            color: var(--text);

            background:
                rgba(
                    108,
                    99,
                    255,
                    .08
                );

        }


        .nav-links a.active {

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

        }


        .nav-right {

            display: flex;

            align-items: center;

            gap: 9px;

            flex-shrink: 0;

        }


        .theme-btn {

            width: 39px;

            height: 39px;

            border-radius: 10px;

            border:
                1px solid var(--border);

            background: var(--card);

            color: var(--text);

            cursor: pointer;

            font-size: 16px;

            transition: .25s;

        }


        .theme-btn:hover {

            transform:
                translateY(-2px);

            border-color:
                var(--primary);

        }


        .menu-btn {

            display: none;

            width: 39px;

            height: 39px;

            border-radius: 10px;

            border:
                1px solid var(--border);

            background: var(--card);

            color: var(--text);

            cursor: pointer;

            font-size: 19px;

        }


        .nav-register {

            padding:
                10px 15px;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

            color: #fff;

            font-size: 13px;

            font-weight: 700;

        }


        /* =====================================================
           MAIN
        ====================================================== */

        .login-wrapper {

            flex: 1;

            display: flex;

            align-items: center;

            justify-content: center;

            padding:
                55px 20px 70px;

        }


        .login-card {

            width: 100%;

            max-width: 455px;

            background: var(--card);

            border:
                1px solid var(--border);

            border-radius: 22px;

            padding: 38px;

            box-shadow:
                0 25px 70px
                rgba(
                    0,
                    0,
                    0,
                    .25
                );

        }


        html[data-theme="light"]
        .login-card {

            box-shadow:
                0 20px 50px
                rgba(
                    15,
                    23,
                    42,
                    .08
                );

        }


        /* =====================================================
           HEADING
        ====================================================== */

        .login-heading {

            text-align: center;

            margin-bottom: 30px;

        }


        .login-icon {

            width: 58px;

            height: 58px;

            margin:
                0 auto 18px;

            border-radius: 16px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 26px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

            box-shadow:
                0 12px 28px
                rgba(
                    108,
                    99,
                    255,
                    .25
                );

        }


        .login-heading h1 {

            font-size: 30px;

            margin-bottom: 8px;

        }


        .login-heading p {

            color: var(--muted);

            font-size: 14px;

            line-height: 1.5;

        }


        /* =====================================================
           ERROR
        ====================================================== */

        .error-box {

            margin-bottom: 20px;

            padding:
                12px 14px;

            border-radius: 10px;

            background:
                rgba(
                    239,
                    68,
                    68,
                    .10
                );

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    .25
                );

            color: #f87171;

            font-size: 12px;

            line-height: 1.5;

        }


        /* =====================================================
           VERIFIED EMAIL BOX
        ====================================================== */

        .email-box {

            margin-bottom: 24px;

            padding: 15px;

            border-radius: 12px;

            background: var(--card-2);

            border:
                1px solid var(--border);

        }


        .email-label {

            display: block;

            margin-bottom: 6px;

            color: var(--muted);

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .6px;

        }


        .email-value {

            display: block;

            color: var(--text);

            font-size: 13px;

            font-weight: 700;

            word-break: break-word;

        }


        .email-note {

            margin-top: 7px;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.5;

        }


        /* =====================================================
           FORM
        ====================================================== */

        .form-group {

            margin-bottom: 19px;

        }


        .form-label {

            display: block;

            margin-bottom: 8px;

            font-size: 13px;

            font-weight: 600;

        }


        .input-wrapper {

            position: relative;

        }


        .form-input {

            width: 100%;

            height: 48px;

            padding:
                0 46px 0 15px;

            border-radius: 11px;

            border:
                1px solid var(--border);

            background: var(--input);

            color: var(--text);

            outline: none;

            font-size: 14px;

            transition: .25s;

        }


        .form-input::placeholder {

            color: #788397;

        }


        .form-input:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(
                    108,
                    99,
                    255,
                    .12
                );

        }


        .password-toggle {

            position: absolute;

            right: 13px;

            top: 50%;

            transform:
                translateY(-50%);

            border: none;

            background: transparent;

            color: var(--muted);

            cursor: pointer;

            font-size: 16px;

        }


        .password-toggle:hover {

            color:
                var(--text);

        }


        /* =====================================================
           PASSWORD NOTE
        ====================================================== */

        .password-note {

            margin-top: 7px;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.5;

        }


        .field-error {

            margin-top: 6px;

            color: #f87171;

            font-size: 11px;

        }


        /* =====================================================
           BUTTON ROW
        ====================================================== */

        .button-row {

            display: flex;

            gap: 10px;

            margin-top: 25px;

        }


        .reset-btn {

            flex: 1;

            height: 49px;

            border: none;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

            color: #fff;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition: .25s;

        }


        .reset-btn:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 25px
                rgba(
                    108,
                    99,
                    255,
                    .25
                );

        }


        .back-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            height: 49px;

            padding:
                0 18px;

            border-radius: 11px;

            border:
                1px solid var(--border);

            background:
                var(--card-2);

            color: var(--text);

            font-size: 13px;

            font-weight: 700;

            transition: .25s;

        }


        .back-btn:hover {

            border-color:
                var(--primary);

            color:
                var(--primary);

        }


        /* =====================================================
           SECURITY NOTE
        ====================================================== */

        .security-note {

            margin-top: 23px;

            padding:
                14px 15px;

            border-radius: 11px;

            background:
                var(--card-2);

            border:
                1px solid var(--border);

        }


        .security-note strong {

            display: block;

            margin-bottom: 5px;

            font-size: 11px;

            color: var(--text);

        }


        .security-note p {

            margin: 0;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.6;

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .auth-footer {

            border-top:
                1px solid var(--border);

            padding: 20px;

            text-align: center;

            color: var(--muted);

            font-size: 12px;

        }


        /* =====================================================
           MOBILE NAV
        ====================================================== */

        @media (max-width: 1050px) {

            .nav-links {

                gap: 0;

            }


            .nav-links a {

                padding:
                    8px 7px;

                font-size: 12px;

            }


            .nav-register {

                display: none;

            }

        }


        @media (max-width: 850px) {

            .nav-links {

                display: none;

                position: absolute;

                top: 76px;

                left: 0;

                width: 100%;

                padding:
                    15px 4%;

                background: var(--card);

                border-bottom:
                    1px solid var(--border);

                flex-direction: column;

                align-items: stretch;

                gap: 4px;

            }


            .nav-links.show {

                display: flex;

            }


            .nav-links a {

                display: block;

                padding:
                    12px 14px;

            }


            .menu-btn {

                display: block;

            }

        }


        /* =====================================================
           MOBILE CONTENT
        ====================================================== */

        @media (max-width: 600px) {

            .nav-container {

                min-height: 68px;

            }


            .login-wrapper {

                padding:
                    35px 15px 45px;

            }


            .login-card {

                padding:
                    28px 21px;

                border-radius: 18px;

            }


            .login-heading h1 {

                font-size: 26px;

            }


            .button-row {

                flex-direction: column;

            }


            .reset-btn,
            .back-btn {

                width: 100%;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <header class="navbar">

        <div class="nav-container">


            <a
                href="{{ route('home') }}"
                class="logo"
            >
                Event<span>ora</span>
            </a>


            <ul
                class="nav-links"
                id="navLinks"
            >


                <li>

                    <a
                        href="{{ route('home') }}"
                        class="active"
                    >
                        Home
                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('home') }}#events"
                    >
                        Events
                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('organizations.search') }}"
                    >
                        Organizations
                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('home') }}#categories"
                    >
                        Categories
                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('home') }}#how-it-works"
                    >
                        How It Works
                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('home') }}#about"
                    >
                        About
                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('home') }}#contact"
                    >
                        Contact
                    </a>

                </li>


            </ul>


            <div class="nav-right">


                <a
                    href="{{ route('register') }}"
                    class="nav-register"
                >
                    Get Started
                </a>


                <button
                    type="button"
                    class="theme-btn"
                    id="themeButton"
                    onclick="toggleTheme()"
                    title="Change Theme"
                >
                    ☀️
                </button>


                <button
                    type="button"
                    class="menu-btn"
                    onclick="toggleMenu()"
                    title="Menu"
                >
                    ☰
                </button>


            </div>


        </div>

    </header>


    <!-- =====================================================
         MAIN
    ====================================================== -->

    <main class="login-wrapper">


        <div class="login-card">


            <!-- HEADING -->

            <div class="login-heading">


                <div class="login-icon">
                    🔑
                </div>


                <h1>
                    Reset Password
                </h1>


                <p>
                    Create a new password for your Eventora account
                </p>


            </div>


            <!-- ERRORS -->

            @if ($errors->any())

                <div class="error-box">

                    @foreach ($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <!-- VERIFIED EMAIL -->

            <div class="email-box">


                <span class="email-label">
                    Verified Account Email
                </span>


                <span class="email-value">
                    {{ $email }}
                </span>


                <div class="email-note">
                    Your OTP has been verified. You are now resetting the password for this registered Eventora account.
                </div>


            </div>


            <!-- FORM -->

            <form
                method="POST"
                action="{{ route('password.otp.reset.store') }}"
            >

                @csrf


                <!-- NEW PASSWORD -->

                <div class="form-group">


                    <label
                        for="password"
                        class="form-label"
                    >
                        New Password
                    </label>


                    <div class="input-wrapper">


                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="Enter new password"
                            minlength="8"
                            required
                            autofocus
                            autocomplete="new-password"
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'password',
                                'passwordToggle'
                            )"
                            id="passwordToggle"
                            title="Show password"
                        >
                            👁️
                        </button>


                    </div>


                    <div class="password-note">

                        Password must contain at least
                        8 characters.

                    </div>


                    @error('password')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror


                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="form-group">


                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Confirm New Password
                    </label>


                    <div class="input-wrapper">


                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Confirm new password"
                            minlength="8"
                            required
                            autocomplete="new-password"
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'password_confirmation',
                                'confirmPasswordToggle'
                            )"
                            id="confirmPasswordToggle"
                            title="Show password"
                        >
                            👁️
                        </button>


                    </div>


                    @error('password_confirmation')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror


                </div>


                <!-- BUTTONS -->

                <div class="button-row">


                    <a
                        href="{{ route('login') }}"
                        class="back-btn"
                    >
                        ← Login
                    </a>


                    <button
                        type="submit"
                        class="reset-btn"
                    >
                        🔐 Reset Password
                    </button>


                </div>


            </form>


            <!-- SECURITY -->

            <div class="security-note">


                <strong>
                    🔒 Security
                </strong>


                <p>
                    Your new password will be securely encrypted before being saved.
                    After resetting your password, you can log in to Eventora using your new password.
                </p>


            </div>


        </div>


    </main>


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer class="auth-footer">

        © {{ date('Y') }} Eventora.
        All Rights Reserved.

    </footer>


    <script>


        /* =====================================================
           MENU
        ====================================================== */

        function toggleMenu() {

            const navLinks =
                document.getElementById(
                    "navLinks"
                );


            navLinks.classList.toggle(
                "show"
            );

        }


        /* =====================================================
           THEME
        ====================================================== */

        const html =
            document.documentElement;


        const themeButton =
            document.getElementById(
                "themeButton"
            );


        function setTheme(theme) {

            html.setAttribute(
                "data-theme",
                theme
            );


            localStorage.setItem(
                "eventora-theme",
                theme
            );


            if (
                theme === "light"
            ) {

                themeButton.innerHTML =
                    "🌙";

            } else {

                themeButton.innerHTML =
                    "☀️";

            }

        }


        function toggleTheme() {

            const currentTheme =
                html.getAttribute(
                    "data-theme"
                ) || "dark";


            setTheme(
                currentTheme === "dark"
                    ? "light"
                    : "dark"
            );

        }


        const savedTheme =
            localStorage.getItem(
                "eventora-theme"
            ) || "dark";


        setTheme(savedTheme);


        /* =====================================================
           PASSWORD TOGGLE
        ====================================================== */

        function togglePassword(
            fieldId,
            buttonId
        ) {

            const field =
                document.getElementById(
                    fieldId
                );


            const button =
                document.getElementById(
                    buttonId
                );


            if (
                field.type === "password"
            ) {

                field.type = "text";

                button.innerHTML =
                    "🙈";

                button.title =
                    "Hide password";

            } else {

                field.type = "password";

                button.innerHTML =
                    "👁️";

                button.title =
                    "Show password";

            }

        }

    </script>


</body>

</html>