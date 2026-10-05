@include('organization_admin.sidebar')

<div class="organization-password-page">

    <div class="password-container">

        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="password-header">

            <div>

                <div class="breadcrumb">
                    Organization Panel / Account Security / Forgot Password
                </div>

                <h1>
                    Verify OTP
                </h1>

                <p>
                    Enter the verification code sent to your registered login email.
                </p>

            </div>

        </div>


        <!-- =====================================================
             OTP CARD
        ====================================================== -->

        <section class="password-card">

            <div class="password-card-header">

                <div class="password-icon">
                    🔐
                </div>

                <div>

                    <h2>
                        Verify Your Identity
                    </h2>

                    <p>
                        We sent a 6-digit OTP to your account email.
                    </p>

                </div>

            </div>


            <!-- =================================================
                 SUCCESS MESSAGE
            ================================================== -->

            @if (session('status'))

                <div class="success-message">
                    ✓ {{ session('status') }}
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
                 REGISTERED EMAIL
            ================================================== -->

            <div class="account-email-box">

                <div class="email-icon">
                    ✉️
                </div>

                <div>

                    <span>
                        OTP Sent To
                    </span>

                    <strong>
                        {{ $email }}
                    </strong>

                </div>

            </div>


            <!-- =================================================
                 OTP FORM
            ================================================== -->

            <form
                method="POST"
                action="{{ route('organization.admin.password.forgot.verify.submit') }}"
            >

                @csrf


                <div class="form-group">

                    <label
                        for="otp"
                    >
                        6-Digit OTP
                    </label>


                    <input
                        id="otp"
                        type="text"
                        name="otp"
                        class="otp-input"
                        value="{{ old('otp') }}"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="000000"
                        required
                        autofocus
                    >


                    <div class="password-help">
                        Enter the 6-digit OTP sent to your registered email.
                    </div>


                    @error('otp')

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
                        href="{{ route('organization.admin.password.change') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="change-btn"
                    >
                        ✓ Verify OTP
                    </button>

                </div>

            </form>


            <!-- =================================================
                 SECURITY NOTE
            ================================================== -->

            <div class="security-note">

                <div class="security-note-icon">
                    🛡️
                </div>

                <div>

                    <strong>
                        Secure Password Reset
                    </strong>

                    <span>
                        Your OTP is valid for 10 minutes and can be used only once.
                        Never share your OTP with anyone.
                    </span>

                </div>

            </div>


            <!-- =================================================
                 BACK TO PROFILE
            ================================================== -->

            <div class="back-link">

                <a
                    href="{{ url()->previous() }}"
                >
                    ← Back
                </a>

            </div>

        </section>

    </div>

</div>


<style>

/* ============================================================
   PAGE
============================================================ */

.organization-password-page {

    min-height: 100vh;

    margin-left: 260px;

    padding: 35px;

    background: #f5f7fb;

    color: #172033;

}


.password-container {

    width: min(760px, 100%);

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

    color: #172033;

    font-size: 30px;

    font-weight: 800;

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

    color: #172033;

    font-size: 20px;

    font-weight: 800;

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
   ACCOUNT EMAIL
============================================================ */

.account-email-box {

    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 25px;

    padding: 15px;

    border-radius: 12px;

    background: #f8f9fc;

    border: 1px solid #e7ebf1;

}


.email-icon {

    width: 42px;

    height: 42px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

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


/* ============================================================
   OTP INPUT
============================================================ */

.otp-input {

    width: 100%;

    height: 60px;

    padding: 0 18px;

    border: 1px solid #dce2ec;

    border-radius: 12px;

    background: #ffffff;

    color: #172033;

    outline: none;

    text-align: center;

    font-size: 24px;

    font-weight: 800;

    letter-spacing: 10px;

    transition: .2s;

}


.otp-input::placeholder {

    color: #b2bac7;

    letter-spacing: 8px;

}


.otp-input:focus {

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


.password-help {

    margin-top: 8px;

    color: #8a94a6;

    font-size: 11px;

    line-height: 1.5;

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

    padding: 0 19px;

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

    transform: translateY(-1px);

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
   SECURITY NOTE
============================================================ */

.security-note {

    display: flex;

    align-items: flex-start;

    gap: 11px;

    margin-top: 25px;

    padding: 15px;

    border-radius: 12px;

    background: #f8f9fc;

    border: 1px solid #e7ebf1;

}


.security-note-icon {

    width: 38px;

    height: 38px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background: #ffffff;

    font-size: 16px;

}


.security-note strong {

    display: block;

    margin-bottom: 4px;

    color: #344054;

    font-size: 12px;

}


.security-note span {

    display: block;

    color: #7b8494;

    font-size: 11px;

    line-height: 1.55;

}


/* ============================================================
   BACK
============================================================ */

.back-link {

    margin-top: 22px;

    text-align: center;

}


.back-link a {

    color: #667085;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

}


.back-link a:hover {

    color: #5848eb;

}


/* ============================================================
   MOBILE
============================================================ */

@media (max-width: 1050px) {

    .organization-password-page {

        margin-left: 0;

        padding: 25px;

    }

}


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


    .otp-input {

        height: 55px;

        font-size: 21px;

        letter-spacing: 7px;

    }


    .form-actions {

        flex-direction: column-reverse;

    }


    .cancel-btn,
    .change-btn {

        width: 100%;

    }

}

</style>


<script>

/*
|--------------------------------------------------------------------------
| OTP Input - Numbers Only
|--------------------------------------------------------------------------
*/

const otpInput =
    document.getElementById('otp');


if (otpInput) {

    otpInput.addEventListener(
        'input',
        function () {

            this.value =
                this.value
                    .replace(/\D/g, '')
                    .slice(0, 6);

        }
    );

}

</script>