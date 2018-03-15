<?php

namespace App\Mail;

use App\Theme;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $theme;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Theme $theme)
    {
        $this->user = $user;
        $this->theme = $theme;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('themes.'.$this->theme->slug.'.emails.register-confirmation')->subject('Potrvda registracije')->from(['address' => 'info@eleganza.hr', 'name' => 'Eleganza.hr']);
    }
}
