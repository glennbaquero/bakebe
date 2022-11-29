<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branches\Branch;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
    	$filterBranch = Branch::all();

        return view('admin.dashboards.index',[
        'filterBranch' => $filterBranch,

        ]);
    }
}
