<?php

use App\Person;

function FilterLowerThan($collection, $max)
{
	return $collection->filter(function ($value, $key) use ($max){
            return $value < $max;
        });
}

function FilterHigherThan($collection, $max)
{
	return $collection->filter(function ($value, $key) use ($max){
            return $value >= $max;
        });
}

function getPoepleGroupsIds()
    {
        $people = [];
        $people['hrbp'] = Person::whereIn('post_id', [4,5,6])->pluck('id');
        $people['business'] = Person::whereIn('post_id', [1,2,3])->pluck('id');
        $people['all'] = Person::all()->pluck('id');
        return $people;
    }

function getPoepleHrbpBusinessIds()
    {
        $people = [];
        $people['hrbp'] = Person::whereIn('post_id', [4,5,6])->pluck('id');
        $people['business'] = Person::whereIn('post_id', [1,2,3])->pluck('id');
        return $people;
    }


function getPoepleBusinessIds()
    {
        $people = [];
        $people['Zarząd'] = Person::where('post_id', 1)->pluck('id');
        $people['Kadra Zarządzająca raportująca do Zarządu'] = Person::where('post_id', 2)->pluck('id');
        $people['Kadra Kierownicza'] = Person::where('post_id', 3)->pluck('id');
        return $people;
    }