<?php

namespace App\Notifications;

use App\Models\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentRating extends Notification
{
    use Queueable;
    /**
     * @var Rating
     */
    private $rating;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Rating $rating)
    {

        $this->rating = $rating;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    //    public function toMail($notifiable)
    //    {
    //        return (new MailMessage)
    //                    ->line('The introduction to the notification.')
    //                    ->action('Notification Action', url('/'))
    //                    ->line('Thank you for using our application!');
    //    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $user = $this->rating->user;
        $comment = Rating::withModel($this->rating);
        return [
            'message' => 'Пользователь ' . $user->name . ' оценил Ваш комментарий',
            'user' => $user,
            'comment' => $comment,
            'href' => "/post/{$comment->post->slug}#$comment->id",
            'cssClass'    => ($this->rating->type == 1)? "notif-like": "notif-disslike",
            'comment_id' => $comment->id,
            'user_id' => $user->id,
        ];
    }
}
