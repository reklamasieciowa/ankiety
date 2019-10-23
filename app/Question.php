<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Question extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = ['name'];
    protected $fillable = ['category_id', 'question_type_id', 'scale_id', 'order', 'required'];

    public function surveys()
    {
        return $this->belongsToMany('App\Survey');
    }

    public function question_type()
    {
        return $this->belongsTo('App\QuestionType');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function options()
    {
        return $this->hasMany('App\QuestionOption');
    }

    public function scale()
    {
        return $this->belongsTo('App\Scale');
    }

    public function answers()
    {
        return $this->belongsTo('App\Answer');
    }

    public function canHaveOptions()
    {
        return $this->question_type->options;
    }

    public function hasScale()
    {
        return $this->scale_id;
    }

    public function getOptions()
    {
        if(count($this->options)) {
            return $this->options;
        } else {
            return false;
        }
    }
}
