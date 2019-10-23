<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Person;
use App\Answer;
use App\Question;
use App\Category;

class AdminController extends Controller
{
    public function index()
    {
    	$surveys = Survey::all();
    	$people = Person::all();
    	$answers = Answer::all();
    	$questions = Question::all();
    	$categories = Category::all();

    	return view('admin.index')->with('surveys', $surveys)->with('people', $people)->with('answers', $answers)->with('questions', $questions)->with('categories', $categories);
    }
}
