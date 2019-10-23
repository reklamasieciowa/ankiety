<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAnswer;
use Illuminate\Support\Arr;
use App;
use App\Survey;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created answer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($locale, Survey $survey, $person, $currentCategory, StoreAnswer $request)
    {

        $validated = $request->validated();

        $answers = $validated['answers'];

        //dd($answers);

        //save answers
        if(isset($answers)) {
            foreach($answers as $key => $value) 
            {
                if(!empty($answer))
                {
                    Answer::create([
                        'survey_id' => $survey->id,
                        'person_id' => $person,
                        'question_id' => $key,
                        'value' => $value,
                    ]);
                }
            }
        }

        //determine next category/page
        if($currentCategory < Category::all()->count()) 
        {
            $nextCategory = $currentCategory+1;

            return redirect()->route('survey.category', ['locale' => App::getLocale(), 'survey' => $survey, 'person' => $person, 'currentCategory' => $nextCategory]);

        } elseif($currentCategory == Category::all()->count()) {
           return redirect()->route('survey.finish', ['locale' => App::getLocale(), 'survey' => $survey]);
        } else {
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
