<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class FileStatusChangedNotification extends Notification
{
    use Queueable;

    private $fileStatus;

    public function __construct($fileStatus)
    {
        $this->fileStatus = $fileStatus;
    }

    // القنوات المستخدمة
    public function via($notifiable)
    {
        return ['database']; // إرسال الإشعار عبر قاعدة البيانات
    }

    // البيانات التي سيتم تخزينها في قاعدة البيانات
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'The file status has changed.',
            'status' => $this->fileStatus,
            'time' => now()->toDateTimeString(),
        ];
    }
}
