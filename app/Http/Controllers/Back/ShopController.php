<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request\Request;
use App\Http\Requests\ShopRequest;
use App\Models\Shop;

class ShopController extends Controller
{
    public function edit()
    {
        $shop = Shop::firstOrFail();
        return view('back.shop.edit', compact('shop'));
    }

    public function update(ShopRequest $request)
    {
        $request->merge([
            'invoice' => $request->has('invoice'),
            'card' => $request->has('card'),
            'paypal' => $request->has('paypal'),
            'transfer' => $request->has('transfer'),
            'check' => $request->has('check'),
            'mandat' => $request->has('mandat'),
        ]);        
        Shop::firstOrFail()->update($request->all());
        return back()->with('alert', config('messages.shopupdated'));
    }
}
