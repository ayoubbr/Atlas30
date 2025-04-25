<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketPurchased extends Notification
{
    use Queueable;


    public $tickets;
    public $totalAmount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tickets, $totalAmount)
    {
        $this->tickets = $tickets;
        $this->totalAmount = $totalAmount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $game = $this->tickets->first()->game;

        return (new MailMessage)
            ->subject('Your Tickets for World Cup 2030')
            ->greeting('Hello ' . $notifiable->name)
            ->line('You have successfully purchased your tickets.')
            ->line('Match: ' . $game->homeTeam->name . ' vs ' . $game->awayTeam->name)
            ->line('Date: ' . $game->start_date . ' at ' . $game->start_hour)
            ->line('Total Paid: $' . number_format($this->totalAmount, 2))
            ->action('View Tickets', url('/profile'))
            ->line('Thank you for your purchase!');
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
