<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CreateCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with(['translations', 'questions'])->get();

        return view('admin.category.index')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategory $request)
    {
        $validated = $request->validated();

        $category = Category::create([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Kategoria '.$category->name.' zapisana.');

        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $category = $category->load('translations');

        return view('admin.category.edit')->with(compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategory $request, Category $category)
    {
        $validated = $request->validated();

        $category->update([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Kategoria '.$category->name.' zapisana.');

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        if(!count($category->questions)) {
            $category->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Kategoria '.$category->name.' usunięta.');
        } else {
            $request->session()->flash('class', 'alert-danger');
            $request->session()->flash('info', 'Kategoria '.$category->name.' zawiera pytania, więcnie została usunięta.');
        }

        return redirect()->route('admin.category.index');
    }
}
