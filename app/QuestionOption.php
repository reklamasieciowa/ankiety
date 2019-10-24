<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class QuestionOption extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = ['name'];
    protected $fillable = ['question_id', 'value'];

    public function question()
    {
    	return $this->belongsTo('App\Question');
    }
}
