<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\{ Order, State, Shop, Product, Order_Product };
use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;
use App\Services\Facture;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('back.shared.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('adresses', 'products', 'state', 'user', 'user.orders', 'payment_infos')->findOrFail($id);
        $shop = Shop::firstOrFail();
        // Cas du mandat administratif
        $annule_indice = State::whereSlug('annule')->first()->indice;
        $states = $order->payment === 'mandat' && !$order->purchase_order ?
          State::where('indice', '<=', $annule_indice)
              ->where('indice', '>', 0)
              ->get() :
          State::where('indice', '>=', $order->state->indice)->get();    
        return view('back.orders.show', compact('order', 'states', 'shop', 'annule_indice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $commande)
    {
        $order = Order::with('adresses', 'products', 'state', 'user', 'user.orders', 'payment_infos')->findOrFail($commande->id);
        $commande->load('state');
        $states = State::all();
        if($request->state_id !== $commande->state_id) {
            // En cas de changement de type de paiement
            $indice_payment = $states->firstWhere('slug', 'cheque')->indice;
            $state_new = $states->firstWhere('id', $request->state_id);
            if($commande->state->indice ===  $indice_payment && $state_new->indice ===  $indice_payment){
                $commande->payment = $states->firstWhere('id', $request->state_id)->slug;
            }
            $commande->state_id = $request->state_id;       
            

            // Mise à jour du stock
            // dd($commande);
            // dd($order->products);
            if ($request->state_id == 7){
                foreach ($order->products as $item){
                    $name = $item->name;
                    $prodId = DB::table('products')->where('name', $name)->value('id');
                    $product = Product::findOrFail($prodId);
                    $product->quantity += $item->quantity;
                    $product->save();
                }
            }  
            
            $commande->save();
        }
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function invoice(Request $request, Facture $facture,  Order $commande)
    {
        $response = $facture->create($commande, $request->has('paid'));       
        if($response->successful()) {
            $data = json_decode($response->body());
            $commande->invoice_id = $data->id;
            $commande->invoice_number = $data->number;
            $commande->save();
        } else {
            $request->session()->flash('invoice', 'La création de facture n\'a pas abouti');
        }
        return back();
    }

    public function updateNumber(Request $request, Order $commande)
    {
        $request->validate([
            'purchase_order' => 'required|string|max:100'
        ]);
        $commande->purchase_order = $request->purchase_order;
        $commande->save();            
        return back();
    }
}
