<?php

namespace App\Http\Controllers;

use App\Mail\PasswordOtpMail;
use App\Models\PasswordOtp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class OrganizationAdminPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Initial Password Setup
    |--------------------------------------------------------------------------
    |
    | Used from the password setup link sent to:
    | - Organization Admin
    | - Organization Staff
    |
    */


    /**
     * Show password setup form.
     */
    public function create(Request $request): View
    {
        return view('organization_admin.password_setup', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }


    /**
     * Store password from initial setup link.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => [
                'required',
                'string',
            ],

            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);


        $status = Password::broker('users')->reset(
            [
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' =>
                    $request->password_confirmation,
                'token' => $request->token,
            ],
            function ($user, $password) {

                $user->forceFill([
                    'password' => $password,
                    'email_verified_at' => now(),
                ])->save();

            }
        );


        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with(
                    'status',
                    'Password created successfully. You can now login.'
                );

        }


        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([
                'email' => __($status),
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ORGANIZATION PANEL ACCESS
    |--------------------------------------------------------------------------
    */


    /**
     * Make sure only Organization Admin / Staff can use
     * the organization-panel password management.
     */
    private function authorizeOrganizationPanelUser(): void
    {
        $user = auth()->user();


        if (!$user) {

            abort(
                403,
                'Unauthorized access.'
            );

        }


        if (
            !in_array(
                $user->role,
                [
                    'organization_admin',
                    'organization_staff',
                ],
                true
            )
        ) {

            abort(
                403,
                'This password section is available only to Organization Admin and Organization Staff.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Staff Account Must Be Active
        |--------------------------------------------------------------------------
        */

        if (
            $user->role ===
            'organization_staff'
        ) {

            $staff =
                $user->currentOrganizationStaff();


            if (!$staff) {

                abort(
                    403,
                    'Your staff access is inactive or not assigned.'
                );

            }


            if (
                $staff->status !==
                'active'
            ) {

                abort(
                    403,
                    'Your staff account is inactive.'
                );

            }

        }
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD
    |--------------------------------------------------------------------------
    |
    | Current Password
    | New Password
    | Confirm New Password
    |
    | No OTP.
    |
    */


    /**
     * Show Change Password page.
     */
    public function changePasswordForm(): View
    {
        $this->authorizeOrganizationPanelUser();

        return view(
            'organization_admin.password_change'
        );
    }


    /**
     * Change password using current password.
     */
    public function changePassword(
        Request $request
    ): RedirectResponse {

        $this->authorizeOrganizationPanelUser();


        $request->validate([

            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ]);


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Check Current Password
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {

            return back()
                ->withInput(
                    $request->except([
                        'current_password',
                        'password',
                        'password_confirmation',
                    ])
                )
                ->withErrors([
                    'current_password' =>
                        'Current password is incorrect.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Same Password
        |--------------------------------------------------------------------------
        */

        if (
            Hash::check(
                $request->password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'password' =>
                        'New password must be different from your current password.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        $user->forceFill([
            'password' =>
                Hash::make(
                    $request->password
                ),
        ])->save();


        /*
        |--------------------------------------------------------------------------
        | Logout Other Sessions
        |--------------------------------------------------------------------------
        |
        | Current session remains active.
        |
        */

        auth()->logoutOtherDevices(
            $request->password
        );


        return back()->with(
            'password_changed',
            'Password changed successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD - DIRECT OTP
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | No email input is required.
    |
    | The currently logged-in Organization Admin / Staff
    | email is automatically used.
    |
    */


    /**
     * Start forgot-password OTP process.
     */
    public function forgotPassword(): View|RedirectResponse
    {
        $this->authorizeOrganizationPanelUser();


        $user = auth()->user();


        $email = strtolower(
            trim($user->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Previous OTPs
        |--------------------------------------------------------------------------
        */

        PasswordOtp::where(
            'email',
            $email
        )->delete();


        /*
        |--------------------------------------------------------------------------
        | Generate 6 Digit OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(
            100000,
            999999
        );


        /*
        |--------------------------------------------------------------------------
        | Create OTP Record
        |--------------------------------------------------------------------------
        */

        $passwordOtp = PasswordOtp::create([

            'email' =>
                $email,

            'otp_hash' =>
                Hash::make($otp),

            'expires_at' =>
                now()->addMinutes(10),

            'verified_at' =>
                null,

            'used_at' =>
                null,

            'attempts' =>
                0,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Send OTP
        |--------------------------------------------------------------------------
        */

        try {

            Mail::to($email)->send(
                new PasswordOtpMail($otp)
            );

        } catch (\Throwable $e) {

            $passwordOtp->delete();


            return back()->withErrors([
                'password' =>
                    'OTP could not be sent. Please try again.',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Store Session
        |--------------------------------------------------------------------------
        */

        Session::put(
            'organization_password_otp_email',
            $email
        );


        Session::put(
            'organization_password_otp_id',
            $passwordOtp->id
        );


        Session::forget(
            'organization_password_otp_verified'
        );


        /*
        |--------------------------------------------------------------------------
        | OTP Verification Page
        |--------------------------------------------------------------------------
        */

        return view(
            'organization_admin.password_forgot_otp',
            compact('email')
        )->with(
            'status',
            'A 6-digit OTP has been sent to your registered email address.'
        );
    }


    /**
     * Show OTP verification page.
     */
    public function forgotPasswordForm(): View|RedirectResponse
    {
        $this->authorizeOrganizationPanelUser();


        $email = Session::get(
            'organization_password_otp_email'
        );


        if (!$email) {

            return redirect()
                ->back()
                ->withErrors([
                    'password' =>
                        'Please request a new password reset OTP.',
                ]);

        }


        return view(
            'organization_admin.password_forgot_otp',
            compact('email')
        );
    }


    /**
     * Verify OTP.
     */
    public function verifyForgotPasswordOtp(
        Request $request
    ): RedirectResponse {

        $this->authorizeOrganizationPanelUser();


        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);


        $email = Session::get(
            'organization_password_otp_email'
        );


        $otpId = Session::get(
            'organization_password_otp_id'
        );


        if (
            !$email ||
            !$otpId
        ) {

            return redirect()
                ->back()
                ->withErrors([
                    'otp' =>
                        'Your OTP session has expired. Please request a new OTP.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Security: OTP Email Must Match Logged In User
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(auth()->user()->email)
            ) !== $email
        ) {

            Session::forget([
                'organization_password_otp_email',
                'organization_password_otp_id',
                'organization_password_otp_verified',
            ]);


            abort(
                403,
                'Unauthorized password reset request.'
            );

        }


        $passwordOtp = PasswordOtp::where(
                'id',
                $otpId
            )
            ->where(
                'email',
                $email
            )
            ->first();


        if (!$passwordOtp) {

            return back()
                ->withErrors([
                    'otp' =>
                        'Invalid or expired OTP.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Already Used
        |--------------------------------------------------------------------------
        */

        if ($passwordOtp->used_at) {

            return back()
                ->withErrors([
                    'otp' =>
                        'This OTP has already been used.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Expired
        |--------------------------------------------------------------------------
        */

        if (
            now()->greaterThan(
                $passwordOtp->expires_at
            )
        ) {

            return back()
                ->withErrors([
                    'otp' =>
                        'This OTP has expired. Please request a new OTP.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Maximum Attempts
        |--------------------------------------------------------------------------
        */

        if (
            $passwordOtp->attempts >= 5
        ) {

            return back()
                ->withErrors([
                    'otp' =>
                        'Too many incorrect attempts. Please request a new OTP.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Check OTP
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->otp,
                $passwordOtp->otp_hash
            )
        ) {

            $passwordOtp->increment(
                'attempts'
            );


            return back()
                ->withErrors([
                    'otp' =>
                        'The OTP you entered is incorrect.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Mark OTP Verified
        |--------------------------------------------------------------------------
        */

        $passwordOtp->update([
            'verified_at' =>
                now(),
        ]);


        Session::put(
            'organization_password_otp_verified',
            true
        );


        return redirect()->route(
            'organization.admin.password.forgot.reset'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD AFTER OTP
    |--------------------------------------------------------------------------
    */


    /**
     * Show reset password page.
     */
    public function forgotPasswordResetForm(): View|RedirectResponse
    {
        $this->authorizeOrganizationPanelUser();


        $email = Session::get(
            'organization_password_otp_email'
        );


        $verified = Session::get(
            'organization_password_otp_verified'
        );


        if (
            !$email ||
            !$verified
        ) {

            return redirect()
                ->back()
                ->withErrors([
                    'password' =>
                        'Please verify your OTP first.',
                ]);

        }


        return view(
            'organization_admin.password_forgot_reset',
            compact('email')
        );
    }


    /**
     * Reset password after successful OTP verification.
     */
    public function forgotPasswordReset(
        Request $request
    ): RedirectResponse {

        $this->authorizeOrganizationPanelUser();


        $request->validate([

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ]);


        $email = Session::get(
            'organization_password_otp_email'
        );


        $otpId = Session::get(
            'organization_password_otp_id'
        );


        $verified = Session::get(
            'organization_password_otp_verified'
        );


        if (
            !$email ||
            !$otpId ||
            !$verified
        ) {

            return redirect()
                ->back()
                ->withErrors([
                    'password' =>
                        'Your password reset session has expired. Please request a new OTP.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Security: Email Must Belong To Current Account
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(auth()->user()->email)
            ) !== $email
        ) {

            Session::forget([
                'organization_password_otp_email',
                'organization_password_otp_id',
                'organization_password_otp_verified',
            ]);


            abort(
                403,
                'Unauthorized password reset request.'
            );

        }


        $passwordOtp = PasswordOtp::where(
                'id',
                $otpId
            )
            ->where(
                'email',
                $email
            )
            ->first();


        if (!$passwordOtp) {

            return redirect()
                ->back()
                ->withErrors([
                    'password' =>
                        'Invalid password reset session.',
                ]);

        }


        if ($passwordOtp->used_at) {

            return redirect()
                ->back()
                ->withErrors([
                    'password' =>
                        'This OTP has already been used.',
                ]);

        }


        if (
            now()->greaterThan(
                $passwordOtp->expires_at
            )
        ) {

            return redirect()
                ->back()
                ->withErrors([
                    'password' =>
                        'Your OTP has expired. Please request a new OTP.',
                ]);

        }


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Prevent Same Password
        |--------------------------------------------------------------------------
        */

        if (
            Hash::check(
                $request->password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'password' =>
                        'New password must be different from your current password.',
                ]);

        }


        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Update Password
            |--------------------------------------------------------------------------
            */

            $user->forceFill([
                'password' =>
                    Hash::make(
                        $request->password
                    ),
            ])->save();


            /*
            |--------------------------------------------------------------------------
            | Mark OTP Used
            |--------------------------------------------------------------------------
            */

            $passwordOtp->update([
                'used_at' =>
                    now(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Clear OTP Session
            |--------------------------------------------------------------------------
            */

            Session::forget([
                'organization_password_otp_email',
                'organization_password_otp_id',
                'organization_password_otp_verified',
            ]);


            DB::commit();


            return redirect()
                ->route(
                    'organization.admin.dashboard'
                )
                ->with(
                    'password_changed',
                    'Password reset successfully.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withErrors([
                    'password' =>
                        'Password could not be updated. Please try again.',
                ]);
        }
    }
}