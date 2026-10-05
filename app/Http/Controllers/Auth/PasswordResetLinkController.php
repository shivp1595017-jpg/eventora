<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordOtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display forgot password page.
     *
     * This flow is for logged-in users.
     * The registered email is taken automatically
     * from the currently authenticated user.
     */
    public function create(): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | User Must Be Logged In
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Please login to continue with password recovery.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Show Forgot Password Page
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.forgot-password'
        );
    }


    /**
     * Send OTP to the currently logged-in user's
     * registered email address.
     */
    public function store(
        Request $request
    ): RedirectResponse|View {

        /*
        |--------------------------------------------------------------------------
        | User Must Be Logged In
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Please login to continue with password recovery.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Get Logged-in User
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Get Registered Email Automatically
        |--------------------------------------------------------------------------
        */

        $email = strtolower(
            trim($user->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Make Sure User Exists
        |--------------------------------------------------------------------------
        */

        if (!$user instanceof User) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Your account could not be found.',
                ]);
        }


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
        | Remove Previous OTPs
        |--------------------------------------------------------------------------
        */

        PasswordOtp::where(
            'email',
            $email
        )->delete();


        /*
        |--------------------------------------------------------------------------
        | Create New OTP
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
        | Send OTP Email
        |--------------------------------------------------------------------------
        */

        try {

            Mail::to($email)
                ->send(
                    new PasswordOtpMail($otp)
                );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Remove OTP If Email Fails
            |--------------------------------------------------------------------------
            */

            $passwordOtp->delete();

            return back()
                ->withErrors([
                    'reset' =>
                        'OTP could not be sent to your registered email. Please try again.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Store OTP Information In Session
        |--------------------------------------------------------------------------
        */

        Session::put(
            'password_otp_email',
            $email
        );


        Session::put(
            'password_otp_id',
            $passwordOtp->id
        );


        Session::forget(
            'password_otp_verified'
        );


        /*
        |--------------------------------------------------------------------------
        | Show OTP Verification Page
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.verify-password-otp',
            compact('email')
        )->with(
            'status',
            'A 6-digit OTP has been sent to your registered email address.'
        );
    }


    /**
     * Display OTP verification page.
     */
    public function verifyForm(): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Please login to continue with password recovery.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Get Session Email
        |--------------------------------------------------------------------------
        */

        $email = Session::get(
            'password_otp_email'
        );


        $userEmail = strtolower(
            trim(auth()->user()->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Make Sure OTP Belongs To Logged-in User
        |--------------------------------------------------------------------------
        */

        if (
            !$email ||
            strtolower(trim($email)) !== $userEmail
        ) {

            Session::forget([
                'password_otp_email',
                'password_otp_id',
                'password_otp_verified',
            ]);


            return redirect()
                ->route('password.request')
                ->withErrors([
                    'reset' =>
                        'Please request a new password reset OTP.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Show OTP Page
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.verify-password-otp',
            compact('email')
        );
    }


    /**
     * Verify entered OTP.
     */
    public function verify(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Please login to continue with password recovery.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Validate OTP
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Session Data
        |--------------------------------------------------------------------------
        */

        $email = Session::get(
            'password_otp_email'
        );


        $otpId = Session::get(
            'password_otp_id'
        );


        /*
        |--------------------------------------------------------------------------
        | Current Logged-in User Email
        |--------------------------------------------------------------------------
        */

        $userEmail = strtolower(
            trim(auth()->user()->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Validate OTP Session
        |--------------------------------------------------------------------------
        */

        if (
            !$email ||
            !$otpId
        ) {

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'reset' =>
                        'Your OTP session has expired. Please request a new OTP.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Using OTP For Another Account
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(trim($email)) !==
            $userEmail
        ) {

            Session::forget([
                'password_otp_email',
                'password_otp_id',
                'password_otp_verified',
            ]);


            return redirect()
                ->route('password.request')
                ->withErrors([
                    'reset' =>
                        'This OTP does not belong to your account.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Find OTP
        |--------------------------------------------------------------------------
        */

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
            'password_otp_verified',
            true
        );


        /*
        |--------------------------------------------------------------------------
        | Go To Reset Password Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'password.otp.reset'
            );
    }


    /**
     * Show new password page.
     */
    public function resetForm(): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Please login to continue with password recovery.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Get Session
        |--------------------------------------------------------------------------
        */

        $email = Session::get(
            'password_otp_email'
        );


        $verified = Session::get(
            'password_otp_verified'
        );


        /*
        |--------------------------------------------------------------------------
        | Current User Email
        |--------------------------------------------------------------------------
        */

        $userEmail = strtolower(
            trim(auth()->user()->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Session
        |--------------------------------------------------------------------------
        */

        if (
            !$email ||
            !$verified ||
            strtolower(trim($email)) !== $userEmail
        ) {

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'reset' =>
                        'Please verify the OTP first.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Show Reset Page
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.reset-password-otp',
            compact('email')
        );
    }


    /**
     * Update password after OTP verification.
     */
    public function reset(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'reset' =>
                        'Please login to continue with password recovery.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Validate New Password
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Session Data
        |--------------------------------------------------------------------------
        */

        $email = Session::get(
            'password_otp_email'
        );


        $otpId = Session::get(
            'password_otp_id'
        );


        $verified = Session::get(
            'password_otp_verified'
        );


        /*
        |--------------------------------------------------------------------------
        | Current User Email
        |--------------------------------------------------------------------------
        */

        $userEmail = strtolower(
            trim(auth()->user()->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Reset Session
        |--------------------------------------------------------------------------
        */

        if (
            !$email ||
            !$otpId ||
            !$verified
        ) {

            return redirect()
                ->route(
                    'password.request'
                )
                ->withErrors([
                    'reset' =>
                        'Your password reset session has expired. Please request a new OTP.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Account Mismatch
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(trim($email)) !==
            $userEmail
        ) {

            Session::forget([
                'password_otp_email',
                'password_otp_id',
                'password_otp_verified',
            ]);


            return redirect()
                ->route(
                    'password.request'
                )
                ->withErrors([
                    'reset' =>
                        'This password reset session does not belong to your account.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Find OTP
        |--------------------------------------------------------------------------
        */

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
                ->route(
                    'password.request'
                )
                ->withErrors([
                    'reset' =>
                        'Invalid password reset session.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Already Used
        |--------------------------------------------------------------------------
        */

        if (
            $passwordOtp->used_at
        ) {

            return redirect()
                ->route(
                    'password.request'
                )
                ->withErrors([
                    'reset' =>
                        'This password reset OTP has already been used.',
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

            return redirect()
                ->route(
                    'password.request'
                )
                ->withErrors([
                    'reset' =>
                        'Your OTP has expired. Please request a new one.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Find Current User
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();


        if (!$user instanceof User) {

            return redirect()
                ->route(
                    'login'
                )
                ->withErrors([
                    'reset' =>
                        'Account not found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Double Check Email
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(trim($user->email)) !==
            strtolower(trim($email))
        ) {

            return redirect()
                ->route(
                    'password.request'
                )
                ->withErrors([
                    'reset' =>
                        'Your registered email has changed. Please request a new OTP.',
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
                ->withInput()
                ->withErrors([
                    'password' =>
                        'Your new password must be different from your current password.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Update Password
            |--------------------------------------------------------------------------
            */

            $user->update([

                'password' =>
                    Hash::make(
                        $request->password
                    ),

            ]);


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
            | Clear Reset Session
            |--------------------------------------------------------------------------
            */

            Session::forget([

                'password_otp_email',

                'password_otp_id',

                'password_otp_verified',

            ]);


            /*
            |--------------------------------------------------------------------------
            | Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Logout Current Session
            |--------------------------------------------------------------------------
            */

            auth()->logout();


            /*
            |--------------------------------------------------------------------------
            | Regenerate Session
            |--------------------------------------------------------------------------
            */

            $request->session()->invalidate();

            $request->session()->regenerateToken();


            /*
            |--------------------------------------------------------------------------
            | Redirect Login
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'login'
                )
                ->with(
                    'status',
                    'Your password has been reset successfully. You can now login with your new password.'
                );


        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->withErrors([
                    'password' =>
                        'Password could not be updated. Please try again.',
                ]);
        }
    }
}