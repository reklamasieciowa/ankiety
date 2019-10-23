<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Scale extends Model
{
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function values()
    {
        return $this->hasMany('App\ScaleValue');
    }
}
