<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Address, Country, Shop, State, Product, User, Page };
use App\Mail\{ NewOrder, Ordered, ProductAlert };
use Illuminate\Support\Facades\Mail;
use App\Services\Shipping;
use Illuminate\Support\Str;
use App\Notifications\NewOrder as NewOrderNotification;
use Swift_TransportException;
use Cart;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\Shipping  $ship
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Shipping $ship)
    {        
        $addresses = $request->user()->addresses()->get();
        if($addresses->isEmpty()) {
            return redirect()->route('adresses.create')->with('message', 'Vous devez créer au moins une adresse pour pouvoir passer une commande.');
        }

        $country_id = $addresses->first()->country_id;
        $shipping = $ship->compute($country_id);
        $content = Cart::getContent();
        $total = Cart::getTotal();
        $tax = Country::findOrFail($country_id)->tax;
        
        return view('command.index', compact('addresses', 'shipping', 'content', 'total', 'tax'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\Shipping  $ship
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shipping $ship)
    {
        // Vérification du stock
        $items = Cart::getContent();
        foreach($items as $row) {
            $product = Product::findOrFail($row->id);
            if($product->quantity < $row->quantity) {
                $request->session()->flash('message', 'Nous sommes désolés mais le produit "' . $row->name . '" ne dispose pas d\'un stock suffisant pour satisfaire votre demande. Il ne nous reste plus que ' . $product->quantity . ' exemplaires disponibles.');
                return back();
            }
        }

        // Client
        $user = $request->user();

        // Facturation
        $address_facturation = Address::with('country')->findOrFail($request->facturation);

        // Livraison
        $address_livraison = $request->different ? Address::with('country')->findOrFail($request->livraison) : $address_facturation;
        $shipping = $request->expedition === 'colissimo' ? $ship->compute($address_livraison->country->id) : 0;

        // TVA
        $tvaBase = Country::whereName('France')->first()->tax;
        $tax = $request->expedition === 'colissimo' ? $address_livraison->country->tax : $tvaBase;

        // Enregistrement commande
        $order = $user->orders()->create([
            'reference' => strtoupper(Str::random(8)),
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $tax > 0 ? Cart::getTotal() : Cart::getTotal() / (1 + $tvaBase),
            'payment' => $request->payment,
            'pick' => $request->expedition === 'retrait',
            'state_id' => State::whereSlug($request->payment)->first()->id,
        ]);

        // Enregistrement adresse de facturation
        $order->adresses()->create($address_facturation->toArray());

        // Enregistrement éventuel adresse de livraison
        if($request->different) {
            $address_livraison->facturation = false;
            $order->adresses()->create($address_livraison->toArray());
        }

        // Enregistrement des produits
        foreach($items as $row) {
            $order->products()->create(
                [
                    'name' => $row->name,
                    'total_price_gross' => ($tax > 0 ? $row->price : $row->price / (1 + $tvaBase)) * $row->quantity,
                    'quantity' => $row->quantity,
                ]
            );        
            // Mise à jour du stock
            $product = Product::findOrFail($row->id);
            $product->quantity -= $row->quantity;
            $product->save();
            // Alerte stock
            if($product->quantity <= $product->quantity_alert) {
                $shop = Shop::firstOrFail();
                $admins = User::whereAdmin(true)->get();
                foreach($admins as $admin) {
                    Mail::to($admin)->send(new ProductAlert($shop, $product));
                }
            }
        }

        // On vide le panier
        Cart::clear();
        Cart::session($request->user())->clear();
        
        // Notification au client
        $shop = Shop::firstOrFail();
        $page = Page::whereSlug('conditions-generales-de-vente')->first();
        // dd($request);
        Mail::to($request->user())->send(new Ordered($shop, $order, $page));
        
        // Notification à l'administrateur
        $shop = Shop::firstOrFail();
        $admins = User::whereAdmin(true)->get();
        foreach($admins as $admin) {
            Mail::to($admin)->send(new NewOrder($shop, $order, $user));
            $admin->notify(new NewOrderNotification($order));
        }        
                

        return redirect(route('commandes.confirmation', $order->id));
    }
}