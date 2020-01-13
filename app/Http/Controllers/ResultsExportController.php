<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PeopleExport;
use App\Exports\AnswersAllExport;
use Maatwebsite\Excel\Facades\Excel;

class ResultsExportController extends Controller
{
    public function exportAll() 
    {
        return Excel::download(new PeopleExport, 'wyniki-wszystkie.xlsx');
        //return Excel::download(new AnswersAllExport, 'wyniki.xlsx');
    }
}
