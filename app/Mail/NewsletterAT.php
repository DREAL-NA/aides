<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterAT extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter', ['email' => $this->email])
            ->subject("Nouvelle inscription à la newsletter d'aides territoire pour la fiche ADDNA !")
            ->to(config('mail.newsletter.to.address'), config('mail.newsletter.to.name'));
    }
}