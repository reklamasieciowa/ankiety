<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\PercentMultiple;
use App\Charts\PercentMultipleCompare;
use App\Charts\Number;
use App\Charts\NumberCompare;
use App\Charts\Line;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;
use App\Survey;

class ResultsCompareController extends Controller
{

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

    public function CompareIndustries(Survey $survey)
    {
        
        $answers = Answer::where('question_id', '<', 32)->where('survey_id', '<>', $survey->id)->with('person.industry.translations','question.category.translations')->get();

        $answersByIndustry = $answers->groupBy(
             ['person.industry.name', 'question.category.name']
        )
        ->filter(function ($item) {
            //only industries with answers from all categories
            return $item->count() == 6;
        })
        ->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            })->sortKeys();
        })
        ->sortKeys();

        $surveyAnswers = $survey->answers->where('question_id', '<', 32)->load('person.industry.translations', 'survey', 'question.category.translations');

        $surveyAnswersGrouped = $surveyAnswers->groupBy(
             ['survey.company.name', 'question.category.name']
        )
        ->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            })->sortKeys();
        });

        $answersAll = $answersByIndustry->merge($surveyAnswersGrouped);

        //dd($answersAll);

        $title = 'Średnie kategorii wg branż vs '.$survey->company->name;

        $chart = Line::generateChart($answersAll, 'line', '');

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

        $answersSurvey = Answer::whereIn('question_id', $category_questions)->where('survey_id', $survey->id)->get();

        $answersSurveyGrouped = $answersSurvey->load('question.translations')->groupBy(function($item, $key)
        {
            return $item['question']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $answersValues = [];

        $answersValues['company'] = $survey->company->name;

        $answersValues['keys'] = $answersAllGrouped->keys();

        array_push($answersValues, $answersAllGrouped->values());
        array_push($answersValues, $answersSurveyGrouped->values());

        $title = 'Kategoria '.$category->{'name:pl'};

        $chart = NumberCompare::generateChart($answersValues, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryValuesChart(Survey $survey, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $category_questions = $category->questions->pluck('id');

        $category_keys = $category->questions->pluck('name:pl');
        $company = $survey->company->name;

        $company_category_keys = $category_keys->map(function ($item, $key) use ($company) {
            //return $item.' ('.$company.')';
            return $company;
        });

        $category_keys = $category_keys->concat($company_category_keys);

        $answersAll = Answer::whereIn('question_id', $category_questions)
            ->where('survey_id', '<>', $survey->id)
            ->get()
            ->load('question.translations')
            ->groupBy([
                'question_id', 'value'
            ]);

        $answersSurvey = Answer::whereIn('question_id', $category_questions)
            ->where('survey_id', '=', $survey->id)
            ->get()
            ->load('question.translations')
            ->groupBy([
                'question_id', 'value'
        ]);

        $answers = array();
        array_push($answers, $answersAll);
        array_push($answers, $answersSurvey);

        // $answersAllGrouped = $answersAll->mapWithKeys(function ($item, $value) {
        //     return [$item['question']->{'name:pl'} => $item->sortBy('value')->groupBy('value')];
        // });

        // dd($answersAllGrouped);

        $answersValues = [];
        $data0_1 = [];
        $data2_3 = [];
        $data4_5 = [];
        $iteration = 0;
        $i = 0;

        foreach ($answers as $answer) {

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

                $iteration += 2; // odd and even table indexes
                $i++;

                // array_push($data0_1, $count0_1/$totalnaswers*100);
                // array_push($data2_3, $count2_3/$totalnaswers*100);
                // array_push($data4_5, $count4_5/$totalnaswers*100);
            }

            $answersValues['data']['01'] = $data0_1;
            $answersValues['data']['02'] = $data2_3;
            $answersValues['data']['03'] = $data4_5;

            $iteration = 1;

        }

        ksort($answersValues['keys']);
        ksort($answersValues['data']['01']);
        ksort($answersValues['data']['02']);
        ksort($answersValues['data']['03']);

        //$answersValues['keys'] = $category_keys;

        //dd($answersValues);

        $title = 'Rozkład odpowiedzi kategorii '.$category->name;

        $chart = PercentMultipleCompare::generateChart($answersValues, 'horizontalBar', '%');

        return view('admin.result.chart', compact('chart', 'title', 'questions'));
    }

    public function topFive(Survey $survey, $order = "worst")
    {
        $numericQuestionsIds = $survey->questionsNumericIds();

        $answers = Answer::where('survey_id', $survey->id)
            ->whereIn('question_id', $numericQuestionsIds)
            ->with('question')
            ->get()
            ->groupBy(function ($item) {
                return  $item->question->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            });

        //remove null
        $answers = $answers->filter(function ($value, $key) {
            return !is_null($value);
        });

        $answers = $answers->sort();

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

    public function openQuestions(Survey $survey)
    {
        $questionsIds = Question::whereIn('question_type_id', [3,4])->pluck('id');

       $answers = Answer::whereIn('question_id', $questionsIds)
                    ->where('survey_id', $survey->id)
                    ->with('question')
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->question->{'name:pl'};
                    });

        return view('admin.result.openQuestions', compact('answers'));
    }
}
