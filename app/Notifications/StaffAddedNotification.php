<?php

namespace App\Notifications;

use App\Models\OrganizationStaff;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StaffAddedNotification extends Notification
{
    use Queueable;

    public function __construct(private OrganizationStaff $staff)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New organization staff added',
            'message' => $this->staff->name.' was added to '.($this->staff->organization?->name ?? 'an organization').'.',
            'url' => route('admin.staff.show', $this->staff),
        ];
    }
}
