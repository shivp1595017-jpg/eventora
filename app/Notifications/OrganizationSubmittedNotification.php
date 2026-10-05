<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrganizationSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(private int $organizationId, private string $organizationName)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New organization application',
            'message' => $this->organizationName.' is waiting for review.',
            'url' => route('admin.organizations.index'),
        ];
    }
}
