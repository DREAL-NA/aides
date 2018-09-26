<?php

namespace App\Newsletter\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignCreatedAndSent extends Notification
{
    use Queueable;

    public $news;

    /**
     * Create a new notification instance.
     *
     * @param \Illuminate\Support\Collection $news
     */
    public function __construct($news)
    {
        $this->news = $news;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $week = date('W');

        return (new MailMessage)->markdown('emails.mailchimp.campaign-sent', [
            'news' => $this->news,
            'week' => $week
        ])->subject("La campagne correspondant aux actualités de la semaine {$week} a bien été envoyée.");

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
