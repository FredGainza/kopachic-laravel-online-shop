<?php

namespace App\Http\Controllers;

use App\Models\{ Product, Page, Category };

class HomeController extends Controller
{
    /**
     * Show home page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::whereActive(true)->get();
        $categories = Category::all(); 
        return view('home', compact('products', 'categories'));
    }

    public function category($id)
    {
        $products = Product::whereActive(true)->get();
        $categories = Category::find($id);
        $category = $categories->slug;
        // dd($category);
        $products = Product::where('category_id', $id)->get();
        return view('home', compact('products', 'category'));
    }

    public function page(Page $page)
    {
        return view('page', compact('page'));
    }
}
