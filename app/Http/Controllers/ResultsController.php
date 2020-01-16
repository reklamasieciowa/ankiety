<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Percent;
use App\Charts\PercentMultiple;
use App\Charts\Number;
use App\Charts\NumberCompare;
use App\Charts\NumberBusiness;
use App\Charts\NumberHrbp;
use App\Charts\NumberHrbpBusiness;
use App\Charts\Line;
use App\Person;
use App\Answer;
use App\Category;
use App\Question;

class ResultsController extends Controller
{


    public function PostListChart()
    {
        $peopleCount = Person::count();

        $peopleByPost = Person::all()->load(['post.translations'])->sortBy('post_id')->groupBy(function($item, $key)
        {
            return $item['post']->{'name:pl'};
        })->map(function ($item) use($peopleCount) {
            // Return the number of persons with that age
            return count($item)/$peopleCount;
        });

        $title = 'Stanowiska';

        $chart = Percent::generateChart($peopleByPost, 'pie', '%');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function IndustryListChart()
    {
        $peopleCount = Person::count();

        $peopleByIndustry = Person::all()->load(['industry.translations'])->sortBy('industry_id')->groupBy(function($item, $key)
        {
            return $item['industry']->{'name:pl'};
        })->map(function ($item) use($peopleCount) {
            return count($item)/$peopleCount;
        });

        $peopleByIndustryFiltered = FilterHigherThan($peopleByIndustry, 0.03);

        $peopleByIndustryFiltered->put('Pozostałe <3%', FilterLowerThan($peopleByIndustry, 0.03)->sum());

        $title = 'Branże';

        $chart = Percent::generateChart($peopleByIndustryFiltered, 'pie', '%');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function DepartmentListChart()
    {
        $peopleCount = Person::count();

        $peopleByDepartment = Person::all()->load(['department.translations', 'answers'])->sortBy('department_id')->groupBy(function($item, $key)
        {
            return $item['department']->{'name:pl'};
        })->map(function ($item) use($peopleCount) {
            return count($item)/$peopleCount;
        });

        $peopleByDepartmentFiltered = FilterHigherThan($peopleByDepartment, 0.03);

        $peopleByDepartmentFiltered->put('Pozostałe <3%', FilterLowerThan($peopleByDepartment, 0.03)->sum());

        $title = 'Działy';

        $chart = Percent::generateChart($peopleByDepartmentFiltered, 'pie', '%');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesChart()
    {
        //without effectivness of IT tools and text answers
        $answers = Answer::where('question_id', '<', 32)->get();

        $answersgrouped = $answers->load('question.category.translations')->groupBy(function($item, $key)
        {
            return $item['question']['category']->{'name:pl'};
        })->map(function ($item) {
            return $item->avg('value');
        });

        $title = 'Kategorie';

        $chart = Number::generateChart($answersgrouped, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesBusinessChart()
    {
        $people = getPoepleBusinessIds();

        $answersValues = collect();

        foreach($people as $group) {
            $answers = Answer::where('question_id', '<', 32)
            ->whereIn('person_id', $group)
            ->with('question.category.translations')
            ->get()
            ->groupBy(function ($item) {
                return $item['question']['category']->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            });

            $answersValues->push($answers->values());

            if(empty($answersValues['keys'])) {
                $answersValues['keys'] = $answers->keys();
            }
        }

        $title = 'Kategorie Business';

        $chart = NumberBusiness::generateChart($answersValues, 'bar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesHrbpBusinessChart()
    {
        $people = getPoepleHrbpBusinessIds();

        $answersValues = collect();

        foreach($people as $group) {
            $answers = Answer::where('question_id', '<', 32)
            ->whereIn('person_id', $group)
            ->with('question.category.translations')
            ->get()
            ->groupBy(function ($item) {
                return $item['question']['category']->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            });

            $answersValues->push($answers->values());

            if(empty($answersValues['keys'])) {
                $answersValues['keys'] = $answers->keys();
            }
        }

        //dd($answersValues);

        $title = 'Kategorie HRBP vs Business';

        $chart = NumberHrbpBusiness::generateChart($answersValues, 'radar', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesIndustries()
    {
        
        $answersByIndustry = Answer::where('question_id', '<', 32)
        ->with('person.industry.translations','question.category.translations')
        ->get()
        ->groupBy(
             ['person.industry.name', 'question.category.name']
        )
        ->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            })->sortKeys();
        })
        ->sortKeys();

        //dd($answersByIndustry);

        $title = 'Średnie kategorii wg branż';

        $chart = Line::generateChart($answersByIndustry, 'line', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }

    public function AllCategoriesPosts()
    {
        
        $answersByPost = Answer::where('question_id', '<', 32)      
        ->with('person.post.translations','question.category.translations')
        ->get()
        ->groupBy(
             ['person.post.name', 'question.category.name']
        )->map(function ($item) {   
            return $item->map(function ($nesteditem) {
                return $nesteditem->avg('value');
            });
        });

        $title = 'Średnie kategorii wg stanowisk';

        $chart = Line::generateChart($answersByPost, 'line', '');

        return view('admin.result.chart', compact('chart', 'title'));
    }



    public function CategoryChart($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category_questions = $category->questions->pluck('id');

        $people = getPoepleGroupsIds();

        $answersValues = collect();

        foreach($people as $group) {
            $answers = Answer::whereIn('question_id', $category_questions)
            ->whereIn('person_id', $group)
            ->with('question.category.translations')
            ->get()
            ->groupBy(function ($item) {
                return $item['question']->{'name:pl'};
            })
            ->map(function ($item) {
                return  $item->avg('value');
            });

            $answersValues->push($answers->values());

            if(empty($answersValues['keys'])) {
                $answersValues['keys'] = $answers->keys();
            }
        }

        //dd($answersValues);

        $title = 'Kategoria '.$category->{'name:pl'};

        $chart = NumberHrbp::generateChart($answersValues, 'bar', '');

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

    public function topFive($group, $order = "worst")
    {
        $people = getPoepleHrbpBusinessIds();

        $answers = Answer::where('question_id', '<', 32)
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

        $title = 'Top 5 '.$order.' '.$group;

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

   public function openQuestions()
   {
        $questionsIds = Question::whereIn('question_type_id', [3,4])->pluck('id');

       $answers = Answer::whereIn('question_id', $questionsIds)
                    ->with('question')
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->question->{'name:pl'};
                    });

        return view('admin.result.openQuestions', compact('answers'));
   }
}
