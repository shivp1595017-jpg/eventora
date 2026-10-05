<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizationAdminPasswordSetup extends Notification
{
    use Queueable;

    public function __construct(
        protected string $setupUrl
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Set Your Eventora Organization Admin Password')
            ->greeting('Welcome to Eventora!')
            ->line('Your organization has been approved by the Eventora Super Admin.')
            ->line('An Organization Admin account has been created for you.')
            ->line('Please click the button below to securely set your password.')
            ->action('Set Password', $this->setupUrl)
            ->line('For security, this link should only be used by you.')
            ->line('If you did not expect this email, you can safely ignore it.')
            ->salutation('Regards, Eventora Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'setup_url' => $this->setupUrl,
        ];
    }
}