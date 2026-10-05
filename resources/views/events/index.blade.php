@include('layouts.navbar')

<style>
    body { margin: 0; font-family: Arial, Helvetica, sans-serif; }

    /* =====================================================
       PAGE
    ====================================================== */

    .events-page {
        min-height: 100vh;

        padding:
            50px 20px 80px;

        background:
            #f7f8fc;
    }


    .events-container {
        max-width: 1200px;

        margin:
            auto;
    }


    /* =====================================================
       HEADER
    ====================================================== */

    .events-header {
        text-align: center;

        margin-bottom:
            35px;
    }


    .events-header h1 {
        font-size:
            42px;

        font-weight:
            800;

        color:
            #111827;

        margin-bottom:
            10px;
    }


    .events-header p {
        color:
            #6b7280;

        font-size:
            16px;
    }


    /* =====================================================
       FILTER BOX
    ====================================================== */

    .filter-box {
        background:
            #ffffff;

        border-radius:
            18px;

        padding:
            22px;

        margin-bottom:
            35px;

        box-shadow:
            0 8px 30px
            rgba(
                0,
                0,
                0,
                .06
            );
    }


    .filter-form {
        display:
            grid;

        grid-template-columns:
            2fr 1fr 1fr 180px auto;

        gap:
            10px;

        align-items:
            center;
    }


    .filter-input,
    .filter-select,
    .filter-date {
        width:
            100%;

        min-height:
            48px;

        padding:
            0 14px;

        border:
            1px solid #e5e7eb;

        border-radius:
            11px;

        background:
            #fff;

        color:
            #111827;

        font-size:
            14px;

        outline:
            none;

        transition:
            .2s;
    }


    .filter-input:focus,
    .filter-select:focus,
    .filter-date:focus {
        border-color:
            #6366f1;

        box-shadow:
            0 0 0 3px
            rgba(
                99,
                102,
                241,
                .10
            );
    }


    .filter-input::placeholder {
        color:
            #8b95a7;
    }


    .filter-select,
    .filter-date {
        cursor:
            pointer;
    }


    /* =====================================================
       FILTER BUTTON
    ====================================================== */

    .search-btn {
        min-height:
            48px;

        border:
            none;

        border-radius:
            11px;

        padding:
            0 17px;

        background:
            #111827;

        color:
            white;

        font-weight:
            700;

        cursor:
            pointer;

        transition:
            .2s;

        white-space:
            nowrap;
    }


    .search-btn:hover {
        background:
            #4f46e5;

        transform:
            translateY(-1px);
    }


    .clear-btn {
        min-height:
            48px;

        border:
            1px solid #d9dee8;

        border-radius:
            11px;

        padding:
            0 14px;

        background:
            #f8fafc;

        color:
            #475467;

        font-size:
            13px;

        font-weight:
            700;

        cursor:
            pointer;

        transition:
            .2s;

        white-space:
            nowrap;
    }


    .clear-btn:hover {
        border-color:
            #6366f1;

        color:
            #4f46e5;

        background:
            #f5f3ff;
    }


    /* =====================================================
       LIVE SEARCH STATUS
    ====================================================== */

    .live-search-status {
        display:
            none;

        align-items:
            center;

        justify-content:
            center;

        gap:
            8px;

        margin-top:
            14px;

        color:
            #6366f1;

        font-size:
            12px;

        font-weight:
            700;
    }


    .search-loader {
        width:
            16px;

        height:
            16px;

        border:
            2px solid #ddd9ff;

        border-top-color:
            #6366f1;

        border-radius:
            50%;

        animation:
            searchSpin .7s
            linear infinite;
    }


    @keyframes searchSpin {

        to {
            transform:
                rotate(
                    360deg
                );
        }

    }


    /* =====================================================
       ACTIVE FILTER INFO
    ====================================================== */

    .filter-summary {
        display:
            none;

        margin-top:
            13px;

        color:
            #667085;

        font-size:
            12px;

        text-align:
            center;
    }


    /* =====================================================
       EVENTS GRID
    ====================================================== */

    .events-grid {
        display:
            grid;

        grid-template-columns:
            repeat(
                3,
                1fr
            );

        gap:
            24px;
    }


    .event-card {
        background:
            #fff;

        border-radius:
            18px;

        overflow:
            hidden;

        box-shadow:
            0 8px 30px
            rgba(
                0,
                0,
                0,
                .06
            );

        transition:
            .25s ease;
    }


    .event-card:hover {
        transform:
            translateY(-6px);

        box-shadow:
            0 16px 40px
            rgba(
                0,
                0,
                0,
                .10
            );
    }


    /* =====================================================
       EVENT IMAGE
    ====================================================== */

    .event-image {
        height:
            210px;

        background: #eef0f7;

        background:
            linear-gradient(
                135deg,
                #6366f1,
                #8b5cf6
            );

        position:
            relative;

        overflow:
            hidden;
    }


    .event-image img {
        width:
            100%;

        height:
            100%;

        object-fit:
            contain;

        object-position: center;

        display: block;
    }


    .event-placeholder {
        width:
            100%;

        height:
            100%;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        color:
            white;

        font-size:
            42px;

        font-weight:
            800;
    }


    .category-badge {
        position:
            absolute;

        top:
            14px;

        left:
            14px;

        background:
            rgba(
                255,
                255,
                255,
                .95
            );

        color:
            #111827;

        padding:
            7px 12px;

        border-radius:
            30px;

        font-size:
            12px;

        font-weight:
            700;
    }


    /* =====================================================
       CONTENT
    ====================================================== */

    .event-content {
        padding:
            20px;
    }


    .event-content h3 {
        margin:
            0 0 10px;

        font-size:
            20px;

        line-height:
            1.35;

        color:
            #111827;
    }


    .organization {
        color:
            #6366f1;

        font-size:
            14px;

        font-weight:
            700;

        margin-bottom:
            15px;
    }


    .event-info {
        display:
            flex;

        flex-direction:
            column;

        gap:
            9px;

        margin-bottom:
            18px;

        color:
            #6b7280;

        font-size:
            14px;
    }


    .event-info span {
        display:
            flex;

        align-items:
            center;

        gap:
            8px;
    }


    /* =====================================================
       SEATS
    ====================================================== */

    .seat-info {
        margin-bottom:
            17px;

        padding:
            9px 11px;

        border-radius:
            9px;

        background:
            #f5f3ff;

        color:
            #5b4df7;

        font-size:
            12px;

        font-weight:
            700;
    }


    .sold-out {
        background:
            #fff1f1;

        color:
            #c62828;
    }


    /* =====================================================
       FOOTER
    ====================================================== */

    .event-footer {
        display:
            flex;

        justify-content:
            space-between;

        align-items:
            center;

        gap:
            12px;
    }


    .price {
        font-size:
            17px;

        font-weight:
            800;

        color:
            #111827;
    }


    .view-btn {
        display:
            inline-block;

        padding:
            10px 15px;

        border-radius:
            10px;

        background:
            #111827;

        color:
            white;

        text-decoration:
            none;

        font-size:
            13px;

        font-weight:
            700;

        transition:
            .2s;
    }


    .view-btn:hover {
        background:
            #4f46e5;
    }


    /* =====================================================
       EMPTY
    ====================================================== */

    .empty-state {
        grid-column:
            1 / -1;

        background:
            #fff;

        padding:
            70px 20px;

        text-align:
            center;

        border-radius:
            18px;

        box-shadow:
            0 8px 30px
            rgba(
                0,
                0,
                0,
                .05
            );
    }


    .empty-state .icon {
        font-size:
            50px;

        margin-bottom:
            15px;
    }


    .empty-state h3 {
        color:
            #111827;

        margin-bottom:
            8px;
    }


    .empty-state p {
        color:
            #6b7280;

        margin:
            0;
    }


    /* =====================================================
       PAGINATION
    ====================================================== */

    .pagination-wrapper {
        margin-top:
            40px;

        display:
            flex;

        justify-content:
            center;
    }


    .pagination-wrapper nav {
        display:
            flex;

        justify-content:
            center;
    }


    .pagination-wrapper a,
    .pagination-wrapper span {
        margin:
            0 3px;
    }

    /* The shared navbar theme toggle also themes this listing page. */
    html[data-theme="dark"] .events-page { background:#0b0f19; color:#f4f6fb; }
    html[data-theme="dark"] .events-header h1,
    html[data-theme="dark"] .price,
    html[data-theme="dark"] .empty-state h3 { color:#f8fafc; }
    html[data-theme="dark"] .events-header p,
    html[data-theme="dark"] .event-info,
    html[data-theme="dark"] .empty-state p { color:#aab5c8; }
    html[data-theme="dark"] .filter-box,
    html[data-theme="dark"] .event-card,
    html[data-theme="dark"] .empty-state { background:#151b2b; border:1px solid #29344c; color:#f4f6fb; }
    html[data-theme="dark"] .filter-input,
    html[data-theme="dark"] .filter-select,
    html[data-theme="dark"] .filter-date { background:#0f1422; color:#f4f6fb; border-color:#303a52; }
    html[data-theme="dark"] .search-btn,
    html[data-theme="dark"] .view-btn { background:#6d5dfc; color:#fff; }
    html[data-theme="dark"] .clear-btn { background:#1f2937; color:#d5dbea; border-color:#3b4659; }
    html[data-theme="dark"] .event-image { background:#0f1422; }
    html[data-theme="dark"] .event-content h3 { color:#f8fafc; }
    html[data-theme="dark"] .organization { color:#a69fff; }
    html[data-theme="dark"] .seat-info { background:#282342; color:#c4bdff; }
    html[data-theme="dark"] .sold-out { background:#392025; color:#ff9da7; }
    html[data-theme="dark"] .pagination-wrapper a,
    html[data-theme="dark"] .pagination-wrapper span { background:#151b2b; color:#d5dbea; border-color:#303a52; }


    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 1100px) {

        .filter-form {

            grid-template-columns:
                1.5fr 1fr 1fr;

        }


        .search-btn,
        .clear-btn {

            width:
                100%;

        }


        .events-grid {

            grid-template-columns:
                repeat(
                    2,
                    1fr
                );

        }

    }


    @media (max-width: 850px) {

        .nav-links {

            display:
                none;

        }

        .filter-form {

            grid-template-columns:
                1fr 1fr;

        }

    }


    @media (max-width: 600px) {

        .events-page {

            padding:
                35px 14px 60px;

        }


        .events-header h1 {

            font-size:
                32px;

        }


        .filter-box {

            padding:
                16px;

        }


        .filter-form {

            grid-template-columns:
                1fr;

        }


        .events-grid {

            grid-template-columns:
                1fr;

        }


        .event-image {

            height:
                200px;

        }

    }

</style>


<div class="events-page">


    <div class="events-container">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="events-header">

            <h1>
                Discover Events
            </h1>


            <p>
                Find and book amazing events happening near you.
            </p>

        </div>


        {{-- =================================================
             SEARCH & FILTERS
        ================================================== --}}

        <div class="filter-box">


            <form
                method="GET"
                action="{{ route('events.index') }}"
                class="filter-form"
                id="eventSearchForm"
            >


                {{-- SEARCH --}}

                <input
                    type="text"
                    name="search"
                    id="eventSearch"
                    class="filter-input"
                    placeholder="Search events, city, venue..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >


                {{-- CATEGORY --}}

                <select
                    name="category"
                    id="eventCategory"
                    class="filter-select"
                >

                    <option value="">
                        All Categories
                    </option>


                    @foreach($categories as $category)

                        <option
                            value="{{ $category }}"
                            {{ request('category') == $category ? 'selected' : '' }}
                        >
                            {{ $category }}
                        </option>

                    @endforeach

                </select>


                {{-- CITY --}}

                <select
                    name="city"
                    id="eventCity"
                    class="filter-select"
                >

                    <option value="">
                        All Cities
                    </option>


                    @foreach($cities as $city)

                        <option
                            value="{{ $city }}"
                            {{ request('city') == $city ? 'selected' : '' }}
                        >
                            {{ $city }}
                        </option>

                    @endforeach

                </select>


                {{-- DATE --}}

                <input
                    type="date"
                    name="date"
                    id="eventDate"
                    class="filter-date"
                    value="{{ request('date') }}"
                    title="Filter by event date"
                >


                {{-- SEARCH BUTTON --}}

                <button
                    type="submit"
                    class="search-btn"
                    id="searchButton"
                >
                    🔍 Search
                </button>


                {{-- CLEAR BUTTON --}}

                <button
                    type="button"
                    class="clear-btn"
                    id="clearFilters"
                >
                    ✕ Clear
                </button>


            </form>


            {{-- LIVE STATUS --}}

            <div
                class="live-search-status"
                id="liveSearchStatus"
            >

                <span>
                    Updating events
                </span>

                <span
                    class="search-loader"
                    id="searchLoader"
                ></span>

            </div>


            {{-- FILTER SUMMARY --}}

            <div
                class="filter-summary"
                id="filterSummary"
            ></div>


        </div>


        {{-- =================================================
             EVENTS
        ================================================== --}}

        <div
            class="events-grid"
            id="eventsGrid"
        >


            @forelse($events as $event)


                <div class="event-card">


                    {{-- EVENT IMAGE --}}

                    <div class="event-image">


                        @if($event->banner)

                            <img
                                src="{{ asset(
                                    'storage/' .
                                    $event->banner
                                ) }}"
                                alt="{{ $event->title }}"
                                loading="lazy"
                            >

                        @else

                            <div class="event-placeholder">
                                🎫
                            </div>

                        @endif


                        @if($event->category)

                            <span class="category-badge">

                                {{ $event->category }}

                            </span>

                        @endif


                    </div>


                    {{-- CONTENT --}}

                    <div class="event-content">


                        <h3>
                            {{ $event->title }}
                        </h3>


                        @if($event->organization)

                            <div class="organization">

                                🏢
                                {{ $event->organization->name }}

                            </div>

                        @endif


                        <div class="event-info">


                            <span>

                                📅

                                {{
                                    \Carbon\Carbon::parse(
                                        $event->event_date
                                    )->format(
                                        'd M Y'
                                    )
                                }}

                            </span>


                            @if($event->event_time)

                                <span>

                                    🕐

                                    {{
                                        \Carbon\Carbon::parse(
                                            $event->event_time
                                        )->format(
                                            'h:i A'
                                        )
                                    }}

                                </span>

                            @endif


                            @if($event->venue)

                                <span>

                                    📍

                                    {{ $event->venue }}

                                    @if($event->city)

                                        ,
                                        {{ $event->city }}

                                    @endif

                                </span>

                            @endif


                        </div>


                        {{-- SEAT INFORMATION --}}

                        @if($event->available_seats === null)

                            <div class="seat-info">

                                ♾️ Unlimited Seats

                            </div>

                        @elseif($event->available_seats > 0)

                            <div class="seat-info">

                                🎟️
                                {{ $event->available_seats }}
                                seat(s) available

                            </div>

                        @else

                            <div class="seat-info sold-out">

                                ⚠️ Sold Out

                            </div>

                        @endif


                        {{-- FOOTER --}}

                        <div class="event-footer">


                            <div class="price">

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

                                    Free

                                @endif

                            </div>


                            <a
                                href="{{ route(
                                    'events.show',
                                    $event->slug
                                ) }}"
                                class="view-btn"
                            >
                                View Event
                            </a>


                        </div>


                    </div>


                </div>


            @empty


                <div class="empty-state">


                    <div class="icon">
                        🔎
                    </div>


                    <h3>
                        No Events Found
                    </h3>


                    <p>
                        We couldn't find any events matching your filters.
                    </p>


                </div>


            @endforelse


        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        <div
            class="pagination-wrapper"
            id="paginationWrapper"
        >

            @if($events->hasPages())

                {{ $events->links() }}

            @endif

        </div>


    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const searchInput =
            document.getElementById(
                'eventSearch'
            );


        const categorySelect =
            document.getElementById(
                'eventCategory'
            );


        const citySelect =
            document.getElementById(
                'eventCity'
            );


        const dateInput =
            document.getElementById(
                'eventDate'
            );


        const searchForm =
            document.getElementById(
                'eventSearchForm'
            );


        const eventsGrid =
            document.getElementById(
                'eventsGrid'
            );


        const paginationWrapper =
            document.getElementById(
                'paginationWrapper'
            );


        const statusBox =
            document.getElementById(
                'liveSearchStatus'
            );


        const loader =
            document.getElementById(
                'searchLoader'
            );


        const clearButton =
            document.getElementById(
                'clearFilters'
            );


        const filterSummary =
            document.getElementById(
                'filterSummary'
            );


        let searchTimer =
            null;


        let currentController =
            null;


        /*
        |--------------------------------------------------------------------------
        | Build URL
        |--------------------------------------------------------------------------
        */

        function buildUrl(
            page = 1
        ) {

            const url =
                "{{ route('events.index') }}";


            const params =
                new URLSearchParams();


            const search =
                searchInput.value.trim();


            const category =
                categorySelect.value;


            const city =
                citySelect.value;


            const date =
                dateInput.value;


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            if (
                search !== ''
            ) {

                params.set(
                    'search',
                    search
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            if (
                category !== ''
            ) {

                params.set(
                    'category',
                    category
                );

            }


            /*
            |--------------------------------------------------------------------------
            | City
            |--------------------------------------------------------------------------
            */

            if (
                city !== ''
            ) {

                params.set(
                    'city',
                    city
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Date
            |--------------------------------------------------------------------------
            */

            if (
                date !== ''
            ) {

                params.set(
                    'date',
                    date
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            if (
                page > 1
            ) {

                params.set(
                    'page',
                    page
                );

            }


            const query =
                params.toString();


            return query
                ? url + '?' + query
                : url;

        }


        /*
        |--------------------------------------------------------------------------
        | Update Filter Summary
        |--------------------------------------------------------------------------
        */

        function updateFilterSummary() {

            const filters = [];


            const search =
                searchInput.value.trim();


            const category =
                categorySelect.value;


            const city =
                citySelect.value;


            const date =
                dateInput.value;


            if (search) {

                filters.push(
                    'Search: "' +
                    search +
                    '"'
                );

            }


            if (category) {

                filters.push(
                    'Category: ' +
                    category
                );

            }


            if (city) {

                filters.push(
                    'City: ' +
                    city
                );

            }


            if (date) {

                filters.push(
                    'Date: ' +
                    date
                );

            }


            if (
                filters.length
            ) {

                filterSummary.style.display =
                    'block';

                filterSummary.textContent =
                    filters.join(
                        ' • '
                    );

            } else {

                filterSummary.style.display =
                    'none';

                filterSummary.textContent =
                    '';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Loading State
        |--------------------------------------------------------------------------
        */

        function setLoading(
            loading
        ) {

            if (!statusBox) {
                return;
            }


            if (loading) {

                statusBox.style.display =
                    'flex';

            } else {

                statusBox.style.display =
                    'none';

            }


            if (loader) {

                loader.style.display =
                    loading
                        ? 'inline-block'
                        : 'none';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Live Search / Filter
        |--------------------------------------------------------------------------
        */

        function performLiveSearch(
            page = 1,
            pushHistory = true
        ) {

            const url =
                buildUrl(page);


            /*
            |--------------------------------------------------------------------------
            | Cancel Previous Request
            |--------------------------------------------------------------------------
            */

            if (
                currentController
            ) {

                currentController.abort();

            }


            currentController =
                new AbortController();


            setLoading(true);


            fetch(
                url,
                {
                    method:
                        'GET',

                    headers: {

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'Accept':
                            'text/html'

                    },

                    signal:
                        currentController.signal

                }
            )
            .then(
                response => {

                    if (!response.ok) {

                        throw new Error(
                            'Events request failed.'
                        );

                    }

                    return response.text();

                }
            )
            .then(
                html => {

                    const parser =
                        new DOMParser();


                    const documentHtml =
                        parser.parseFromString(
                            html,
                            'text/html'
                        );


                    const newGrid =
                        documentHtml.querySelector(
                            '#eventsGrid'
                        );


                    const newPagination =
                        documentHtml.querySelector(
                            '#paginationWrapper'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Update Event Cards
                    |--------------------------------------------------------------------------
                    */

                    if (
                        newGrid
                    ) {

                        eventsGrid.innerHTML =
                            newGrid.innerHTML;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Update Pagination
                    |--------------------------------------------------------------------------
                    */

                    if (
                        newPagination
                    ) {

                        paginationWrapper.innerHTML =
                            newPagination.innerHTML;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Update Browser URL
                    |--------------------------------------------------------------------------
                    */

                    if (
                        pushHistory
                    ) {

                        window.history.pushState(
                            {
                                eventsPage:
                                    true
                            },
                            '',
                            url
                        );

                    }


                    updateFilterSummary();

                }
            )
            .catch(
                error => {

                    if (
                        error.name !==
                        'AbortError'
                    ) {

                        console.error(
                            error
                        );

                    }

                }
            )
            .finally(
                () => {

                    setLoading(false);

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Typing Search
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(
                    searchTimer
                );


                searchTimer =
                    setTimeout(
                        function () {

                            performLiveSearch(
                                1,
                                true
                            );

                        },
                        350
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Category Live Filter
        |--------------------------------------------------------------------------
        */

        categorySelect.addEventListener(
            'change',
            function () {

                performLiveSearch(
                    1,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | City Live Filter
        |--------------------------------------------------------------------------
        */

        citySelect.addEventListener(
            'change',
            function () {

                performLiveSearch(
                    1,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Date Live Filter
        |--------------------------------------------------------------------------
        */

        dateInput.addEventListener(
            'change',
            function () {

                performLiveSearch(
                    1,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Search Button
        |--------------------------------------------------------------------------
        |
        | Still works, but without full page reload.
        |
        */

        searchForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                clearTimeout(
                    searchTimer
                );


                performLiveSearch(
                    1,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Clear Filters
        |--------------------------------------------------------------------------
        */

        clearButton.addEventListener(
            'click',
            function () {

                searchInput.value =
                    '';

                categorySelect.value =
                    '';

                citySelect.value =
                    '';

                dateInput.value =
                    '';


                performLiveSearch(
                    1,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Pagination Without Page Reload
        |--------------------------------------------------------------------------
        */

        paginationWrapper.addEventListener(
            'click',
            function (event) {

                const link =
                    event.target.closest(
                        'a'
                    );


                if (!link) {
                    return;
                }


                event.preventDefault();


                const linkUrl =
                    new URL(
                        link.href,
                        window.location.origin
                    );


                const page =
                    parseInt(
                        linkUrl.searchParams.get(
                            'page'
                        )
                    ) || 1;


                performLiveSearch(
                    page,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Browser Back / Forward
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'popstate',
            function () {

                const currentUrl =
                    new URL(
                        window.location.href
                    );


                searchInput.value =
                    currentUrl.searchParams.get(
                        'search'
                    ) || '';


                categorySelect.value =
                    currentUrl.searchParams.get(
                        'category'
                    ) || '';


                citySelect.value =
                    currentUrl.searchParams.get(
                        'city'
                    ) || '';


                dateInput.value =
                    currentUrl.searchParams.get(
                        'date'
                    ) || '';


                const page =
                    parseInt(
                        currentUrl.searchParams.get(
                            'page'
                        )
                    ) || 1;


                performLiveSearch(
                    page,
                    false
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Initial Filter Summary
        |--------------------------------------------------------------------------
        */

        updateFilterSummary();

    }
);

</script>


@include('layouts.footer')
