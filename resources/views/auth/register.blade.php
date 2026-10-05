<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Account - Eventora</title>


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
                    rgba(108, 99, 255, .14),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 80%,
                    rgba(139, 92, 246, .12),
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


        /* ================= NAVBAR ================= */


        .navbar {

            width: 100%;

            border-bottom:
                1px solid var(--border);

            background:
                rgba(7, 11, 20, .78);

            backdrop-filter: blur(14px);

        }


        html[data-theme="light"] .navbar {

            background:
                rgba(255, 255, 255, .85);

        }


        .nav-container {

            width: min(1180px, 92%);

            margin: auto;

            min-height: 76px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 25px;

        }


        .logo {

            font-size: 25px;

            font-weight: 800;

            letter-spacing: -.7px;

            color: var(--text);

        }


        .logo span {

            color: var(--primary);

        }


        .back-home {

            color: var(--muted);

            font-size: 14px;

            transition: .25s;

        }


        .back-home:hover {

            color: var(--text);

        }


        .theme-btn {

            width: 40px;
            height: 40px;

            border-radius: 10px;

            border:
                1px solid var(--border);

            background: var(--card);

            color: var(--text);

            cursor: pointer;

            font-size: 17px;

            transition: .25s;

        }


        .theme-btn:hover {

            transform: translateY(-2px);

            border-color: var(--primary);

        }


        .nav-right {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        /* ================= MAIN ================= */


        .register-wrapper {

            flex: 1;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 45px 20px 60px;

        }


        .register-card {

            width: 100%;

            max-width: 455px;

            background: var(--card);

            border:
                1px solid var(--border);

            border-radius: 22px;

            padding: 38px;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, .25);

        }


        html[data-theme="light"] .register-card {

            box-shadow:
                0 20px 50px
                rgba(15, 23, 42, .08);

        }


        .register-heading {

            text-align: center;

            margin-bottom: 28px;

        }


        .register-icon {

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
                rgba(108, 99, 255, .25);

        }


        .register-heading h1 {

            font-size: 30px;

            margin-bottom: 8px;

        }


        .register-heading p {

            color: var(--muted);

            font-size: 14px;

        }


        /* ================= FORM ================= */


        .form-group {

            margin-bottom: 17px;

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
                0 45px 0 15px;

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
                rgba(108, 99, 255, .12);

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


        /* ================= REGISTER BUTTON ================= */


        .register-btn {

            width: 100%;

            height: 49px;

            margin-top: 5px;

            border: none;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

            color: #ffffff;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition: .25s;

        }


        .register-btn:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 25px
                rgba(108, 99, 255, .25);

        }


        /* ================= DIVIDER ================= */


        .divider {

            display: flex;

            align-items: center;

            gap: 12px;

            margin: 24px 0;

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

            border:
                1px solid var(--border);

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

            transform:
                translateY(-1px);

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


        /* ================= LOGIN ================= */


        .login-text {

            text-align: center;

            margin-top: 24px;

            color: var(--muted);

            font-size: 13px;

        }


        .login-text a {

            color: #8b82ff;

            font-weight: 700;

        }


        .login-text a:hover {

            color: var(--primary);

        }


        /* ================= ERRORS ================= */


        .error-box {

            margin-bottom: 20px;

            padding: 12px 14px;

            border-radius: 10px;

            background:
                rgba(239, 68, 68, .10);

            border:
                1px solid
                rgba(239, 68, 68, .25);

            color: #f87171;

            font-size: 12px;

        }


        /* ================= FOOTER ================= */


        .auth-footer {

            border-top:
                1px solid var(--border);

            padding: 20px;

            text-align: center;

            color: var(--muted);

            font-size: 12px;

        }


        /* ================= MOBILE ================= */


        @media (max-width: 600px) {

            .nav-container {

                min-height: 68px;

            }


            .register-wrapper {

                padding:
                    30px 15px 45px;

            }


            .register-card {

                padding:
                    28px 21px;

                border-radius: 18px;

            }


            .register-heading h1 {

                font-size: 26px;

            }


            .back-home {

                display: none;

            }

        }

    </style>

</head>


<body>


    @include('layouts.navbar')


    <!-- ================= REGISTER ================= -->

    <main class="register-wrapper">


        <div class="register-card">


            <div class="register-heading">


                <div class="register-icon">
                    ✨
                </div>


                <h1>
                    Create Account
                </h1>


                <p>
                    Join Eventora and discover amazing events
                </p>


            </div>



            {{-- VALIDATION ERRORS --}}

            @if ($errors->any())

                <div class="error-box">

                    @foreach ($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif



            {{-- REGISTER FORM --}}

            <form
                method="POST"
                action="{{ route('register') }}"
            >

                @csrf


                <!-- NAME -->

                <div class="form-group">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Full Name
                    </label>


                    <div class="input-wrapper">

                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="form-input"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            required
                            autofocus
                            autocomplete="name"
                        >

                    </div>

                </div>



                <!-- EMAIL -->

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
                            autocomplete="username"
                        >

                    </div>

                </div>



                <!-- PASSWORD -->

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
                            placeholder="Create a password"
                            required
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
                        >
                            👁️
                        </button>

                    </div>

                </div>



                <!-- CONFIRM PASSWORD -->

                <div class="form-group">

                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Confirm Password
                    </label>


                    <div class="input-wrapper">

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Confirm your password"
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
                        >
                            👁️
                        </button>

                    </div>

                </div>



                <!-- CREATE ACCOUNT -->

                <button
                    type="submit"
                    class="register-btn"
                >
                    Create Account
                </button>


            </form>



            <!-- DIVIDER -->

            <div class="divider">
                OR
            </div>



            <!-- GOOGLE -->

          <a
    href="#"
    class="google-btn"
    onclick="return googleLoginComingSoon()"
>

                <span class="google-icon">
                    G
                </span>

                Continue with Google

            </a>



            <!-- LOGIN -->

            <div class="login-text">

                Already have an account?

                <a href="{{ route('login') }}">
                    Login
                </a>

            </div>


        </div>

    </main>



    <!-- ================= FOOTER ================= -->

    <footer class="auth-footer">

        © {{ date('Y') }} Eventora.
        All Rights Reserved.

    </footer>



    <!-- ================= JAVASCRIPT ================= -->

    <script>


        /* ================= THEME ================= */


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


        function toggleTheme() {

            const currentTheme =
                html.getAttribute(
                    "data-theme"
                )
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
            )
            || "dark";


        setTheme(savedTheme);



        /* ================= PASSWORD ================= */


        function togglePassword(
            inputId,
            buttonId
        ) {

            const password =
                document.getElementById(
                    inputId
                );

            const button =
                document.getElementById(
                    buttonId
                );


            if (
                password.type ===
                "password"
            ) {

                password.type = "text";

                button.innerHTML =
                    "🙈";

            } else {

                password.type =
                    "password";

                button.innerHTML =
                    "👁️";

            }

        }



        /* ================= GOOGLE ================= */


    </script>


</body>

</html>