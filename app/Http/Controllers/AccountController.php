<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = $request->user()->orders()->count();
        return view('account.index', compact('orders'));
    }
}