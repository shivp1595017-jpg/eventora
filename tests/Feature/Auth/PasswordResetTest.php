<?php

namespace Tests\Feature\Auth;

use App\Mail\PasswordOtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_requires_an_authenticated_user(): void
    {
        $this->get('/forgot-password')
            ->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/forgot-password')
            ->assertOk();
    }

    public function test_authenticated_user_can_request_a_password_reset_otp(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/forgot-password');

        $response
            ->assertOk()
            ->assertViewIs('auth.verify-password-otp')
            ->assertViewHas('email', $user->email);

        Mail::assertSent(PasswordOtpMail::class, fn (PasswordOtpMail $mail) => $mail->hasTo($user->email));

        $otp = PasswordOtp::where('email', $user->email)->sole();
        $this->assertTrue($otp->expires_at->isFuture());
        $this->assertNull($otp->verified_at);
        $this->assertNull($otp->used_at);
    }

    public function test_reset_password_form_is_only_available_after_otp_verification(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/password/otp/reset')
            ->assertRedirect(route('password.request'));

        $this->post('/forgot-password');

        $otp = null;
        Mail::assertSent(PasswordOtpMail::class, function (PasswordOtpMail $mail) use (&$otp): bool {
            $otp = $mail->otp;

            return true;
        });

        $this->post('/password/otp/verify', ['otp' => $otp])
            ->assertRedirect(route('password.otp.reset'));

        $this->get('/password/otp/reset')
            ->assertOk()
            ->assertViewIs('auth.reset-password-otp')
            ->assertViewHas('email', $user->email);
    }

    public function test_password_can_be_reset_after_valid_otp_verification(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/forgot-password');

        $otp = null;
        Mail::assertSent(PasswordOtpMail::class, function (PasswordOtpMail $mail) use (&$otp): bool {
            $otp = $mail->otp;

            return true;
        });

        $this->post('/password/otp/verify', ['otp' => $otp])
            ->assertRedirect(route('password.otp.reset'));

        $this->post('/password/otp/reset', [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $this->assertNotNull(PasswordOtp::sole()->used_at);
    }

    public function test_invalid_otp_does_not_allow_password_reset(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/forgot-password');

        $this->from('/password/otp/verify')
            ->post('/password/otp/verify', ['otp' => '000000'])
            ->assertRedirect('/password/otp/verify')
            ->assertSessionHasErrors('otp');

        $this->assertSame(1, PasswordOtp::sole()->attempts);
        $this->get('/password/otp/reset')
            ->assertRedirect(route('password.request'));
    }
}
