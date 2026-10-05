<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Eventora</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #1f2937;
        }

        .admin-main {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        .mobile-header {
            display: none;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: 28px;
            color: #111827;
        }

        .topbar p {
            color: #6b7280;
            margin-top: 6px;
        }

        .admin-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 9px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .settings-card {
            background: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .settings-card.full {
            grid-column: 1 / -1;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .card-title h2 {
            font-size: 18px;
            color: #111827;
        }

        .card-title p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 3px;
        }

        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 17px 0;
            border-bottom: 1px solid #eef0f4;
            gap: 20px;
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-info h3 {
            font-size: 15px;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .setting-info p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .toggle {
            width: 48px;
            height: 26px;
            background: #d1d5db;
            border-radius: 30px;
            position: relative;
            cursor: pointer;
            flex-shrink: 0;
        }

        .toggle::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 3px;
            left: 4px;
            transition: 0.25s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }

        .toggle.active {
            background: #4f46e5;
        }

        .toggle.active::after {
            transform: translateX(20px);
        }

        .select-box {
            border: 1px solid #dfe3ea;
            border-radius: 9px;
            padding: 10px 13px;
            background: white;
            min-width: 130px;
            outline: none;
            color: #374151;
        }

        .danger {
            border: 1px solid #fee2e2;
            background: #fffafa;
        }

        .danger .card-icon {
            background: #fee2e2;
        }

        .danger-btn {
            border: none;
            background: #dc2626;
            color: white;
            padding: 10px 17px;
            border-radius: 9px;
            cursor: pointer;
            font-weight: 600;
        }

        .danger-btn:hover {
            background: #b91c1c;
        }

        @media (max-width: 900px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }

            .settings-card.full {
                grid-column: auto;
            }
        }

        @media (max-width: 768px) {
            .admin-main {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-header {
                display: flex;
                align-items: center;
                gap: 14px;
                background: white;
                padding: 15px 20px;
                margin: -20px -20px 25px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }

            .mobile-header button {
                border: none;
                background: #eef2ff;
                color: #4f46e5;
                font-size: 22px;
                width: 42px;
                height: 42px;
                border-radius: 10px;
                cursor: pointer;
            }

            .mobile-header strong {
                font-size: 18px;
            }

            .topbar {
                align-items: flex-start;
            }

            .topbar h1 {
                font-size: 23px;
            }

            .admin-badge {
                display: none;
            }
        }

        @media (max-width: 520px) {
            .setting-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .toggle,
            .select-box,
            .danger-btn {
                align-self: flex-start;
            }
        }
    </style>
</head>

<body>

    @include('organization_admin.sidebar')

    <main class="admin-main">

        <div class="mobile-header">
            <button onclick="openAdminSidebar()">☰</button>
            <strong>Eventora</strong>
        </div>

        <div class="topbar">
            <div>
                <h1>⚙️ Settings</h1>
                <p>Manage your organization dashboard preferences.</p>
            </div>

            <div class="admin-badge">
                Organization Admin
            </div>
        </div>

        <div class="settings-grid">

            <!-- General Settings -->
            <div class="settings-card">

                <div class="card-title">
                    <div class="card-icon">⚙️</div>

                    <div>
                        <h2>General Settings</h2>
                        <p>Basic dashboard preferences</p>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Dashboard Notifications</h3>
                        <p>Receive notifications about new bookings.</p>
                    </div>

                    <div class="toggle active"
                         onclick="this.classList.toggle('active')">
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Booking Alerts</h3>
                        <p>Show alerts when a new booking is received.</p>
                    </div>

                    <div class="toggle active"
                         onclick="this.classList.toggle('active')">
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Language</h3>
                        <p>Select your dashboard language.</p>
                    </div>

                    <select class="select-box">
                        <option>English</option>
                        <option>Gujarati</option>
                        <option>Hindi</option>
                    </select>
                </div>

            </div>

            <!-- Appearance -->
            <div class="settings-card">

                <div class="card-title">
                    <div class="card-icon">🎨</div>

                    <div>
                        <h2>Appearance</h2>
                        <p>Customize your dashboard experience</p>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Dark Mode</h3>
                        <p>Use dark theme for the organization dashboard.</p>
                    </div>

                    <div class="toggle"
                         onclick="this.classList.toggle('active')">
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Compact Sidebar</h3>
                        <p>Use a smaller sidebar layout on desktop.</p>
                    </div>

                    <div class="toggle"
                         onclick="this.classList.toggle('active')">
                    </div>
                </div>

            </div>

            <!-- Account -->
            <div class="settings-card full">

                <div class="card-title">
                    <div class="card-icon">👤</div>

                    <div>
                        <h2>Account Settings</h2>
                        <p>Manage your organization administrator account</p>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Organization Profile</h3>
                        <p>Update your organization name, logo, contact details and other information.</p>
                    </div>

                    <a href="{{ route('organization.admin.profile') }}"
                       style="text-decoration:none;">
                        <button class="danger-btn"
                                style="background:#4f46e5;">
                            View Profile
                        </button>
                    </a>
                </div>

            </div>

            <!-- Security -->
            <div class="settings-card full">

                <div class="card-title">
                    <div class="card-icon">🔐</div>

                    <div>
                        <h2>Security</h2>
                        <p>Keep your organization account secure</p>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Password</h3>
                        <p>Change your organization admin account password.</p>
                    </div>

                    <a href="{{ route('password.request') }}"
                       style="text-decoration:none;">
                        <button class="danger-btn"
                                style="background:#4f46e5;">
                            Change Password
                        </button>
                    </a>
                </div>

            </div>

            <!-- Danger Zone -->
            <div class="settings-card full danger">

                <div class="card-title">
                    <div class="card-icon">⚠️</div>

                    <div>
                        <h2>Danger Zone</h2>
                        <p>Actions that can affect your organization account</p>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-info">
                        <h3>Organization Account</h3>
                        <p>
                            Organization account deletion is restricted.
                            Contact the Super Admin for account-related actions.
                        </p>
                    </div>

                    <button class="danger-btn"
                            onclick="alert('Please contact the Super Admin for this action.')">
                        Contact Admin
                    </button>
                </div>

            </div>

        </div>

    </main>

    <script>
        function openAdminSidebar() {
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            }
        }
    </script>

</body>
</html>