<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['survey_id', 'person_id', 'question_id', 'value'];

	public function survey()
	{
		return $this->belongsTo('App\Survey');
	}

	public function person()
	{
		return $this->belongsTo('App\Person');
	}

	public function question()
	{
		return $this->belongsTo('App\Question');
	}
}