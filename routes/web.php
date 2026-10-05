<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrganizationAdminController;
use App\Http\Controllers\OrganizationAdminEventController;
use App\Http\Controllers\SuperAdminOrganizationController;
use App\Http\Controllers\SuperAdminEventController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdminUserController;
use App\Http\Controllers\SuperAdminBookingController;
use App\Http\Controllers\SuperAdminPaymentController;
use App\Http\Controllers\SuperAdminExportController;
use App\Http\Controllers\OrganizationAdminPasswordController;
use App\Http\Controllers\OrganizationAdminProfileController;
use App\Http\Controllers\OrganizationAdminBookingController;
use App\Http\Controllers\OrganizationAdminParticipantController;
use App\Http\Controllers\OrganizationAdminSettingsController;
use App\Http\Controllers\OrganizationAdminTicketVerificationController;
use App\Http\Controllers\OrganizationAdminExportController;
use App\Http\Controllers\OrganizationAdminUnitController;
use App\Http\Controllers\OrganizationAdminStaffController;
use App\Http\Controllers\SuperAdminStaffController;
use App\Http\Controllers\SuperAdminAccessStaffController;
use App\Http\Controllers\SuperAdminTicketVerificationController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/categories', [PublicPageController::class, 'categories'])->name('categories.index');
Route::get('/how-it-works', [PublicPageController::class, 'howItWorks'])->name('pages.how-it-works');
Route::get('/about', [PublicPageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('pages.contact');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| User Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'show'
    ])->name('profile.show');

    Route::get('/profile/edit', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Google Authentication
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [
    GoogleController::class,
    'redirect'
])->name('google.redirect');

Route::get('/auth/google/callback', [
    GoogleController::class,
    'callback'
])->name('google.callback');


/*
|--------------------------------------------------------------------------
| Organizations
|--------------------------------------------------------------------------
*/

Route::get('/organizations/search', [
    OrganizationController::class,
    'search'
])->name('organizations.search');

Route::get('/organization/register', [
    OrganizationController::class,
    'create'
])->name('organizations.create');

Route::post('/organization/register', [
    OrganizationController::class,
    'store'
])->name('organizations.store');

Route::get('/organization/{slug}', [
    OrganizationController::class,
    'show'
])->name('organizations.show');


/*
|--------------------------------------------------------------------------
| Events
|--------------------------------------------------------------------------
*/

Route::get('/event/{slug}', [
    EventController::class,
    'show'
])->name('events.show');


/*
|--------------------------------------------------------------------------
| Booking
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/event/{slug}/book', [
        BookingController::class,
        'create'
    ])->name('bookings.create');

    Route::post('/event/{slug}/book', [
        BookingController::class,
        'store'
    ])->name('bookings.store');

    Route::get('/booking/{id}/payment', [
        BookingController::class,
        'payment'
    ])->name('bookings.payment');

    Route::get('/my-bookings', [
        BookingController::class,
        'index'
    ])->name('bookings.index');

    Route::get('/booking/{id}/ticket', [
        BookingController::class,
        'ticket'
    ])->name('bookings.ticket');

   
Route::get(
    '/bookings/{id}/payment/success',
    [BookingController::class, 'paymentSuccess']
)->name('bookings.payment.success');


});


/*
|--------------------------------------------------------------------------
| Organization Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'organization.admin'])->group(function () {

    /*
    | Dashboard
    */

    Route::get(
        '/organization-admin/dashboard',
        [OrganizationAdminController::class, 'dashboard']
    )->name('organization.admin.dashboard');


    /*
    | Events
    */

    Route::resource(
        '/organization-admin/events',
        OrganizationAdminEventController::class
    )->names('organization.admin.events');


    /*
    | Organization Profile - View
    */

    Route::get(
        '/organization-admin/profile',
        [OrganizationAdminProfileController::class, 'show']
    )->name('organization.admin.profile');


    /*
    | Organization Profile - Edit
    */

    Route::get(
        '/organization-admin/profile/edit',
        [OrganizationAdminProfileController::class, 'edit']
    )->name('organization.admin.profile.edit');


    /*
    | Organization Profile - Update
    */

    Route::put(
        '/organization-admin/profile',
        [OrganizationAdminProfileController::class, 'update']
    )->name('organization.admin.profile.update');

    Route::get(
    '/organization-admin/bookings',
    [OrganizationAdminBookingController::class, 'index']
)->name('organization.admin.bookings.index');

Route::patch('/organization-admin/bookings/{booking}/confirm',
    [OrganizationAdminBookingController::class, 'confirm'])
    ->name('organization.admin.bookings.confirm');

Route::patch('/organization-admin/bookings/{booking}/cancel',
    [OrganizationAdminBookingController::class, 'cancel'])
    ->name('organization.admin.bookings.cancel');

Route::get(
    '/organization-admin/participants',
    [OrganizationAdminParticipantController::class, 'index']
)->name('organization.admin.participants.index');

Route::get(
    '/organization-admin/settings',
    [OrganizationAdminSettingsController::class, 'index']
)->name('organization.admin.settings');

Route::get('/organization-admin/export/{resource}/{format}', [OrganizationAdminExportController::class, 'export'])
    ->whereIn('resource', ['events', 'staff', 'units', 'bookings', 'participants'])
    ->whereIn('format', ['xlsx', 'csv', 'pdf'])
    ->name('organization.admin.export');
Route::get('/organization-admin/print/{resource}', [OrganizationAdminExportController::class, 'print'])
    ->whereIn('resource', ['events', 'staff', 'units', 'bookings', 'participants'])
    ->name('organization.admin.print');

Route::get(
    '/organization-admin/ticket-verification',
    [OrganizationAdminTicketVerificationController::class, 'index']
)->name('organization.admin.ticket.verification');


Route::get(
    '/organization-admin/ticket-verification/search',
    [OrganizationAdminTicketVerificationController::class, 'search']
)->name('organization.admin.ticket.search');


Route::get(
    '/organization-admin/ticket-verification/{bookingNumber}',
    [OrganizationAdminTicketVerificationController::class, 'verify']
)->name('organization.admin.ticket.verify');

Route::get(
    '/organization-admin/units/search',
    [OrganizationAdminUnitController::class, 'search']
)->name('organization.admin.units.search');

Route::resource(
    '/organization-admin/units',
    OrganizationAdminUnitController::class
)->names('organization.admin.units');

Route::resource(
    '/organization-admin/staff',
    OrganizationAdminStaffController::class
)->names('organization.admin.staff');

Route::get(
    '/organization-admin/password/change',
    [OrganizationAdminPasswordController::class, 'changePasswordForm']
)->name('organization.admin.password.change');


Route::post(
    '/organization-admin/password/change',
    [OrganizationAdminPasswordController::class, 'changePassword']
)->name('organization.admin.password.change.store');


Route::get(
    '/organization-admin/password/forgot',
    [OrganizationAdminPasswordController::class, 'forgotPassword']
)->name('organization.admin.password.forgot');


Route::get(
    '/organization-admin/password/forgot/verify',
    [OrganizationAdminPasswordController::class, 'forgotPasswordForm']
)->name('organization.admin.password.forgot.verify');


Route::post(
    '/organization-admin/password/forgot/verify',
    [OrganizationAdminPasswordController::class, 'verifyForgotPasswordOtp']
)->name('organization.admin.password.forgot.verify.submit');


Route::get(
    '/organization-admin/password/forgot/reset',
    [OrganizationAdminPasswordController::class, 'forgotPasswordResetForm']
)->name('organization.admin.password.forgot.reset');


Route::post(
    '/organization-admin/password/forgot/reset',
    [OrganizationAdminPasswordController::class, 'forgotPasswordReset']
)->name('organization.admin.password.forgot.reset.store');
});


/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super.admin'])->group(function () {

    Route::get('/admin/dashboard', [
        SuperAdminDashboardController::class,
        'index'
    ])->name('admin.dashboard');

    Route::view('/admin/settings', 'admin.settings.index')->name('admin.settings');
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile');
    Route::get('/admin/ticket-verification', [SuperAdminTicketVerificationController::class, 'index'])->name('admin.ticket-verification.index');
    Route::get('/admin/ticket-verification/search', [SuperAdminTicketVerificationController::class, 'search'])->name('admin.ticket-verification.search');
    Route::get('/admin/ticket-verification/{bookingNumber}', [SuperAdminTicketVerificationController::class, 'verify'])->name('admin.ticket-verification.verify');
    Route::get('/admin/print/{resource}', [SuperAdminExportController::class, 'print'])
        ->whereIn('resource', ['organizations', 'events', 'users', 'bookings', 'payments', 'staff', 'admin_staff'])
        ->name('admin.print');

    // Super Admin account staff are managed separately from organization staff.
    Route::get('/admin/access-staff', [SuperAdminAccessStaffController::class, 'index'])->name('admin.access-staff.index');
    Route::post('/admin/access-staff', [SuperAdminAccessStaffController::class, 'store'])->name('admin.access-staff.store');
    Route::patch('/admin/access-staff/{staff}', [SuperAdminAccessStaffController::class, 'update'])->name('admin.access-staff.update');
    Route::delete('/admin/access-staff/{staff}', [SuperAdminAccessStaffController::class, 'destroy'])->name('admin.access-staff.destroy');

    // Organizations
    Route::get('/admin/organizations', [
        SuperAdminOrganizationController::class,
        'index'
    ])->name('admin.organizations.index');

    Route::patch('/admin/organizations/{organization}/approve', [
        SuperAdminOrganizationController::class,
        'approve'
    ])->name('admin.organizations.approve');

    Route::patch('/admin/organizations/{organization}/reject', [
        SuperAdminOrganizationController::class,
        'reject'
    ])->name('admin.organizations.reject');

    Route::get('/admin/export/{resource}/{format}', [
        SuperAdminExportController::class,
        'export'
    ])
        ->whereIn('resource', ['organizations', 'events', 'users', 'bookings', 'payments', 'staff', 'admin_staff'])
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('admin.export');

    Route::get('/admin/organizations/export/{format}', [
        SuperAdminExportController::class,
        'export'
    ])
        ->defaults('resource', 'organizations')
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('admin.organizations.export');

    Route::get('/admin/organizations/print', [
        SuperAdminOrganizationController::class,
        'print'
    ])->name('admin.organizations.print');

    // Events - overview and full management; event approval is not part of Super Admin.
    Route::get('/admin/events', [
        SuperAdminEventController::class,
        'index'
    ])->name('admin.events.index');

    Route::get('/admin/events/create', [
        SuperAdminEventController::class,
        'create'
    ])->name('admin.events.create');

    Route::post('/admin/events', [
        SuperAdminEventController::class,
        'store'
    ])->name('admin.events.store');

    Route::get('/admin/events/print', [
        SuperAdminEventController::class,
        'print'
    ])->name('admin.events.print');

    Route::get('/admin/events/{event}', [
        SuperAdminEventController::class,
        'show'
    ])->name('admin.events.show');

    Route::get('/admin/events/{event}/edit', [
        SuperAdminEventController::class,
        'edit'
    ])->name('admin.events.edit');

    Route::put('/admin/events/{event}', [
        SuperAdminEventController::class,
        'update'
    ])->name('admin.events.update');

    Route::delete('/admin/events/{event}', [
        SuperAdminEventController::class,
        'destroy'
    ])->name('admin.events.destroy');

    // Staff & Access
    Route::resource('/admin/staff', SuperAdminStaffController::class)
        ->names('admin.staff');

    Route::get('/admin/notifications/{notification}/read', [
        SuperAdminStaffController::class,
        'markNotificationRead'
    ])->name('admin.notifications.read');

    Route::get('/admin/events/export/{format}', [
        SuperAdminExportController::class,
        'export'
    ])
        ->defaults('resource', 'events')
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('admin.events.export');

    // Users
    Route::get('/admin/users', [
        SuperAdminUserController::class,
        'index'
    ])->name('admin.users.index');

    Route::get('/admin/users/export/{format}', [
        SuperAdminExportController::class,
        'export'
    ])
        ->defaults('resource', 'users')
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('admin.users.export');

    Route::get('/admin/users/print', [
        SuperAdminUserController::class,
        'print'
    ])->name('admin.users.print');

    // Bookings
    Route::get('/admin/bookings', [
        SuperAdminBookingController::class,
        'index'
    ])->name('admin.bookings.index');

    Route::get('/admin/bookings/export/{format}', [
        SuperAdminExportController::class,
        'export'
    ])
        ->defaults('resource', 'bookings')
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('admin.bookings.export');

    Route::get('/admin/bookings/print', [
        SuperAdminBookingController::class,
        'print'
    ])->name('admin.bookings.print');

    // Payments (read-only overview derived from bookings)
    Route::get('/admin/payments', [
        SuperAdminPaymentController::class,
        'index'
    ])->name('admin.payments.index');

    Route::get('/admin/payments/export/{format}', [
        SuperAdminExportController::class,
        'export'
    ])
        ->defaults('resource', 'payments')
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('admin.payments.export');

    Route::get('/admin/payments/print', [
        SuperAdminPaymentController::class,
        'print'
    ])->name('admin.payments.print');
});


/*
|--------------------------------------------------------------------------
| Organization Admin Password Setup
|--------------------------------------------------------------------------
*/


Route::get(
    '/organization-admin/password/setup',
    [OrganizationAdminPasswordController::class, 'create']
)->name('organization.admin.password.setup');

Route::post(
    '/organization-admin/password/setup',
    [OrganizationAdminPasswordController::class, 'store']
)->name('organization.admin.password.store');


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');

require __DIR__ . '/auth.php';
