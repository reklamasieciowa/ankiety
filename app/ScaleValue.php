<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ScaleValue extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = ['name'];
    protected $fillable = ['scale_id', 'value'];

    public function scale()
    {
        return $this->belongsTo('App\Scale');
    }
}
