<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Category;
use App\Scale;
use App\Post;
use App\Department;
use App\Person;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function personalInfo($locale, $survey_uuid)
    {
        $survey = Survey::where('uuid', '=', $survey_uuid)->firstOrFail();

        $posts = Post::with('translations')->get();
        $departments = Department::with('translations')->get();

        return view('front.survey.personalInfo')->with('survey', $survey)->with('posts', $posts)->with('departments', $departments);
    }

    /**
     * Display the specified survey.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($locale, $survey_uuid, Request $request)
    {
        $survey = Survey::where('uuid', '=', $survey_uuid)->firstOrFail();

        return view('front.survey.show')->with('survey', $survey);
    }

    /**
     * Display questions from the specified category.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function showCategory($locale, $survey_uuid, Person $person, Category $currentCategory)
    {
        $survey = Survey::where('uuid', '=', $survey_uuid)->firstOrFail();

        $questions = $survey->questions->where('category_id', $currentCategory->id)->load('translations', 'question_type', 'options', 'scale.values.translations')->sortBy('order');

        $categories = Category::with('translations')->get();
        //$scales = Scale::with('values.translations')->get();

        return view('front.survey.showCategory')->with('questions', $questions)->with('categories', $categories)->with('survey', $survey)->with('currentCategory', $currentCategory);
    }

    /**
     * Display finish page for survey.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function finish($locale, $survey_uuid)
    {
        $survey = Survey::where('uuid', '=', $survey_uuid)->firstOrFail();
        
        return view('front.survey.finish')->with('survey', $survey);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
