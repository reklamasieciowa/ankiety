<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['survey_id', 'post_id', 'department_id', 'industry_id', 'email', 'agree', 'practice'];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function industry()
    {
        return $this->belongsTo('App\Industry');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function countAnswers()
    {
    	return $this->answers->count();
    }

    public function percentAnswered()
    {

        if($this->countAnswers() && $this->survey->questions->count()) {
            $answered = round(($this->countAnswers()/$this->survey->requiredQuestions()->count())*100, 2);
            if($answered > 100) {
                return '100%';
            } else {
                return $answered.'%';
            }
            
        } else {
            return '-';
        }
    }
}