<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hunHuch;
use DB;
use Yajra\DataTables\DataTables;

class hunHuchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('hunHuch.hunHuchShow');
    }

    public function getHunHuchToNew(){
        $hunHuchs = DB::table('tb_hunhuch')
            ->join('tb_companies', 'tb_hunhuch.companyID', '=', 'tb_companies.id')
            ->select('tb_hunhuch.*', 'tb_companies.companyName')
            ->get();
        return DataTables::of($hunHuchs)
            ->make(true);
    }

    public function store(Request $req){
        $hunHuch = new hunHuch;
        $hunHuch->companyID = $req->companyID;
        $hunHuch->hunHuch = $req->hunHuch;
        $hunHuch->mashinTehnik = $req->mashinTehnik;
        $hunHuch->ognoo = $req->ognoo;
        $hunHuch->save();
        return "Амжилттай хадгаллаа.";
    }

    public function update(Request $req){
        $hunHuch = hunHuch::find($req->id);
        $hunHuch->companyID = $req->companyID;
        $hunHuch->hunHuch = $req->hunHuch;
        $hunHuch->mashinTehnik = $req->mashinTehnik;
        $hunHuch->ognoo = $req->ognoo;
        $hunHuch->save();
        return "Амжилттай заслаа.";
    }

    public function delete(Request $req){
        $hunHuch = hunHuch::find($req->id);
        $hunHuch->delete();
        return "Амжилттай устгалаа.";
    }
}
