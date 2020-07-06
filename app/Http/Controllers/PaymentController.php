<?php

namespace App\Http\Controllers;

use App\Mail\PaymentOk;
use Illuminate\Http\Request;
use App\Models\{ Order, State, Shop, Payment };
use Illuminate\Support\Facades\Mail;
use App\Services\Shipping;
use App\Services\Facture;
class PaymentController extends Controller
{
    
    /**
     * Manage payment
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __invoke(Request $request, Facture $facture, Order $order)
    {
        $this->authorize('manage', $order);
        $state = null;
        if($request->payment_intent_id === 'error') {
            $state = 'erreur'; 
        } else {
            \Stripe\Stripe::setApiKey(config('stripe.secret_key'));
            $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);
            if ($intent->status === 'succeeded') {              
                $request->session()->forget($order->reference); 
                $order->payment_infos()->create(['payment_id' => $intent->id]);         
                $state = 'paiement_ok';

                $transacId = $intent->id;
                $request->session()->flash('transacId', $transacId);

                // Mail au client
                $shop = Shop::firstOrFail();
                $payment = Payment::where('order_id', $order->id)->first();
                Mail::to($request->user())->send(new PaymentOk($shop, $order, $payment));

                // Création de la facture
                $response = $facture->create($order, true);  
                if($response->successful()) {
                    $data = json_decode($response->body());
                    $order->invoice_id = $data->id;
                    $order->invoice_number = $data->number;
                }           
            } else {
                $state = 'erreur';     
            }
        }
        $order->state_id = State::whereSlug($state)->first()->id;              
        $order->save();
    }
}