@php
    $currentUser = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Current Account Type
    |--------------------------------------------------------------------------
    */

    $isOrganizationAdmin =
        $currentUser->role === 'organization_admin';

    $currentStaff =
        $currentUser->role === 'organization_staff'
            ? $currentUser->currentOrganizationStaff()
            : null;


    /*
    |--------------------------------------------------------------------------
    | Staff Permissions
    |--------------------------------------------------------------------------
    */

    $staffPermissions =
        $currentStaff?->permissions ?? [];


    /*
    |--------------------------------------------------------------------------
    | Permission Helper
    |--------------------------------------------------------------------------
    |
    | Organization Admin gets full access.
    | Staff gets access only when permission exists.
    |
    */

    $hasPermission = function (string $permission) use (
        $isOrganizationAdmin,
        $staffPermissions
    ) {
        return $isOrganizationAdmin ||
            in_array(
                $permission,
                $staffPermissions,
                true
            );
    };
@endphp


<!-- =========================================================
     MOBILE OVERLAY
========================================================= -->

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>


<!-- =========================================================
     ORGANIZATION ADMIN / STAFF SIDEBAR
========================================================= -->

<aside
    class="admin-sidebar"
    id="adminSidebar"
>


    <!-- =====================================================
         LOGO
    ====================================================== -->

    <div class="sidebar-logo">

        <a
            href="{{ route('organization.admin.dashboard') }}"
        >
            Event<span>ora</span>
        </a>

    </div>


    <!-- =====================================================
         MOBILE CLOSE
    ====================================================== -->

    <button
        type="button"
        class="sidebar-close"
        id="sidebarClose"
        aria-label="Close Menu"
    >
        ×
    </button>


    <!-- =====================================================
         MAIN MENU
    ====================================================== -->

    <div class="sidebar-section-title">
        MAIN MENU
    </div>


    <nav class="sidebar-menu">


        <!-- =================================================
             DASHBOARD
        ================================================== -->

        <a
            href="{{ route('organization.admin.dashboard') }}"
            class="{{
                request()->routeIs(
                    'organization.admin.dashboard'
                )
                    ? 'active'
                    : ''
            }}"
        >

            <span class="menu-icon">
                🏠
            </span>

            <span>
                Dashboard
            </span>

        </a>


        <!-- =================================================
             ORGANIZATION UNITS
             ONLY ORGANIZATION ADMIN
        ================================================== -->

        @if($isOrganizationAdmin)

            <a
                href="{{ route('organization.admin.units.index') }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.units.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    🏢
                </span>

                <span>
                    Organization Units
                </span>

            </a>

        @endif


        <!-- =================================================
             STAFF & ACCESS
             PERMISSION: manage_staff
        ================================================== -->

        @if($hasPermission('manage_staff'))

            <a
                href="{{ route('organization.admin.staff.index') }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.staff.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    👥
                </span>

                <span>
                    Staff & Access
                </span>

            </a>

        @endif


        <!-- =================================================
             MY EVENTS
             PERMISSION: view_events / manage_events
        ================================================== -->

        @if(
            $hasPermission('view_events') ||
            $hasPermission('manage_events')
        )

            <a
                href="{{ route('organization.admin.events.index') }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.events.index'
                    ) ||
                    request()->routeIs(
                        'organization.admin.events.show'
                    ) ||
                    request()->routeIs(
                        'organization.admin.events.edit'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    🎫
                </span>

                <span>
                    My Events
                </span>

            </a>

        @endif


        <!-- =================================================
             CREATE EVENT
             PERMISSION: create_events / manage_events
        ================================================== -->

        @if(
            $hasPermission('create_events') ||
            $hasPermission('manage_events')
        )

            <a
                href="{{ route('organization.admin.events.create') }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.events.create'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    ➕
                </span>

                <span>
                    Create Event
                </span>

            </a>

        @endif


        <!-- =================================================
             BOOKINGS
             PERMISSION: view_bookings / manage_bookings
        ================================================== -->

        @if(
            $hasPermission('view_bookings') ||
            $hasPermission('manage_bookings')
        )

            <a
                href="{{ route('organization.admin.bookings.index') }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.bookings.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    📋
                </span>

                <span>
                    Bookings
                </span>

            </a>

        @endif


        <!-- =================================================
             PARTICIPANTS
             PERMISSION: view_participants
        ================================================== -->

        @if($hasPermission('view_participants'))

            <a
                href="{{ route(
                    'organization.admin.participants.index'
                ) }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.participants.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    👤
                </span>

                <span>
                    Participants
                </span>

            </a>

        @endif


        <!-- =================================================
             TICKET VERIFICATION
             PERMISSION: verify_tickets
        ================================================== -->

        @if($hasPermission('verify_tickets'))

            <a
                href="{{ route(
                    'organization.admin.ticket.verification'
                ) }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.ticket.*'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    ✅
                </span>

                <span>
                    Ticket Verification
                </span>

            </a>

        @endif

    </nav>


    <!-- =====================================================
         ORGANIZATION
    ====================================================== -->

    <div class="sidebar-section-title">
        ORGANIZATION
    </div>


    <nav class="sidebar-menu">


        <!-- =================================================
             ORGANIZATION ADMIN PROFILE
        ================================================== -->

        @if($isOrganizationAdmin)

            <a
                href="{{ route(
                    'organization.admin.profile'
                ) }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.profile'
                    ) ||
                    request()->routeIs(
                        'organization.admin.profile.edit'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    👤
                </span>

                <span>
                    Organization Profile
                </span>

            </a>


            <!-- =============================================
                 SETTINGS
            ============================================== -->

            <a
                href="{{ route(
                    'organization.admin.settings'
                ) }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.settings'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    ⚙️
                </span>

                <span>
                    Settings
                </span>

            </a>


        @elseif($currentStaff)

            <!-- =============================================
                 STAFF PROFILE
            ============================================== -->

            <a
                href="{{ route(
                    'organization.admin.staff.show',
                    $currentStaff->id
                ) }}"
                class="{{
                    request()->routeIs(
                        'organization.admin.staff.show'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    👤
                </span>

                <span>
                    My Profile
                </span>

            </a>

        @endif

    </nav>


    <!-- =====================================================
         BOTTOM
    ====================================================== -->

    <div class="sidebar-bottom">


        <!-- =================================================
             MINI PROFILE
        ================================================== -->

        <div class="admin-mini-profile">


            <div class="profile-avatar">

                {{ strtoupper(
                    substr(
                        auth()->user()->name,
                        0,
                        1
                    )
                ) }}

                @if(auth()->user()->profilePhotoUrl())
                    <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">
                @endif

            </div>


            <div class="profile-info">

                <strong>

                    {{ auth()->user()->name }}

                </strong>


                <small>

                    @if($isOrganizationAdmin)

                        Organization Admin

                    @elseif(
                        auth()->user()->role ===
                        'organization_staff'
                    )

                        {{ $currentStaff?->role ?? 'Staff' }}

                    @else

                        Organization User

                    @endif

                </small>

            </div>

        </div>


        <!-- =================================================
             LOGOUT
        ================================================== -->

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf


            <button
                type="submit"
                class="logout-button"
            >

                <span>
                    🚪
                </span>

                <span>
                    Logout
                </span>

            </button>

        </form>


    </div>


</aside>



<style>

/* =========================================================
   IMPORTANT: SIDEBAR BOX SIZING
========================================================= */

.admin-sidebar,
.admin-sidebar *,
.sidebar-overlay {
    box-sizing: border-box;
}


/* =========================================================
   SIDEBAR
========================================================= */

.admin-sidebar {

    width: 260px;

    height: 100vh;

    position: fixed;

    top: 0;
    left: 0;

    background: #111827;

    color: white;

    padding: 24px 16px;

    display: flex;

    flex-direction: column;

    z-index: 1000;

    overflow-y: scroll;

    overflow-x: hidden;

    transition: transform 0.3s ease;

    flex-shrink: 0;

    scrollbar-width: thin;

    scrollbar-color: #4b5563 #111827;
}


/* =========================================================
   SCROLLBAR
========================================================= */

.admin-sidebar::-webkit-scrollbar {

    width: 7px;

}


.admin-sidebar::-webkit-scrollbar-track {

    background: #111827;

}


.admin-sidebar::-webkit-scrollbar-thumb {

    background: #4b5563;

    border-radius: 10px;

}


.admin-sidebar::-webkit-scrollbar-thumb:hover {

    background: #6b7280;

}


/* =========================================================
   LOGO
========================================================= */

.sidebar-logo {

    flex-shrink: 0;

    padding:
        4px 12px 28px;

}


.sidebar-logo a {

    text-decoration: none;

    color: white;

    font-size: 27px;

    font-weight: 800;

    letter-spacing: -0.5px;

}


.sidebar-logo span {

    color: #6366f1;

}


/* =========================================================
   MOBILE CLOSE
========================================================= */

.sidebar-close {

    display: none;

    position: absolute;

    top: 17px;

    right: 16px;

    border: none;

    background: transparent;

    color: white;

    font-size: 28px;

    cursor: pointer;

    z-index: 5;

}


/* =========================================================
   SECTION TITLE
========================================================= */

.sidebar-section-title {

    flex-shrink: 0;

    padding:
        0 12px;

    margin:
        14px 0 9px;

    color: #8b93a7;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 1px;

}


/* =========================================================
   MENU
========================================================= */

.sidebar-menu {

    display: flex;

    flex-direction: column;

    gap: 5px;

    flex-shrink: 0;

}


.sidebar-menu a {

    display: flex;

    align-items: center;

    gap: 12px;

    min-height: 44px;

    padding:
        12px 13px;

    color: #cbd5e1;

    text-decoration: none;

    border-radius: 10px;

    font-size: 14px;

    font-weight: 500;

    transition:
        all 0.2s ease;

}


.sidebar-menu a:hover {

    background: #1f2937;

    color: white;

    transform:
        translateX(2px);

}


.sidebar-menu a.active {

    background: #6366f1;

    color: white;

    box-shadow:
        0 5px 15px
        rgba(
            99,
            102,
            241,
        0.25
        );

}


.menu-icon {

    width: 22px;

    min-width: 22px;

    display: inline-flex;

    justify-content: center;

    align-items: center;

    font-size: 17px;

}


/* =========================================================
   BOTTOM
========================================================= */

.sidebar-bottom {

    margin-top: auto;

    padding-top: 20px;

    flex-shrink: 0;

}


/* =========================================================
   ADMIN / STAFF MINI PROFILE
========================================================= */

.admin-mini-profile {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 12px;

    background: #1f2937;

    border-radius: 12px;

    margin-bottom: 10px;

}


.profile-avatar {

    position: relative;

    width: 38px;

    height: 38px;

    min-width: 38px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #6366f1;

    color: white;

    font-weight: bold;

}

.profile-avatar img {

    position: absolute;

    inset: 0;

    width: 100%;

    height: 100%;

    border-radius: inherit;

    object-fit: cover;

}


.profile-info {

    min-width: 0;

    display: flex;

    flex-direction: column;

}


.profile-info strong {

    color: white;

    font-size: 13px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

}


.profile-info small {

    color: #9ca3af;

    font-size: 11px;

    margin-top: 2px;

}


/* =========================================================
   LOGOUT
========================================================= */

.logout-button {

    width: 100%;

    border: 1px solid rgba(239, 68, 68, .20);

    background: rgba(239, 68, 68, .07);

    color: #ff8585;

    padding:
        11px 13px;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    font-size: 14px;

    cursor: pointer;

    text-align: left;

    transition: 0.2s;

}


.logout-button:hover {

    background: rgba(239, 68, 68, .14);

    color: #f87171;

}


/* =========================================================
   OVERLAY
========================================================= */

.sidebar-overlay {

    display: none;

    position: fixed;

    inset: 0;

    background:
        rgba(
            0,
            0,
            0,
            0.5
        );

    z-index: 999;

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .admin-sidebar {

        width: 260px;

        max-width: 85vw;

        transform:
            translateX(-100%);

        overflow-y: auto;

    }


    .admin-sidebar.open {

        transform:
            translateX(0);

    }


    .sidebar-close {

        display: block;

    }


    .sidebar-overlay.show {

        display: block;

    }

}

</style>



<script>

(function () {

    const sidebar =
        document.getElementById(
            'adminSidebar'
        );


    const sidebarOverlay =
        document.getElementById(
            'sidebarOverlay'
        );


    const sidebarClose =
        document.getElementById(
            'sidebarClose'
        );


    /*
    |--------------------------------------------------------------------------
    | Open Sidebar
    |--------------------------------------------------------------------------
    */

    window.openAdminSidebar = function () {

        if (
            !sidebar ||
            !sidebarOverlay
        ) {

            return;

        }


        sidebar.classList.add(
            'open'
        );


        sidebarOverlay.classList.add(
            'show'
        );


        document.body.style.overflow =
            'hidden';

    };


    /*
    |--------------------------------------------------------------------------
    | Close Sidebar
    |--------------------------------------------------------------------------
    */

    window.closeAdminSidebar = function () {

        if (
            !sidebar ||
            !sidebarOverlay
        ) {

            return;

        }


        sidebar.classList.remove(
            'open'
        );


        sidebarOverlay.classList.remove(
            'show'
        );


        document.body.style.overflow =
            '';

    };


    /*
    |--------------------------------------------------------------------------
    | Close Button
    |--------------------------------------------------------------------------
    */

    if (sidebarClose) {

        sidebarClose.addEventListener(
            'click',
            window.closeAdminSidebar
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Overlay Click
    |--------------------------------------------------------------------------
    */

    if (sidebarOverlay) {

        sidebarOverlay.addEventListener(
            'click',
            window.closeAdminSidebar
        );

    }

})();

</script>
