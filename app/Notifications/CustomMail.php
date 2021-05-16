<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Base\DatabaseNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;

    public $body;

    /**
     * Create a new notification instance.
     *
     * @param $subject
     * @param $body
     */
    public function __construct($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->markdown('mail.custom-mail', [
                'user' => $notifiable,
                'body' => $this->body,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return DatabaseNotification::make($this->subject)
            ->description($this->body)
            ->toArray();
    }
}
