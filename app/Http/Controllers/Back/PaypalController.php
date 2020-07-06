<?php

namespace App\Http\Controllers\Back;

use App\Mail\PaymentOk;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\{ Order, State, Country, Payment, Shop };
use App\PayPal;
use Illuminate\Http\Request;
use App\Services\Shipping;
use App\Services\Facture;
use Cart;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class PayPalController
 * @package App\Http\Controllers
 */
class PayPalController extends Controller
{
    /**
     * @param Request $request
     */
    public function form($order_id, Request $request)
    {
        $order = Order::with('products', 'adresses', 'state')->findOrFail($order_id);

        return view('command.confirm-paypal-ok', compact('order'));
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function checkout($order_id, Request $request)
    {
        $order = Order::with('products', 'adresses', 'state')->findOrFail($order_id);
        $amount = $order->total + $order->shipping;
        $taxTemp = (integer) (($order->total) / (1 + $order->tax) * 100);
        $tax = $taxTemp / 100;

        $paypal = new PayPal;

        $response = $paypal->purchase([
            'amount' => $amount,
            'transactionId' => $order->id,
            'currency' => 'EUR',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
        ]);

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return mixed
     */
    public function completed($order_id, Request $request, Facture $facture)
    {
        $order = Order::findOrFail($order_id);
        $paypal = new PayPal;

        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($order->total + $order->shipping),
            'transactionId' => $order->id,
            'currency' => 'EUR',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
        ]);

        // dd($response);

        if ($response->isSuccessful()) {
            $order->update([
                'state_id' => (integer)("9"),  
            ]);

            $order->payment_infos()->create(['payment_id' => $response->getTransactionReference()]);

            $paymentId = Payment::where('order_id', $order->id);
            $paymentId->update([
                'payment_id' => $response->getTransactionReference(),  
            ]);
            // dd($response);
            $payment = Payment::where('order_id', $order->id)->first();

            // Mail au client
            $shop = Shop::firstOrFail();
            Mail::to($request->user())->send(new PaymentOk($shop, $order, $payment));
            $transacId = $payment->payment_id;
            $request->session()->flash('transacId', $transacId);
            // dd($transacId);

            // Création de la facture
            $response = $facture->create($order, true);  
            $data = json_decode($response->body());
            // dd($data);
            $order->invoice_id = $data->id;
            $order->invoice_number = $data->number;
            $order->save();
            // dd($order);

            return redirect()->route('order.paypal', $order_id);
        }
    }

    /**
     * @param $order_id
     */
    public function cancelled($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->update([
            'state_id' => (integer)("7"),  
        ]);

        return redirect()->route('order.paypal', $order_id)->with([
            'message' => 'You have cancelled your recent PayPal payment !',
        ]);
    }
}
