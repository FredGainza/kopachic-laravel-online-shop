<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use App\DataTables\StatesDataTable;
use App\Http\Requests\StateRequest;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatesDataTable $dataTable)
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
        return view('back.states.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {      
        State::create($request->all());
        return back()->with('alert', config('messages.statecreated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $etat)
    {
        return view('back.states.form', ['state' => $etat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, State $etat)
    {
        $etat->update($request->all());
        return back()->with('alert', config('messages.stateupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $etat)
    {
        $etat->delete();
        return redirect(route('etats.index'));
    }
    public function alert(State $etat)
    {
        return view('back.states.destroy', ['state' => $etat]);
    }
}
