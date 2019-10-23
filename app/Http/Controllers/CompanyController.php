<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCompany;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = Company::with('survey.translations')->get();

        return view('admin.company.index')->with(compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompany $request)
    {
        
        Company::create($request->validated());

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Firma zapisana.');

        return redirect()->route('admin.company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('admin.company.edit')->with(compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCompany $request, Company $company)
    {
        $company->update($request->validated());

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Firma '.$company->name.' zapisana.');

        return redirect()->route('admin.company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Request $request)
    {
        $company->delete();

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Firma '.$company->name.' usunięta.');

        return redirect()->route('admin.company.index');
    }
}
