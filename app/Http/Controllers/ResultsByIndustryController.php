<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\Line;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;
use App\Survey;
use App\Department;
use App\Industry;

class ResultsByIndustryController extends Controller
{

    public function IndustryListChart(Industry $industry)
    {
        $people = People::where('industry_id', $industry->id);

        $peopleCount = $people->count();

        $peopleByIndustry = $people->load(['industry.translations', 'answers'])
            ->sortBy('industry_id')
            ->groupBy(function($item, $key)
            {
                return $item['industry']->{'name:pl'};
            })
            ->map(function ($item) use($peopleCount) {
                // Return the number of persons with that age
                return count($item)/$peopleCount;
            });

        $title = 'Branże';

        $chart = Percent::generateChart($peopleByIndustry, 'pie', '%');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesChart(Survey $survey, Industry $industry)
    {
        
        $people = $survey->peopleByIndustry($industry);

        $answers = Answer::whereIn('person_id', $people)->where('question_id', '<', 32)->get();

        $answersgrouped = $answers->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $title = 'Średnie kategorii. Firma '.$survey->company->name.'. Dział: '.$industry->name;

        $chart = Line::generateChart($answersgrouped, 'line', '');

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
