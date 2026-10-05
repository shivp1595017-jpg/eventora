@include('layouts.navbar')

<main class="profile-page">
    <div class="profile-shell">
        <header class="profile-heading">
            <div>
                <p class="eyebrow">ACCOUNT</p>
                <h1>My Profile</h1>
                <p class="subtitle">Your account details and security settings.</p>
            </div>
            <a class="button button-primary" href="{{ route('profile.edit') }}">Edit Profile</a>
        </header>

        @if (session('status') === 'profile-updated')
            <div class="notice notice-success" role="status">Your profile was updated successfully.</div>
        @elseif (session('status') === 'password-updated')
            <div class="notice notice-success" role="status">Your password was updated successfully.</div>
        @endif

        <section class="identity-card">
            <div class="avatar">
                <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @if ($user->profilePhotoUrl())
                    <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }} profile photo" referrerpolicy="no-referrer" onerror="this.remove()">
                @endif
            </div>
            <div class="identity-copy">
                <span class="eyebrow">EVENTORA MEMBER</span>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
            </div>
            <span class="account-badge">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
        </section>

        <div class="profile-grid">
            <section class="detail-card">
                <div class="card-heading">
                    <div class="card-icon" aria-hidden="true">👤</div>
                    <div>
                        <h2>Personal information</h2>
                        <p>These details are visible only to you.</p>
                    </div>
                </div>
                <dl class="detail-list">
                    <div>
                        <dt>Full name</dt>
                        <dd>{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt>Email address</dt>
                        <dd>{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt>Email verification</dt>
                        <dd>
                            <span class="verification-badge {{ $user->email_verified_at ? 'verified' : 'unverified' }}">
                                {{ $user->email_verified_at ? 'Verified' : 'Not verified' }}
                            </span>
                        </dd>
                    </div>
                </dl>
                <a class="text-link" href="{{ route('profile.edit') }}">Edit personal information <span aria-hidden="true">→</span></a>
            </section>

            <section class="detail-card security-card">
                <div class="card-heading">
                    <div class="card-icon" aria-hidden="true">🔐</div>
                    <div>
                        <h2>Password &amp; security</h2>
                        <p>Keep your account safe and up to date.</p>
                    </div>
                </div>
                <p class="security-copy">Change your password using your current password, or request a password reset link if you have forgotten it.</p>
                <div class="security-actions">
                    <a class="button button-secondary" href="{{ route('profile.edit') }}#update-password">Change Password</a>
                    <a class="text-link" href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
            </section>
        </div>

        <a class="back-link" href="{{ route('home') }}">← Back to Home</a>
    </div>
</main>

@include('layouts.footer')

<style>
    .profile-page {
        min-height: calc(100vh - 70px);
        padding: 54px 20px 70px;
        color: #f8fafc;
        background: radial-gradient(ellipse at 15% 0%, rgba(109, 93, 252, .16), transparent 38%), #0b0f19;
    }

    .profile-shell { width: min(1000px, 100%); margin: 0 auto; }
    .profile-heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 28px; }
    .profile-heading h1 { margin: 3px 0 7px; font-size: clamp(29px, 4vw, 38px); letter-spacing: -.8px; }
    .eyebrow { color: #9d91ff; font-size: 11px; font-weight: 800; letter-spacing: 1.4px; }
    .subtitle, .card-heading p { margin: 0; color: #9aa6ba; font-size: 14px; }
    .identity-card, .detail-card { border: 1px solid #29344c; border-radius: 18px; background: #111725; }
    .identity-card { display: flex; align-items: center; gap: 18px; padding: 24px; margin-bottom: 18px; }
    .avatar { position: relative; display: grid; width: 132px; height: 132px; flex: 0 0 132px; place-items: center; overflow: hidden; border: 4px solid rgba(255, 255, 255, .9); border-radius: 50%; background: linear-gradient(135deg, #6d5dfc, #a78bfa); color: white; font-size: 48px; font-weight: 800; box-shadow: 0 10px 26px rgba(0, 0, 0, .24); }
    .avatar img { position: absolute; inset: 0; width: 100%; height: 100%; border-radius: inherit; object-fit: cover; }
    .identity-copy { min-width: 0; flex: 1; }
    .identity-copy h2 { margin: 4px 0; font-size: 22px; overflow-wrap: anywhere; }
    .identity-copy p { margin: 0; color: #aab5c8; font-size: 14px; overflow-wrap: anywhere; }
    .account-badge, .verification-badge { display: inline-flex; align-items: center; border-radius: 999px; padding: 7px 11px; font-size: 12px; font-weight: 700; }
    .account-badge { border: 1px solid #393361; background: rgba(109, 93, 252, .12); color: #c4baff; white-space: nowrap; }
    .profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
    .detail-card { padding: 23px; }
    .card-heading { display: flex; align-items: center; gap: 13px; padding-bottom: 19px; border-bottom: 1px solid #29344c; }
    .card-icon { display: grid; width: 42px; height: 42px; flex: 0 0 42px; place-items: center; border-radius: 12px; background: rgba(109, 93, 252, .15); font-size: 20px; }
    .card-heading h2 { margin: 0 0 5px; font-size: 17px; }
    .card-heading p { font-size: 12px; line-height: 1.5; }
    .detail-list { display: grid; gap: 16px; margin: 20px 0; }
    .detail-list div { display: grid; grid-template-columns: 135px minmax(0, 1fr); align-items: center; gap: 12px; }
    .detail-list dt { color: #9aa6ba; font-size: 13px; }
    .detail-list dd { margin: 0; color: #f8fafc; font-size: 14px; font-weight: 600; overflow-wrap: anywhere; }
    .verified { background: rgba(18, 183, 106, .14); color: #75e0a7; }
    .unverified { background: rgba(247, 144, 9, .14); color: #fdb022; }
    .text-link { color: #aaa0ff; text-decoration: none; font-size: 13px; font-weight: 700; }
    .text-link:hover, .back-link:hover { color: #d1cbff; }
    .security-copy { margin: 20px 0; color: #aab5c8; font-size: 14px; line-height: 1.7; }
    .security-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 16px; }
    .button { display: inline-flex; min-height: 42px; align-items: center; justify-content: center; padding: 0 16px; border: 1px solid transparent; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 700; transition: .2s; }
    .button-primary { background: #6d5dfc; color: white; }
    .button-primary:hover { background: #5848eb; transform: translateY(-1px); }
    .button-secondary { border-color: #3a4560; background: #20283a; color: #f8fafc; }
    .button-secondary:hover { border-color: #6d5dfc; }
    .back-link { display: inline-block; margin-top: 24px; color: #aab5c8; text-decoration: none; font-size: 13px; font-weight: 600; }
    .notice { margin-bottom: 18px; padding: 13px 16px; border: 1px solid #126e47; border-radius: 10px; background: rgba(18, 183, 106, .12); color: #75e0a7; font-size: 14px; }

    html[data-theme="light"] .profile-page { color: #172033; background: radial-gradient(ellipse at 15% 0%, rgba(109, 93, 252, .12), transparent 38%), #f5f7fb; }
    html[data-theme="light"] .identity-card, html[data-theme="light"] .detail-card { border-color: #e1e6ef; background: #fff; box-shadow: 0 8px 25px rgba(20, 30, 50, .05); }
    html[data-theme="light"] .subtitle, html[data-theme="light"] .card-heading p, html[data-theme="light"] .identity-copy p, html[data-theme="light"] .security-copy, html[data-theme="light"] .detail-list dt, html[data-theme="light"] .back-link { color: #687386; }
    html[data-theme="light"] .identity-copy h2, html[data-theme="light"] .card-heading h2, html[data-theme="light"] .detail-list dd { color: #172033; }
    html[data-theme="light"] .card-heading { border-color: #e1e6ef; }
    html[data-theme="light"] .button-secondary { border-color: #dce2ec; background: #eef1f6; color: #172033; }
    html[data-theme="light"] .text-link { color: #5848eb; }
    html[data-theme="light"] .text-link:hover, html[data-theme="light"] .back-link:hover { color: #3928cb; }

    @media (max-width: 700px) {
        .profile-page { padding: 35px 16px 50px; }
        .profile-grid { grid-template-columns: 1fr; }
        .profile-heading { align-items: flex-start; }
    }
    @media (max-width: 460px) {
        .profile-heading { flex-direction: column; }
        .identity-card { align-items: flex-start; flex-wrap: wrap; }
        .account-badge { margin-left: 150px; }
        .detail-list div { grid-template-columns: 1fr; gap: 5px; }
    }
</style>
