<?php

namespace App\Notifications;

use App\Models\LeaveApplication;
use Illuminate\Notifications\Notification;

/** Sent to admins when a teacher applies for leave. */
class LeaveApplied extends Notification
{
    public function __construct(public LeaveApplication $leave)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => __(':name applied for :type: :dates (:days day(s))', [
                'name' => $this->leave->user->name,
                'type' => $this->leave->typeLabel(),
                'dates' => $this->leave->dateRange(),
                'days' => rtrim(rtrim((string) $this->leave->days, '0'), '.'),
            ]),
            'url' => route('leave.index', ['status' => 'pending']),
        ];
    }
}
