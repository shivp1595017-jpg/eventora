<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Ticket Verification - Eventora
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
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


        a {
            text-decoration: none;
            color: inherit;
        }


        /* =========================================
           MAIN
        ========================================= */

        .admin-main {

            margin-left: 260px;

            min-height: 100vh;

            padding: 30px;
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

            box-shadow:
                0 5px 20px rgba(0,0,0,.05);
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
           HEADER
        ========================================= */

        .page-header {

            margin-bottom: 25px;
        }


        .page-header h1 {

            margin: 0 0 7px;

            font-size: 30px;
        }


        .page-header p {

            margin: 0;

            color: #667085;

            font-size: 14px;
        }


        /* =========================================
           VERIFICATION CARD
        ========================================= */

        .verify-card {

            background: white;

            border-radius: 22px;

            padding: 28px;

            margin-bottom: 25px;

            box-shadow:
                0 10px 30px rgba(0,0,0,.06);
        }


        .verify-card h2 {

            margin: 0 0 8px;

            font-size: 21px;
        }


        .verify-card > p {

            margin: 0 0 20px;

            color: #667085;
        }


        /* =========================================
           SEARCH
        ========================================= */

        .search-wrapper {

            position: relative;
        }


        .search-box {

            width: 100%;

            height: 50px;

            padding:
                0 18px 0 45px;

            border:
                1px solid #d9deea;

            border-radius: 13px;

            font-size: 14px;

            outline: none;

            background: white;
        }


        .search-box:focus {

            border-color: #6366f1;

            box-shadow:
                0 0 0 3px
                rgba(99,102,241,.10);
        }


        .search-icon {

            position: absolute;

            left: 16px;

            top: 50%;

            transform:
                translateY(-50%);

            font-size: 18px;

            color: #667085;

            pointer-events: none;
        }


        /* =========================================
           LIVE SEARCH RESULTS
        ========================================= */

        .search-results {

            display: none;

            margin-top: 10px;

            border:
                1px solid #e4e7ec;

            border-radius: 14px;

            overflow: hidden;

            background: white;

            box-shadow:
                0 12px 30px rgba(0,0,0,.08);
        }


        .search-result-item {

            display: block;

            width: 100%;

            text-align: left;

            border: none;

            background: white;

            padding: 15px 16px;

            cursor: pointer;

            border-bottom:
                1px solid #edf0f5;
        }


        .search-result-item:last-child {

            border-bottom: none;
        }


        .search-result-item:hover {

            background: #f8f9ff;
        }


        .result-booking-number {

            font-weight: 700;

            color: #4f46e5;

            font-size: 14px;

            margin-bottom: 5px;
        }


        .result-participant {

            font-weight: 700;

            font-size: 14px;

            color: #172033;
        }


        .result-event {

            margin-top: 3px;

            font-size: 13px;

            color: #667085;
        }


        .search-empty {

            padding: 18px;

            text-align: center;

            color: #667085;

            font-size: 14px;
        }


        /* =========================================
           SCAN BUTTON
        ========================================= */

        .scan-button {

            width: 100%;

            height: 52px;

            margin-top: 16px;

            border: none;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #4f46e5
                );

            color: white;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }


        .scan-button:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 10px 25px
                rgba(79,70,229,.20);
        }


        /* =========================================
           RESULT
        ========================================= */

        .result-card {

            background: white;

            border-radius: 22px;

            padding: 30px;

            box-shadow:
                0 10px 30px rgba(0,0,0,.06);
        }


        .result-header {

            display: flex;

            align-items: center;

            gap: 16px;

            margin-bottom: 25px;

            padding-bottom: 20px;

            border-bottom:
                1px solid #edf0f5;
        }


        .result-icon {

            width: 58px;
            height: 58px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-size: 27px;
            font-weight: 700;
        }


        .valid .result-icon {

            background: #dcfce7;

            color: #15803d;
        }


        .invalid .result-icon {

            background: #fee2e2;

            color: #dc2626;
        }


        .result-header h2 {

            margin: 0 0 5px;

            font-size: 24px;
        }


        .result-header p {

            margin: 0;

            color: #667085;

            font-size: 14px;
        }


        /* =========================================
           DETAILS
        ========================================= */

        .details-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 15px;
        }


        .detail-item {

            background: #f8f9fc;

            border:
                1px solid #edf0f5;

            border-radius: 14px;

            padding: 17px;
        }


        .detail-item small {

            display: block;

            color: #7a8498;

            font-size: 12px;

            margin-bottom: 6px;
        }


        .detail-item strong {

            display: block;

            color: #172033;

            font-size: 14px;

            word-break: break-word;
        }


        /* =========================================
           STATUS
        ========================================= */

        .status-badge {

            display: inline-flex;

            align-items: center;

            padding:
                6px 11px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 700;
        }


        .status-paid {

            background: #dcfce7;

            color: #15803d;
        }


        .status-confirmed {

            background: #dbeafe;

            color: #1d4ed8;
        }


        .invalid-message {

            background: #fff1f2;

            border:
                1px solid #fecdd3;

            color: #be123c;

            border-radius: 14px;

            padding: 18px;

            font-weight: 600;

            line-height: 1.6;
        }


        /* =========================================
           SCANNER MODAL
        ========================================= */

        .scanner-modal {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(0,0,0,.78);

            z-index: 9999;

            align-items: center;

            justify-content: center;

            padding: 20px;
        }


        .scanner-modal.show {

            display: flex;
        }


        .scanner-box {

            width: 100%;

            max-width: 560px;

            background: white;

            border-radius: 22px;

            padding: 20px;

            position: relative;
        }


        .scanner-top {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 15px;
        }


        .scanner-top h2 {

            margin: 0;

            font-size: 20px;
        }


        .close-scanner {

            width: 38px;
            height: 38px;

            border: none;

            border-radius: 10px;

            background: #fee2e2;

            color: #dc2626;

            font-size: 19px;

            cursor: pointer;
        }


        #qr-reader {

            width: 100%;

            max-width: 500px;

            margin: auto;

            overflow: hidden;

            border-radius: 14px;
        }


        #scan-status {

            text-align: center;

            margin-top: 12px;

            color: #667085;

            font-size: 14px;
        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 768px) {

            .admin-main {

                margin-left: 0;

                padding: 15px;
            }


            .mobile-header {

                display: flex;
            }


            .page-header h1 {

                font-size: 24px;
            }


            .verify-card,
            .result-card {

                padding: 20px;

                border-radius: 18px;
            }


            .details-grid {

                grid-template-columns: 1fr;
            }


            .result-header {

                align-items: flex-start;
            }

        }

    </style>

</head>


<body>


    @include('organization_admin.sidebar')


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


        {{-- PAGE HEADER --}}

        <div class="page-header">

            <h1>
                🎟️ Ticket Verification
            </h1>

            <p>
                Search for a ticket or scan its QR code.
            </p>

        </div>


        {{-- =========================================
             SEARCH + SCAN
        ========================================= --}}

        <div class="verify-card">

            <h2>
                🔎 Search Ticket
            </h2>

            <p>
                Start typing booking number, participant name,
                email or event name.
            </p>


            <div class="search-wrapper">

                <div class="search-icon">
                    🔎
                </div>


                <input
                    type="text"
                    id="liveSearch"
                    class="search-box"
                    placeholder="Search booking number..."
                    autocomplete="off"
                >


                <div
                    id="searchResults"
                    class="search-results"
                ></div>

            </div>


            <button
                type="button"
                id="openScannerBtn"
                class="scan-button"
            >
                📷 Scan QR Code
            </button>

        </div>


        {{-- =========================================
             VERIFIED RESULT
        ========================================= --}}

        @if(isset($booking) && $booking)

            <div
                class="
                    result-card
                    {{ $isValid ? 'valid' : 'invalid' }}
                "
            >

                <div class="result-header">

                    <div class="result-icon">

                        @if($isValid)
                            ✓
                        @else
                            ✕
                        @endif

                    </div>


                    <div>

                        <h2>

                            @if($isValid)
                                Valid Ticket
                            @else
                                Invalid Ticket
                            @endif

                        </h2>


                        <p>
                            {{ $message }}
                        </p>

                    </div>

                </div>


                @if($isValid)

                    <div class="details-grid">


                        <div class="detail-item">

                            <small>
                                Booking Number
                            </small>

                            <strong>
                                {{ $booking->booking_number }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Participant
                            </small>

                            <div style="display:flex;align-items:center;gap:12px">
                                <div style="position:relative;display:grid;width:58px;height:58px;flex:0 0 58px;place-items:center;overflow:hidden;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:20px;font-weight:800">
                                    <span>{{ strtoupper(substr($booking->user?->name ?? 'N', 0, 1)) }}</span>
                                    @if($booking->user?->profilePhotoUrl())
                                        <img src="{{ $booking->user->profilePhotoUrl() }}" alt="" aria-hidden="true" style="position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover" referrerpolicy="no-referrer" onerror="this.remove()">
                                    @endif
                                </div>
                                <strong>{{ $booking->user?->name ?? 'N/A' }}</strong>
                            </div>

                        </div>


                        <div class="detail-item">

                            <small>
                                Email
                            </small>

                            <strong>
                                {{ $booking->user->email ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Event
                            </small>

                            <strong>
                                {{ $booking->event->title ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Tickets
                            </small>

                            <strong>
                                {{ $booking->quantity }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Amount
                            </small>

                            <strong>
                                ₹{{ number_format($booking->total_amount, 2) }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Payment Status
                            </small>

                            <strong>

                                <span
                                    class="
                                        status-badge
                                        status-paid
                                    "
                                >
                                    ✓ Paid
                                </span>

                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Booking Status
                            </small>

                            <strong>

                                <span
                                    class="
                                        status-badge
                                        status-confirmed
                                    "
                                >
                                    ✓ Confirmed
                                </span>

                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Event Date
                            </small>

                            <strong>
                                {{
                                    \Carbon\Carbon::parse(
                                        $booking->event->event_date
                                    )->format('d M Y')
                                }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <small>
                                Venue
                            </small>

                            <strong>
                                {{ $booking->event->venue ?? 'N/A' }}
                            </strong>

                        </div>

                    </div>

                @else

                    <div class="invalid-message">

                        {{ $message }}

                    </div>

                @endif

            </div>


        @elseif(isset($message) && $message)

            <div class="result-card invalid">

                <div class="result-header">

                    <div class="result-icon">
                        ✕
                    </div>


                    <div>

                        <h2>
                            Invalid Ticket
                        </h2>

                        <p>
                            Ticket verification failed.
                        </p>

                    </div>

                </div>


                <div class="invalid-message">

                    {{ $message }}

                </div>

            </div>

        @endif


    </main>


    {{-- =========================================
         SCANNER MODAL
    ========================================= --}}

    <div
        id="scannerModal"
        class="scanner-modal"
    >

        <div class="scanner-box">


            <div class="scanner-top">

                <h2>
                    📷 Scan QR Code
                </h2>


                <button
                    type="button"
                    id="closeScannerBtn"
                    class="close-scanner"
                >
                    ✕
                </button>

            </div>


            <div id="qr-reader"></div>


            <div id="scan-status">

                Point the camera at the ticket QR code.

            </div>

        </div>

    </div>


    <script src="https://unpkg.com/html5-qrcode"></script>


    <script>

        /* =========================================
           LIVE SEARCH
        ========================================= */

        const liveSearch =
            document.getElementById('liveSearch');

        const searchResults =
            document.getElementById('searchResults');


        let searchTimer = null;


        liveSearch.addEventListener(
            'input',
            function () {

                const query =
                    this.value.trim();


                clearTimeout(searchTimer);


                if (query.length < 2) {

                    searchResults.style.display =
                        'none';

                    searchResults.innerHTML =
                        '';

                    return;
                }


                searchTimer =
                    setTimeout(
                        function () {

                            performLiveSearch(query);

                        },
                        300
                    );

            }
        );


        async function performLiveSearch(query)
        {

            searchResults.style.display =
                'block';

            searchResults.innerHTML =

                '<div class="search-empty">' +
                'Searching...' +
                '</div>';


            try {

                const response =
                    await fetch(
                        "{{ route('organization.admin.ticket.search') }}" +
                        "?q=" +
                        encodeURIComponent(query),
                        {
                            headers: {
                                'Accept':
                                    'application/json'
                            }
                        }
                    );


                const results =
                    await response.json();


                if (
                    !Array.isArray(results) ||
                    results.length === 0
                ) {

                    searchResults.innerHTML =

                        '<div class="search-empty">' +
                        'No matching ticket found.' +
                        '</div>';

                    return;
                }


                searchResults.innerHTML =
                    results
                        .map(function (item) {

                            return `

                                <button
                                    type="button"
                                    class="search-result-item"
                                    onclick="openTicket('${escapeHtml(item.booking_number)}')"
                                >

                                    <div class="result-booking-number">
                                        ${escapeHtml(item.booking_number)}
                                    </div>

                                    <div class="result-participant">
                                        👤 ${escapeHtml(item.participant)}
                                    </div>

                                    <div class="result-event">
                                        🎫 ${escapeHtml(item.event)}
                                    </div>

                                </button>

                            `;

                        })
                        .join('');

            }

            catch (error) {

                searchResults.innerHTML =

                    '<div class="search-empty">' +
                    'Unable to search right now.' +
                    '</div>';

            }

        }


        function escapeHtml(value)
        {

            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;

        }


        function openTicket(bookingNumber)
        {

            window.location.href =
                "{{ url('/organization-admin/ticket-verification') }}/" +
                encodeURIComponent(bookingNumber);

        }


        /* =========================================
           CLOSE SEARCH WHEN CLICKING OUTSIDE
        ========================================= */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    !event.target.closest(
                        '.search-wrapper'
                    )
                ) {

                    searchResults.style.display =
                        'none';

                }

            }
        );


        /* =========================================
           QR SCANNER
        ========================================= */

        const scannerModal =
            document.getElementById('scannerModal');

        const openScannerBtn =
            document.getElementById('openScannerBtn');

        const closeScannerBtn =
            document.getElementById('closeScannerBtn');

        const scanStatus =
            document.getElementById('scan-status');


        let qrScanner = null;

        let scannerRunning = false;
        let scannerStartPromise = null;
        let scannerCancelled = false;


        openScannerBtn.addEventListener(
            'click',
            function () {

                scannerModal.classList.add(
                    'show'
                );

                startScanner();

            }
        );


        closeScannerBtn.addEventListener(
            'click',
            function () {

                stopScanner();

            }
        );


        scannerModal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === scannerModal
                ) {

                    stopScanner();

                }

            }
        );


        function startScanner()
        {

            if (scannerRunning || scannerStartPromise) {
                return;
            }

            if (typeof Html5Qrcode === 'undefined') {
                scanStatus.textContent = 'QR scanner could not load. Please search by booking number.';
                return;
            }

            scannerCancelled = false;


            qrScanner =
                new Html5Qrcode(
                    "qr-reader"
                );


            const config = {

                fps: 10,

                qrbox: {
                    width: 250,
                    height: 250
                }

            };


            const activeScanner = qrScanner;
            scannerStartPromise = activeScanner.start(

                {
                    facingMode:
                        "environment"
                },

                config,

                function (decodedText) {

                    scanStatus.innerHTML =
                        '✅ QR detected. Verifying ticket...';


                    let bookingNumber =
                        decodedText.trim();


                    /*
                     * Support both:
                     *
                     * EVT-XXXXXXXXXX
                     *
                     * and full URLs
                     */

                    if (
                        bookingNumber.includes('/')
                    ) {

                        bookingNumber =
                            bookingNumber
                                .split('/')
                                .filter(Boolean)
                                .pop();

                    }


                    stopScanner(false);


                    window.location.href =
                        "{{ url('/organization-admin/ticket-verification') }}/" +
                        encodeURIComponent(
                            bookingNumber
                        );

                },

                function () {

                    // Normal scanning errors ignored.

                }

            )

            .then(function () {

                scannerRunning = true;
                scannerStartPromise = null;

            })

            .catch(function () {

                scannerRunning = false;
                scannerStartPromise = null;

                if (!scannerCancelled) {
                    scanStatus.textContent =
                        '❌ Camera access failed. Please allow camera permission.';
                }

            });

        }


        async function stopScanner(
            hideModal = true
        )
        {

            scannerCancelled = true;

            const activeScanner = qrScanner;
            const pendingStart = scannerStartPromise;

            if (hideModal) {
                scannerModal.classList.remove('show');
            }

            if (pendingStart) {
                try {
                    await pendingStart;
                } catch (error) {
                    // Camera start can reject when permission is denied.
                }
            }

            if (
                activeScanner
            ) {

                try {
                    await activeScanner.stop();
                } catch (error) {
                    // The camera may already be stopped or start may have failed.
                }

                try {
                    activeScanner.clear();
                } catch (error) {
                    // The scanner has no rendered reader to clear after a failed start.
                }

            }

            scannerRunning = false;
            scannerStartPromise = null;
            if (qrScanner === activeScanner) qrScanner = null;

        }

    </script>


</body>

</html>
