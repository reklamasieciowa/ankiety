<?php

namespace App;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Department extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = ['name'];
    protected $fillable = ['order'];

    public function people()
    {
        return $this->hasMany('App\Person');
    }
}
