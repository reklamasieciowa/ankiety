<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\Number;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;

class ResultsController extends Controller
{


    public function PostListChart()
    {
        $peopleCount = Person::count();

        $peopleByPost = Person::all()->load(['post.translations', 'answers'])->sortBy('post_id')->groupBy(function($item, $key)
        {
            return $item['post']->{'name:en'};
        })->map(function ($item) use($peopleCount) {
            // Return the number of persons with that age
            return count($item)/$peopleCount;
        });

        $title = 'Stanowiska';

        $chart = Percent::generateChart($peopleByPost, 'pie', '%');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesChart()
    {

        $answers = Answer::all()->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:en'};
        })->map(function ($item) {
            // Return the number of persons with that age
            return $item->avg('value');
        });

        //cut 2 categories IT and additional
        $answers = $answers->slice(0,6);

       // dd($answers);

        $title = 'Kategorie';

        $chart = Number::generateChart($answers, 'horizontalBar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryChart($category_id)
    {
        $category = Category::findOrFail($category_id);
        $questions = $category->questions->load('translations');

        // $answers = $category->questions->load('answers')->mapWithKeys(function ($item) {
        //     // Return the avg for answers
        //     return [$item->{'name:en'} => $item->answers->avg('value')];
        //     //return $item->answers->avg('value');
        // });

        $answers = $category->questions->load('answers')->map(function ($item) {
            // Return the avg for answers
            return $item->answers->avg('value');
            //return $item->answers->avg('value');
        });

       // dd($answers);

        $title = 'Kategoria '.$category->{'name:en'};

        $chart = Number::generateChart($answers, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title', 'questions'));
    }

    public function CategoryValuesChart($category_id)
    {
        $category = Category::findOrFail($category_id);

        $answers = $category->questions->load('answers')->map(function ($item) {
            // Return the avg for answers
            return $item->answers->sortBy('value')->groupBy('value');
            //return $item->answers->avg('value');
        });

        dd($answers);


        $title = 'Kategoria ';

        $chart = Number::generateChart($answers, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title', 'questions'));
    }

    public function topFive($order = "worst")
    {

        $answers = Question::all()->load('answers')->mapWithKeys(function ($item) {
            // Return the number of persons with that age
            return [ $item->{'name:en'} => $item->answers->avg('value')];
        });

        $answers = $answers->sort();

        if($order == "best") {
            $answers = $answers->reverse();
        }
        
        $answers = $answers->take(5);

        $title = 'Top 5 '.$order;

        $chart = Number::generateChart($answers, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all()->take(6);

        return view('admin.result.index', compact('categories'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
