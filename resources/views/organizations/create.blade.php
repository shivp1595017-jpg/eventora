@include('layouts.navbar')

<div class="organization-page">

    <div class="organization-container">

        <!-- HEADER -->

        <div class="organization-header">

            <div>

                <span class="header-badge">
                    🏢 Organization Registration
                </span>

                <h1>Register Your Organization</h1>

                <p>
                    Create your organization profile on Eventora and
                    start managing your events.
                </p>

            </div>

            <div class="header-icon">
                🏫
            </div>

        </div>


        <!-- SUCCESS MESSAGE -->

        @if (session('success'))

            <div class="success-alert">
                <span>✓</span>

                <div>
                    <strong>Submitted Successfully</strong>

                    <p>
                        {{ session('success') }}
                    </p>
                </div>
            </div>

        @endif


        <!-- FORM CARD -->

        <div class="organization-card">

            <form
                method="POST"
                action="{{ route('organizations.store') }}"
            >

                @csrf


                <!-- BASIC INFORMATION -->

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            🏢
                        </div>

                        <div>

                            <h2>Basic Information</h2>

                            <p>
                                Tell us about your organization.
                            </p>

                        </div>

                    </div>


                    <div class="form-grid">

                        <!-- ORGANIZATION NAME -->

                        <div class="form-group full-width">

                            <label for="name">
                                Organization Name
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. RNGPIT"
                                required
                            >

                            @error('name')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- TYPE -->

                        <div class="form-group">

                            <label for="type">
                                Organization Type
                                <span>*</span>
                            </label>

                            <select
                                id="type"
                                name="type"
                                required
                            >

                                <option value="">
                                    Select organization type
                                </option>

                                <option
                                    value="School"
                                    {{ old('type') == 'School' ? 'selected' : '' }}
                                >
                                    School
                                </option>

                                <option
                                    value="College"
                                    {{ old('type') == 'College' ? 'selected' : '' }}
                                >
                                    College
                                </option>

                                <option
                                    value="Company"
                                    {{ old('type') == 'Company' ? 'selected' : '' }}
                                >
                                    Company
                                </option>

                                <option
                                    value="NGO"
                                    {{ old('type') == 'NGO' ? 'selected' : '' }}
                                >
                                    NGO
                                </option>

                                <option
                                    value="Other"
                                    {{ old('type') == 'Other' ? 'selected' : '' }}
                                >
                                    Other
                                </option>

                            </select>

                            @error('type')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- WEBSITE -->

                        <div class="form-group">

                            <label for="website">
                                Website
                            </label>

                            <input
                                type="url"
                                id="website"
                                name="website"
                                value="{{ old('website') }}"
                                placeholder="https://example.com"
                            >

                            @error('website')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="form-group full-width">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Write a short description about your organization..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>



                <!-- CONTACT INFORMATION -->

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-icon">
                            📞
                        </div>

                        <div>

                            <h2>Contact Information</h2>

                            <p>
                                Add contact details for your organization.
                            </p>

                        </div>

                    </div>


                    <div class="form-grid">

                        <!-- EMAIL -->

                        <div class="form-group">

                            <label for="email">
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="organization@example.com"
                            >

                            @error('email')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- PHONE -->

                        <div class="form-group">

                            <label for="phone">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+91 98765 43210"
                            >

                            @error('phone')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- ADDRESS -->

                        <div class="form-group full-width">

                            <label for="address">
                                Address
                            </label>

                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                placeholder="Enter complete organization address..."
                            >{{ old('address') }}</textarea>

                            @error('address')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- CITY -->

                        <div class="form-group">

                            <label for="city">
                                City
                            </label>

                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="e.g. Surat"
                            >

                            @error('city')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- STATE -->

                        <div class="form-group">

                            <label for="state">
                                State
                            </label>

                            <input
                                type="text"
                                id="state"
                                name="state"
                                value="{{ old('state') }}"
                                placeholder="e.g. Gujarat"
                            >

                            @error('state')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>



                <!-- APPROVAL INFO -->

                <div class="approval-box">

                    <div class="approval-icon">
                        ℹ️
                    </div>

                    <div>

                        <h3>Admin Approval Required</h3>

                        <p>
                            Your organization will be submitted for review.
                            It will become publicly visible on Eventora only
                            after an administrator approves it.
                        </p>

                    </div>

                </div>



                <!-- ACTIONS -->

                <div class="form-actions">

                    <a
                        href="{{ route('dashboard') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="submit-btn"
                    >
                        Register Organization
                        <span>→</span>
                    </button>

                </div>

            </form>

        </div>


        <!-- BACK -->

        <div class="back-link">

            <a href="{{ route('organizations.search') }}">
                ← Browse Organizations
            </a>

        </div>

    </div>

</div>


@include('layouts.footer')


<style>

/* =========================================
   ORGANIZATION PAGE
========================================= */

.organization-page {
    min-height: 100vh;

    padding: 55px 20px 30px;

    background: #0b0f19;

    color: #ffffff;
}


.organization-container {
    width: min(1000px, 100%);

    margin: auto;
}


/* =========================================
   HEADER
========================================= */

.organization-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 30px;

    margin-bottom: 35px;
}


.header-badge {
    display: inline-block;

    margin-bottom: 13px;

    padding: 7px 12px;

    border: 1px solid #3b356f;

    border-radius: 30px;

    background: rgba(109, 93, 252, 0.12);

    color: #a99fff;

    font-size: 12px;
    font-weight: 700;

    letter-spacing: 0.3px;
}


.organization-header h1 {
    margin: 0 0 9px;

    color: #ffffff;

    font-size: 34px;

    font-weight: 800;

    letter-spacing: -0.5px;
}


.organization-header p {
    margin: 0;

    max-width: 650px;

    color: #8f9aae;

    font-size: 15px;

    line-height: 1.6;
}


.header-icon {
    width: 75px;
    height: 75px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border: 1px solid #393452;

    border-radius: 20px;

    background: linear-gradient(
        135deg,
        rgba(109, 93, 252, 0.16),
        rgba(139, 124, 255, 0.06)
    );

    font-size: 34px;

    box-shadow:
        0 15px 35px rgba(0, 0, 0, 0.20);
}


/* =========================================
   SUCCESS
========================================= */

.success-alert {
    display: flex;

    align-items: flex-start;

    gap: 13px;

    margin-bottom: 25px;

    padding: 16px 18px;

    border: 1px solid #285d3d;

    border-radius: 12px;

    background: #13291d;

    color: #71dc93;
}


.success-alert > span {
    font-size: 20px;
}


.success-alert strong {
    display: block;

    margin-bottom: 4px;

    color: #8be6a6;

    font-size: 14px;
}


.success-alert p {
    margin: 0;

    color: #72c98b;

    font-size: 13px;

    line-height: 1.5;
}


/* =========================================
   MAIN CARD
========================================= */

.organization-card {
    padding: 32px;

    background: #151b2b;

    border: 1px solid #29344c;

    border-radius: 20px;

    box-shadow:
        0 20px 55px rgba(0, 0, 0, 0.20);
}


/* =========================================
   SECTION
========================================= */

.form-section {
    padding-bottom: 30px;

    margin-bottom: 30px;

    border-bottom: 1px solid #29344c;
}


.section-heading {
    display: flex;

    align-items: center;

    gap: 14px;

    margin-bottom: 25px;
}


.section-icon {
    width: 45px;
    height: 45px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 11px;

    background: rgba(109, 93, 252, 0.12);

    font-size: 21px;
}


.section-heading h2 {
    margin: 0 0 4px;

    color: #ffffff;

    font-size: 19px;
}


.section-heading p {
    margin: 0;

    color: #7f8a9e;

    font-size: 13px;
}


/* =========================================
   FORM GRID
========================================= */

.form-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 20px;
}


.form-group {
    min-width: 0;
}


.full-width {
    grid-column: 1 / -1;
}


.form-group label {
    display: block;

    margin-bottom: 8px;

    color: #d8deea;

    font-size: 14px;

    font-weight: 600;
}


.form-group label span {
    color: #ff707b;
}


.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;

    box-sizing: border-box;

    padding: 13px 14px;

    border: 1px solid #303a52;

    border-radius: 9px;

    outline: none;

    background: #0f1422;

    color: #ffffff;

    font-family: inherit;

    font-size: 14px;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}


.form-group input,
.form-group select {
    height: 48px;
}


.form-group textarea {
    resize: vertical;

    min-height: 100px;

    line-height: 1.5;
}


.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #657086;
}


.form-group select {
    cursor: pointer;
}


.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #6d5dfc;

    box-shadow:
        0 0 0 3px rgba(109, 93, 252, 0.12);
}


.error-text {
    margin-top: 7px;

    color: #ff7d87;

    font-size: 12px;
}


/* =========================================
   APPROVAL
========================================= */

.approval-box {
    display: flex;

    align-items: flex-start;

    gap: 13px;

    margin-bottom: 28px;

    padding: 17px;

    border: 1px solid #403820;

    border-radius: 12px;

    background: #211d12;
}


.approval-icon {
    font-size: 20px;
}


.approval-box h3 {
    margin: 0 0 5px;

    color: #e9c76f;

    font-size: 14px;
}


.approval-box p {
    margin: 0;

    color: #b8a66f;

    font-size: 13px;

    line-height: 1.6;
}


/* =========================================
   ACTIONS
========================================= */

.form-actions {
    display: flex;

    align-items: center;
    justify-content: flex-end;

    gap: 12px;
}


.cancel-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-height: 46px;

    padding: 0 19px;

    border: 1px solid #303a52;

    border-radius: 9px;

    background: #20283a;

    color: #cbd3e1;

    text-decoration: none;

    font-size: 14px;

    font-weight: 600;

    transition: 0.2s;
}


.cancel-btn:hover {
    background: #29344a;

    color: #ffffff;
}


.submit-btn {
    min-height: 46px;

    padding: 0 20px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 10px;

    border: none;

    border-radius: 9px;

    background: #6d5dfc;

    color: #ffffff;

    font-family: inherit;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.2s;
}


.submit-btn:hover {
    background: #5848eb;

    transform: translateY(-1px);

    box-shadow:
        0 8px 20px rgba(109, 93, 252, 0.22);
}


.submit-btn span {
    font-size: 18px;
}


/* =========================================
   BACK
========================================= */

.back-link {
    margin-top: 22px;

    text-align: center;
}


.back-link a {
    color: #8f9aae;

    text-decoration: none;

    font-size: 14px;
}


.back-link a:hover {
    color: #8b7cff;
}


/* =========================================
   LIGHT MODE
========================================= */

html[data-theme="light"] .organization-page {
    background: #f5f7fb;

    color: #172033;
}


html[data-theme="light"] .organization-header h1 {
    color: #172033;
}


html[data-theme="light"] .organization-header p {
    color: #687386;
}


html[data-theme="light"] .header-badge {
    background: #eeecff;

    border-color: #dcd7ff;

    color: #5848eb;
}


html[data-theme="light"] .header-icon {
    background: #ffffff;

    border-color: #e1e6ef;

    box-shadow:
        0 12px 30px rgba(20, 30, 50, 0.07);
}


html[data-theme="light"] .organization-card {
    background: #ffffff;

    border-color: #e1e6ef;

    box-shadow:
        0 15px 40px rgba(20, 30, 50, 0.06);
}


html[data-theme="light"] .form-section {
    border-bottom-color: #e1e6ef;
}


html[data-theme="light"] .section-icon {
    background: #eeecff;
}


html[data-theme="light"] .section-heading h2 {
    color: #172033;
}


html[data-theme="light"] .section-heading p {
    color: #687386;
}


html[data-theme="light"] .form-group label {
    color: #344054;
}


html[data-theme="light"] .form-group input,
html[data-theme="light"] .form-group select,
html[data-theme="light"] .form-group textarea {
    background: #ffffff;

    border-color: #dce2ec;

    color: #172033;
}


html[data-theme="light"] .form-group input::placeholder,
html[data-theme="light"] .form-group textarea::placeholder {
    color: #8a94a6;
}


html[data-theme="light"] .approval-box {
    background: #fff9e9;

    border-color: #f0dfad;
}


html[data-theme="light"] .approval-box h3 {
    color: #a77900;
}


html[data-theme="light"] .approval-box p {
    color: #8c7638;
}


html[data-theme="light"] .success-alert {
    background: #edf9f1;

    border-color: #c7ead2;
}


html[data-theme="light"] .success-alert strong {
    color: #218838;
}


html[data-theme="light"] .success-alert p {
    color: #4d9461;
}


html[data-theme="light"] .cancel-btn {
    background: #f1f3f7;

    border-color: #dce2ec;

    color: #344054;
}


html[data-theme="light"] .cancel-btn:hover {
    background: #e8ebf1;

    color: #172033;
}


html[data-theme="light"] .back-link a {
    color: #687386;
}


html[data-theme="light"] .back-link a:hover {
    color: #5848eb;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 700px) {

    .organization-page {
        padding: 35px 14px 25px;
    }


    .organization-header {
        align-items: flex-start;
    }


    .organization-header h1 {
        font-size: 28px;
    }


    .header-icon {
        width: 58px;
        height: 58px;

        border-radius: 15px;

        font-size: 26px;
    }


    .organization-card {
        padding: 22px;
    }


    .form-grid {
        grid-template-columns: 1fr;
    }


    .full-width {
        grid-column: auto;
    }

}


@media (max-width: 500px) {

    .organization-header {
        flex-direction: column;
    }


    .header-icon {
        display: none;
    }


    .form-actions {
        flex-direction: column-reverse;

        align-items: stretch;
    }


    .cancel-btn,
    .submit-btn {
        width: 100%;
    }

}

</style>