<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment - Eventora</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #070b14;
            --card: #0e1524;
            --card2: #111b2d;
            --text: #ffffff;
            --muted: #94a0b5;
            --border: #202b40;
            --primary: #6c63ff;
            --primary2: #8b5cf6;
            --success: #22c55e;
            --danger: #ef4444;
        }

        html[data-theme="light"] {
            --bg: #f5f7fb;
            --card: #ffffff;
            --card2: #f8faff;
            --text: #111827;
            --muted: #64748b;
            --border: #dce2ec;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .payment-wrapper {
            width: min(850px, 92%);
            margin: 45px auto 70px;
        }

        .payment-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
        }

        .payment-header {
            padding: 32px;
            background:
                radial-gradient(
                    circle at 85% 20%,
                    rgba(139, 92, 246, .20),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #18233b,
                    #101625
                );
        }

        .payment-header h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .payment-header p {
            color: #9ca8bd;
            font-size: 14px;
        }

        .payment-content {
            padding: 32px;
        }

        .error-message {
            margin-bottom: 22px;
            padding: 14px 16px;
            border-radius: 12px;
            background: rgba(239, 68, 68, .10);
            border: 1px solid rgba(239, 68, 68, .25);
            color: #fca5a5;
            font-size: 14px;
        }

        .event-info {
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            margin-bottom: 24px;
        }

        .event-info h2 {
            margin-bottom: 13px;
            font-size: 22px;
            line-height: 1.3;
        }

        .event-info p {
            color: var(--muted);
            margin: 8px 0;
            font-size: 14px;
        }

        .amount-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            background: var(--card2);
            border: 1px solid var(--border);
            padding: 21px;
            border-radius: 13px;
            margin-bottom: 22px;
        }

        .amount-label {
            color: var(--muted);
            font-size: 14px;
        }

        .amount {
            font-size: 28px;
            font-weight: 800;
        }

        .payment-note {
            padding: 16px;
            border-radius: 12px;
            background: rgba(109, 93, 252, .10);
            border: 1px solid rgba(109, 93, 252, .25);
            color: #cbd4ff;
            line-height: 1.7;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .payment-note strong {
            color: var(--text);
        }

        .pay-btn {
            width: 100%;
            min-height: 54px;
            border: none;
            padding: 15px 20px;
            border-radius: 12px;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary2)
            );
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: .25s;
        }

        .pay-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow:
                0 10px 25px rgba(108, 99, 255, .25);
        }

        .pay-btn:disabled {
            cursor: not-allowed;
            opacity: .75;
            transform: none;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: var(--muted);
            font-size: 14px;
        }

        .back:hover {
            color: var(--primary);
        }

        .secure-note {
            text-align: center;
            color: var(--muted);
            font-size: 12px;
            margin-top: 16px;
        }

        .loader {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,.35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .8s linear infinite;
            margin: 0 auto;
        }

        .pay-btn.loading .button-text {
            display: none;
        }

        .pay-btn.loading .loader {
            display: block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 600px) {
            .payment-wrapper {
                width: 94%;
                margin: 20px auto 45px;
            }

            .payment-header,
            .payment-content {
                padding: 22px;
            }

            .payment-header h1 {
                font-size: 25px;
            }

            .amount-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .amount {
                font-size: 25px;
            }
        }

        /* LIGHT MODE */

        html[data-theme="light"] .payment-card {
            box-shadow:
                0 20px 50px rgba(20, 30, 50, .08);
        }

        html[data-theme="light"] .payment-header {
            background:
                radial-gradient(
                    circle at 85% 20%,
                    rgba(139, 92, 246, .10),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #f1efff,
                    #ffffff
                );
        }

        html[data-theme="light"] .payment-header h1 {
            color: #172033;
        }

        html[data-theme="light"] .payment-header p {
            color: #687386;
        }

        html[data-theme="light"] .event-info,
        html[data-theme="light"] .amount-box {
            background: #f7f8fb;
            border-color: #e1e6ef;
        }

        html[data-theme="light"] .event-info h2 {
            color: #172033;
        }

        html[data-theme="light"] .payment-note {
            background: #f1efff;
            border-color: #d8d3ff;
            color: #5146a5;
        }

        html[data-theme="light"] .payment-note strong {
            color: #172033;
        }

        html[data-theme="light"] .amount {
            color: #172033;
        }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <main class="payment-wrapper">

        <div class="payment-card">

            <div class="payment-header">

                <h1>
                    Complete Your Payment
                </h1>

                <p>
                    Secure your Eventora event registration.
                </p>

            </div>

            <div class="payment-content">

                {{-- ERROR --}}
                @if(session('error'))

                    <div class="error-message">
                        {{ session('error') }}
                    </div>

                @endif

                {{-- EVENT --}}
                <div class="event-info">

                    <h2>
                        {{ $booking->event->title }}
                    </h2>

                    <p>
                        🏢
                        {{ $booking->event->organization->name }}
                    </p>

                    @if($booking->event->event_date)

                        <p>
                            📅
                            {{
                                \Carbon\Carbon::parse(
                                    $booking->event->event_date
                                )->format('d M Y')
                            }}
                        </p>

                    @endif

                    @if($booking->event->event_time)

                        <p>
                            ⏰
                            {{
                                \Carbon\Carbon::parse(
                                    $booking->event->event_time
                                )->format('h:i A')
                            }}
                        </p>

                    @endif

                    @if($booking->event->venue)

                        <p>
                            📍
                            {{ $booking->event->venue }}
                        </p>

                    @endif

                    @if($booking->event->city)

                        <p>
                            🌍
                            {{ $booking->event->city }}
                        </p>

                    @endif

                </div>

                {{-- AMOUNT --}}
                <div class="amount-box">

                    <div class="amount-label">
                        Total Amount
                    </div>

                    <div class="amount">
                        ₹{{ number_format($booking->total_amount, 2) }}
                    </div>

                </div>

                {{-- BOOKING NOTE --}}
                <div class="payment-note">

                    <strong>
                        Booking Number:
                    </strong>

                    {{ $booking->booking_number }}

                    <br><br>

                    <strong>
                        Ticket:
                    </strong>

                    1 Ticket

                    <br><br>

                    Your registration is currently pending.
                    Complete the payment to confirm your participation.

                </div>

                {{-- PAY BUTTON --}}
                <button
                    type="button"
                    id="payButton"
                    class="pay-btn"
                >

                    <span class="button-text">
                        Pay ₹{{ number_format($booking->total_amount, 2) }}
                    </span>

                    <span class="loader"></span>

                </button>

                <div class="secure-note">
                    🔒 Secure payment powered by Razorpay
                </div>

                <a
                    href="{{ route('events.show', $booking->event->slug) }}"
                    class="back"
                >
                    ← Back to Event
                </a>

            </div>

        </div>

    </main>

    @include('layouts.footer')

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const payButton =
                document.getElementById('payButton');

            if (!payButton) {
                return;
            }

            let paymentOpened = false;

            payButton.addEventListener('click', function () {

                if (paymentOpened) {
                    return;
                }

                if (
                    typeof Razorpay === 'undefined'
                ) {
                    alert(
                        'Payment service is currently unavailable. Please try again.'
                    );

                    return;
                }

                paymentOpened = true;

                payButton.disabled = true;
                payButton.classList.add('loading');

                const options = {

                    key: @json(config('services.razorpay.key')),

                    amount: {{ (int) round($booking->total_amount * 100) }},

                    currency: 'INR',

                    name: 'Eventora',

                    description:
                        @json($booking->event->title),

                    order_id:
                        @json($order['id']),

                    prefill: {

                        name:
                            @json(auth()->user()->name),

                        email:
                            @json(auth()->user()->email),

                        contact:
                            @json(auth()->user()->mobile ?? '')

                    },

                    theme: {
                        color: '#6c63ff'
                    },

                    handler: function (response) {

                        const successUrl =
                            @json(
                                route(
                                    'bookings.payment.success',
                                    $booking->id
                                )
                            );

                        const params =
                            new URLSearchParams();

                        params.append(
                            'payment_id',
                            response.razorpay_payment_id
                        );

                        params.append(
                            'razorpay_order_id',
                            response.razorpay_order_id
                        );

                        params.append(
                            'razorpay_signature',
                            response.razorpay_signature
                        );

                        window.location.href =
                            successUrl + '?' + params.toString();
                    },

                    modal: {

                        ondismiss: function () {

                            paymentOpened = false;

                            payButton.disabled = false;
                            payButton.classList.remove(
                                'loading'
                            );

                        }

                    }
                };

                try {

                    const razorpay =
                        new Razorpay(options);

                    razorpay.on(
                        'payment.failed',
                        function () {

                            paymentOpened = false;

                            payButton.disabled = false;
                            payButton.classList.remove(
                                'loading'
                            );

                            alert(
                                'Payment failed. Please try again.'
                            );

                        }
                    );

                    razorpay.open();

                } catch (error) {

                    paymentOpened = false;

                    payButton.disabled = false;
                    payButton.classList.remove(
                        'loading'
                    );

                    alert(
                        'Unable to open payment gateway. Please try again.'
                    );

                    console.error(error);
                }

            });

        });
    </script>

    <script>
        const html = document.documentElement;

        const savedTheme =
            localStorage.getItem('eventora-theme') || 'dark';

        html.setAttribute(
            'data-theme',
            savedTheme
        );
    </script>

</body>

</html>