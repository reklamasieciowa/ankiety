<?php

namespace App\Exports;

use App\Survey;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SurveyCategoriesPostsFromViewExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.export.survey_categories_by_post', [
            'data' => $this->data
        ]);
    }
}
