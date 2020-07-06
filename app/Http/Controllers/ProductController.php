<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Product $product)
    {
        if($product->active || $request->user()->admin) {
            return view('products.show', compact('product'));
        }
        return redirect(route('home'));
    }
}
