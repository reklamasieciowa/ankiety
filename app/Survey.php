<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Survey extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['finished', 'company_id', 'uuid'];

 //    public function getRouteKeyName()
	// {
	//     return 'uuid';
	// }

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function people()
    {
        return $this->hasMany('App\Person');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function requiredQuestions()
    {
        return $this->questions->where('required', '=', 1);
    }

    public function percentAnswered()
    {
        if($this->answers->count() && $this->requiredQuestions()->count() && $this->people->count()) {
            return  round($this->answers->count()/($this->requiredQuestions()->count()*$this->people->count())*100, 2).'%';
        } else {
            return '-';
        }
    }

    public function peopleWithoutAnswersCollections()
    {
        return $this->people->filter(function($person)
        {
            return !$person->answers->count();
        });
    }

    public function peopleWithoutAnswersCount()
    {
        $people = $this->people->load('answers');

        if(count($people)) {
            $peopleWithoutAnswers = $people->filter(function ($item, $key) {
                return !$item->answers->count();
            })->count();

            return $peopleWithoutAnswers.' ('.round(($peopleWithoutAnswers/$people->count()*100),2).'%)';
        } else {
            return '-';
        }
    }

    public function peopleUnfinished()
    {
        $people = $this->people->load('answers');

        if(count($people)) 
        {
            $peopleUnfinished = $people->filter(function ($item, $key) {
                return $item->answers->count() < $this->requiredQuestions()->count();
            })->count();

            return $peopleUnfinished.'/'.count($people).' ('.round(($peopleUnfinished/$people->count()*100), 2).'%)';
        } else {
            return '-';
        }
    }

    public function peopleByPost()
    {
        $peopleByPost = $this->people->load(['post.translations', 'answers'])->groupBy(function($item, $key)
        {
            return $item['post']->name;
        });

        return $peopleByPost;
    }

    public function peopleByDepartment()
    {
        $peopleByDepartment = $this->people->load('department.translations')->groupBy(function($item, $key)
        {
            return $item['department']->name;
        });

        return $peopleByDepartment;
    }

    public function peopleByIndustry()
    {
        $peopleByIndustry = $this->people->load('industry.translations')->groupBy(function($item, $key)
        {
            return $item['industry']->name;
        });

        return $peopleByIndustry;
    }

    public function peopleFromDepartment($department)
    {
        return $this->people
                    ->where('department_id', $department->id)
                    ->pluck('id');
    }

    public function poepleHrbpBusinessIds()
    {
        $people = [];
        $people['hrbp'] = $this->people->whereIn('post_id', [1,2,3])->pluck('id');
        $people['business'] = $this->people->whereIn('post_id', [4,5,6])->pluck('id');
        return $people;
    }

    //Questions with numeric values
    public function questionsNumericIds()
    {
        return $this->questions->whereIn('question_type_id', [1,2])->pluck('id');
    }

}
