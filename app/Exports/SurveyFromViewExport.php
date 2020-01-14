<?php

namespace App\Exports;

use App\Survey;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SurveyFromViewExport implements FromView
{
	protected $survey;

    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.export.survey', [
            'survey' => $this->survey
        ]);
    }
}
