<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Shop;
class Registered extends Mailable
{
    use Queueable, SerializesModels;
    public $shop;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bienvenue !')
                    ->view('mail.registered', ['user' => auth()->user()]);
        // return $this->from($this->shop->email, $this->shop->name)
        //             ->subject('Bienvenue !')
        //             ->view('mail.registered', ['user' => auth()->user()]);
    }
}