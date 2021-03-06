<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddComment extends Notification {
    use Queueable;
    private $message;
    /**
     * @var Comment
     */
    private $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment){
        //
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable){
        return ['database'];
    }

    //    /**
    //     * Get the mail representation of the notification.
    //     *
    //     * @param  mixed  $notifiable
    //     * @return \Illuminate\Notifications\Messages\MailMessage
    //     */
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
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable){
        $user = $this->comment->user;
        $post = $this->comment->post;

        return [
            'message'  => 'Пользователь ' . $user->name . ' прокомментировал Ваш пост',
            'user'     => $user,
            'post'     => $post,
            'cssClass' => "notif-comment",
            'user_id'  => $user->id,
            'post_id'  => $post->id,
            'href' => "/post/{$post->slug}#{$this->comment->id}",

        ];
    }
}
