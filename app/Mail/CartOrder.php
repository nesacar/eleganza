<?php

namespace App\Mail;

use App\Cart;
use App\Theme;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('themes.eleganza.email.cart-order')->with('cart', $this->cart)
            ->subject('Poruka sa sajta Eleganza.hr')->from('service@eleganza.hr', 'Porudžbina sa sajta P-Grupacija.hr');
    }
}
