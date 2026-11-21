<?php

namespace App\Notifications;

use App\Models\LeaveApplication;
use Illuminate\Notifications\Notification;

/** Sent to the teacher when their leave is approved or rejected. */
class LeaveDecided extends Notification
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
        $key = $this->leave->status === 'approved'
            ? 'Your :type (:dates) was approved'
            : 'Your :type (:dates) was rejected';

        return [
            'message' => __($key, ['type' => $this->leave->typeLabel(), 'dates' => $this->leave->dateRange()])
                .($this->leave->admin_remarks ? ': '.$this->leave->admin_remarks : ''),
            'url' => route('my_leave.index'),
        ];
    }
}
