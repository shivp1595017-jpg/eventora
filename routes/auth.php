<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    Route::get(
        'register',
        [RegisteredUserController::class, 'create']
    )->name('register');


    Route::post(
        'register',
        [RegisteredUserController::class, 'store']
    );


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        'login',
        [AuthenticatedSessionController::class, 'create']
    )->name('login');


    Route::post(
        'login',
        [AuthenticatedSessionController::class, 'store']
    );


    /*
    |--------------------------------------------------------------------------
    | Normal Password Setup Link
    |--------------------------------------------------------------------------
    |
    | Used for:
    | - New Staff
    | - Organization Admin
    |
    */

    Route::get(
        'reset-password/{token}',
        [NewPasswordController::class, 'create']
    )->name('password.reset');


    Route::post(
        'reset-password',
        [NewPasswordController::class, 'store']
    )->name('password.store');

});


/*
|--------------------------------------------------------------------------
| Forgot Password + OTP
|--------------------------------------------------------------------------
|
| These routes are intentionally NOT inside guest middleware.
| This allows logged-in User / Organization Admin / Staff
| to use Forgot Password from their Profile.
|
*/


/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/

Route::get(
    'forgot-password',
    [PasswordResetLinkController::class, 'create']
)->name('password.request');


Route::post(
    'forgot-password',
    [PasswordResetLinkController::class, 'store']
)->name('password.email');


/*
|--------------------------------------------------------------------------
| Verify Password Reset OTP
|--------------------------------------------------------------------------
*/

Route::get(
    'password/otp/verify',
    [PasswordResetLinkController::class, 'verifyForm']
)->name('password.otp.verify');


Route::post(
    'password/otp/verify',
    [PasswordResetLinkController::class, 'verify']
)->name('password.otp.verify.submit');


/*
|--------------------------------------------------------------------------
| Reset Password After OTP
|--------------------------------------------------------------------------
*/

Route::get(
    'password/otp/reset',
    [PasswordResetLinkController::class, 'resetForm']
)->name('password.otp.reset');


Route::post(
    'password/otp/reset',
    [PasswordResetLinkController::class, 'reset']
)->name('password.otp.reset.store');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    Route::get(
        'verify-email',
        EmailVerificationPromptController::class
    )->name('verification.notice');


    Route::get(
        'verify-email/{id}/{hash}',
        VerifyEmailController::class
    )
        ->middleware([
            'signed',
            'throttle:6,1'
        ])
        ->name('verification.verify');


    Route::post(
        'email/verification-notification',
        [
            EmailVerificationNotificationController::class,
            'store'
        ]
    )
        ->middleware('throttle:6,1')
        ->name('verification.send');


    /*
    |--------------------------------------------------------------------------
    | Confirm Password
    |--------------------------------------------------------------------------
    */

    Route::get(
        'confirm-password',
        [
            ConfirmablePasswordController::class,
            'show'
        ]
    )->name('password.confirm');


    Route::post(
        'confirm-password',
        [
            ConfirmablePasswordController::class,
            'store'
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Change Password
    |--------------------------------------------------------------------------
    |
    | Current Password
    | New Password
    | Confirm New Password
    |
    */

    Route::put(
        'password',
        [
            PasswordController::class,
            'update'
        ]
    )->name('password.update');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post(
        'logout',
        [
            AuthenticatedSessionController::class,
            'destroy'
        ]
    )->name('logout');

});