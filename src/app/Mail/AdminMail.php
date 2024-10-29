<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $body;

    public function __construct($user, $subject, $body)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view('admin.emails.body')
            ->with([
                'subject' => $this->subject,
                'body' => $this->body,
            ]);
    }
}
