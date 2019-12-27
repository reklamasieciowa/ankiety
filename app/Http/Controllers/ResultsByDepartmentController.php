<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\PercentMultiple;
use App\Charts\Number;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;
use App\Survey;
use App\Department;

class ResultsByDepartmentController extends Controller
{


    public function PostListChart(Survey $survey, Department $department)
    {
        $people = $survey->people->where('department_id', $department->id);

        $peopleCount = $people->count();

        $peopleByPost = $people->load(['post.translations', 'answers'])->sortBy('post_id')->groupBy(function($item, $key)
        {
            return $item['post']->{'name:pl'};
        })->map(function ($item) use($peopleCount) {
            // Return the number of persons with that age
            return count($item)/$peopleCount;
        });

        $title = 'Stanowiska w firmie '.$survey->company->name;

        $chart = Percent::generateChart($peopleByPost, 'pie', '%');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesChart(Survey $survey, Department $department)
    {
        
        $people = $survey->peopleFromDepartment($department);

        //without effectivness of IT tools and text answers
        $answers = Answer::whereIn('person_id', $people)->where('question_id', '<', 32)->get();

        $answersgrouped = $answers->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $title = 'Średnie kategorii. Firma '.$survey->company->name.'. Dział: '.$department->name;

        $chart = Number::generateChart($answersgrouped, 'horizontalBar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryChart(Survey $survey, Department $department, Category $category)
    {
        $people = $survey->peopleFromDepartment($department);

        $category_questions = $category->questions->pluck('id');

        $answers = Answer::whereIn('person_id', $people)
        ->whereIn('question_id', $category_questions)
        ->get();

        $answersgrouped = $answers->load('question.translations')->groupBy(function($item, $key)
        {
            return $item['question']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $title = 'Firma '.$survey->company->name.'. Dział '.$department->name.'. Kategoria '.$category->name.'.';

        $chart = Number::generateChart($answersgrouped, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function CategoryValuesChart(Survey $survey, Department $department, Category $category)
    {
        $people = $survey->peopleFromDepartment($department);

        $category_questions = $category->questions->pluck('id');

        $answers = Answer::whereIn('person_id', $people)
                    ->whereIn('question_id', $category_questions)
                    ->get();

        $answersgrouped = $answers->load('question.translations')->groupBy(function($item, $key)
        {
            return $item['question']->{'name:pl'};
        })->map(function ($item) {
            return $item->sortBy('value')->groupBy('value');
        });

        $answersValues = [];
        $keys = [];
        $data0_1 = [];
        $data2_3 = [];
        $data4_5 = [];

        foreach ($answersgrouped as $key => $answer_value) {
                
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

    public function topFive(Survey $survey, Department $department, $order = "worst")
    {

        $people = $survey->peopleFromDepartment($department);

        $answers = Answer::whereIn('person_id', $people)
                    ->where('question_id', '<', 32)
                    ->with('question.translations')
                    ->get()
                    ->groupBy(function($item, $key)
                    {
                        return $item['question']->{'name:pl'};
                    })->map(function ($item) {
                        return $item->avg('value');
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

        $title = 'Top 5 '.$order;

        $chart = Number::generateChart($answers, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    /**
     * Display a listing of companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectSurvey()
    {
        $surveys = Survey::whereNotNull('company_id')->with('company')->get();

        return view('admin.result_by_department.select_survey', compact('surveys'));
    }

    /**
     * Display a listing of departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectDepartment(Survey $survey)
    {
        //$departments[id][name:pl]
        //$departments[id][count]

        $departments = $survey->people->load(['department.translations'])->sortBy('department_id')->groupBy(function($item, $key)
        {
            return $item['department']->id;
        })->map(function ($item) {
            return array($item[0]['department']->{'name:pl'}, count($item));
        });

        return view('admin.result_by_department.select_department', compact('departments', 'survey'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey, Department $department)
    {
        $people = $survey->people->where('department_id', $department->id)->count();

        $categories = Category::all()->take(6)->load('translations');

        return view('admin.result_by_department.index', compact('people', 'categories', 'survey', 'department'));
    }



}
