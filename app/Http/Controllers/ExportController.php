<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportToExcel(Request $request)
    {
        Excel::create("{$request->fileName}", function ($excel) use ($request) {
            $excel->sheet('Items', function ($sheet) use ($request) {
                $sheet->loadView("{$request->viewName}");
            });
        })->export('xlsx');
    }
}
