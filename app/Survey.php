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

    public function percentAnswered()
    {
        if($this->answers->count() && $this->questions->count() && $this->people->count()) {
            return  round($this->answers->count()/($this->questions->count()*$this->people->count())*100, 2).'%';
        } else {
            return '-';
        }
        
    }

    public function peopleWithoutAnswers()
    {
        $people = $this->people;

        if(count($people))
        {
            $peopleWithoutAnswers = 0;

            foreach($people as $person)
            {
                if(!$person->answers->count()) 
                {
                    $peopleWithoutAnswers++;
                }
            }

            return $peopleWithoutAnswers.' ('.($peopleWithoutAnswers/$people->count()*100).'%)';
        } else {
            return '-';
        }
    }

    public function peopleUnfinished()
    {
        $people = $this->people;

        if(count($people)) 
        {
            $peopleUnfinished = 0;

            foreach($people as $person)
            {
                if($person->answers->count() !== $this->questions->count()) 
                {
                    $peopleUnfinished++;
                }
            }

            return $peopleUnfinished.' ('.($peopleUnfinished/$people->count()*100).'%)';
        } else {
            return '-';
        }
        
    }

    public function peopleByPost()
    {
        $peopleByPost = $this->people->load('post')->groupBy(function($item, $key)
        {
            return $item['post']->name;
        });

       //dd($peopleByPost);

        return $peopleByPost;
    }

    public function peopleByDepartment()
    {
        $peopleByDepartment = $this->people->load('department')->groupBy(function($item, $key)
        {
            return $item['department']->name;
        });

        return $peopleByDepartment;
    }
}
