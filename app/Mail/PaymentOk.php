<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{ Order, Shop, Payment };

class PaymentOk extends Mailable
{
    use Queueable, SerializesModels;
    public $shop;
    public $order;
    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, Order $order, Payment $payment)
    {
        $this->shop = $shop;
        $this->order = $order;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de paiement')
                    ->view('mail.paymentok', ['user' => auth()->user()]);
    }
}
