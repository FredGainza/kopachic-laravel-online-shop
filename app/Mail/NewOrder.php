<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{ Order, Shop, User };

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $shop;
    public $order;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, Order $order, User $user)
    {
        $this->shop = $shop;
        $this->order = $order;
        $this->user = $user;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvelle commande')
                    ->view('mail.neworder');
        // return $this->from($this->shop->email, $this->shop->name)
        //             ->subject('Nouvelle commande')
        //             ->view('mail.neworder');
    }
}