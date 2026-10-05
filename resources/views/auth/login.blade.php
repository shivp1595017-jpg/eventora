<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Eventora</title>

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
                radial-gradient(circle at 10% 20%, rgba(108, 99, 255, .14), transparent 28%),
                radial-gradient(circle at 90% 80%, rgba(139, 92, 246, .12), transparent 28%),
                var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ================= NAVBAR ================= */

        .navbar {
            width: 100%;
            border-bottom: 1px solid var(--border);
            background: rgba(7, 11, 20, .78);
            backdrop-filter: blur(14px);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        html[data-theme="light"] .navbar {
            background: rgba(255, 255, 255, .88);
        }

        .nav-container {
            width: min(1180px, 92%);
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
            color: var(--primary);
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
            padding: 9px 11px;
            border-radius: 8px;
            transition: .25s;
        }

        .nav-links a:hover {
            color: var(--text);
            background: rgba(108, 99, 255, .08);
        }

        .nav-links a.active {
            color: #ffffff;
            background: linear-gradient(
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
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text);
            cursor: pointer;
            font-size: 16px;
            transition: .25s;
        }

        .theme-btn:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        .menu-btn {
            display: none;
            width: 39px;
            height: 39px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text);
            cursor: pointer;
            font-size: 19px;
        }

        .nav-login {
            padding: 9px 14px;
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            font-size: 13px;
            font-weight: 600;
            transition: .25s;
        }

        .nav-login:hover {
            border-color: var(--primary);
        }

        .nav-register {
            padding: 10px 15px;
            border-radius: 9px;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary-2)
            );
            color: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        /* ================= MAIN ================= */

        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 55px 20px 70px;
        }

        .login-card {
            width: 100%;
            max-width: 455px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 38px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, .25);
        }

        html[data-theme="light"] .login-card {
            box-shadow: 0 20px 50px rgba(15, 23, 42, .08);
        }

        .login-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 18px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary-2)
            );
            box-shadow: 0 12px 28px rgba(108, 99, 255, .25);
        }

        .login-heading h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .login-heading p {
            color: var(--muted);
            font-size: 14px;
        }

        /* ================= FORM ================= */

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
            padding: 0 45px 0 15px;
            border-radius: 11px;
            border: 1px solid var(--border);
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
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, .12);
        }

        .password-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            font-size: 16px;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 4px 0 22px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 12px;
            cursor: pointer;
        }

        .remember input {
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot {
            color: #8b82ff;
            font-size: 12px;
            font-weight: 600;
        }

        .login-btn {
            width: 100%;
            height: 49px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(
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

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(108, 99, 255, .25);
        }

        /* ================= DIVIDER ================= */

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 25px 0;
            color: var(--muted);
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ================= GOOGLE ================= */

        .google-btn {
            width: 100%;
            height: 48px;
            border-radius: 11px;
            border: 1px solid var(--border);
            background: var(--card-2);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 11px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
        }

        .google-btn:hover {
            border-color: #6b7280;
            transform: translateY(-1px);
        }

        .google-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            font-weight: 800;
        }

        .register-text {
            text-align: center;
            margin-top: 25px;
            color: var(--muted);
            font-size: 13px;
        }

        .register-text a {
            color: #8b82ff;
            font-weight: 700;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 10px;
            background: rgba(239, 68, 68, .10);
            border: 1px solid rgba(239, 68, 68, .25);
            color: #f87171;
            font-size: 12px;
        }

        .session-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 10px;
            background: rgba(34, 197, 94, .10);
            border: 1px solid rgba(34, 197, 94, .25);
            color: #4ade80;
            font-size: 12px;
        }

        /* ================= FOOTER ================= */

        .auth-footer {
            border-top: 1px solid var(--border);
            padding: 20px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }

        /* ================= MOBILE ================= */

        @media (max-width: 1050px) {

            .nav-links {
                gap: 0;
            }

            .nav-links a {
                padding: 8px 7px;
                font-size: 12px;
            }

            .nav-login,
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
                padding: 15px 4%;
                background: var(--card);
                border-bottom: 1px solid var(--border);
                flex-direction: column;
                align-items: stretch;
                gap: 4px;
            }

            .nav-links.show {
                display: flex;
            }

            .nav-links a {
                display: block;
                padding: 12px 14px;
            }

            .menu-btn {
                display: block;
            }
        }

        @media (max-width: 600px) {

            .nav-container {
                min-height: 68px;
            }

            .login-wrapper {
                padding: 35px 15px 45px;
            }

            .login-card {
                padding: 28px 21px;
                border-radius: 18px;
            }

            .login-heading h1 {
                font-size: 26px;
            }
        }

    </style>
</head>

<body>

    @include('layouts.navbar')


    <!-- ================= LOGIN ================= -->

    <main class="login-wrapper">

        <div class="login-card">

            <div class="login-heading">

                <div class="login-icon">
                    🎟️
                </div>

                <h1>
                    Welcome Back
                </h1>

                <p>
                    Login to continue to Eventora
                </p>

            </div>


            @if (session('status'))

                <div class="session-message">
                    {{ session('status') }}
                </div>

            @endif


            @if ($errors->any())

                <div class="error-box">

                    @foreach ($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('login') }}"
            >

                @csrf

                <div class="form-group">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email Address
                    </label>

                    <div class="input-wrapper">

                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required
                            autofocus
                            autocomplete="username"
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="input-wrapper">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()"
                            id="passwordToggle"
                        >
                            👁️
                        </button>

                    </div>

                </div>


                <div class="form-options">

                    <label class="remember">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        Remember me

                    </label>


                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot"
                        >
                            Forgot Password?
                        </a>

                    @endif

                </div>


                <button
                    type="submit"
                    class="login-btn"
                >
                    Login
                </button>

            </form>


            <div class="divider">
                OR
            </div>


            <a
                href="{{ route('google.redirect') }}"
                class="google-btn"
            >

                <span class="google-icon">
                    G
                </span>

                Continue with Google

            </a>


            <div class="register-text">

                Don't have an account?

                <a href="{{ route('register') }}">
                    Create Account
                </a>

            </div>

        </div>

    </main>


    <!-- ================= FOOTER ================= -->

    <footer class="auth-footer">

        © {{ date('Y') }} Eventora.
        All Rights Reserved.

    </footer>


    <script>

        /* ================= MENU ================= */

        function toggleMenu() {

            const navLinks =
                document.getElementById("navLinks");

            navLinks.classList.toggle("show");

        }


        /* ================= THEME ================= */

        const html =
            document.documentElement;

        const themeButton =
            document.getElementById("themeButton");


        function setTheme(theme) {

            html.setAttribute(
                "data-theme",
                theme
            );

            localStorage.setItem(
                "eventora-theme",
                theme
            );

            if (theme === "light") {

                themeButton.innerHTML = "🌙";

            } else {

                themeButton.innerHTML = "☀️";

            }

        }


        function toggleTheme() {

            const currentTheme =
                html.getAttribute("data-theme")
                || "dark";

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


        /* ================= PASSWORD ================= */

        function togglePassword() {

            const password =
                document.getElementById("password");

            const button =
                document.getElementById(
                    "passwordToggle"
                );

            if (password.type === "password") {

                password.type = "text";

                button.innerHTML = "🙈";

            } else {

                password.type = "password";

                button.innerHTML = "👁️";

            }

        }

    </script>

</body>

</html>