<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'post_id', 'department_id', 'industry_id', 'email'];

    public function survey()
    {
        return $this->hasOne('App\Survey');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function industry()
    {
        return $this->belongsTo('App\Industry');
    }
}
