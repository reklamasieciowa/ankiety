<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests\CreateDepartment;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('translations')->get()->sortBy('order');

        return view('admin.department.index')->with(compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDepartment $request)
    {
        $validated = $request->validated();

        $department = Department::create([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
            'order' => $validated['order'],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Dział '.$department->name.' zapisany.');

        return redirect()->route('admin.department.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('admin.department.edit')->with(compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(CreateDepartment $request, Department $department)
    {
        $validated = $request->validated();

        $department->update([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
            'order' => $validated['order'],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Dział '.$department->name.' zapisany.');

        return redirect()->route('admin.department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Request $request)
    {
        if(!count($department->people)) {
            $department->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Dział '.$department->name.' usunięty.');

            return redirect()->route('admin.department.index');
        } else {
            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Dział jest przypisany do ankietowanych. Nie został usunięty.');

            return redirect()->route('admin.department.index');
        }
    }
}
