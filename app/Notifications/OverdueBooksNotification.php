<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class OverdueBooksNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $overdue_book;
    public function __construct($overdue_book)
    {
        $this->overdue_book = $overdue_book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            
            ->subject('Overdue Books Reminder')
            ->greeting('Hello ' . $notifiable->student->user->name . ',')
            ->line('You have an overdue book from the library.')
        ->line('**Book Title:** ' . $this->overdue_book->book_copy->book->title)
        ->line('**Due Date:** ' . Carbon::parse($this->overdue_book->due_date)->format('D M d Y'))


        ->line('Please return it as soon as possible to avoid penalties.')
        ->action('Go to Library Portal', url('/login'))
        ->line('Thank you for using our library services.')
        ->salutation(Auth::user()->name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
