@include('organization_admin.sidebar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Event | Eventora Admin</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .admin-main {
            margin-left: 270px;
            min-height: 100vh;
            padding: 30px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .title-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-menu-btn {
            display: none;
            width: 42px;
            height: 42px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            font-size: 20px;
        }

        .page-title h1 {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .page-title p {
            color: #6b7280;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 16px;
            background: white;
            color: #374151;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-btn:hover {
            background: #f9fafb;
        }

        .form-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            max-width: 1000px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .required {
            color: #dc2626;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            padding: 12px 13px;
            font-size: 14px;
            color: #111827;
            background: white;
            outline: none;
            transition: 0.2s;
            font-family: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.08);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .help-text {
            font-size: 12px;
            color: #6b7280;
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .banner-preview {
            margin-top: 10px;
            width: 220px;
            height: 130px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #f3f4f6;
        }

        .banner-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .seat-info {
            padding: 12px 14px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            color: #6b7280;
            font-size: 13px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .cancel-btn,
        .update-btn {
            padding: 12px 20px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .cancel-btn {
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .cancel-btn:hover {
            background: #f9fafb;
        }

        .update-btn {
            background: #111827;
            color: white;
            border: none;
        }

        .update-btn:hover {
            background: #374151;
            transform: translateY(-1px);
        }

        .unlimited-note {
            display: none;
            padding: 10px 12px;
            border-radius: 8px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 600;
            margin-top: 4px;
        }

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

            .topbar {
                align-items: flex-start;
            }

            .page-title h1 {
                font-size: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: auto;
            }
        }

        @media (max-width: 600px) {

            .admin-main {
                padding: 16px;
            }

            .topbar {
                flex-wrap: wrap;
            }

            .page-title h1 {
                font-size: 22px;
            }

            .page-title p {
                font-size: 13px;
            }

            .back-btn {
                width: 100%;
                justify-content: center;
            }

            .form-card {
                padding: 20px;
                border-radius: 12px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .cancel-btn,
            .update-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="admin-main">

    {{-- Top Header --}}
    <div class="topbar">

        <div class="title-section">

            <button
                class="mobile-menu-btn"
                onclick="openAdminSidebar()"
                type="button"
            >
                ☰
            </button>

            <div class="page-title">
                <h1>Edit Event</h1>
                <p>Update your organization's event details.</p>
            </div>

        </div>

        <a
            href="{{ route('organization.admin.events.index') }}"
            class="back-btn"
        >
            ← Back to Events
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="error-box">

            <strong>Please fix the following errors:</strong>

            <ul style="margin-top:8px;padding-left:20px;">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Edit Form --}}
    <div class="form-card">

        <form
            action="{{ route('organization.admin.events.update', $event) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            {{-- Basic Information --}}
            <div class="section-title">
                Basic Information
            </div>

            <div class="form-grid">

                {{-- Title --}}
                <div class="form-group full-width">

                    <label for="title">
                        Event Title <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $event->title) }}"
                        placeholder="Enter event title"
                        required
                    >

                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Category --}}
                <div class="form-group">

                    <label for="category">
                        Category <span class="required">*</span>
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
                            {{ old('category', $event->category) == 'Technology' ? 'selected' : '' }}
                        >
                            Technology
                        </option>

                        <option
                            value="Education"
                            {{ old('category', $event->category) == 'Education' ? 'selected' : '' }}
                        >
                            Education
                        </option>

                        <option
                            value="Cultural"
                            {{ old('category', $event->category) == 'Cultural' ? 'selected' : '' }}
                        >
                            Cultural
                        </option>

                        <option
                            value="Sports"
                            {{ old('category', $event->category) == 'Sports' ? 'selected' : '' }}
                        >
                            Sports
                        </option>

                        <option
                            value="Workshop"
                            {{ old('category', $event->category) == 'Workshop' ? 'selected' : '' }}
                        >
                            Workshop
                        </option>

                        <option
                            value="Competition"
                            {{ old('category', $event->category) == 'Competition' ? 'selected' : '' }}
                        >
                            Competition
                        </option>

                        <option
                            value="Other"
                            {{ old('category', $event->category) == 'Other' ? 'selected' : '' }}
                        >
                            Other
                        </option>

                    </select>

                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Ticket Price --}}
                <div class="form-group">

                    <label for="ticket_price">
                        Ticket Price <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="ticket_price"
                        name="ticket_price"
                        value="{{ old('ticket_price', $event->ticket_price) }}"
                        min="0"
                        step="0.01"
                        placeholder="0"
                        required
                    >

                    <div class="help-text">
                        Enter 0 for a free event.
                    </div>

                    @error('ticket_price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="form-group full-width">

                    <label for="description">
                        Description <span class="required">*</span>
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Describe your event..."
                        required
                    >{{ old('description', $event->description) }}</textarea>

                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>

            </div>


            {{-- Event Schedule --}}
            <div
                class="section-title"
                style="margin-top:32px;"
            >
                Event Schedule & Location
            </div>

            <div class="form-grid">

                {{-- Date --}}
                <div class="form-group">

                    <label for="event_date">
                        Event Date <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        id="event_date"
                        name="event_date"
                        value="{{ old('event_date', $event->event_date) }}"
                        required
                    >

                    @error('event_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Time --}}
                <div class="form-group">

                    <label for="event_time">
                        Event Time <span class="required">*</span>
                    </label>

                    <input
                        type="time"
                        id="event_time"
                        name="event_time"
                        value="{{ old('event_time', $event->event_time) }}"
                        required
                    >

                    @error('event_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Venue --}}
                <div class="form-group">

                    <label for="venue">
                        Venue <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="venue"
                        name="venue"
                        value="{{ old('venue', $event->venue) }}"
                        placeholder="Enter venue"
                        required
                    >

                    @error('venue')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- City --}}
                <div class="form-group">

                    <label for="city">
                        City <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="city"
                        name="city"
                        value="{{ old('city', $event->city) }}"
                        placeholder="Enter city"
                        required
                    >

                    @error('city')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>

            </div>


            {{-- Seats --}}
            <div
                class="section-title"
                style="margin-top:32px;"
            >
                Seat Availability
            </div>

            <div class="form-grid">

                {{-- Seat Type --}}
                <div class="form-group">

                    <label for="seat_type">
                        Seat Availability <span class="required">*</span>
                    </label>

                    @php
                        $currentSeatType = is_null($event->total_seats)
                            ? 'unlimited'
                            : 'limited';
                    @endphp

                    <select
                        id="seat_type"
                        name="seat_type"
                        required
                    >

                        <option
                            value="limited"
                            {{ old('seat_type', $currentSeatType) == 'limited' ? 'selected' : '' }}
                        >
                            Limited Seats
                        </option>

                        <option
                            value="unlimited"
                            {{ old('seat_type', $currentSeatType) == 'unlimited' ? 'selected' : '' }}
                        >
                            No Limit / Unlimited
                        </option>

                    </select>

                    <div class="help-text">
                        Choose unlimited if every participant can register.
                    </div>

                    <div
                        class="unlimited-note"
                        id="unlimitedNote"
                    >
                        ∞ This event allows unlimited participants.
                    </div>

                    @error('seat_type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Total Seats --}}
                <div
                    class="form-group"
                    id="totalSeatsGroup"
                >

                    <label for="total_seats">
                        Total Seats <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="total_seats"
                        name="total_seats"
                        value="{{ old('total_seats', $event->total_seats) }}"
                        min="1"
                        placeholder="e.g. 100"
                    >

                    <div class="help-text">
                        Enter the maximum number of participants.
                    </div>

                    @error('total_seats')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Current Seat Information --}}
                <div class="form-group full-width">

                    <div class="seat-info">

                        @if(is_null($event->total_seats))

                            Current setting:
                            <strong>Unlimited</strong>

                        @else

                            Current availability:
                            <strong>
                                {{ $event->available_seats }}
                                / {{ $event->total_seats }}
                            </strong>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Banner --}}
            <div
                class="section-title"
                style="margin-top:32px;"
            >
                Event Banner
            </div>

            <div class="form-group">

                <label for="banner">
                    Change Event Banner
                </label>

                <input
                    type="file"
                    id="banner"
                    name="banner"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <div class="help-text">
                    JPG, JPEG, PNG or WEBP. Maximum size: 4MB.
                </div>

                @error('banner')
                    <div class="error-message">{{ $message }}</div>
                @enderror


                {{-- Current Banner --}}
                @if($event->banner)

                    <div class="banner-preview">

                        <img
                            src="{{ asset('storage/' . $event->banner) }}"
                            alt="{{ $event->title }}"
                        >

                    </div>

                    <div
                        class="help-text"
                        style="margin-top:8px;"
                    >
                        Current event banner
                    </div>

                @endif

            </div>


            {{-- Actions --}}
            <div class="form-actions">

                <a
                    href="{{ route('organization.admin.events.index') }}"
                    class="cancel-btn"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="update-btn"
                >
                    Update Event
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | Seat Type Toggle
    |--------------------------------------------------------------------------
    */

    const seatType = document.getElementById('seat_type');

    const totalSeatsGroup =
        document.getElementById('totalSeatsGroup');

    const totalSeatsInput =
        document.getElementById('total_seats');

    const unlimitedNote =
        document.getElementById('unlimitedNote');


    function updateSeatField() {

        if (seatType.value === 'unlimited') {

            totalSeatsGroup.style.display = 'none';

            totalSeatsInput.required = false;

            unlimitedNote.style.display = 'block';

        } else {

            totalSeatsGroup.style.display = 'flex';

            totalSeatsInput.required = true;

            unlimitedNote.style.display = 'none';
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