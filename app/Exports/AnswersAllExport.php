<?php

namespace App\Exports;

use App\Answer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnswersAllExport implements FromCollection, WithMapping, WithHeadings
{
	public function headings(): array
    {
        return [
            '#',
            'Ankieta',
            'Stanowisko',
            'Dział',
        ];
    }

	public function map($answer): array
    {
        return [
            $answer->person->id,
            $answer->survey->title,
            $answer->person->post->name,
            $answer->person->department->name,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$answers = Answer::with('person')
    				->with('survey', 'question')
    				->get();


    	//dd($answers);

        return $answers;
    }
}
