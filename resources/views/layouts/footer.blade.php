<footer class="eventora-footer" id="contact">

    <div class="footer-container">

        <div class="footer-grid">

            <!-- Brand -->
            <div class="footer-brand">

                <a href="{{ route('home') }}" class="footer-logo">
                    Event<span>ora</span>
                </a>

                <p>
                    Discover events, book tickets and create
                    unforgettable experiences with Eventora.
                </p>

            </div>


            <!-- Explore -->
            <div class="footer-column">

                <h4>Explore</h4>

                <a href="{{ route('events.index') }}">
                    Events
                </a>

                <a href="{{ route('categories.index') }}">
                    Categories
                </a>

                <a href="{{ route('organizations.search') }}">
                    Organizations
                </a>

                <a href="{{ route('pages.how-it-works') }}">
                    How It Works
                </a>

            </div>


            <!-- Company -->
            <div class="footer-column">

                <h4>Company</h4>

                <a href="{{ route('pages.about') }}">
                    About Us
                </a>

                <a href="{{ route('pages.contact') }}">
                    Contact
                </a>

                @auth
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('bookings.index') }}">
                        My Bookings
                    </a>
                @endif
                @endauth

            </div>


            <!-- Social -->
            <div class="footer-column">

                <h4>Follow Us</h4>

                <a href="{{ route('pages.contact') }}">
                    Instagram
                </a>

                <a href="{{ route('pages.contact') }}">
                    Facebook
                </a>

                <a href="{{ route('pages.contact') }}">
                    LinkedIn
                </a>

            </div>

        </div>


        <div class="footer-bottom">

            <span>
                © {{ date('Y') }} Eventora. All Rights Reserved.
            </span>

            <span>
                Made with ❤️ for event lovers
            </span>

        </div>

    </div>

</footer>


<style>

    /* =========================
       EVENTORA FOOTER
    ========================= */

    .eventora-footer {
        margin-top: 70px;

        background: #0a0e17;

        border-top: 1px solid #252d40;

        color: #ffffff;
    }


    .footer-container {
        width: min(1200px, calc(100% - 40px));

        margin: auto;
    }


    .footer-grid {
        display: grid;

        grid-template-columns:
            2fr
            1fr
            1fr
            1fr;

        gap: 50px;

        padding: 60px 0 45px;
    }


    /* Brand */

    .footer-logo {
        display: inline-block;

        color: #ffffff;

        text-decoration: none;

        font-size: 27px;
        font-weight: 800;

        margin-bottom: 16px;
    }


    .footer-logo span {
        color: #6d5dfc;
    }


    .footer-brand p {
        max-width: 330px;

        color: #8f9aae;

        line-height: 1.7;

        font-size: 14px;
    }


    /* Columns */

    .footer-column {
        display: flex;

        flex-direction: column;

        align-items: flex-start;

        gap: 11px;
    }


    .footer-column h4 {
        color: #ffffff;

        font-size: 15px;

        margin-bottom: 7px;
    }


    .footer-column a {
        color: #8f9aae;

        text-decoration: none;

        font-size: 14px;

        transition: 0.2s;
    }


    .footer-column a:hover {
        color: #ffffff;

        transform: translateX(2px);
    }


    /* Bottom */

    .footer-bottom {
        min-height: 70px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        border-top: 1px solid #252d40;

        color: #707b90;

        font-size: 13px;
    }


    /* =========================
       LIGHT THEME
    ========================= */

    html[data-theme="light"] .eventora-footer {
        background: #ffffff;

        border-top-color: #e1e6ef;

        color: #172033;
    }


    html[data-theme="light"] .footer-logo {
        color: #172033;
    }


    html[data-theme="light"] .footer-brand p {
        color: #687386;
    }


    html[data-theme="light"] .footer-column h4 {
        color: #172033;
    }


    html[data-theme="light"] .footer-column a {
        color: #687386;
    }


    html[data-theme="light"] .footer-column a:hover {
        color: #5848eb;
    }


    html[data-theme="light"] .footer-bottom {
        border-top-color: #e1e6ef;

        color: #7b8494;
    }


    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 800px) {

        .footer-grid {
            grid-template-columns: repeat(2, 1fr);

            gap: 35px;
        }

    }


    @media (max-width: 550px) {

        .footer-container {
            width: calc(100% - 28px);
        }


        .footer-grid {
            grid-template-columns: 1fr;

            gap: 30px;

            padding: 45px 0 35px;
        }


        .footer-brand p {
            max-width: 100%;
        }


        .footer-bottom {
            flex-direction: column;

            justify-content: center;

            text-align: center;

            padding: 20px 0;

            line-height: 1.6;
        }

    }

</style>
