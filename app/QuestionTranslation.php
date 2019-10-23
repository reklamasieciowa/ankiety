<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
