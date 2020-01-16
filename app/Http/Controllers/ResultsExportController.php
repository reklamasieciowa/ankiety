<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PeopleExport;
use App\Exports\AnswersAllExport;
use App\Exports\SurveyExport;
use App\Exports\SurveyFromViewExport;
use App\Exports\CategoriesPostsFromViewExport;
use App\Exports\CategoriesIndustryFromViewExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Survey;
use App\Answer;
use App\Person;

class ResultsExportController extends Controller
{
    public function exportAll() 
    {
        return Excel::download(new PeopleExport, 'wyniki-wszystkie.xlsx');
    }

    public function exportSurvey(Survey $survey) 
    {
    	if($survey->company) {
    		$filename = 'wyniki-'.$survey->company->name.'.xlsx';
    	} else {
    		$filename = 'wyniki-'.$survey->title.'-'.$survey->id.'.xlsx';
    	}
    	
        return Excel::download(new SurveyExport($survey->id), $filename);
    }

    public function exportSurveyView(Survey $survey) 
    {
    	$numericQuestions = $survey->questionsNumericIds();

    	$survey = Survey::where('id', $survey->id)
    				->with(['questions' => function($query) use ($numericQuestions) {
				        $query->whereIn('question_type_id', [1,2])->with('translations');
				    }])
    				->with(['people.post.translations', 'people.department.translations', 'people.industry.translations'])
    				->with(['people.answers' => function($query) use ($numericQuestions) {
				        $query->whereIn('question_id', $numericQuestions)->orderBy('question_id');
				     }])
    				->first();

    	 //return view('admin.export.survey', compact('survey'));

    	if($survey->company) {
    		$filename = 'wyniki-'.$survey->company->name.'.xlsx';
    	} else {
    		$filename = 'wyniki-'.$survey->title.'-'.$survey->id.'.xlsx';
    	}
    	
        return Excel::download(new SurveyFromViewExport($survey), $filename);
    }


    public function exportAllCategoriesByPost()
    {
        
        $data = Answer::where('question_id', '<', 32)
        ->with('person.post.translations','question.category.translations')
        ->get()
        ->groupBy(
             ['person.post.name', 'question.category.name']
        )->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            });
        });

        $groupCount = Person::all()->load(['post.translations'])->sortBy('post_id')->groupBy(function($item, $key)
        {
            return $item['post']->{'name:pl'};
        })->map(function ($item)  {
            return count($item);
        });

        //dd($groupCount);

        //return view('admin.export.categories_by_post', compact('data', 'groupCount'));

        return Excel::download(new CategoriesPostsFromViewExport($data, $groupCount), 'Kategorie wg stanowisk.xlsx');
    }

    public function exportAllCategoriesByIndustry()
    {
        
        $data = Answer::where('question_id', '<', 32)
        ->with('person.industry.translations','question.category.translations')
        ->get()
        ->groupBy(
             ['person.industry.name', 'question.category.name']
        )->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            });
        });

        $groupCount = Person::all()->load(['industry.translations'])->sortBy('industry_id')->groupBy(function($item, $key)
        {
            return $item['industry']->{'name:pl'};
        })->map(function ($item)  {
            return count($item);
        });

        //return view('admin.export.categories_by_industry', compact('data', 'groupCount'));

        return Excel::download(new CategoriesIndustryFromViewExport($data, $groupCount), 'Kategorie wg branż.xlsx');
    }

    /**
     * Display a listing of companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectSurvey()
    {
        $surveys = Survey::whereNotNull('company_id')->with('company')->get();

        return view('admin.export.select_survey', compact('surveys'));
    }
}
