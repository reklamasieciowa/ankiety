<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\PercentMultiple;
use App\Charts\Number;
use App\Charts\NumberCompare;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;
use App\Survey;

class ResultsCompareController extends Controller
{


    // public function PostListChart()
    // {
    //     $peopleCount = Person::count();

    //     $peopleByPost = Person::all()->load(['post.translations', 'answers'])->sortBy('post_id')->groupBy(function($item, $key)
    //     {
    //         return $item['post']->{'name:pl'};
    //     })->map(function ($item) use($peopleCount) {
    //         // Return the number of persons with that age
    //         return count($item)/$peopleCount;
    //     });

    //     $title = 'Stanowiska';

    //     $chart = Percent::generateChart($peopleByPost, 'pie', '%');

    //     return view('admin.result.chart', compact('chart', 'title'));
    // }

    // public function IndustryListChart()
    // {
    //     $peopleCount = Person::count();

    //     $peopleByIndustry = Person::all()->load(['industry.translations', 'answers'])->sortBy('industry_id')->groupBy(function($item, $key)
    //     {
    //         return $item['industry']->{'name:pl'};
    //     })->map(function ($item) use($peopleCount) {
    //         // Return the number of persons with that age
    //         return count($item)/$peopleCount;
    //     });

    //     $title = 'Branże';

    //     $chart = Percent::generateChart($peopleByIndustry, 'pie', '%');

    //     return view('admin.result.chart', compact('chart', 'title'));
    // }

    public function AllCategoriesChart(Survey $survey)
    {
        //without effectivness of IT tools and text answers
        $answersAll = Answer::where('question_id', '<', 32)->where('survey_id', '<>', $survey->id)->get();
        $answersSurvey = Answer::where('question_id', '<', 32)->where('survey_id',  $survey->id)->get();

        $answersAllGrouped = $answersAll->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersSurveyGrouped = $answersSurvey->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersValues = [];

        $answersValues['company'] = $survey->company->name;

        $answersValues['keys'] = $answersAllGrouped->keys();

        array_push($answersValues, $answersAllGrouped->values());
        array_push($answersValues, $answersSurveyGrouped->values());

        $title = 'Kategorie';

        $chart = NumberCompare::generateChart($answersValues, 'horizontalBar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryChart(Survey $survey, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $category_questions = $category->questions->pluck('id');


        $answersAll = Answer::whereIn('question_id', $category_questions)->where('survey_id', '<>', $survey->id)->get();

        $answersAllGrouped = $answersAll->load('question.translations')->groupBy(function($item, $key)
        {
            return $item['question']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        //dd($answersAllGrouped);

        $answersSurvey = Answer::whereIn('question_id', $category_questions)->where('survey_id', $survey->id)->get();

        $answersSurveyGrouped = $answersSurvey->load('question.translations')->groupBy(function($item, $key)
        {
            return $item['question']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        //dd($answersSurveyGrouped);

        $answersValues = [];

        $answersValues['company'] = $survey->company->name;

        $answersValues['keys'] = $answersAllGrouped->keys();

        array_push($answersValues, $answersAllGrouped->values());
        array_push($answersValues, $answersSurveyGrouped->values());

        $title = 'Kategoria '.$category->{'name:pl'};

        //dd($answersValues);

        $chart = NumberCompare::generateChart($answersValues, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryValuesChart($category_id)
    {
        $category = Category::findOrFail($category_id);

        $answers = $category->questions->load('answers')->mapWithKeys(function ($item) {
            return [$item->{'name:pl'} => $item->answers->sortBy('value')->groupBy('value')];
        });

        $answersValues = [];
        $keys = [];
        $data0_1 = [];
        $data2_3 = [];
        $data4_5 = [];

        foreach ($answers as $key => $answer_value) {
                
            $count0_1 = 0;
            if(isset($answer_value[0])) {
                $count0_1 += $answer_value[0]->count();
            }

            if(isset($answer_value[1])) {
                $count0_1 += $answer_value[1]->count();
            }

            
            $count2_3 = 0;
            if(isset($answer_value[2])) {
                $count2_3 += $answer_value[2]->count();
            }

            if(isset($answer_value[3])) {
                $count2_3 += $answer_value[3]->count();
            }

            
            $count4_5 = 0;
            if(isset($answer_value[4])) {
                $count4_5 += $answer_value[4]->count();
            }

            if(isset($answer_value[5])) {
                $count4_5 += $answer_value[5]->count();
            }

            array_push($keys, $key);


            $totalnaswers = $count0_1 + $count2_3 + $count4_5;

            array_push($data0_1, $count0_1/$totalnaswers*100);
            array_push($data2_3, $count2_3/$totalnaswers*100);
            array_push($data4_5, $count4_5/$totalnaswers*100);

        }

        $data['keys'] = $keys;

        $answersValues['keys'] = $data['keys'];
        $answersValues['data']['01'] = $data0_1;
        $answersValues['data']['02'] = $data2_3;
        $answersValues['data']['03'] = $data4_5;

        $title = 'Rozkład odpowiedzi kategorii '.$category->name;

        $chart = PercentMultiple::generateChart($answersValues, 'horizontalBar', '%');

        return view('admin.result.chart', compact('chart', 'title', 'questions'));
    }

    public function topFive($order = "worst")
    {

        $answers = Question::all()->load('answers')->mapWithKeys(function ($item) {
            // Return the number of persons with that age
            return [ $item->{'name:pl'} => $item->answers->avg('value')];
        });

        //remove null
        $answers = $answers->filter(function ($value, $key) {
            return !is_null($value);
        });

        $answers = $answers->filter(function ($value, $key) {
            return !is_null($value);
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
     * Display a listing of companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function select()
    {
        $surveys = Survey::whereNotNull('company_id')->with('company')->get();

        return view('admin.compare.select_survey', compact('surveys'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {

        $categories = Category::all()->take(6)->load('translations');

        return view('admin.compare.index', compact('categories', 'survey'));
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
