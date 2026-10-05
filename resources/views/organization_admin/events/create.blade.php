<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Add Event | Eventora Admin
    </title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f5f7fb;

            color: #1f2937;
        }


        .admin-main {

            margin-left: 270px;

            min-height: 100vh;

            padding: 30px;
        }


        /* =========================================
           TOPBAR
        ========================================= */

        .topbar {

            display: flex;

            align-items: center;

            gap: 15px;

            margin-bottom: 25px;
        }


        .back-btn {

            width: 42px;
            height: 42px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            text-decoration: none;

            color: #374151;

            font-size: 20px;

            transition: 0.2s;
        }


        .back-btn:hover {

            background: #f3f4f6;
        }


        .page-title h1 {

            font-size: 28px;

            color: #111827;

            margin-bottom: 5px;
        }


        .page-title p {

            color: #6b7280;

            font-size: 14px;
        }


        /* =========================================
           FORM CARD
        ========================================= */

        .form-card {

            max-width: 1000px;

            margin: 0 auto;

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

            padding: 30px;

            box-shadow:
                0 5px 20px
                rgba(0, 0, 0, 0.04);
        }


        .section {

            margin-bottom: 30px;
        }


        .section:last-child {

            margin-bottom: 0;
        }


        .section-title {

            font-size: 18px;

            font-weight: 700;

            color: #111827;

            margin-bottom: 18px;

            padding-bottom: 12px;

            border-bottom:
                1px solid #e5e7eb;
        }


        .form-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;
        }


        .form-group {

            display: flex;

            flex-direction: column;
        }


        .full-width {

            grid-column: 1 / -1;
        }


        label {

            font-size: 13px;

            font-weight: 600;

            color: #374151;

            margin-bottom: 8px;
        }


        .required {

            color: #dc2626;
        }


        input,
        select,
        textarea {

            width: 100%;

            padding: 13px 14px;

            border:
                1px solid #d1d5db;

            border-radius: 10px;

            background: white;

            color: #111827;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }


        input:focus,
        select:focus,
        textarea:focus {

            border-color: #111827;

            box-shadow:
                0 0 0 3px
                rgba(17, 24, 39, 0.08);
        }


        textarea {

            min-height: 150px;

            resize: vertical;

            line-height: 1.6;
        }


        .help-text {

            margin-top: 6px;

            color: #9ca3af;

            font-size: 12px;
        }


        .error-message {

            margin-top: 6px;

            color: #dc2626;

            font-size: 12px;
        }


        /* =========================================
           BANNER UPLOAD
        ========================================= */

        .banner-upload {

            border:
                2px dashed #d1d5db;

            border-radius: 12px;

            padding: 30px;

            text-align: center;

            cursor: pointer;

            transition: 0.2s;
        }


        .banner-upload:hover {

            border-color: #9ca3af;

            background: #fafafa;
        }


        .upload-icon {

            font-size: 38px;

            margin-bottom: 10px;
        }


        .banner-upload strong {

            display: block;

            color: #374151;

            margin-bottom: 5px;
        }


        .banner-upload span {

            color: #9ca3af;

            font-size: 12px;
        }


        #banner {

            display: none;
        }


        .image-preview {

            display: none;

            margin-top: 15px;
        }


        .image-preview img {

            width: 100%;

            max-height: 280px;

            object-fit: cover;

            border-radius: 12px;

            border:
                1px solid #e5e7eb;
        }


        /* =========================================
           FORM ACTIONS
        ========================================= */

        .form-actions {

            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 12px;

            padding-top: 25px;

            border-top:
                1px solid #e5e7eb;
        }


        .cancel-btn,
        .submit-btn {

            padding: 13px 22px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;

            transition: 0.2s;
        }


        .cancel-btn {

            background: white;

            color: #374151;

            border:
                1px solid #d1d5db;
        }


        .cancel-btn:hover {

            background: #f3f4f6;
        }


        .submit-btn {

            border: none;

            background: #111827;

            color: white;
        }


        .submit-btn:hover {

            background: #374151;

            transform:
                translateY(-1px);
        }


        /* =========================================
           MOBILE MENU
        ========================================= */

        .mobile-menu-btn {

            display: none;

            width: 42px;
            height: 42px;

            border:
                1px solid #e5e7eb;

            border-radius: 10px;

            background: white;

            cursor: pointer;

            font-size: 20px;
        }


        /* =========================================
           ERROR ALERT
        ========================================= */

        .alert-error {

            background: #fef2f2;

            border:
                1px solid #fecaca;

            color: #991b1b;

            border-radius: 10px;

            padding: 14px 18px;

            margin-bottom: 20px;

            font-size: 14px;
        }


        .alert-error ul {

            margin-left: 18px;

            margin-top: 7px;
        }


        /* =========================================
           UNIT INFO
        ========================================= */

        .unit-notice {

            margin-top: 8px;

            padding: 10px 12px;

            border-radius: 9px;

            background: #f8fafc;

            border:
                1px solid #e5e7eb;

            color: #64748b;

            font-size: 12px;

            line-height: 1.5;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 900px) {

            .admin-main {

                margin-left: 0;

                padding: 20px;
            }


            .mobile-menu-btn {

                display: inline-flex;

                align-items: center;

                justify-content: center;
            }


            .form-card {

                padding: 22px;
            }

        }


        @media (max-width: 650px) {

            .admin-main {

                padding: 16px;
            }


            .form-grid {

                grid-template-columns: 1fr;
            }


            .full-width {

                grid-column: auto;
            }


            .form-card {

                padding: 18px;

                border-radius: 14px;
            }


            .page-title h1 {

                font-size: 23px;
            }


            .form-actions {

                flex-direction:
                    column-reverse;
            }


            .cancel-btn,
            .submit-btn {

                width: 100%;

                text-align: center;
            }

        }

    </style>

</head>


<body>


    @include('organization_admin.sidebar')


    <div class="admin-main">


        {{-- =========================================
             HEADER
        ========================================= --}}

        <div class="topbar">

            <button
                class="mobile-menu-btn"
                onclick="openAdminSidebar()"
                type="button"
            >
                ☰
            </button>


            <a
                href="{{ route('organization.admin.events.index') }}"
                class="back-btn"
                title="Back"
            >
                ←
            </a>


            <div class="page-title">

                <h1>
                    Add Event
                </h1>

                <p>
                    Create a new event for
                    {{ $organization->name }}.
                </p>

            </div>

        </div>


        {{-- =========================================
             VALIDATION ERRORS
        ========================================= --}}

        @if($errors->any())

            <div class="alert-error">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =========================================
             FORM
        ========================================= --}}

        <div class="form-card">

            <form
                action="{{ route('organization.admin.events.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- =====================================
                     BASIC INFORMATION
                ====================================== --}}

                <div class="section">

                    <div class="section-title">
                        Basic Information
                    </div>


                    <div class="form-grid">


                        {{-- EVENT TITLE --}}

                        <div class="form-group full-width">

                            <label for="title">

                                Event Title

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Enter event title"
                                required
                            >


                            @error('title')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- CATEGORY --}}

                        <div class="form-group">

                            <label for="category">

                                Category

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <select
                                id="category"
                                name="category"
                                required
                            >

                                <option value="">
                                    Select Category
                                </option>


                                <option
                                    value="Technology"
                                    {{ old('category') == 'Technology' ? 'selected' : '' }}
                                >
                                    Technology
                                </option>


                                <option
                                    value="Cultural"
                                    {{ old('category') == 'Cultural' ? 'selected' : '' }}
                                >
                                    Cultural
                                </option>


                                <option
                                    value="Sports"
                                    {{ old('category') == 'Sports' ? 'selected' : '' }}
                                >
                                    Sports
                                </option>


                                <option
                                    value="Workshop"
                                    {{ old('category') == 'Workshop' ? 'selected' : '' }}
                                >
                                    Workshop
                                </option>


                                <option
                                    value="Seminar"
                                    {{ old('category') == 'Seminar' ? 'selected' : '' }}
                                >
                                    Seminar
                                </option>


                                <option
                                    value="Competition"
                                    {{ old('category') == 'Competition' ? 'selected' : '' }}
                                >
                                    Competition
                                </option>


                                <option
                                    value="Other"
                                    {{ old('category') == 'Other' ? 'selected' : '' }}
                                >
                                    Other
                                </option>

                            </select>


                            @error('category')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================
                             ORGANIZATION UNIT
                        ================================== --}}

                        @if(isset($units) && $units->count() > 0)

                            <div class="form-group">

                                <label for="organization_unit_id">

                                    Department / Team / Section

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <select
                                    id="organization_unit_id"
                                    name="organization_unit_id"
                                >

                                    <option value="">
                                        General / Organization-wide
                                    </option>


                                    @foreach($units as $unit)

                                        <option
                                            value="{{ $unit->id }}"
                                            {{ old('organization_unit_id') == $unit->id ? 'selected' : '' }}
                                        >

                                            {{ $unit->name }}

                                            @if($unit->type)
                                                — {{ $unit->type }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>


                                <div class="help-text">

                                    Select the department, team or section
                                    responsible for this event.

                                </div>


                                @error('organization_unit_id')

                                    <div class="error-message">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        @else

                            <div class="form-group">

                                <label>
                                    Organization Unit
                                </label>


                                <div class="unit-notice">

                                    No departments, teams or sections
                                    have been created yet. This event will
                                    be treated as an organization-wide event.

                                </div>

                            </div>

                        @endif


                        {{-- =================================
                             BANNER
                        ================================== --}}

                        <div class="form-group">

                            <label>
                                Event Banner
                            </label>


                            <label
                                for="banner"
                                class="banner-upload"
                            >

                                <div class="upload-icon">
                                    🖼️
                                </div>


                                <strong>
                                    Click to upload banner
                                </strong>


                                <span>
                                    JPG, JPEG, PNG or WEBP
                                    • Max 4MB
                                </span>

                            </label>


                            <input
                                type="file"
                                id="banner"
                                name="banner"
                                accept=".jpg,.jpeg,.png,.webp"
                            >


                            <div
                                class="image-preview"
                                id="imagePreview"
                            >

                                <img
                                    id="previewImage"
                                    src=""
                                    alt="Banner Preview"
                                >

                            </div>


                            @error('banner')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================
                             DESCRIPTION
                        ================================== --}}

                        <div class="form-group full-width">

                            <label for="description">

                                Description

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <textarea
                                id="description"
                                name="description"
                                placeholder="Describe your event..."
                                required
                            >{{ old('description') }}</textarea>


                            @error('description')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================
                     SCHEDULE & LOCATION
                ====================================== --}}

                <div class="section">

                    <div class="section-title">
                        Schedule & Location
                    </div>


                    <div class="form-grid">


                        {{-- DATE --}}

                        <div class="form-group">

                            <label for="event_date">

                                Event Date

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="date"
                                id="event_date"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                required
                            >


                            @error('event_date')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- TIME --}}

                        <div class="form-group">

                            <label for="event_time">

                                Event Time

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="time"
                                id="event_time"
                                name="event_time"
                                value="{{ old('event_time') }}"
                                required
                            >


                            @error('event_time')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- VENUE --}}

                        <div class="form-group">

                            <label for="venue">

                                Venue

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                id="venue"
                                name="venue"
                                value="{{ old('venue') }}"
                                placeholder="e.g. RNGPIT Auditorium"
                                required
                            >


                            @error('venue')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- CITY --}}

                        <div class="form-group">

                            <label for="city">

                                City

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="e.g. Bardoli"
                                required
                            >


                            @error('city')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================
                     TICKET INFORMATION
                ====================================== --}}

                <div class="section">

                    <div class="section-title">
                        Ticket Information
                    </div>


                    <div class="form-grid">


                        {{-- PRICE --}}

                        <div class="form-group">

                            <label for="ticket_price">

                                Ticket Price (₹)

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="number"
                                id="ticket_price"
                                name="ticket_price"
                                value="{{ old('ticket_price', 0) }}"
                                min="0"
                                step="0.01"
                                placeholder="0"
                                required
                            >


                            <div class="help-text">
                                Enter 0 if the event is free.
                            </div>


                            @error('ticket_price')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- SEAT TYPE --}}

                        <div class="form-group">

                            <label for="seat_type">

                                Seat Availability

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <select
                                id="seat_type"
                                name="seat_type"
                                required
                            >

                                <option
                                    value="limited"
                                    {{ old('seat_type', 'limited') == 'limited' ? 'selected' : '' }}
                                >
                                    Limited Seats
                                </option>


                                <option
                                    value="unlimited"
                                    {{ old('seat_type') == 'unlimited' ? 'selected' : '' }}
                                >
                                    No Limit / Unlimited
                                </option>

                            </select>


                            <div class="help-text">

                                Choose unlimited if every participant
                                can register.

                            </div>

                        </div>


                        {{-- TOTAL SEATS --}}

                        <div
                            class="form-group"
                            id="totalSeatsGroup"
                        >

                            <label for="total_seats">

                                Total Seats

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input
                                type="number"
                                id="total_seats"
                                name="total_seats"
                                value="{{ old('total_seats') }}"
                                min="1"
                                placeholder="e.g. 100"
                            >


                            <div class="help-text">

                                Enter the maximum number
                                of participants.

                            </div>


                            @error('total_seats')

                                <div class="error-message">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================
                     ACTIONS
                ====================================== --}}

                <div class="form-actions">


                    <a
                        href="{{ route('organization.admin.events.index') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="submit-btn"
                    >
                        Create Event
                    </button>


                </div>

            </form>

        </div>

    </div>


    {{-- =========================================
         JAVASCRIPT
    ========================================= --}}

    <script>

        /* =========================================
           BANNER PREVIEW
        ========================================= */

        const bannerInput =
            document.getElementById('banner');

        const imagePreview =
            document.getElementById('imagePreview');

        const previewImage =
            document.getElementById('previewImage');


        bannerInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];


                if (file) {

                    const reader =
                        new FileReader();


                    reader.onload =
                        function (e) {

                            previewImage.src =
                                e.target.result;

                            imagePreview.style.display =
                                'block';
                        };


                    reader.readAsDataURL(file);

                } else {

                    imagePreview.style.display =
                        'none';

                    previewImage.src =
                        '';

                }

            }
        );


        /* =========================================
           SEAT TYPE
        ========================================= */

        const seatType =
            document.getElementById(
                'seat_type'
            );


        const totalSeatsGroup =
            document.getElementById(
                'totalSeatsGroup'
            );


        const totalSeatsInput =
            document.getElementById(
                'total_seats'
            );


        function updateSeatField()
        {

            if (
                seatType.value ===
                'unlimited'
            ) {

                totalSeatsGroup.style.display =
                    'none';

                totalSeatsInput.required =
                    false;

                totalSeatsInput.value =
                    '';

            } else {

                totalSeatsGroup.style.display =
                    'flex';

                totalSeatsInput.required =
                    true;
            }
        }


        seatType.addEventListener(
            'change',
            updateSeatField
        );


        updateSeatField();

    </script>


</body>

</html>