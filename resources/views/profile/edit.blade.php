@include('layouts.navbar')

<div class="profile-page">

    <div class="profile-container">

        <!-- PAGE HEADER -->
        <div class="profile-header">
            <div>
                <h1>My Profile</h1>
                <p>Manage your account information and security settings.</p>
            </div>

            <div class="profile-avatar">
                <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @if($user->profilePhotoUrl())
                    <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }} profile photo" referrerpolicy="no-referrer" onerror="this.remove()">
                @endif
            </div>
        </div>


        <!-- PROFILE INFORMATION -->
        <section class="profile-card">

            <div class="card-icon">
                👤
            </div>

            <div class="card-content">

                <h2>Profile Information</h2>

                <p class="card-description">
                    Update your account name and email address.
                </p>


                @if (session('status') === 'profile-updated')

                    <div class="success-message">
                        ✓ Profile information updated successfully.
                    </div>

                @endif


                <form
                    method="post"
                    action="{{ route('profile.update') }}"
                    class="profile-form"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('patch')


                    <div class="form-group">

                        <label for="name">
                            Name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            required
                            autofocus
                            autocomplete="name"
                        >

                        @if ($errors->get('name'))

                            <div class="error-message">
                                {{ $errors->first('name') }}
                            </div>

                        @endif

                    </div>

                    <div class="form-group">
                        <label for="profile_photo">Profile photo</label>
                        <input id="profile_photo" name="profile_photo" type="file" accept="image/jpeg,image/png,image/webp">
                        <small class="photo-help">JPG, PNG or WebP, up to 2 MB. Upload a photo to replace your Google profile image.</small>
                        @error('profile_photo')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    @if($user->profile_photo_path)
                        <label class="remove-photo-option"><input type="checkbox" name="remove_profile_photo" value="1"> Remove uploaded photo and use Google image or initials</label>
                    @endif


                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            autocomplete="username"
                        >

                        @if ($errors->get('email'))

                            <div class="error-message">
                                {{ $errors->first('email') }}
                            </div>

                        @endif

                    </div>


                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

                        <div class="verify-box">

                            <p>
                                Your email address is not verified.
                            </p>

                            <button type="submit" form="resendVerificationForm">Resend Verification Email</button>

                        </div>

                    @endif


                    <button type="submit" class="save-btn">
                        Save Changes
                    </button>

                </form>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <form id="resendVerificationForm" method="post" action="{{ route('verification.send') }}">@csrf</form>
                @endif

            </div>

        </section>



        <!-- UPDATE PASSWORD -->
        <section class="profile-card" id="update-password">

            <div class="card-icon">
                🔐
            </div>

            <div class="card-content">

                <h2>Update Password</h2>

                <p class="card-description">
                    Use a strong password to keep your Eventora account secure.
                </p>


                @if (session('status') === 'password-updated')

                    <div class="success-message">
                        ✓ Password updated successfully.
                    </div>

                @endif


                <form
                    method="post"
                    action="{{ route('password.update') }}"
                    class="profile-form"
                >

                    @csrf
                    @method('put')


                    <div class="form-group">

                        <label for="current_password">
                            Current Password
                        </label>

                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            autocomplete="current-password"
                        >

                        @if ($errors->updatePassword->get('current_password'))

                            <div class="error-message">
                                {{ $errors->updatePassword->first('current_password') }}
                            </div>

                        @endif

                    </div>


                    <div class="form-group">

                        <label for="password">
                            New Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                        >

                        @if ($errors->updatePassword->get('password'))

                            <div class="error-message">
                                {{ $errors->updatePassword->first('password') }}
                            </div>

                        @endif

                    </div>


                    <div class="form-group">

                        <label for="password_confirmation">
                            Confirm New Password
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                        >

                        @if ($errors->updatePassword->get('password_confirmation'))

                            <div class="error-message">
                                {{ $errors->updatePassword->first('password_confirmation') }}
                            </div>

                        @endif

                    </div>


                    <button type="submit" class="save-btn">
                        Update Password
                    </button>

                </form>

            </div>

        </section>



        <!-- DELETE ACCOUNT -->
        <section class="profile-card danger-card">

            <div class="card-icon danger-icon">
                🗑️
            </div>

            <div class="card-content">

                <h2>Delete Account</h2>

                <p class="card-description">
                    Permanently delete your Eventora account and all
                    associated data.
                </p>


                <button
                    type="button"
                    class="delete-btn"
                    onclick="openDeleteModal()"
                >
                    Delete Account
                </button>

            </div>

        </section>


        <!-- BACK -->
        <div class="profile-back">

            <a href="{{ route('profile.show') }}">
                ← Back to Profile
            </a>

        </div>

    </div>

</div>


<!-- DELETE MODAL -->

<div
    class="modal-overlay"
    id="deleteModal"
>

    <div class="delete-modal">

        <div class="modal-icon">
            ⚠️
        </div>

        <h2>Delete Account?</h2>

        <p>
            Once your account is deleted, all of your data will be
            permanently removed. This action cannot be undone.
        </p>


        <form
            method="post"
            action="{{ route('profile.destroy') }}"
        >

            @csrf
            @method('delete')


            <div class="form-group">

                <label for="delete_password">
                    Enter your password
                </label>

                <input
                    id="delete_password"
                    name="password"
                    type="password"
                    placeholder="Enter your password"
                    required
                >

                @if ($errors->userDeletion->get('password'))

                    <div class="error-message">
                        {{ $errors->userDeletion->first('password') }}
                    </div>

                @endif

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeDeleteModal()"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="confirm-delete-btn"
                >
                    Delete Permanently
                </button>

            </div>

        </form>

    </div>

</div>


@include('layouts.footer')


<style>

/* =========================================
   EVENTORA PROFILE
========================================= */

.profile-page {
    min-height: 100vh;
    padding: 55px 20px 20px;
    background: #0b0f19;
    color: #ffffff;
}


.profile-container {
    width: min(1000px, 100%);
    margin: auto;
}


/* =========================================
   HEADER
========================================= */

.profile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 25px;

    margin-bottom: 35px;
}


.profile-header h1 {
    margin: 0 0 8px;

    font-size: 34px;
    font-weight: 800;

    color: #ffffff;
}


.profile-header p {
    margin: 0;

    color: #8f9aae;

    font-size: 15px;
}


.profile-avatar {
    width: 68px;
    height: 68px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 50%;
    position: relative;
    overflow: hidden;

    background: linear-gradient(
        135deg,
        #6d5dfc,
        #8b7cff
    );

    color: #ffffff;

    font-size: 25px;
    font-weight: 800;

    box-shadow:
        0 10px 30px rgba(109, 93, 252, 0.25);
}

.profile-avatar img { position:absolute; inset:0; width:100%; height:100%; border-radius:inherit; object-fit:cover; }
.photo-help { display:block; margin-top:7px; color:#8f9aae; font-size:12px; }
.remove-photo-option { display:flex; align-items:center; gap:8px; margin:-5px 0 18px; color:#cbd5e1; font-size:12px; }
.remove-photo-option input { accent-color:#6d5dfc; }


/* =========================================
   CARD
========================================= */

.profile-card {
    display: flex;

    gap: 24px;

    margin-bottom: 24px;

    padding: 30px;

    background: #151b2b;

    border: 1px solid #29344c;

    border-radius: 18px;

    box-shadow:
        0 15px 40px rgba(0, 0, 0, 0.18);
}


.card-icon {
    width: 48px;
    height: 48px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    background: rgba(109, 93, 252, 0.13);

    font-size: 23px;
}


.card-content {
    flex: 1;
}


.card-content h2 {
    margin: 0 0 7px;

    color: #ffffff;

    font-size: 21px;
}


.card-description {
    margin: 0 0 25px;

    color: #8f9aae;

    line-height: 1.6;

    font-size: 14px;
}


/* =========================================
   FORM
========================================= */

.profile-form {
    width: 100%;
}


.form-group {
    margin-bottom: 20px;
}


.form-group label {
    display: block;

    margin-bottom: 8px;

    color: #d8deea;

    font-size: 14px;
    font-weight: 600;
}


.form-group input {
    width: 100%;

    box-sizing: border-box;

    padding: 13px 15px;

    background: #0f1422;

    border: 1px solid #303a52;

    border-radius: 9px;

    outline: none;

    color: #ffffff;

    font-size: 14px;

    transition: 0.2s;
}


.form-group input:focus {
    border-color: #6d5dfc;

    box-shadow:
        0 0 0 3px rgba(109, 93, 252, 0.12);
}


.form-group input::placeholder {
    color: #687386;
}


/* =========================================
   BUTTONS
========================================= */

.save-btn {
    padding: 12px 21px;

    border: none;

    border-radius: 9px;

    background: #6d5dfc;

    color: #ffffff;

    font-size: 14px;
    font-weight: 700;

    cursor: pointer;

    transition: 0.2s;
}


.save-btn:hover {
    background: #5848eb;

    transform: translateY(-1px);
}


.delete-btn {
    padding: 11px 18px;

    border: 1px solid #74353a;

    border-radius: 9px;

    background: #351c21;

    color: #ff8d95;

    font-size: 14px;
    font-weight: 700;

    cursor: pointer;

    transition: 0.2s;
}


.delete-btn:hover {
    background: #4a2228;

    border-color: #ff5d68;
}


.danger-card {
    border-color: #472b31;
}


.danger-icon {
    background: rgba(255, 80, 90, 0.10);
}


/* =========================================
   SUCCESS
========================================= */

.success-message {
    margin-bottom: 20px;

    padding: 12px 14px;

    border: 1px solid #285d3d;

    border-radius: 9px;

    background: #13291d;

    color: #71dc93;

    font-size: 14px;
}


.error-message {
    margin-top: 7px;

    color: #ff7d87;

    font-size: 13px;
}


/* =========================================
   VERIFY
========================================= */

.verify-box {
    margin-bottom: 20px;

    padding: 15px;

    border: 1px solid #4a3c20;

    border-radius: 10px;

    background: #292313;

    color: #e9c76f;

    font-size: 14px;
}


.verify-box p {
    margin: 0 0 10px;
}


.verify-box button {
    padding: 8px 12px;

    border: 1px solid #6d5dfc;

    border-radius: 7px;

    background: transparent;

    color: #a99fff;

    cursor: pointer;
}


/* =========================================
   BACK
========================================= */

.profile-back {
    margin-top: 10px;

    text-align: center;
}


.profile-back a {
    color: #8f9aae;

    text-decoration: none;

    font-size: 14px;
}


.profile-back a:hover {
    color: #8b7cff;
}


/* =========================================
   DELETE MODAL
========================================= */

.modal-overlay {
    position: fixed;

    inset: 0;

    z-index: 10000;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(0, 0, 0, 0.72);

    backdrop-filter: blur(5px);
}


.modal-overlay.show {
    display: flex;
}


.delete-modal {
    width: min(450px, 100%);

    padding: 30px;

    background: #151b2b;

    border: 1px solid #343e55;

    border-radius: 18px;

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.5);
}


.modal-icon {
    width: 52px;
    height: 52px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 17px;

    border-radius: 12px;

    background: rgba(255, 80, 90, 0.10);

    font-size: 24px;
}


.delete-modal h2 {
    margin: 0 0 10px;

    color: #ffffff;

    font-size: 22px;
}


.delete-modal p {
    margin: 0 0 22px;

    color: #8f9aae;

    line-height: 1.6;

    font-size: 14px;
}


.modal-actions {
    display: flex;

    justify-content: flex-end;

    gap: 10px;

    margin-top: 22px;
}


.cancel-btn {
    padding: 11px 17px;

    border: 1px solid #303a52;

    border-radius: 8px;

    background: #20283a;

    color: #d8deea;

    cursor: pointer;
}


.confirm-delete-btn {
    padding: 11px 17px;

    border: none;

    border-radius: 8px;

    background: #dc3545;

    color: #ffffff;

    font-weight: 700;

    cursor: pointer;
}


.confirm-delete-btn:hover {
    background: #c82333;
}


/* =========================================
   LIGHT MODE
========================================= */

html[data-theme="light"] .profile-page {
    background: #f5f7fb;

    color: #172033;
}


html[data-theme="light"] .profile-header h1 {
    color: #172033;
}


html[data-theme="light"] .profile-header p {
    color: #687386;
}


html[data-theme="light"] .profile-card {
    background: #ffffff;

    border-color: #e1e6ef;

    box-shadow:
        0 10px 30px rgba(20, 30, 50, 0.06);
}


html[data-theme="light"] .card-icon {
    background: #eeecff;
}


html[data-theme="light"] .card-content h2 {
    color: #172033;
}


html[data-theme="light"] .card-description {
    color: #687386;
}


html[data-theme="light"] .form-group label {
    color: #344054;
}


html[data-theme="light"] .form-group input {
    background: #ffffff;

    border-color: #dce2ec;

    color: #172033;
}

html[data-theme="light"] .photo-help,
html[data-theme="light"] .remove-photo-option { color:#687386; }


html[data-theme="light"] .form-group input:focus {
    border-color: #6d5dfc;

    box-shadow:
        0 0 0 3px rgba(109, 93, 252, 0.10);
}


html[data-theme="light"] .success-message {
    background: #edf9f1;

    border-color: #c7ead2;

    color: #218838;
}


html[data-theme="light"] .danger-card {
    border-color: #f0d7da;
}


html[data-theme="light"] .delete-btn {
    background: #fff1f2;

    border-color: #f3c5ca;

    color: #d63031;
}


html[data-theme="light"] .delete-btn:hover {
    background: #ffe4e7;

    border-color: #e75b64;
}


html[data-theme="light"] .profile-back a {
    color: #687386;
}


html[data-theme="light"] .profile-back a:hover {
    color: #5848eb;
}


html[data-theme="light"] .delete-modal {
    background: #ffffff;

    border-color: #e1e6ef;

    box-shadow:
        0 25px 70px rgba(20, 30, 50, 0.20);
}


html[data-theme="light"] .delete-modal h2 {
    color: #172033;
}


html[data-theme="light"] .delete-modal p {
    color: #687386;
}


html[data-theme="light"] .cancel-btn {
    background: #f1f3f7;

    border-color: #dce2ec;

    color: #344054;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 650px) {

    .profile-page {
        padding: 35px 14px 20px;
    }


    .profile-header {
        align-items: flex-start;
    }


    .profile-header h1 {
        font-size: 28px;
    }


    .profile-avatar {
        width: 55px;
        height: 55px;

        font-size: 21px;
    }


    .profile-card {
        flex-direction: column;

        padding: 22px;

        gap: 15px;
    }


    .card-icon {
        width: 44px;
        height: 44px;
    }


    .modal-actions {
        flex-direction: column-reverse;
    }


    .cancel-btn,
    .confirm-delete-btn {
        width: 100%;
    }

}

</style>


<script>

function openDeleteModal()
{
    document
        .getElementById('deleteModal')
        .classList.add('show');
}


function closeDeleteModal()
{
    document
        .getElementById('deleteModal')
        .classList.remove('show');
}


document
    .getElementById('deleteModal')
    .addEventListener('click', function(event) {

        if (event.target === this) {

            closeDeleteModal();

        }

    });


document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeDeleteModal();

    }

});

</script>
