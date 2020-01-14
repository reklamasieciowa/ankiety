<?php

namespace App\Exports;

use App\Person;
use App\Question;

//use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeopleExport implements FromCollection, WithMapping, WithHeadings
{

	public function headings(): array
    {
    	$headings = [];
    	$headings[0] = '#';
    	$headings[1] = 'Stanowisko';
    	$headings[2] = 'Dział';
    	$headings[3] = 'Branża';
    	$headings[4] = 'Firma';

    	$questions = Question::where('id', '<', 32)->with('translations')->get();

    	foreach($questions as $question) {
        	array_push($headings, $question->{'name:pl'});
        }

        return $headings;
    }

	public function map($person): array
    {
    	$columns = [];

    	$columns[0] = $person->id;
        $columns[1] = $person->post->name;
        $columns[2] = $person->department->name;
        $columns[3] = $person->industry->name;

        if($person->survey->company) {
        	$columns[4] = $person->survey->company->name;
    	} else {
    		$columns[4] = '';
    	}

        foreach($person->answers as $answer) {
        	array_push($columns, $answer->value);
        }
       
        return $columns;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$people = Person::with(['answers' => function ($query) {
		    $query->where('question_id', '<', 32);
		}])->get();

    	$peopleWithAnswers = $people->filter(function ($item) {
		    return $item->answers->count() > 0;
		});

		//dd($peopleWithAnswers->take(5));

        return $peopleWithAnswers;
    }
}
