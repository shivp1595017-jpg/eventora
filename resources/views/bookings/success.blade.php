
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Successful - Eventora</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0b0f19;
            color: #fff;
            min-height: 100vh;
        }

        .success-wrapper {
            max-width: 650px;
            margin: 70px auto;
            padding: 20px;
        }

        .success-card {
            background: #151b2b;
            border: 1px solid #29344c;
            border-radius: 22px;
            padding: 45px 35px;
            text-align: center;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: rgba(34, 197, 94, 0.15);
            border: 2px solid #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        .success-card h1 {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .success-card > p {
            color: #aab5c8;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .booking-info {
            background: #0e1422;
            border: 1px solid #29344c;
            border-radius: 14px;
            padding: 20px;
            text-align: left;
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #222c40;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            color: #8f9bb0;
        }

        .value {
            color: #fff;
            font-weight: 600;
            text-align: right;
        }

        .confirmed {
            color: #22c55e;
        }

        .buttons {
            display: flex;
            gap: 12px;
            flex-direction: column;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.2s;
        }

        .ticket-btn {
            background: #6d5dfc;
            color: #fff;
        }

        .ticket-btn:hover {
            background: #5848eb;
            transform: translateY(-1px);
        }

        .bookings-btn {
            border: 1px solid #35415b;
            color: #cbd4e4;
        }

        .bookings-btn:hover {
            border-color: #6d5dfc;
            color: #fff;
        }

        @media (max-width: 600px) {
            .success-wrapper {
                margin: 25px auto;
                padding: 12px;
            }

            .success-card {
                padding: 35px 20px;
            }

            .success-card h1 {
                font-size: 26px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .value {
                text-align: left;
            }
        }

        /* Light Theme */

        html[data-theme="light"] body {
            background: #f5f7fb;
            color: #172033;
        }

        html[data-theme="light"] .success-card {
            background: #ffffff;
            border-color: #e1e6ef;
            box-shadow: 0 20px 50px rgba(20, 30, 50, 0.08);
        }

        html[data-theme="light"] .success-card h1 {
            color: #172033;
        }

        html[data-theme="light"] .success-card > p {
            color: #687386;
        }

        html[data-theme="light"] .booking-info {
            background: #f7f8fb;
            border-color: #e1e6ef;
        }

        html[data-theme="light"] .info-row {
            border-color: #e1e6ef;
        }

        html[data-theme="light"] .label {
            color: #687386;
        }

        html[data-theme="light"] .value {
            color: #172033;
        }

        html[data-theme="light"] .bookings-btn {
            color: #687386;
            border-color: #d9deea;
        }

        html[data-theme="light"] .bookings-btn:hover {
            color: #5848eb;
        }
    </style>
</head>

<body>

@include('layouts.navbar')

<div class="success-wrapper">

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <h1>Payment Successful!</h1>

        <p>
            Your event registration has been successfully confirmed.
            We look forward to seeing you at the event.
        </p>

        <div class="booking-info">

            <div class="info-row">
                <span class="label">Event</span>
                <span class="value">
                    {{ $booking->event->title }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Booking Number</span>
                <span class="value">
                    {{ $booking->booking_number }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Payment ID</span>
                <span class="value">
                    {{ $booking->payment_id }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Amount Paid</span>
                <span class="value">
                    ₹{{ number_format($booking->total_amount, 2) }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Status</span>
                <span class="value confirmed">
                    ✓ Confirmed
                </span>
            </div>

        </div>

        <div class="buttons">

            <a
                href="{{ route('bookings.ticket', $booking->id) }}"
                class="btn ticket-btn"
            >
                🎟 View Ticket
            </a>

            <a
                href="{{ route('bookings.index') }}"
                class="btn bookings-btn"
            >
                View My Bookings
            </a>

        </div>

    </div>

</div>

@include('layouts.footer')

</body>
</html>

