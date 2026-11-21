<?php

namespace App\Notifications;

use App\Models\OneToOneClass;
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

        return [
            'message' => __($key, [
                'student' => $this->class->student->displayName(),
                'subject' => $this->class->subject,
                'day' => $this->class->dayName(),
                'time' => $this->class->timeRange(),
            ]),
            'url' => route('my_classes.index'),
        ];
    }
}
