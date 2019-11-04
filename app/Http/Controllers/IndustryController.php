<?php

namespace App\Http\Controllers;

use App\Industry;
use Illuminate\Http\Request;
use App\Http\Requests\CreateIndustry;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industries = Industry::with('translations')->get();

        return view('admin.industry.index')->with(compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIndustry $request)
    {
        $validated = $request->validated();

        $industry = Industry::create([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Branża '.$industry->name.' zapisana.');

        return redirect()->route('admin.industry.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function edit(Industry $industry)
    {
        return view('admin.industry.edit')->with(compact('industry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function update(CreateIndustry $request, Industry $industry)
    {
        $validated = $request->validated();

        $industry->update([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Branża '.$industry->name.' zapisana.');

        return redirect()->route('admin.industry.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Industry $industry, Request $request)
    {
        if(!count($industry->people)) {
            $industry->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Branża '.$industry->name.' usunięta.');

            return redirect()->route('admin.industry.index');
        } else {
            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Branża jest przypisana do ankietowanych. Nie została usunięta.');

            return redirect()->route('admin.industry.index');
        }
    }
}
