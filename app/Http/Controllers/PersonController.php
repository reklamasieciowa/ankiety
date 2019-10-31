<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use App\Http\Requests\StorePerson;
use Illuminate\Support\Arr;
use App;
use App\Survey;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::with(['answers', 'survey.translations', 'post.translations', 'department.translations'])->get();

        return view('admin.person.index')->with(compact('people'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($locale, $survey_uuid, StorePerson $request)
    {
        $validated = $request->validated();

        $survey = Survey::where('uuid', '=', $survey_uuid)->firstOrFail();

        if(!isset($validated['agree'])) {
            $validated['agree'] = 0;
        }

        //zapis person i przekierowanie do ankieta/1/kategoria/1
        $person = Person::create([
            'survey_id' => $survey->id,
            'post_id' => $validated['post_id'],
            'department_id' => $validated['department_id'],
            'industry_id' => $validated['industry_id'],
            'email' => $validated['email'],
            'agree' => $validated['agree'],
        ]);


        return redirect()->route('survey.category', ['locale' => App::getLocale(), 'survey_uuid' => $survey_uuid, 'person' => $person ,'currentCategory' => '1']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        $answers = $person->answers->load(['question.category.translations'])->first();

        return view('admin.person.show')->with(compact('person', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person, Request $request)
    {

        if(!$person->countAnswers()) {
            $person->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Użytkownik usunięty');
        } else {
            $person->answers()->delete();

            $person->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Użytkownik usunięty');
        }

        $people = Person::with(['answers', 'survey.translations', 'post.translations', 'department.translations'])->get();

        return view('admin.person.index')->with(compact('people'));
    }
}
