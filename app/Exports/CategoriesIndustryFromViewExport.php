<?php

namespace App\Exports;

use App\Survey;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoriesIndustryFromViewExport implements FromView
{
    protected $data;
	protected $groupCount;

    public function __construct($data, $groupCount)
    {
        $this->data = $data;
        $this->groupCount = $groupCount;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.export.categories_by_industry', [
            'data' => $this->data,
            'groupCount' => $this->groupCount,
        ]);
    }
}
