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
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f4f6fb;

            color: #172033;
        }

        /* =====================================================
           MAIN
        ====================================================== */

        .admin-main {
            margin-left: 260px;

            min-height: 100vh;

            padding: 30px;
        }

        /* =====================================================
           MOBILE HEADER
        ====================================================== */

        .mobile-header {
            display: none;

            height: 58px;

            background: white;

            align-items: center;

            gap: 15px;

            padding: 0 16px;

            margin-bottom: 22px;

            border-radius: 14px;

            box-shadow:
                0 5px 20px rgba(
                    0,
                    0,
                    0,
                    .05
                );
        }

        .mobile-header strong {
            font-size: 20px;
        }

        .mobile-menu-button {
            width: 40px;
            height: 40px;

            border: none;

            border-radius: 10px;

            background: #6366f1;

            color: white;

            font-size: 21px;

            cursor: pointer;
        }

        /* =====================================================
           TOPBAR
        ====================================================== */

        .topbar {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;
        }

        .topbar-left h1 {
            margin: 0 0 7px;

            font-size: 29px;
        }

        .topbar-left p {
            margin: 0;

            color: #667085;

            font-size: 14px;
        }

        .back-dashboard {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            min-height: 42px;

            padding: 0 16px;

            background: white;

            border: 1px solid #dce2ec;

            border-radius: 10px;

            color: #344054;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            transition: .2s;
        }

        .back-dashboard:hover {
            border-color: #6366f1;

            color: #4f46e5;

            background: #f8f8ff;

            transform:
                translateY(-1px);
        }

        /* =====================================================
           MAIN CARD
        ====================================================== */

        .password-card {
            max-width: 760px;

            margin: 15px auto 30px;

            background: white;

            border-radius: 22px;

            padding: 32px;

            box-shadow:
                0 10px 35px rgba(
                    0,
                    0,
                    0,
                    .06
                );
        }

        /* =====================================================
           CARD HEADER
        ====================================================== */

        .card-heading {
            display: flex;

            align-items: center;

            gap: 15px;

            margin-bottom: 25px;
        }

        .card-icon {
            width: 55px;

            height: 55px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    #ede9fe,
                    #e0e7ff
                );

            font-size: 25px;
        }

        .card-heading h2 {
            margin: 0 0 5px;

            font-size: 22px;
        }

        .card-heading p {
            margin: 0;

            color: #7b8494;

            font-size: 13px;

            line-height: 1.5;
        }

        /* =====================================================
           EMAIL BOX
        ====================================================== */

        .email-box {
            padding: 17px 18px;

            margin-bottom: 24px;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #f7f5ff,
                    #f5f7ff
                );

            border: 1px solid #e4e1ff;
        }

        .email-label {
            display: block;

            margin-bottom: 7px;

            color: #7b8494;

            font-size: 11px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .45px;
        }

        .email-value {
            display: block;

            color: #4f46e5;

            font-size: 14px;

            font-weight: 700;

            word-break: break-word;
        }

        .email-note {
            margin-top: 6px;

            color: #98a2b3;

            font-size: 11px;

            line-height: 1.5;
        }

        /* =====================================================
           ALERTS
        ====================================================== */

        .error-message {
            margin-bottom: 20px;

            padding: 14px 17px;

            border-radius: 12px;

            background: #fff1f1;

            border: 1px solid #ffd0d0;

            color: #b42318;

            font-size: 13px;

            line-height: 1.55;
        }

        .success-message {
            margin-bottom: 20px;

            padding: 14px 17px;

            border-radius: 12px;

            background: #ecfdf3;

            border: 1px solid #abefc6;

            color: #027a48;

            font-size: 14px;

            font-weight: 600;
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

            color: #344054;

            font-size: 13px;

            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .form-input {
            width: 100%;

            height: 50px;

            padding:
                0 50px 0 15px;

            border:
                1px solid #d9dee8;

            border-radius: 11px;

            outline: none;

            background: #ffffff;

            color: #172033;

            font-size: 14px;

            transition: .2s;
        }

        .form-input:focus {
            border-color: #6366f1;

            box-shadow:
                0 0 0 3px
                rgba(
                    99,
                    102,
                    241,
                    .10
                );
        }

        .toggle-password {
            position: absolute;

            top: 50%;

            right: 12px;

            transform:
                translateY(-50%);

            width: 34px;

            height: 34px;

            border: none;

            border-radius: 8px;

            background: #f5f6fa;

            color: #667085;

            cursor: pointer;

            font-size: 16px;
        }

        .toggle-password:hover {
            background: #eceeff;

            color: #4f46e5;
        }

        .field-error {
            margin-top: 6px;

            color: #b42318;

            font-size: 11px;
        }

        /* =====================================================
           PASSWORD RULE
        ====================================================== */

        .password-hint {
            margin-top: 7px;

            color: #98a2b3;

            font-size: 11px;

            line-height: 1.5;
        }

        /* =====================================================
           BUTTONS
        ====================================================== */

        .button-row {
            display: flex;

            gap: 10px;

            margin-top: 25px;
        }

        .submit-button,
        .cancel-button {
            min-height: 48px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;
        }

        .submit-button {
            flex: 1;

            border: none;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #4f46e5
                );

            color: white;

            box-shadow:
                0 8px 20px rgba(
                    79,
                    70,
                    229,
                    .18
                );
        }

        .submit-button:hover {
            transform:
                translateY(-1px);

            box-shadow:
                0 11px 24px rgba(
                    79,
                    70,
                    229,
                    .25
                );
        }

        .cancel-button {
            padding: 0 20px;

            background: white;

            border: 1px solid #dce2ec;

            color: #475467;
        }

        .cancel-button:hover {
            border-color: #6366f1;

            color: #4f46e5;

            background: #fafaff;
        }

        /* =====================================================
           SECURITY NOTE
        ====================================================== */

        .security-note {
            margin-top: 24px;

            padding: 16px 17px;

            border-radius: 13px;

            background: #f8f9fc;

            border: 1px solid #edf0f5;
        }

        .security-note strong {
            display: block;

            margin-bottom: 5px;

            color: #344054;

            font-size: 12px;
        }

        .security-note p {
            margin: 0;

            color: #7b8494;

            font-size: 11px;

            line-height: 1.6;
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 768px) {

            .admin-main {
                margin-left: 0;

                padding: 15px;
            }

            .mobile-header {
                display: flex;
            }

            .topbar {
                align-items: flex-start;

                flex-direction: column;

                margin-bottom: 20px;
            }

            .back-dashboard {
                width: 100%;
            }

            .password-card {
                margin-top: 5px;

                padding: 22px;

                border-radius: 18px;
            }
        }

        @media (max-width: 480px) {

            .admin-main {
                padding: 12px;
            }

            .password-card {
                padding: 18px;
            }

            .card-heading {
                align-items: flex-start;
            }

            .card-heading h2 {
                font-size: 20px;
            }

            .button-row {
                flex-direction: column;
            }

            .cancel-button {
                width: 100%;
            }
        }

    </style>

</head>


<body>


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    @include('organization_admin.sidebar')


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <main class="admin-main">


        {{-- MOBILE HEADER --}}

        <div class="mobile-header">

            <button
                type="button"
                class="mobile-menu-button"
                onclick="openAdminSidebar()"
            >
                ☰
            </button>

            <strong>
                Eventora
            </strong>

        </div>


        {{-- TOPBAR --}}

        <div class="topbar">

            <div class="topbar-left">

                <h1>
                    Reset Password
                </h1>

                <p>
                    Create a new password for your Organization Admin account.
                </p>

            </div>


            <a
                href="{{ route('organization.admin.dashboard') }}"
                class="back-dashboard"
            >
                🏠 Dashboard
            </a>

        </div>


        {{-- ERRORS --}}

        @if($errors->any())

            <div class="error-message">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- SUCCESS --}}

        @if(session('success'))

            <div class="success-message">

                ✓ {{ session('success') }}

            </div>

        @endif


        {{-- RESET CARD --}}

        <section class="password-card">


            {{-- HEADER --}}

            <div class="card-heading">

                <div class="card-icon">
                    🔐
                </div>

                <div>

                    <h2>
                        Set New Password
                    </h2>

                    <p>
                        OTP verification was successful. Enter your new password below.
                    </p>

                </div>

            </div>


            {{-- REGISTERED EMAIL --}}

            <div class="email-box">

                <span class="email-label">
                    Verified Login Email
                </span>

                <span class="email-value">
                    {{ $email }}
                </span>

                <div class="email-note">
                    This password reset is being completed for your registered Organization Admin account.
                </div>

            </div>


            {{-- FORM --}}

            <form
                method="POST"
                action="{{ route(
                    'organization.admin.password.forgot.reset.store'
                ) }}"
            >

                @csrf


                {{-- NEW PASSWORD --}}

                <div class="form-group">

                    <label
                        for="password"
                        class="form-label"
                    >
                        New Password
                    </label>


                    <div class="input-wrap">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="Enter new password"
                            minlength="8"
                            required
                            autocomplete="new-password"
                        >


                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword(
                                'password',
                                this
                            )"
                            aria-label="Show password"
                        >
                            👁
                        </button>

                    </div>


                    <div class="password-hint">
                        Password must contain at least 8 characters.
                    </div>


                    @error('password')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- CONFIRM PASSWORD --}}

                <div class="form-group">

                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Confirm New Password
                    </label>


                    <div class="input-wrap">

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
                            class="toggle-password"
                            onclick="togglePassword(
                                'password_confirmation',
                                this
                            )"
                            aria-label="Show password"
                        >
                            👁
                        </button>

                    </div>


                    @error('password_confirmation')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- BUTTONS --}}

                <div class="button-row">

                    <a
                        href="{{ route(
                            'organization.admin.password.change'
                        ) }}"
                        class="cancel-button"
                    >
                        ← Back
                    </a>


                    <button
                        type="submit"
                        class="submit-button"
                    >
                        🔐 Reset Password
                    </button>

                </div>

            </form>


            {{-- SECURITY NOTE --}}

            <div class="security-note">

                <strong>
                    🔒 Security
                </strong>

                <p>
                    Your password will be securely encrypted before being saved.
                    After resetting your password, you can continue using your
                    Organization Admin account with the new password.
                </p>

            </div>


        </section>


    </main>


    <script>

        function togglePassword(
            inputId,
            button
        ) {

            const input =
                document.getElementById(
                    inputId
                );

            if (
                input.type === 'password'
            ) {

                input.type = 'text';

                button.textContent = '🙈';

                button.setAttribute(
                    'aria-label',
                    'Hide password'
                );

            } else {

                input.type = 'password';

                button.textContent = '👁';

                button.setAttribute(
                    'aria-label',
                    'Show password'
                );

            }
        }

    </script>


</body>

</html>
