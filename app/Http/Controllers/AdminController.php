<?php

namespace Bevy\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{


    public function index()
    {
        return view('admin.index');
    }

    public function showTables()
    {
        $tables = DB::select('SHOW TABLES');

        return $tables;
    }

    public function database()
    {

        return view('admin.tables');

    }

    public function deleteTable($name)
    {

        Schema::dropIfExists($name);


    }

    public function showTable($name)
    {
        $table = DB::table($name)
            ->get();
        return view('admin.table', compact('table'));

    }
}
