<?php

namespace App\Exports;

use App\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyExport implements FromCollection, WithMapping, WithHeadings
{
	protected $survey;

    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    public function headings(): array
    {
    	$headings = [];
    	$headings[0] = '#';
    	$headings[1] = 'Stanowisko';
    	$headings[2] = 'Dział';
    	$headings[3] = 'Branża';

    	// foreach($survey->questions as $question) {
     //    	array_push($headings, $question->{'name:pl'});
     //    }

        return $headings;
    }

	public function map($person): array
    {
    	$columns = [];

    	$columns[0] = $person->id;
        $columns[1] = $person->post->name;
        $columns[2] = $person->department->name;
        $columns[3] = $person->industry->name;

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
    	
    	$survey = Survey::findOrFail($this->survey)->load('questions.translations', 'people.answers');

    	//dd($survey);

        return $survey->people;
    }
}
