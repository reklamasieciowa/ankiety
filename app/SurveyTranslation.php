<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
