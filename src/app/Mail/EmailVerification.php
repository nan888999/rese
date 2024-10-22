<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct($user, $verification_url)
    {
        $this->user = $user;
        $this->verification_url = $verification_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('【Rese】メールアドレス認証')
        ->view('auth.emails.body')
        ->with([
            'token' => $this->user->email_verify_token,
            'verification_url' => $this->verification_url,
        ]);
    }
}
