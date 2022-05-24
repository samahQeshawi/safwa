<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Imports\UsersImport;

class ExcelController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
       return view('excel.index');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExcel(Request $request)
    {
        \Excel::import(new UsersImport,$request->import_file);

        \Session::put('success', 'Your file is imported successfully in database.');

        return back();
    }
}
