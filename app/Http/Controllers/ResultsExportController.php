<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PeopleExport;
use App\Exports\AnswersAllExport;
use App\Exports\SurveyExport;
use App\Exports\SurveyFromViewExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Survey;

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
