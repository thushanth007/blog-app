<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $commenterName;
    protected $postTitle;
    protected $postId;

    /**
     * Create a new notification instance.
     */
    public function __construct($commenterName, $postTitle , $postId)
    {
        $this->commenterName = $commenterName;
        $this->postTitle = $postTitle;
        $this->postId = $postId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Comment on Your Post')
                    ->line($this->commenterName . ' commented on your post: ' . $this->postTitle)
                    ->action('View Post', url('/post-view/' . $this->postId))
                    ->line('Thank you for using our Website!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
