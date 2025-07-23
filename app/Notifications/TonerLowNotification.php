<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TonerLowNotification extends Notification
{
    protected $printer;
    protected $toner;
    protected $level;

    public function __construct($printer, $toner, $level)
    {
        $this->printer = $printer;
        $this->toner = $toner;
        $this->level = $level;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Nízký stav toneru u tiskárny {$this->printer->name}")
            ->line("Toner {$this->toner->name} je na úrovni {$this->level}%.")
            ->line("Prosím doplňte toner co nejdříve.");
    }
}
