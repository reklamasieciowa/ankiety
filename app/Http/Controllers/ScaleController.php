<?php

namespace App\Http\Controllers;

use App\Scale;
use Illuminate\Http\Request;
use App\Http\Requests\CreateScale;
use App\Http\Requests\CreateValue;

class ScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scales = Scale::with('questions', 'values.translations')->get();

        return view('admin.scale.index')->with(compact('scales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scale.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScale $request)
    {
        
        $scale = Scale::create($request->validated());

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Skala '.$scale->name.' zapisana.');

        return redirect()->route('admin.scale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function show(Scale $scale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function edit(Scale $scale)
    {
        $scale->load('values.translations');

        return view('admin.scale.edit')->with(compact('scale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function update(CreateScale $request, Scale $scale)
    {
        $scale->update($request->validated());

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Skala '.$scale->name.' zapisana.');

        return redirect()->route('admin.scale.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scale $scale, Request $request)
    {
        if(!count($scale->questions)) {

            $scale->values()->delete();
            $scale->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Skala '.$scale->name.' usunięta.');
        } else {
            $request->session()->flash('class', 'alert-danger');
            $request->session()->flash('info', 'Ta skala jest używana! '.$scale->name.' nie została usunięta.');
        }

        return redirect()->route('admin.scale.index');
    }
}
