<?php

namespace App\Notifications;

use App\Models\LeaveApplication;
use App\Support\NotificationText;
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

        $data = NotificationText::make($key, [
            'type' => LeaveApplication::TYPES[$this->leave->type] ?? $this->leave->type,
            'dates' => $this->leave->dateRange(),
        ], route('my_leave.index'), ['type']);

        // The admin's remark is free text, shown as written.
        $data['suffix'] = (string) $this->leave->admin_remarks;
        if ($data['suffix'] !== '') {
            $data['message'] .= ': '.$data['suffix'];
        }

        return $data;
    }
}
