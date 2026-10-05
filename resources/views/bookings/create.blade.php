<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Book Event - Eventora
    </title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #0b0f19;

            color: #ffffff;

            min-height: 100vh;

        }


        .booking-wrapper {

            max-width: 900px;

            margin: 50px auto;

            padding: 20px;

        }


        .booking-card {

            background: #151b2b;

            border:
                1px solid #28324a;

            border-radius: 20px;

            overflow: hidden;

            box-shadow:
                0 20px 50px
                rgba(
                    0,
                    0,
                    0,
                    0.3
                );

        }


        /* =========================
           EVENT HEADER
        ========================= */

        .event-header {

            padding: 30px;

            background:
                linear-gradient(
                    135deg,
                    #18233b,
                    #101625
                );

        }


        .event-header h1 {

            font-size: 30px;

            margin-bottom: 10px;

        }


        .organization {

            color: #9ca8bd;

            font-size: 15px;

        }


        /* =========================
           CONTENT
        ========================= */

        .booking-content {

            padding: 30px;

        }


        .info-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    1fr
                );

            gap: 18px;

            margin-bottom: 25px;

        }


        .info-box {

            background: #0e1422;

            border:
                1px solid #26314a;

            border-radius: 12px;

            padding: 18px;

        }


        .info-box span {

            display: block;

            color: #8e9ab0;

            font-size: 13px;

            margin-bottom: 7px;

        }


        .info-box strong {

            font-size: 16px;

        }


        /* =========================
           NOTICE
        ========================= */

        .notice {

            background:
                rgba(
                    59,
                    130,
                    246,
                    0.10
                );

            border:
                1px solid
                rgba(
                    59,
                    130,
                    246,
                    0.30
                );

            padding: 15px;

            border-radius: 10px;

            color: #c9d8ff;

            margin-bottom: 25px;

            line-height: 1.6;

        }


        /* =========================
           ERROR
        ========================= */

        .error {

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.12
                );

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    0.35
                );

            color: #ffb4b4;

            padding: 14px;

            border-radius: 10px;

            margin-bottom: 20px;

        }


        /* =========================
           SINGLE TICKET
        ========================= */

        .ticket-section {

            margin-bottom: 25px;

        }


        .ticket-section label {

            display: block;

            margin-bottom: 10px;

            font-size: 15px;

            font-weight: 700;

        }


        .single-ticket-box {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            padding: 17px 18px;

            background: #0e1422;

            border:
                1px solid #28324a;

            border-radius: 12px;

        }


        .single-ticket-left {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .single-ticket-icon {

            width: 44px;

            height: 44px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background:
                rgba(
                    109,
                    93,
                    252,
                    0.15
                );

            font-size: 20px;

        }


        .single-ticket-title {

            font-size: 14px;

            font-weight: 700;

            margin-bottom: 3px;

        }


        .single-ticket-note {

            color: #8e9ab0;

            font-size: 11px;

        }


        .single-ticket-count {

            min-width: 55px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 0 13px;

            border-radius: 10px;

            background:
                #6d5dfc;

            color: #ffffff;

            font-size: 14px;

            font-weight: 800;

        }


        /* =========================
           TOTAL
        ========================= */

        .total-box {

            margin-top: 10px;

            margin-bottom: 25px;

            padding: 18px;

            background: #0e1422;

            border:
                1px solid #28324a;

            border-radius: 12px;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }


        .total-label {

            color: #9ca8bd;

            font-size: 14px;

        }


        .total-amount {

            color: #ffffff;

            font-size: 24px;

            font-weight: 800;

        }


        /* =========================
           ACTIONS
        ========================= */

        .actions {

            display: flex;

            gap: 15px;

            align-items: center;

        }


        .back-btn,
        .confirm-btn {

            text-decoration: none;

            border: none;

            padding:
                14px 24px;

            border-radius: 10px;

            font-size: 15px;

            font-weight: 600;

            cursor: pointer;

        }


        .back-btn {

            background: #252d40;

            color: #ffffff;

        }


        .back-btn:hover {

            background: #303a51;

        }


        .confirm-btn {

            background: #6d5dfc;

            color: white;

            transition: 0.2s;

            flex: 1;

        }


        .confirm-btn:hover {

            background: #5848eb;

            transform:
                translateY(-1px);

        }


        .confirm-btn:disabled {

            background: #555d70;

            cursor: not-allowed;

            transform: none;

        }


        /* =========================
           LIGHT THEME
        ========================= */

        html[data-theme="light"] body {

            background: #f5f7fb;

            color: #172033;

        }


        html[data-theme="light"]
        .booking-card {

            background: #ffffff;

            border-color: #e1e6ef;

            box-shadow:
                0 20px 50px
                rgba(
                    20,
                    30,
                    50,
                    0.08
                );

        }


        html[data-theme="light"]
        .event-header {

            background:
                linear-gradient(
                    135deg,
                    #f1efff,
                    #ffffff
                );

        }


        html[data-theme="light"]
        .event-header h1 {

            color: #172033;

        }


        html[data-theme="light"]
        .organization {

            color: #687386;

        }


        html[data-theme="light"]
        .booking-content {

            color: #172033;

        }


        html[data-theme="light"]
        .info-box {

            background: #f7f8fb;

            border-color: #e1e6ef;

        }


        html[data-theme="light"]
        .info-box span {

            color: #687386;

        }


        html[data-theme="light"]
        .info-box strong {

            color: #172033;

        }


        html[data-theme="light"]
        .notice {

            background: #f1efff;

            border-color: #d8d3ff;

            color: #5146a5;

        }


        html[data-theme="light"]
        .error {

            background: #fff1f1;

            border-color: #ffcaca;

            color: #c62828;

        }


        html[data-theme="light"]
        .single-ticket-box {

            background: #f7f8fb;

            border-color: #e1e6ef;

        }


        html[data-theme="light"]
        .single-ticket-note {

            color: #687386;

        }


        html[data-theme="light"]
        .total-box {

            background: #f7f8fb;

            border-color: #e1e6ef;

        }


        html[data-theme="light"]
        .total-label {

            color: #687386;

        }


        html[data-theme="light"]
        .total-amount {

            color: #172033;

        }


        html[data-theme="light"]
        .back-btn {

            background: #eef1f6;

            color: #172033;

        }


        html[data-theme="light"]
        .back-btn:hover {

            background: #e2e6ee;

        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 600px) {

            .booking-wrapper {

                margin:
                    20px auto;

                padding: 12px;

            }


            .event-header,
            .booking-content {

                padding: 22px;

            }


            .event-header h1 {

                font-size: 24px;

            }


            .info-grid {

                grid-template-columns:
                    1fr;

            }


            .actions {

                flex-direction: column;

            }


            .back-btn,
            .confirm-btn {

                width: 100%;

                text-align: center;

            }


            .total-box {

                align-items:
                    flex-start;

                gap: 10px;

                flex-direction:
                    column;

            }


            .single-ticket-box {

                align-items:
                    flex-start;

            }


            .single-ticket-count {

                width:
                    100%;

            }

        }

    </style>

</head>


<body>


    @include('layouts.navbar')


    <div class="booking-wrapper">


        <div class="booking-card">


            {{-- =========================
                 EVENT HEADER
            ========================= --}}

            <div class="event-header">

                <h1>
                    {{ $event->title }}
                </h1>


                <div class="organization">

                    Organized by
                    {{ $event->organization->name }}

                </div>

            </div>


            <div class="booking-content">


                {{-- =========================
                     ERROR
                ========================= --}}

                @if(session('error'))

                    <div class="error">

                        {{ session('error') }}

                    </div>

                @endif


                @if($errors->any())

                    <div class="error">

                        {{ $errors->first() }}

                    </div>

                @endif


                {{-- =========================
                     EVENT INFORMATION
                ========================= --}}

                <div class="info-grid">


                    <div class="info-box">

                        <span>
                            📅 Event Date
                        </span>


                        <strong>

                            {{
                                \Carbon\Carbon::parse(
                                    $event->event_date
                                )->format('d M Y')
                            }}

                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            ⏰ Event Time
                        </span>


                        <strong>

                            {{
                                $event->event_time

                                ? \Carbon\Carbon::parse(
                                    $event->event_time
                                )->format('h:i A')

                                : 'Not specified'
                            }}

                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            📍 Venue
                        </span>


                        <strong>

                            {{
                                $event->venue
                                ?? 'Not specified'
                            }}

                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            💰 Ticket Price
                        </span>


                        <strong>

                            @if(
                                $event->ticket_price > 0
                            )

                                ₹{{
                                    number_format(
                                        $event->ticket_price,
                                        2
                                    )
                                }}

                            @else

                                FREE

                            @endif

                        </strong>

                    </div>


                </div>


                {{-- =========================
                     REGISTRATION NOTICE
                ========================= --}}

                <div class="notice">

                    <strong>
                        Registration Information
                    </strong>

                    <br>

                    One registered Eventora account can book
                    only one ticket for this event.

                    Your ticket will be linked to your registered
                    account and email address.

                </div>


                {{-- =========================
                     BOOKING FORM
                ========================= --}}

                <form
                    action="{{ route(
                        'bookings.store',
                        $event->slug
                    ) }}"
                    method="POST"
                    id="bookingForm"
                >

                    @csrf


                    {{-- =========================
                         SINGLE TICKET
                    ========================= --}}

                    <div class="ticket-section">


                        <label>
                            🎟️ Ticket
                        </label>


                        <div class="single-ticket-box">


                            <div class="single-ticket-left">


                                <div class="single-ticket-icon">
                                    🎫
                                </div>


                                <div>


                                    <div class="single-ticket-title">
                                        Event Ticket
                                    </div>


                                    <div class="single-ticket-note">
                                        1 ticket per registered account
                                    </div>


                                </div>


                            </div>


                            <div class="single-ticket-count">
                                1 Ticket
                            </div>


                        </div>


                    </div>


                    {{-- =========================
                         HIDDEN QUANTITY
                    ========================= --}}

                    <input
                        type="hidden"
                        name="quantity"
                        value="1"
                    >


                    {{-- =========================
                         TOTAL
                    ========================= --}}

                    <div class="total-box">


                        <div class="total-label">
                            Total Amount
                        </div>


                        <div class="total-amount">


                            @if(
                                $event->ticket_price > 0
                            )

                                ₹{{
                                    number_format(
                                        $event->ticket_price,
                                        2
                                    )
                                }}

                            @else

                                FREE

                            @endif


                        </div>


                    </div>


                    {{-- =========================
                         ACTIONS
                    ========================= --}}

                    <div class="actions">


                        <a
                            href="{{ route(
                                'events.show',
                                $event->slug
                            ) }}"
                            class="back-btn"
                        >
                            ← Back to Event
                        </a>


                        <button
                            type="submit"
                            class="confirm-btn"
                            id="confirmButton"
                        >
                            Confirm Registration →
                        </button>


                    </div>


                </form>


            </div>


        </div>


    </div>


    @include('layouts.footer')


    <script>

        /*
        |--------------------------------------------------------------------------
        | Eventora Theme Support
        |--------------------------------------------------------------------------
        */

        const html =
            document.documentElement;


        const savedTheme =
            localStorage.getItem(
                'eventora-theme'
            ) || 'dark';


        html.setAttribute(
            'data-theme',
            savedTheme
        );


        /*
        |--------------------------------------------------------------------------
        | Prevent Multiple Form Submissions
        |--------------------------------------------------------------------------
        */

        const bookingForm =
            document.getElementById(
                'bookingForm'
            );


        const confirmButton =
            document.getElementById(
                'confirmButton'
            );


        if (bookingForm) {

            bookingForm.addEventListener(
                'submit',
                function () {

                    if (confirmButton) {

                        confirmButton.disabled =
                            true;

                        confirmButton.innerText =
                            'Processing...';

                    }

                }
            );

        }

    </script>


</body>

</html>