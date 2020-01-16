<?php

namespace App\Exports;

use App\Survey;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoriesPostsFromViewExport implements FromView
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
        return view('admin.export.categories_by_post', [
            'data' => $this->data,
            'groupCount' => $this->groupCount,
        ]);
    }
}
