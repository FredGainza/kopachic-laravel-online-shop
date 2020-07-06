<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{ Shop, Product };

class ProductAlert extends Mailable
{
    use Queueable, SerializesModels;
    
    public $shop;
    public $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, Product $product)
    {
        $this->shop = $shop;
        $this->product = $product;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Alerte produit')
                    ->view('mail.productalert');
        // return $this->from($this->shop->email, $this->shop->name)
        //             ->subject('Alerte produit')
        //             ->view('mail.productalert');
    }
}