<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['survey_id', 'post_id', 'department_id', 'email'];

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

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function countAnswers()
    {
    	return $this->answers->count();
    }
}