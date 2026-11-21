<?php

namespace App\Notifications;

use App\Models\OneToOneClass;
use App\Support\NotificationText;
use Illuminate\Notifications\Notification;

class OneToOneAssigned extends Notification
{
    public function __construct(public OneToOneClass $class, public bool $updated = false)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $key = $this->updated
            ? 'Your 1-to-1 class with :student (:subject) was updated: :day :time'
            : 'New 1-to-1 class: :student (:subject), every :day :time';

        return NotificationText::make($key, [
            'student' => $this->class->student->displayName(),
            'subject' => $this->class->subject,
            'day' => OneToOneClass::DAYS[$this->class->day] ?? '',
            'time' => $this->class->timeRange(),
        ], route('my_classes.index'), ['day']);
    }
}
