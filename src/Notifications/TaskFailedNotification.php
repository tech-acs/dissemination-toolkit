<?php

namespace Uneca\DisseminationToolkit\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskFailedNotification extends Notification
{
    use Queueable;

    public function __construct(private string $title, private string $body)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'icon' => 'failed',
            'from' => 'Dashboard',
            'title' => $this->title,
            'body' => $this->body,
            'sent_at' => Carbon::now(),
        ];
    }
}
