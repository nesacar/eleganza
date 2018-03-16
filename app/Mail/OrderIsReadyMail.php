<?php

namespace App\Mail;

use App\Cart;
use App\Theme;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderIsReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $theme;
    public $cart;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Theme $theme, Cart $cart)
    {
        $this->user = $user;
        $this->theme = $theme;
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('themes.'.$this->theme->slug.'.emails.order-is-ready')
            ->subject('Vaša porudžba je spremna za slanje')
            ->from(['address' => 'info@eleganza.hr', 'name' => 'Eleganza.hr']);
    }
}
