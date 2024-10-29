<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        $formatted_time = Carbon::createFromFormat('H:i:s', $this->reservation->time)->format('H:i');

        return $this
            ->subject('【Rese】本日のご予約のお知らせ')
            ->view('emails.reminder')
            ->with([
                'shop_name' => $this->reservation->shop->name,
                'time' => $formatted_time,
            ]);
    }
}