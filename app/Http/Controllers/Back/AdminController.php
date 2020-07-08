<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ Order, User };

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    { 
        $notifications = $request->user()->unreadNotifications()->get();
        // dd($notifications);
        $newUsers = 0;
        $newOrders = 0;
        foreach($notifications as $notification) {
            if($notification->type === 'App\Notifications\NewUser') {
                ++$newUsers;
            } elseif($notification->type === 'App\Notifications\NewOrder'){
                ++$newOrders;
            }
        }
        // dd($newUsers);
        return view('back.index', compact('notifications', 'newUsers', 'newOrders'));
    }

    public function viewOrders(Request $request) 
    { 
        $notifications = $request->user()->unreadNotifications()->get();
        // dd($notifications);
        $ref=[];
        $collec = $notifications->where('type', 'App\Notifications\NewOrder');
        foreach ($collec as $el){
            $ref[] = $el->data;
        }
        // dd($ref);
        $orders = Order::all();
        $newcom = Order::whereIn('reference', $ref)->get();
        // dd($newcom);
        return view('back.index', compact('newcom', 'orders'));
    }

    public function viewUsers(Request $request) 
    { 
        $notifications = $request->user()->unreadNotifications()->get();
        $nom=[];
        $collec = $notifications->where('type', 'App\Notifications\NewUser');
        foreach ($collec as $el){
            $nom[] = $el->data;
        }
        // dd($ref);
        $users = User::all();
        $newuser = User::whereIn('name', $nom)->get();
        // dd($newcom);
        return view('back.index', compact('newuser', 'users'));
    }

    public function read(Request $request, $type) 
    { 
        if($type === 'orders') {
            $type = 'App\Notifications\NewOrder';
        } else if($type === 'users') {
            $type = 'App\Notifications\NewUser';
        }
        $request->user()->unreadNotifications->where('type', $type)->markAsRead();
        return redirect(route('admin'));
    }
}