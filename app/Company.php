<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

    public function survey()
    {
        return $this->hasOne('App\Survey');
    }
}
