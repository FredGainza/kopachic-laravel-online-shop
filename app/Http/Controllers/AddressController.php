<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Address, Country, User };
use App\Http\Requests\StoreAddress;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $addresses = $request->user()->addresses()->with('country')->get();
        if($addresses->isEmpty()) {
            return redirect(route('adresses.create'))->with('message', config('messages.oneaddress'));
        }
        
        return view('account.addresses.index', compact('user', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $countries = Country::all();
        $user = $request->user();
        $addresses = $request->user()->addresses()->get();
        return view('account.addresses.create', compact('user', 'addresses', 'countries')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddress $storeAddress)
    {
        $storeAddress->merge(['professionnal' => $storeAddress->has('professionnal')]);

        $user = $storeAddress->user();
        $storeAdd = $storeAddress->user()->addresses()->create($storeAddress->all());
        $addresses = $user->addresses()->with('country')->get();
        // dd($storeAdd->id);
        if($storeAddress->principale == "1" || $addresses->count() == 1){
            $user = $storeAddress->user();
            $user->principale = $storeAdd->id;
            $user->save();
        }
        return redirect(route('adresses.index'))->with('alert', config('messages.addresssaved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $adress
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $adress, Request $request)
    {
        $user = $request->user();
        $addresses = $request->user()->addresses()->with('country')->get();
        $this->authorize('manage', $adress);
        $countries = Country::all();
        return view('account.addresses.edit', compact('user', 'adress', 'addresses', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $adress
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAddress $storeAddress, Address $adress, User $user)
    {
        $this->authorize('manage', $adress);
        $storeAddress->merge(['professionnal' => $storeAddress->has('professionnal')]);
        $adress->update($storeAddress->all());
        if($storeAddress->principale == "1"){
            $user = $storeAddress->user();
            $user->principale = $adress->id;
            $user->save();
        }
        return redirect(route('adresses.index'))->with('alert', config('messages.addressupdated')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address $adress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $adress)
    {
        $this->authorize('manage', $adress);
        $user = Auth::user();
        if($adress->id == $user->principale){
            // return redirect(route('adresses.index'))->with('message2', 'Vous avez ne pouvez pas supprimer votre adresse principale. Veuillez tout d\'abord en définir une nouvelle.');
            return back()->with('alert', config('messages.principalenotdelete'));
        }else{
            $adress->delete();
            return back()->with('alert', config('messages.addressdeleted'));
        }
    }
}
