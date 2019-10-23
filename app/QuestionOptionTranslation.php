<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
