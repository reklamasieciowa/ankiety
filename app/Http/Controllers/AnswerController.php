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
    public function store($locale, $survey_uuid, $person, $currentCategory, StoreAnswer $request)
    {

        $validated = $request->validated();

        $answers = $validated['answers'];

        $survey = Survey::where('uuid', '=', $survey_uuid)->firstOrFail();

        //save answers
        if(isset($answers)) {
            foreach($answers as $key => $value) 
            {
                // unique person id + question id
                $duplicated = Answer::where('person_id', '=', $person)->where('question_id', '=', $key)->get();

                if(!count($duplicated) && isset($value))  
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

        //determine next category/page for this survey
        if($currentCategory < $survey->categories->count()) 
        {
            $nextCategory = $currentCategory+1;

            //check if current category has any questions else go next
            if(!$survey->questions->where('category_id', $nextCategory)) {
                $nextCategory++;
            } 
            
            return redirect()->route('survey.category', ['locale' => App::getLocale(), 'survey_uuid' => $survey_uuid, 'person' => $person, 'currentCategory' => $nextCategory]);

        } elseif($currentCategory == $survey->categories->count()) {
           return redirect()->route('survey.finish', ['locale' => App::getLocale(), 'survey_uuid' => $survey_uuid]);
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
