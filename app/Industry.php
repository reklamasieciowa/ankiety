<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Industry extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = ['name'];

    public function people()
    {
        return $this->hasMany('App\Person');
    }
}
