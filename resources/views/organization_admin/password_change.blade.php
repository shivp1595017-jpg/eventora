@include('organization_admin.sidebar')

<div class="organization-password-page">

    <div class="password-container">

        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="password-header">

            <div>

                <div class="breadcrumb">
                    Organization Panel / Account Security / Change Password
                </div>

                <h1>
                    Change Password
                </h1>

                <p>
                    Update your account password using your current password.
                </p>

            </div>

        </div>


        <!-- =====================================================
             PASSWORD CARD
        ====================================================== -->

        <section class="password-card">

            <div class="password-card-header">

                <div class="password-icon">
                    🔐
                </div>

                <div>

                    <h2>
                        Change Password
                    </h2>

                    <p>
                        Keep your Eventora account secure with a strong password.
                    </p>

                </div>

            </div>


            <!-- =================================================
                 SUCCESS
            ================================================== -->

            @if (session('password_changed'))

                <div class="success-message">
                    ✓ {{ session('password_changed') }}
                </div>

            @endif


            <!-- =================================================
                 ERRORS
            ================================================== -->

            @if ($errors->any())

                <div class="error-message">

                    @foreach ($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <!-- =================================================
                 ACCOUNT EMAIL
            ================================================== -->

            <div class="account-email-box">

                <div class="email-icon">
                    ✉️
                </div>

                <div>

                    <span>
                        Current Login Email
                    </span>

                    <strong>
                        {{ auth()->user()->email }}
                    </strong>

                </div>

            </div>


            <!-- =================================================
                 FORM
            ================================================== -->

            <form
                method="POST"
                action="{{ route('organization.admin.password.change.store') }}"
            >

                @csrf


                <!-- CURRENT PASSWORD -->

                <div class="form-group">

                    <label
                        for="current_password"
                    >
                        Current Password
                    </label>


                    <div class="input-wrapper">

                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="form-input"
                            placeholder="Enter your current password"
                            autocomplete="current-password"
                            required
                            autofocus
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'current_password',
                                'currentPasswordToggle'
                            )"
                            id="currentPasswordToggle"
                        >
                            👁️
                        </button>

                    </div>


                    @error('current_password')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- NEW PASSWORD -->

                <div class="form-group">

                    <label
                        for="password"
                    >
                        New Password
                    </label>


                    <div class="input-wrapper">

                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-input"
                            placeholder="Enter your new password"
                            autocomplete="new-password"
                            required
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


                    <div class="password-help">
                        Use at least 8 characters for a stronger password.
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
                    >
                        Confirm New Password
                    </label>


                    <div class="input-wrapper">

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="form-input"
                            placeholder="Confirm your new password"
                            autocomplete="new-password"
                            required
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


                    @error('password_confirmation')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =================================================
                     ACTIONS
                ================================================== -->

                <div class="form-actions">

                    <a
                        href="{{ url()->previous() }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="change-btn"
                    >
                        🔐 Change Password
                    </button>

                </div>

            </form>


            <!-- =================================================
                 FORGOT PASSWORD
            ================================================== -->

            <div class="forgot-box">

                <div class="forgot-icon">
                    📧
                </div>

                <div class="forgot-content">

                    <strong>
                        Forgot your password?
                    </strong>

                    <span>
                        Get an OTP on your registered login email
                        and reset your password.
                    </span>

                </div>


                <a
                    href="{{ route('organization.admin.password.forgot') }}"
                    class="forgot-btn"
                >
                    Forgot Password
                </a>

            </div>

        </section>

    </div>

</div>


<style>

/* ============================================================
   BASE
============================================================ */

.organization-password-page {

    min-height: 100vh;

    margin-left: 260px;

    padding: 35px;

    background: #f5f7fb;

    color: #172033;

}


/* ============================================================
   CONTAINER
============================================================ */

.password-container {

    width: min(
        760px,
        100%
    );

    margin: 0 auto;

}


/* ============================================================
   HEADER
============================================================ */

.password-header {

    margin-bottom: 25px;

}


.breadcrumb {

    margin-bottom: 8px;

    color: #7b8494;

    font-size: 12px;

}


.password-header h1 {

    margin: 0 0 7px;

    font-size: 30px;

    font-weight: 800;

    color: #172033;

}


.password-header p {

    margin: 0;

    color: #7a8495;

    font-size: 14px;

}


/* ============================================================
   CARD
============================================================ */

.password-card {

    padding: 30px;

    background: #ffffff;

    border: 1px solid #e1e6ee;

    border-radius: 18px;

    box-shadow:
        0 8px 28px rgba(
            16,
            24,
            40,
            .05
        );

}


/* ============================================================
   CARD HEADER
============================================================ */

.password-card-header {

    display: flex;

    align-items: center;

    gap: 14px;

    padding-bottom: 23px;

    margin-bottom: 24px;

    border-bottom: 1px solid #edf0f5;

}


.password-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    background: #f0edff;

    font-size: 23px;

}


.password-card-header h2 {

    margin: 0 0 5px;

    font-size: 20px;

    font-weight: 800;

    color: #172033;

}


.password-card-header p {

    margin: 0;

    color: #7b8494;

    font-size: 12px;

    line-height: 1.5;

}


/* ============================================================
   SUCCESS
============================================================ */

.success-message {

    margin-bottom: 20px;

    padding: 13px 15px;

    border-radius: 10px;

    background: #ecfdf3;

    border: 1px solid #b7ebca;

    color: #027a48;

    font-size: 13px;

    line-height: 1.5;

}


/* ============================================================
   ERROR
============================================================ */

.error-message {

    margin-bottom: 20px;

    padding: 13px 15px;

    border-radius: 10px;

    background: #fff1f1;

    border: 1px solid #ffd0d0;

    color: #b42318;

    font-size: 13px;

    line-height: 1.55;

}


/* ============================================================
   EMAIL
============================================================ */

.account-email-box {

    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 24px;

    padding: 14px;

    border-radius: 12px;

    background: #f8f9fc;

    border: 1px solid #e7ebf1;

}


.email-icon {

    width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 10px;

    background: #ffffff;

    font-size: 17px;

}


.account-email-box span {

    display: block;

    margin-bottom: 4px;

    color: #7b8494;

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .45px;

}


.account-email-box strong {

    display: block;

    color: #172033;

    font-size: 13px;

    word-break: break-word;

}


/* ============================================================
   FORM
============================================================ */

.form-group {

    margin-bottom: 20px;

}


.form-group label {

    display: block;

    margin-bottom: 8px;

    color: #344054;

    font-size: 13px;

    font-weight: 700;

}


.input-wrapper {

    position: relative;

}


.form-input {

    width: 100%;

    height: 49px;

    padding:
        0 48px 0 14px;

    border: 1px solid #dce2ec;

    border-radius: 10px;

    background: #ffffff;

    color: #172033;

    outline: none;

    font-size: 14px;

    transition: .2s;

}


.form-input::placeholder {

    color: #98a2b3;

}


.form-input:focus {

    border-color: #6d5dfc;

    box-shadow:
        0 0 0 3px
        rgba(
            109,
            93,
            252,
            .10
        );

}


.password-toggle {

    position: absolute;

    top: 50%;

    right: 13px;

    transform:
        translateY(-50%);

    border: none;

    background: transparent;

    color: #7b8494;

    cursor: pointer;

    font-size: 16px;

}


.password-help {

    margin-top: 7px;

    color: #8a94a6;

    font-size: 11px;

}


.field-error {

    margin-top: 7px;

    color: #d92d20;

    font-size: 11px;

}


/* ============================================================
   ACTIONS
============================================================ */

.form-actions {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;

    margin-top: 25px;

}


.cancel-btn {

    min-height: 45px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 0 17px;

    border: 1px solid #d8dee8;

    border-radius: 9px;

    background: #ffffff;

    color: #475467;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    transition: .2s;

}


.cancel-btn:hover {

    border-color: #6d5dfc;

    color: #5848eb;

}


.change-btn {

    min-height: 45px;

    padding:
        0 18px;

    border: none;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #6c63ff,
            #8b5cf6
        );

    color: #ffffff;

    font-size: 13px;

    font-weight: 700;

    cursor: pointer;

    transition: .2s;

}


.change-btn:hover {

    transform:
        translateY(-1px);

    box-shadow:
        0 10px 22px
        rgba(
            108,
            99,
            255,
            .22
        );

}


/* ============================================================
   FORGOT BOX
============================================================ */

.forgot-box {

    display: flex;

    align-items: center;

    gap: 12px;

    margin-top: 25px;

    padding: 16px;

    border-radius: 13px;

    background: #fafbff;

    border: 1px solid #e1e5f4;

}


.forgot-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 10px;

    background: #f0edff;

    font-size: 18px;

}


.forgot-content {

    flex: 1;

    min-width: 0;

}


.forgot-content strong {

    display: block;

    margin-bottom: 4px;

    color: #172033;

    font-size: 13px;

}


.forgot-content span {

    display: block;

    color: #7b8494;

    font-size: 11px;

    line-height: 1.5;

}


.forgot-btn {

    flex-shrink: 0;

    padding:
        10px 14px;

    border-radius: 8px;

    background: #eef1ff;

    border: 1px solid #dbe2ff;

    color: #3158d8;

    text-decoration: none;

    font-size: 11px;

    font-weight: 700;

    transition: .2s;

}


.forgot-btn:hover {

    background: #6d5dfc;

    border-color: #6d5dfc;

    color: #ffffff;

}


/* ============================================================
   DARK SIDEBAR PAGE COMPATIBILITY
============================================================ */

@media (max-width: 1050px) {

    .organization-password-page {

        margin-left: 0;

        padding: 25px;

    }

}


/* ============================================================
   MOBILE
============================================================ */

@media (max-width: 650px) {

    .organization-password-page {

        padding: 18px;

    }


    .password-card {

        padding: 21px;

        border-radius: 15px;

    }


    .password-header h1 {

        font-size: 26px;

    }


    .password-card-header {

        align-items: flex-start;

    }


    .form-actions {

        flex-direction: column-reverse;

    }


    .cancel-btn,
    .change-btn {

        width: 100%;

    }


    .forgot-box {

        align-items: flex-start;

        flex-wrap: wrap;

    }


    .forgot-btn {

        width: 100%;

        text-align: center;

    }

}

</style>


<script>

/*
|--------------------------------------------------------------------------
| Toggle Password Visibility
|--------------------------------------------------------------------------
*/

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


    if (!field || !button) {

        return;

    }


    if (
        field.type === 'password'
    ) {

        field.type = 'text';

        button.innerHTML = '🙈';

    } else {

        field.type = 'password';

        button.innerHTML = '👁️';

    }

}

</script>