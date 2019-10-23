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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function personalInfo($locale, Survey $survey)
    {
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
    public function show($locale, Survey $survey, Request $request)
    {
        return view('front.survey.show')->with('survey', $survey);
    }

    /**
     * Display questions from the specified category.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function showCategory($locale, Survey $survey, Person $person, Category $currentCategory)
    {

        $questions = $survey->questions->where('category_id', $currentCategory->id)->load('translations', 'question_type', 'options', 'scale.values')->sortBy('order');

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
    public function finish($locale, Survey $survey)
    {
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
