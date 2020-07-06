<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\DataTables\CountriesDataTable;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountriesDataTable $dataTable)
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
        return view('back.countries.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CountryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        Country::create($request->all());

        return back()->with('alert', config('messages.countrycreated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $pays
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $pays)
    {
        return view('back.countries.form', ['country' => $pays]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CountryRequest  $request
     * @param  \App\Models\Country  $pays
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, Country $pays)
    {
        $pays->update($request->all());

        return back()->with('alert', config('messages.countryupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $pays
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $pays)
    {
        $pays->delete();
        return redirect(route('pays.index'));
    }

    public function alert(Country $pays)
    {
        return view('back.countries.destroy', ['country' => $pays]);
    }
}
