<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PeopleExport;
use App\Exports\AnswersAllExport;
use App\Exports\SurveyExport;
use App\Exports\SurveyFromViewExport;
use App\Exports\CategoriesPostsFromViewExport;
use App\Exports\CategoriesIndustryFromViewExport;
use App\Exports\CategoriesHrbpBusinessAllFromViewExport;
use App\Exports\SurveyCategoriesIndustryFromViewExport;
use App\Exports\SurveyCategoriesPostsFromViewExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Survey;
use App\Answer;
use App\Person;
use App\Category;

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

    public function exportSurveyCategoriesByIndustry(Survey $survey)
    {
        
        $answers = Answer::where('question_id', '<', 32)
                    ->where('survey_id', '<>', $survey->id)
                    ->with('person.industry.translations','question.category.translations')
                    ->get();

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

        $data = $answersByIndustry->merge($surveyAnswersGrouped);


        $filename = 'Średnie kategorii wg branż vs '.$survey->company->name.'.xlsx';

        return Excel::download(new SurveyCategoriesIndustryFromViewExport($data), $filename);
    }

    public function exportSurveyCategoriesByPosts(Survey $survey)
    {
        
        $data = $survey->answers->where('question_id', '<', 32)      
        ->load('person.post.translations','question.category.translations')
        //->get()
        ->groupBy(
             ['person.post.name', 'question.category.name']
        )->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            });
        });

        //dd($data);

        $filename = 'Średnie kategorii wg stanowisk w '.$survey->company->name.'.xlsx'; 

        return Excel::download(new SurveyCategoriesIndustryFromViewExport($data), $filename);

        //return view('admin.export.survey_categories_by_post', compact('data'));
    }

    public function ExportCategoryHrbpBusinessView(Survey $survey, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $category_questions = $category->questions->pluck('id');

        $people = [];

        $people[$survey->company->name] = $survey->poepleHrbpBusinessIds();
        $people['All'] = getPoepleGroupsIds();

        $data = [
            $survey->company->name => [],
            'Pozostali' => []
        ];

        
        foreach($people[$survey->company->name] as $name => $group) {
            $answers = $survey->answers->whereIn('question_id', $category_questions)
            ->whereIn('person_id', $group)
            ->load('question.category.translations')
            //->get()
            ->groupBy(function ($item) {
                return $item['question']->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            });

            $data[$survey->company->name][$name] = $answers->values();

            if(empty($data['keys'])) {
                $data['keys'] = $answers->keys();
            }
        }

        foreach($people['All'] as $name => $group) {
            $answers = Answer::whereIn('question_id', $category_questions)
            ->whereIn('person_id', $group)
            ->where('survey_id', '<>', $survey->id)
            ->with('question.category.translations')
            ->get()
            ->groupBy(function ($item) {
                return $item['question']->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            });

            $data['Pozostali'][$name] = $answers->values();
        }

        //dd($data);

        $filename = 'Ankieta '.$survey->company->name.' kategoria '.$category->{'name:pl'}.' HRBP vs Business vs All.xlsx';

        return Excel::download(new CategoriesHrbpBusinessAllFromViewExport($data), $filename);

        //return view('admin.export.category_hrbp_business', compact('data'));
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
