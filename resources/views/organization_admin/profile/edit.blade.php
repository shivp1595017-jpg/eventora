<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Organization Profile - Eventora</title>

    <style>

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6fb;
            color: #172033;
        }

        /* =========================================
           MAIN CONTENT
        ========================================= */

        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }


        /* =========================================
           MOBILE HEADER
        ========================================= */

        .mobile-header {
            display: none;

            height: 58px;
            background: white;

            align-items: center;
            gap: 15px;

            padding: 0 16px;
            margin-bottom: 22px;

            border-radius: 14px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
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


        /* =========================================
           TOPBAR
        ========================================= */

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
            line-height: 1.2;
        }

        .topbar-left p {
            margin: 0;

            color: #667085;

            font-size: 14px;
        }

        .admin-badge {
            background: white;

            padding: 11px 16px;

            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);

            font-size: 13px;
            font-weight: 700;

            white-space: nowrap;
        }


        /* =========================================
           PROFILE HEADER CARD
        ========================================= */

        .profile-cover {

            position: relative;

            min-height: 230px;

            border-radius: 22px;

            overflow: hidden;

            margin-bottom: 25px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1 0%,
                    #4f46e5 100%
                );

            box-shadow:
                0 15px 35px rgba(79, 70, 229, 0.20);
        }

        .profile-cover-image {

            width: 100%;
            height: 100%;

            min-height: 230px;

            object-fit: cover;

            display: block;
        }

        .profile-cover-overlay {

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(17, 24, 39, 0.75),
                    rgba(79, 70, 229, 0.20)
                );
        }

        .profile-cover-content {

            position: absolute;

            left: 30px;
            right: 30px;
            bottom: 25px;

            display: flex;

            align-items: flex-end;

            gap: 20px;

            color: white;
        }

        .profile-logo {

            width: 105px;
            height: 105px;

            flex-shrink: 0;

            border-radius: 18px;

            background: white;

            padding: 5px;

            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.20);
        }

        .profile-logo img {

            width: 100%;
            height: 100%;

            object-fit: cover;

            border-radius: 14px;
        }

        .profile-logo-placeholder {

            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: #111827;

            color: white;

            font-size: 35px;
            font-weight: 800;
        }

        .profile-title h2 {

            margin: 0 0 8px;

            font-size: 28px;
        }

        .profile-title p {

            margin: 0;

            color: rgba(255,255,255,0.85);

            font-size: 14px;
        }


        /* =========================================
           FORM CARD
        ========================================= */

        .profile-card {

            background: white;

            border-radius: 20px;

            padding: 28px;

            box-shadow:
                0 7px 25px rgba(0, 0, 0, 0.05);

            margin-bottom: 30px;
        }

        .section-title {

            margin: 0 0 20px;

            font-size: 21px;

            color: #172033;
        }

        .form-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 20px;
        }

        .form-group {

            display: flex;

            flex-direction: column;

            gap: 7px;
        }

        .form-group.full {

            grid-column: 1 / -1;
        }

        .form-group label {

            font-size: 13px;

            font-weight: 700;

            color: #344054;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {

            width: 100%;

            padding: 13px 14px;

            border: 1px solid #d0d5dd;

            border-radius: 11px;

            outline: none;

            background: #ffffff;

            color: #172033;

            font-family: Arial, Helvetica, sans-serif;

            font-size: 14px;

            transition: 0.2s;
        }

        .form-group textarea {

            min-height: 115px;

            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {

            border-color: #6366f1;

            box-shadow:
                0 0 0 3px rgba(99, 102, 241, 0.10);
        }

        .form-help {

            color: #98a2b3;

            font-size: 11px;
        }


        /* =========================================
           FILE UPLOAD
        ========================================= */

        .file-box {

            padding: 15px;

            border: 1px dashed #c7d2fe;

            border-radius: 12px;

            background: #f8f9ff;
        }

        .file-box input {

            border: none;

            padding: 0;

            background: transparent;
        }

        .current-file {

            margin-top: 8px;

            color: #667085;

            font-size: 12px;
        }


        /* =========================================
           BUTTONS
        ========================================= */

        .form-actions {

            display: flex;

            justify-content: flex-end;

            gap: 12px;

            margin-top: 28px;

            padding-top: 22px;

            border-top: 1px solid #eaecf0;
        }

        .btn {

            border: none;

            border-radius: 11px;

            padding: 13px 22px;

            font-size: 14px;

            font-weight: 700;

            text-decoration: none;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .btn-primary {

            background: #6366f1;

            color: white;

            box-shadow:
                0 7px 18px rgba(99, 102, 241, 0.20);
        }

        .btn-primary:hover {

            background: #4f46e5;

            transform: translateY(-2px);

            box-shadow:
                0 10px 24px rgba(99, 102, 241, 0.28);
        }

        .btn-secondary {

            background: #eef2f6;

            color: #344054;
        }

        .btn-secondary:hover {

            background: #e4e7ec;

            transform: translateY(-2px);
        }


        /* =========================================
           SUCCESS / ERROR
        ========================================= */

        .alert-success {

            margin-bottom: 20px;

            padding: 14px 17px;

            border-radius: 12px;

            background: #ecfdf3;

            color: #027a48;

            border: 1px solid #abefc6;

            font-size: 14px;

            font-weight: 600;
        }

        .error-box {

            margin-bottom: 20px;

            padding: 14px 17px;

            border-radius: 12px;

            background: #fef3f2;

            color: #b42318;

            border: 1px solid #fecdca;

            font-size: 14px;
        }

        .error-box ul {

            margin: 8px 0 0 18px;

            padding: 0;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

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

            .topbar-left h1 {

                font-size: 24px;
            }

            .admin-badge {

                width: 100%;

                text-align: center;
            }

            .profile-cover {

                min-height: 300px;

                border-radius: 18px;
            }

            .profile-cover-image {

                min-height: 300px;
            }

            .profile-cover-content {

                left: 20px;
                right: 20px;
                bottom: 20px;

                align-items: flex-end;
            }

            .profile-logo {

                width: 82px;
                height: 82px;

                border-radius: 15px;
            }

            .profile-title h2 {

                font-size: 21px;
            }

            .profile-title p {

                font-size: 12px;
            }

            .profile-card {

                padding: 20px;

                border-radius: 18px;
            }

            .form-grid {

                grid-template-columns: 1fr;

                gap: 16px;
            }

            .form-group.full {

                grid-column: auto;
            }

            .form-actions {

                flex-direction: column;
            }

            .btn {

                width: 100%;

                text-align: center;
            }
        }


        /* =========================================
           SMALL MOBILE
        ========================================= */

        @media (max-width: 480px) {

            .admin-main {

                padding: 12px;
            }

            .mobile-header {

                margin-bottom: 17px;
            }

            .topbar-left h1 {

                font-size: 21px;
            }

            .profile-cover {

                min-height: 280px;
            }

            .profile-cover-image {

                min-height: 280px;
            }

            .profile-cover-content {

                flex-direction: column;

                align-items: flex-start;

                gap: 12px;
            }

            .profile-logo {

                width: 75px;
                height: 75px;
            }

            .profile-title h2 {

                font-size: 20px;
            }

            .profile-card {

                padding: 18px;
            }
        }

    </style>

</head>


<body>


    {{-- =========================================
         SIDEBAR
    ========================================== --}}

    @include('organization_admin.sidebar')


    {{-- =========================================
         MAIN CONTENT
    ========================================== --}}

    <main class="admin-main">


        {{-- Mobile Header --}}

        <div class="mobile-header">

            <button
                type="button"
                class="mobile-menu-button"
                onclick="openAdminSidebar()"
                aria-label="Open Menu"
            >
                ☰
            </button>

            <strong>
                Eventora
            </strong>

        </div>


        {{-- =========================================
             TOPBAR
        ========================================== --}}

        <div class="topbar">

            <div class="topbar-left">

                <h1>
                    Organization Profile
                </h1>

                <p>
                    Manage your organization's information
                </p>

            </div>

            <div class="admin-badge">

                👤 {{ auth()->user()->name }}

            </div>

        </div>


        {{-- =========================================
             SUCCESS MESSAGE
        ========================================== --}}

        @if(session('success'))

            <div class="alert-success">

                ✓ {{ session('success') }}

            </div>

        @endif


        {{-- =========================================
             VALIDATION ERRORS
        ========================================== --}}

        @if($errors->any())

            <div class="error-box">

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
             ORGANIZATION PROFILE HEADER
        ========================================== --}}

        <section class="profile-cover">


            @if($organization->cover_image)

                <img
                    class="profile-cover-image"
                    src="{{ asset('storage/' . $organization->cover_image) }}"
                    alt="Organization Cover"
                >

            @endif


            <div class="profile-cover-overlay"></div>


            <div class="profile-cover-content">


                <div class="profile-logo">

                    @if($organization->logo)

                        <img
                            src="{{ asset('storage/' . $organization->logo) }}"
                            alt="{{ $organization->name }} Logo"
                        >

                    @else

                        <div class="profile-logo-placeholder">

                            {{ strtoupper(substr($organization->name, 0, 1)) }}

                        </div>

                    @endif

                </div>


                <div class="profile-title">

                    <h2>
                        {{ $organization->name }}
                    </h2>

                    <p>
                        🏷️ {{ $organization->type }}

                        @if($organization->city)

                            &nbsp; • &nbsp;

                            📍 {{ $organization->city }}

                        @endif
                    </p>

                </div>


            </div>

        </section>


        {{-- =========================================
             PROFILE FORM
        ========================================== --}}

        <div class="profile-card">


            <h2 class="section-title">

                Organization Information

            </h2>


            <form
                action="{{ route('organization.admin.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                @method('PUT')


                <div class="form-grid">


                    {{-- Organization Name --}}

                    <div class="form-group">

                        <label for="name">
                            Organization Name *
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $organization->name) }}"
                            required
                        >

                    </div>


                    {{-- Organization Type --}}

                    <div class="form-group">

                        <label for="type">
                            Organization Type *
                        </label>

                        <select
                            id="type"
                            name="type"
                            required
                        >

                            @foreach([
                                'School',
                                'College',
                                'Company',
                                'NGO',
                                'Other'
                            ] as $type)

                                <option
                                    value="{{ $type }}"
                                    {{ old('type', $organization->type) === $type ? 'selected' : '' }}
                                >

                                    {{ $type }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Description --}}

                    <div class="form-group full">

                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Tell people about your organization..."
                        >{{ old('description', $organization->description) }}</textarea>

                    </div>


                    {{-- Email --}}

                    <div class="form-group">

                        <label for="email">
                            Organization Email *
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $organization->email) }}"
                            required
                        >

                    </div>


                    {{-- Phone --}}

                    <div class="form-group">

                        <label for="phone">
                            Phone
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $organization->phone) }}"
                        >

                    </div>


                    {{-- Address --}}

                    <div class="form-group full">

                        <label for="address">
                            Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            placeholder="Organization address..."
                        >{{ old('address', $organization->address) }}</textarea>

                    </div>


                    {{-- City --}}

                    <div class="form-group">

                        <label for="city">
                            City
                        </label>

                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city', $organization->city) }}"
                        >

                    </div>


                    {{-- State --}}

                    <div class="form-group">

                        <label for="state">
                            State
                        </label>

                        <input
                            type="text"
                            id="state"
                            name="state"
                            value="{{ old('state', $organization->state) }}"
                        >

                    </div>


                    {{-- Website --}}

                    <div class="form-group full">

                        <label for="website">
                            Website
                        </label>

                        <input
                            type="url"
                            id="website"
                            name="website"
                            value="{{ old('website', $organization->website) }}"
                            placeholder="https://example.com"
                        >

                        <span class="form-help">
                            Example: https://www.example.com
                        </span>

                    </div>


                    {{-- Logo --}}

                    <div class="form-group">

                        <label for="logo">
                            Organization Logo
                        </label>

                        <div class="file-box">

                            <input
                                type="file"
                                id="logo"
                                name="logo"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <span class="form-help">
                                JPG, PNG or WEBP. Maximum 4 MB.
                            </span>

                        </div>


                        @if($organization->logo)

                            <div class="current-file">

                                ✓ Current logo is uploaded.

                            </div>

                        @endif

                    </div>


                    {{-- Cover Image --}}

                    <div class="form-group">

                        <label for="cover_image">
                            Cover Image
                        </label>

                        <div class="file-box">

                            <input
                                type="file"
                                id="cover_image"
                                name="cover_image"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <span class="form-help">
                                JPG, PNG or WEBP. Maximum 6 MB.
                            </span>

                        </div>


                        @if($organization->cover_image)

                            <div class="current-file">

                                ✓ Current cover image is uploaded.

                            </div>

                        @endif

                    </div>


                </div>


                {{-- =========================================
                     ACTION BUTTONS
                ========================================== --}}

                <div class="form-actions">


                    <a
                       href="{{ route('organization.admin.profile') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Changes
                    </button>


                </div>


            </form>


        </div>


    </main>


</body>

</html>