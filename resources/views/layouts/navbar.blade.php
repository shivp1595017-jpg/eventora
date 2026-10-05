<header class="navbar">

    <div class="nav-container">

        <a href="{{ route('home') }}" class="logo">
            Event<span>ora</span>
        </a>


        <ul class="nav-links" id="navLinks">

            <!-- HOME -->

            <li>
                <a href="{{ route('home') }}"
                   class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
            </li>


            <!-- DASHBOARD - LOGGED IN ONLY -->

            @auth
                @php
                    $navUser = auth()->user();
                    $accountDashboard = match (auth()->user()->role) {
                        'super_admin', 'super_admin_staff' => 'admin.dashboard',
                        default => 'dashboard',
                    };
                    $navProfileRoute = in_array($navUser->role, ['organization_admin', 'organization_staff'], true)
                        ? 'organization.admin.profile'
                        : 'profile.show';
                    $navEditProfileRoute = in_array($navUser->role, ['organization_admin', 'organization_staff'], true)
                        ? 'organization.admin.profile.edit'
                        : 'profile.edit';
                @endphp

                @if(in_array($navUser->role, ['super_admin', 'super_admin_staff'], true))
                    <li>
                        <a href="{{ route($accountDashboard) }}"
                           class="nav-link {{ request()->routeIs($accountDashboard) ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>
                @endif

            @endauth


            <!-- EVENTS -->

            <li>
                <a href="{{ route('events.index') }}"
                   class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    Events
                </a>
            </li>


            <!-- ORGANIZATIONS -->

            <li>
                <a href="{{ route('organizations.search') }}"
                   class="nav-link {{ request()->routeIs('organizations.*') ? 'active' : '' }}">
                    Organizations
                </a>
            </li>


            <!-- HOW IT WORKS -->

            <li>
                <a href="{{ route('pages.how-it-works') }}"
                   class="nav-link {{ request()->routeIs('pages.how-it-works') ? 'active' : '' }}">
                    How It Works
                </a>
            </li>


            <!-- ABOUT -->

            <li>
                <a href="{{ route('pages.about') }}"
                   class="nav-link {{ request()->routeIs('pages.about') ? 'active' : '' }}">
                    About
                </a>
            </li>


            <!-- CONTACT -->

            <li>
                <a href="{{ route('pages.contact') }}"
                   class="nav-link {{ request()->routeIs('pages.contact') ? 'active' : '' }}">
                    Contact
                </a>
            </li>


            <!-- MY BOOKINGS - LOGGED IN ONLY -->

            @auth
            @if(auth()->user()->role === 'user')

                <li>
                    <a href="{{ route('bookings.index') }}"
                       class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                        My Bookings
                    </a>
                </li>

            @endif

            @endauth


            <!-- LOGIN / REGISTER - LOGGED OUT ONLY -->

            @guest

                <li>
                    <a href="{{ route('login') }}"
                       class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                        Login
                    </a>
                </li>

                <li>
                    <a href="{{ route('register') }}"
                       class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">
                        Register
                    </a>
                </li>

            @endguest

            @auth
                @if(!in_array($navUser->role, ['super_admin', 'super_admin_staff'], true))
                    <li>
                        <button type="button" class="profile-nav-link {{ request()->routeIs('profile.*', 'organization.admin.profile', 'organization.admin.profile.edit') ? 'active' : '' }}"
                                id="profileMenuButton" aria-expanded="false" aria-controls="profileDropdown">
                            <span class="profile-nav-avatar">
                                <span>{{ strtoupper(substr($navUser->name, 0, 1)) }}</span>
                                @if($navUser->profilePhotoUrl())
                                    <img src="{{ $navUser->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">
                                @endif
                            </span>
                            <span class="profile-nav-label">Profile</span>
                        </button>
                        <div class="profile-dropdown" id="profileDropdown" hidden>
                            <div class="profile-dropdown-user">
                                <strong>{{ $navUser->name }}</strong>
                                <span>{{ $navUser->email }}</span>
                            </div>
                            <a href="{{ route($navProfileRoute) }}" class="{{ request()->routeIs('profile.*', 'organization.admin.profile') ? 'active' : '' }}">Profile</a>
                            <a href="{{ route($navEditProfileRoute) }}" class="{{ request()->routeIs('organization.admin.profile.edit') ? 'active' : '' }}">Edit Profile</a>
                            @if($navUser->role === 'user')
                                <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">My Bookings</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-menu-button">Log Out</button>
                            </form>
                        </div>
                    </li>
                @endif
            @endauth

        </ul>


        <!-- RIGHT SIDE -->

        <div class="nav-right">

            <button
                type="button"
                class="theme-btn"
                id="themeButton"
                onclick="toggleTheme()"
                title="Toggle theme"
            >
                🌙
            </button>


            <button
                type="button"
                class="menu-btn"
                onclick="toggleMenu()"
                title="Menu"
            >
                ☰
            </button>

        </div>

    </div>

</header>


<style>

    html, body { margin: 0; }
    html[data-theme="dark"] body { background: #0b0f19; }

    /* =========================
       EVENTORA NAVBAR
    ========================= */

    .navbar {
        width: 100%;
        position: sticky;
        top: 0;
        z-index: 9999;

        background: rgba(11, 15, 25, 0.94);

        border-bottom: 1px solid #252d40;

        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }


    .nav-container {
        width: min(1200px, calc(100% - 40px));

        min-height: 74px;

        margin: auto;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 25px;
    }


    /* =========================
       LOGO
    ========================= */

    .navbar .logo {
        color: #ffffff;

        text-decoration: none;

        font-size: 25px;

        font-weight: 800;

        letter-spacing: -0.5px;

        white-space: nowrap;
        margin-right: 0;
        font-family: Arial, Helvetica, sans-serif;
    }


    .navbar .logo span {
        color: #6d5dfc;
    }


    /* =========================
       MENU
    ========================= */

    .nav-links {
        list-style: none;

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 5px;

        margin: 0;
        padding: 0;
    }


    .nav-links li {
        list-style: none;
    }


    .navbar .nav-links .nav-link {
        display: block;

        color: #aab5c8;

        text-decoration: none;

        font-size: 14px;

        font-weight: 600;

        padding: 9px 12px;

        border-radius: 8px;

        transition:
            color 0.2s ease,
            background 0.2s ease;
        font-family: Arial, Helvetica, sans-serif;
    }


    .navbar .nav-links .nav-link:hover {
        color: #ffffff;

        background: rgba(109, 93, 252, 0.10);
    }


    .navbar .nav-links .nav-link.active {
        color: #ffffff;
        background: linear-gradient(135deg, #654efc, #8b5cf6);
        box-shadow: 0 8px 22px rgba(109, 93, 252, 0.30);
    }

    .profile-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 10px 5px 6px;
        border: 1px solid transparent;
        border-radius: 999px;
        color: #aab5c8;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
        background: transparent;
        cursor: pointer;
        font-family: inherit;
    }

    .profile-nav-link:hover,
    .profile-nav-link.active { color: #fff; background: rgba(109,93,252,.16); border-color: rgba(109,93,252,.3); }

    .profile-nav-avatar {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex: 0 0 34px;
        border-radius: 50%;
        background: linear-gradient(135deg,#6d5dfc,#8b7cff);
        color: #fff;
        font-weight: 800;
    }

    .profile-nav-avatar { position: relative; }
    .profile-nav-avatar img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; border-radius:50%; }
    .profile-dropdown { position:absolute; right:max(20px, calc((100% - 1200px)/2)); top:calc(100% - 2px); width:min(300px, calc(100vw - 32px)); padding:9px; border:1px solid #303a52; border-radius:14px; background:#151b2b; box-shadow:0 18px 46px rgba(0,0,0,.28); z-index:10001; }
    .profile-dropdown[hidden] { display:none; }
    .profile-dropdown-user { display:flex; flex-direction:column; gap:3px; padding:10px 11px 13px; border-bottom:1px solid #303a52; margin-bottom:5px; }
    .profile-dropdown-user strong { color:#fff; font-size:14px; }
    .profile-dropdown-user span { color:#aab5c8; font-size:12px; overflow-wrap:anywhere; }
    .profile-dropdown a,.profile-dropdown form button { display:block; width:100%; border:0; border-radius:8px; padding:10px 11px; color:#d4dbea; text-align:left; text-decoration:none; background:transparent; font-size:13px; font-family:inherit; font-weight:600; cursor:pointer; }
    .profile-dropdown a:hover,.profile-dropdown a.active,.profile-dropdown form button:hover { color:#fff; background:rgba(109,93,252,.18); }
    .profile-dropdown form .logout-menu-button { margin-top:5px; border:1px solid rgba(180,35,24,.35); border-radius:8px; background:rgba(180,35,24,.14); color:#fda4af; }
    .profile-dropdown form .logout-menu-button:hover { color:#fff; background:#b42318; }


    /* =========================
       RIGHT BUTTONS
    ========================= */

    .nav-right {
        display: flex;

        align-items: center;

        gap: 9px;
    }


    .theme-btn,
    .menu-btn {
        width: 40px;
        height: 40px;

        display: flex;

        align-items: center;
        justify-content: center;

        border: 1px solid #303a52;

        border-radius: 9px;

        background: #151b2b;

        color: #ffffff;

        cursor: pointer;

        font-size: 18px;

        transition: 0.2s;
    }


    .theme-btn:hover,
    .menu-btn:hover {
        background: #252e45;

        border-color: #6d5dfc;

        transform: translateY(-1px);
    }


    .menu-btn {
        display: none;
    }


    /* =========================
       LIGHT THEME
    ========================= */

    html[data-theme="light"] body {
        background: #f5f7fb;

        color: #172033;
    }


    html[data-theme="light"] .navbar {
        background: rgba(255, 255, 255, 0.94);

        border-bottom-color: #e2e7f0;
    }


    html[data-theme="light"] .navbar .logo {
        color: #172033;
    }


    html[data-theme="light"] .navbar .nav-links .nav-link {
        color: #5c6678;
    }


    html[data-theme="light"] .navbar .nav-links .nav-link:hover {
        color: #111827;

        background: #f0efff;
    }


    html[data-theme="light"] .navbar .nav-links .nav-link.active {
        color: #ffffff;
        background: linear-gradient(135deg, #654efc, #8b5cf6);
        box-shadow: 0 8px 22px rgba(109, 93, 252, 0.22);
    }

    html[data-theme="light"] .profile-nav-link { color:#5c6678; }
    html[data-theme="light"] .profile-nav-link:hover,
    html[data-theme="light"] .profile-nav-link.active { color:#5848eb; background:#eeecff; }
    html[data-theme="light"] .profile-dropdown { background:#fff; border-color:#e1e6ef; box-shadow:0 18px 46px rgba(20,30,50,.14); }
    html[data-theme="light"] .profile-dropdown-user { border-color:#e1e6ef; }
    html[data-theme="light"] .profile-dropdown-user strong { color:#172033; }
    html[data-theme="light"] .profile-dropdown-user span,.profile-dropdown a { color:#5c6678; }
    html[data-theme="light"] .profile-dropdown a:hover,html[data-theme="light"] .profile-dropdown a.active { color:#5848eb; background:#eeecff; }
    html[data-theme="light"] .profile-dropdown form .logout-menu-button { color:#b42318; border-color:#e1e6ef; }
    html[data-theme="light"] .profile-dropdown form .logout-menu-button:hover { color:#fff; background:#b42318; }


    html[data-theme="light"] .theme-btn,
    html[data-theme="light"] .menu-btn {
        background: #ffffff;

        color: #172033;

        border-color: #dce2ec;
    }


    html[data-theme="light"] .theme-btn:hover,
    html[data-theme="light"] .menu-btn:hover {
        background: #f2f1ff;

        border-color: #6d5dfc;
    }


    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 950px) {

        .nav-container {
            min-height: 68px;
        }


        .nav-links {
            display: none;

            position: absolute;

            top: 68px;

            left: 20px;
            right: 20px;

            flex-direction: column;

            align-items: stretch;

            gap: 4px;

            padding: 12px;

            background: #151b2b;

            border: 1px solid #29344c;

            border-radius: 14px;

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.35);
        }


        .nav-links.show {
            display: flex;
        }


        .navbar .nav-links .nav-link {
            width: 100%;

            padding: 12px 14px;
        }

        .profile-nav-link { width:100%; justify-content:flex-start; padding:8px 12px; }
        .profile-dropdown { position:static; width:100%; margin-top:5px; box-shadow:none; }


        .menu-btn {
            display: flex;
        }


        html[data-theme="light"] .nav-links {
            background: #ffffff;

            border-color: #e1e6ef;

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.12);
        }

    }


    @media (max-width: 500px) {

        .nav-container {
            width: calc(100% - 24px);
        }


        .navbar .logo {
            font-size: 22px;
        }

    }

</style>


<script>
(() => {

    /* =========================
       MOBILE MENU
    ========================= */

    window.toggleMenu = function () {

        const navLinks =
            document.getElementById("navLinks");

        if (navLinks) {

            navLinks.classList.toggle("show");

        }

    };


    /* =========================
       THEME
    ========================= */

    const html =
        document.documentElement;

    const themeButton =
        document.getElementById("themeButton");


    function setTheme(theme) {

        html.setAttribute(
            "data-theme",
            theme
        );


        localStorage.setItem(
            "eventora-theme",
            theme
        );


        if (themeButton) {

            themeButton.textContent =
                theme === "light"
                    ? "☀️"
                    : "🌙";

        }

    }


    window.toggleTheme = function () {

        const currentTheme =
            html.getAttribute("data-theme")
            || "dark";


        setTheme(

            currentTheme === "dark"
                ? "light"
                : "dark"

        );

    };


    const savedTheme =
        localStorage.getItem("eventora-theme")
        || "dark";


    setTheme(savedTheme);

    document.querySelectorAll('#navLinks a').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('navLinks')?.classList.remove('show');
        });
    });

    const profileButton = document.getElementById('profileMenuButton');
    const profileDropdown = document.getElementById('profileDropdown');
    const closeProfileMenu = () => {
        if (!profileButton || !profileDropdown) return;
        profileDropdown.hidden = true;
        profileButton.setAttribute('aria-expanded', 'false');
    };
    profileButton?.addEventListener('click', event => {
        event.stopPropagation();
        profileDropdown.hidden = !profileDropdown.hidden;
        profileButton.setAttribute('aria-expanded', String(!profileDropdown.hidden));
    });
    profileDropdown?.addEventListener('click', event => event.stopPropagation());
    document.addEventListener('click', closeProfileMenu);
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeProfileMenu();
    });

    const sectionLinks = document.querySelectorAll('[data-section-link]');
    const updateSectionActive = () => {
        sectionLinks.forEach(link => link.classList.toggle('active',
            window.location.pathname === '/' && window.location.hash === `#${link.dataset.sectionLink}`));
    };
    updateSectionActive();
    window.addEventListener('hashchange', updateSectionActive);

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') document.getElementById('navLinks')?.classList.remove('show');
    });

})();

</script>
