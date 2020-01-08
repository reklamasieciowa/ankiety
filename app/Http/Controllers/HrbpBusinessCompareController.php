<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\PercentMultiple;
use App\Charts\PercentMultipleCompare;
use App\Charts\Number;
use App\Charts\NumberHrbp;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;
use App\Survey;

class HrbpBusinessCompareController extends Controller
{

    public function AllCategoriesChart(Survey $survey)
    {
        $people = $survey->poepleHrbpBusinessIds();
        //Questions with numeric values
        $questions_ids = $survey->questionsNumericIds();

        $answersHrbp = $survey->answers
                        ->whereIn('question_id', $questions_ids)
                        ->whereIn('person_id', $people['hrbp']);
                        
        $answersHrbpGrouped = $answersHrbp->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersBusiness = $survey->answers
                ->whereIn('question_id', $questions_ids)
                ->whereIn('person_id', $people['business']);
                        
        $answersBusinessGrouped = $answersBusiness->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersAll = $survey->answers
                ->whereIn('question_id', $questions_ids);

        $answersAllGrouped = $answersAll->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });
        
        $answersValues = [];

        $answersValues['keys'] = $answersHrbpGrouped->keys();

        array_push($answersValues, $answersHrbpGrouped->values());
        array_push($answersValues, $answersBusinessGrouped->values());
        array_push($answersValues, $answersAllGrouped->values());

        $title = 'Kategorie';

        $chart = NumberHrbp::generateChart($answersValues, 'horizontalBar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryChart(Survey $survey, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $category_questions = $category->questions->pluck('id');

        $people = $survey->poepleHrbpBusinessIds();

        $answersHrbp = $survey->answers
                        ->whereIn('question_id', $category_questions)
                        ->whereIn('person_id', $people['hrbp']);

        $answersHrbpGrouped = $answersHrbp->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersBusiness = $survey->answers
                ->whereIn('question_id', $category_questions)
                ->whereIn('person_id', $people['business']);
                        
        $answersBusinessGrouped = $answersBusiness->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersAll = $survey->answers
                        ->whereIn('question_id', $category_questions);

        $answersAllGrouped = $answersAll->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersValues = [];

        $answersValues['keys'] = $answersHrbpGrouped->keys();

        array_push($answersValues, $answersHrbpGrouped->values());
        array_push($answersValues, $answersBusinessGrouped->values());
        array_push($answersValues, $answersAllGrouped->values());

        $title = 'Kategoria '.$category->{'name:pl'};

        $chart = NumberHrbp::generateChart($answersValues, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryValuesChart(Survey $survey, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $category_questions = $category->questions->pluck('id');

        $category_keys = $category->questions->pluck('name:pl')
                        ->map(function ($item, $key) {
                            return $item.' HRBP';
                        });

        $company = $survey->company->name;

        $company_category_keys = $category_keys->map(function ($item, $key) use ($company) {
            //return $item.' ('.$company.')';
            return 'Business';
        });

        $all_category_keys = $category_keys->map(function ($item, $key) use ($company) {
            //return $item.' ('.$company.')';
            return 'All';
        });

        $people = $survey->poepleHrbpBusinessIds();

        $answersHrbp = $survey->answers
                        ->whereIn('question_id', $category_questions)
                        ->whereIn('person_id', $people['hrbp'])
                        ->load('question.translations')
                        ->groupBy([
                            'question_id', 'value'
                        ]);

        $answersBusiness = $survey->answers
                ->whereIn('question_id', $category_questions)
                ->whereIn('person_id', $people['business'])
                ->load('question.translations')
                ->groupBy([
                    'question_id', 'value'
                ]);

        $answersAll = $survey->answers
                ->whereIn('question_id', $category_questions)
                ->load('question.translations')
                ->groupBy([
                    'question_id', 'value'
                ]);

        $category_keys = $category_keys->concat($company_category_keys);
        $category_keys = $category_keys->concat($all_category_keys);

        $answers = array();
        array_push($answers, $answersHrbp);
        array_push($answers, $answersBusiness);
        array_push($answers, $answersAll);

        //dd($answers);

        $answersValues = [];
        $data0_1 = [];
        $data2_3 = [];
        $data4_5 = [];
        $iteration = 0;
        $i = 0;

        foreach ($answers as $answer) {

            //dd($answer);

           foreach ($answer as $key => $answer_value) {
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

                $totalnaswers = $count0_1 + $count2_3 + $count4_5;

                $data0_1[$iteration] = $count0_1/$totalnaswers*100;
                $data2_3[$iteration] = $count2_3/$totalnaswers*100;
                $data4_5[$iteration] = $count4_5/$totalnaswers*100;

                $answersValues['keys'][$iteration] = $category_keys[$i];

                $iteration += 3; // odd and even table indexes
                $i++;

                // array_push($data0_1, $count0_1/$totalnaswers*100);
                // array_push($data2_3, $count2_3/$totalnaswers*100);
                // array_push($data4_5, $count4_5/$totalnaswers*100);
            }

            $answersValues['data']['01'] = $data0_1;
            $answersValues['data']['02'] = $data2_3;
            $answersValues['data']['03'] = $data4_5;

            //count($answer)*3
            if($iteration == count($answer)*3) {
                $iteration = 1;
                //count($answer)*3+1
            } elseif($iteration == count($answer)*3+1) {
                $iteration = 2;
            } 

        }

        ksort($answersValues['keys']);
        ksort($answersValues['data']['01']);
        ksort($answersValues['data']['02']);
        ksort($answersValues['data']['03']);

        //dd($answersValues);

        $title = 'Rozkład odpowiedzi kategorii '.$category->name;

        $chart = PercentMultipleCompare::generateChart($answersValues, 'horizontalBar', '%');

        return view('admin.result.chart', compact('chart', 'title', 'questions'));
    }

    public function topFive(Survey $survey, $group, $order = "worst")
    {
        $numericQuestionsIds = $survey->questionsNumericIds();

        $people = $survey->poepleHrbpBusinessIds();

        $answers = Answer::where('survey_id', $survey->id)
            ->whereIn('question_id', $numericQuestionsIds)
            ->whereIn('person_id', $people[$group])
            ->with('question')
            ->get()
            ->groupBy(function ($item) {
                return  $item->question->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            })
            ->sort();

        if($order == "best") {
            $answers = $answers->reverse();
        }
        
        $answers = $answers->take(5);

        $title = 'Top 5 '.$order.' w firmie '.$survey->company->name;

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

        return view('admin.hrbp.select_survey', compact('surveys'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {

        $categories = Category::all()->take(6)->load('translations');

        return view('admin.hrbp.index', compact('categories', 'survey'));
    }
}
