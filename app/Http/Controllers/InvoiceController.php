<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Get invoice pdf
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        $this->authorize('manage', $order);
        // Récupération du pdf
        $url = config('invoice.url') . 'invoices/' .  (string)$order->invoice_id . '.pdf?api_token=' . config('invoice.token');
        $contents = file_get_contents($url);
        $name = (string)$order->invoice_id . '.pdf';
        Storage::disk('invoices')->put($name, $contents);
        // Envoi
        return response()->download(storage_path('app/invoices/' . $name))->deleteFileAfterSend();
    }
}