<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\company;
use DB;
use Yajra\DataTables\DataTables;

class companyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showSlider(){
        return view('companySlider.companySliderShow');
    }

    public function index(){
        return view('company.companies');
    }

    public function getCompanyToNew(){
        $companies = DB::table('tb_companies')
        ->get();
        return DataTables::of($companies)
            ->make(true);
    }

    public function getCompanyByID(Request $req){
        $company = DB::table('tb_companies')
            ->where('tb_companies.id', '=', $req->id)
            ->get();
        return $company;
    }

    public function store(Request $req){
        $company = new company;
        $company->companyName = $req->companyName;
        $company->heseg_id = $req->heseg_id;
        $company->ajliinHeseg = $req->ajliinHeseg;
        $company->hursHuulalt = $req->hursHuulalt;
        $company->dalan = $req->dalan;
        $company->uhmal = $req->uhmal;
        $company->suuriinUy = $req->suuriinUy;
        $company->shuuduu = $req->shuuduu;
        $company->uhmaliinHamgaalalt = $req->uhmaliinHamgaalalt;
        $company->uuliinShuuduu = $req->uuliinShuuduu;
        $company->niit = ($req->hursHuulalt + $req->dalan + $req->uhmal + $req->suuriinUy + $req->shuuduu + $req->uhmaliinHamgaalalt + $req->uuliinShuuduu);
        $company->gereeOgnoo = $req->gereeOgnoo;
        $company->hunHuch = $req->hunHuch;
        $company->mashinTehnik = $req->mashinTehnik;
        $company->save();
        return "Амжилттай хадгаллаа.";
    }

    public function update(Request $req){
        $company = company::find($req->id);
        $company->companyName = $req->companyName;
        $company->heseg_id = $req->heseg_id;
        $company->ajliinHeseg = $req->ajliinHeseg;
        $company->hursHuulalt = $req->hursHuulalt;
        $company->dalan = $req->dalan;
        $company->uhmal = $req->uhmal;
        $company->suuriinUy = $req->suuriinUy;
        $company->shuuduu = $req->shuuduu;
        $company->uhmaliinHamgaalalt = $req->uhmaliinHamgaalalt;
        $company->uuliinShuuduu = $req->uuliinShuuduu;
        $company->niit = ($req->hursHuulalt + $req->dalan + $req->uhmal + $req->suuriinUy + $req->shuuduu + $req->uhmaliinHamgaalalt + $req->uuliinShuuduu);
        $company->gereeOgnoo = $req->gereeOgnoo;
        $company->hunHuch = $req->hunHuch;
        $company->mashinTehnik = $req->mashinTehnik;
        $company->save();
        return "Амжилттай заслаа.";
    }

    public function delete(Request $req){
        $company = company::find($req->id);
        $company->delete();
        return "Амжилттай устгалаа.";
    }
    public function storeWorks(Request $req, $val, $worktype){

        //$company = new company;

        $s=0;

        // $name = $req->input('name');

        $input = $req->inputs->all();

        foreach ($input as $key => $value) {
            
        }

        // $company->companyName = $req->companyName;
        // $company->heseg_id = $req->heseg_id;
        // $company->ajliinHeseg = $req->ajliinHeseg;
        // $company->hursHuulalt = $req->hursHuulalt;
        // $company->dalan = $req->dalan;
        // $company->uhmal = $req->uhmal;
        // $company->suuriinUy = $req->suuriinUy;
        // $company->shuuduu = $req->shuuduu;
        // $company->uhmaliinHamgaalalt = $req->uhmaliinHamgaalalt;
        // $company->uuliinShuuduu = $req->uuliinShuuduu;
        // $company->niit = ($req->hursHuulalt + $req->dalan + $req->uhmal + $req->suuriinUy + $req->shuuduu + $req->uhmaliinHamgaalalt + $req->uuliinShuuduu);
        // $company->gereeOgnoo = $req->gereeOgnoo;
        // $company->hunHuch = $req->hunHuch;
        // $company->mashinTehnik = $req->mashinTehnik;
        // $company->save();
        return $s;
    }

}
