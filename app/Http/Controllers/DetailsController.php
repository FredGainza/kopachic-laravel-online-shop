<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Shipping;
use App\Models\ { Address, Country };
use Cart;

class DetailsController extends Controller
{
    /**
     * Show the order details
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Shipping $ship)
    {
        // Facturation
        $country_facturation = Address::findOrFail($request->facturation)->country;
        // Livraison
        $country_livraison = $request->different ? Address::findOrFail($request->livraison)->country : $country_facturation;
        $shipping = $request->pick ? 0 : $ship->compute($country_livraison->id);
        // TVA
        $tvaBase = Country::whereName('France')->first()->tax;
        $tax = $request->pick ? $tvaBase : $country_livraison->tax; 
        
        // Panier
        $content = Cart::getContent();
        $total = $tax > 0 ? Cart::getTotal() : Cart::getTotal() / (1 + $tvaBase);              
        return response()->json([ 
            'view' => view('command.partials.detail', compact('shipping', 'content', 'total', 'tax'))->render(), 
        ]);
    }
}
