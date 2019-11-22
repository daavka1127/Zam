<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\guitsetgel;
use DB;

class guitsetgelChartController extends Controller
{
    public function getCompaniesChart(Request $req){
        if($req->id>0 && $req->id<4){
            $companies = DB::table('tb_companies')
                ->where('tb_companies.heseg_id', '=', $req->id)
                ->get();
        }
        else{
          $companies = DB::table('tb_companies')->get();
        }
        return view('chart.guitsetgelAllChart', compact('companies'));
    }
}