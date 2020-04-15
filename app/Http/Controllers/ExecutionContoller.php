<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\planController;
use Illuminate\Support\Facades\Auth;
use App\execution;
use DB;
use App\Http\Controllers\logsController;
use Yajra\DataTables\DataTables;


class ExecutionContoller extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }
    public function executionShow(){

        if(Auth::user()->heseg_id >= 1 && Auth::user()->heseg_id <= 3 ){
          $hesegID = Auth::user()->heseg_id;
          $companies = DB::table('tb_companies')
              ->join('tb_heseg', 'tb_companies.heseg_id', '=', 'tb_heseg.id')
              ->select('tb_companies.*', 'tb_heseg.name')
              ->where("tb_companies.heseg_id", "=", $hesegID)
              ->orderBy('tb_companies.heseg_id', 'asc')
              ->orderBy('tb_companies.companyName', 'asc')
              ->get();
        return view('guitsetgel.guitsetgelShow', compact('companies'));
        }else{
          $companies = DB::table('tb_companies')
              ->join('tb_heseg', 'tb_companies.heseg_id', '=', 'tb_heseg.id')
              ->select('tb_companies.*', 'tb_heseg.name')
              ->orderBy('tb_companies.heseg_id', 'asc')
              ->orderBy('tb_companies.companyName', 'asc')
              ->get();
          return view('guitsetgel.guitsetgelShow', compact('companies'));
        }
    }

    public static function previousReportExecutionByComIdWorkID($comID, $workID){
        $allExecution = DB::table("tb_companies")
            ->select(
                DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID` = $comID AND `work_id` = $workID) as allExecution"),
                DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID` = $comID AND `work_id` = $workID AND
                `date` BETWEEN (SELECT `startDate` FROM `tb_reporttime` WHERE `id`=1) AND (SELECT `endDate` FROM `tb_reporttime` WHERE `id`=1)) as lastExecution")
            )
            ->where('id', '=', $comID)
            ->first();
            return $allExecution->allExecution - $allExecution->lastExecution;
    }

    public static function getLastExecByComIdWorkID($comID, $workID){
        $lastExec = DB::table("tb_companies")
            ->select(
                DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID` = $comID AND `work_id` = $workID AND
                `date` BETWEEN (SELECT `startDate` FROM `tb_reporttime` WHERE `id`=1) AND (SELECT `endDate` FROM `tb_reporttime` WHERE `id`=1)) as lastExecution")
            )
            ->where('id', '=', $comID)
            ->first();
        return $lastExec->lastExecution;
    }

    public static function previousReportExecutionByComId($comID){
        $allExecution = DB::table("tb_companies")
            ->select(
                DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID` = $comID) as allExecution"),
                DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID` = $comID AND
                `date` BETWEEN (SELECT `startDate` FROM `tb_reporttime` WHERE `id`=1) AND (SELECT `endDate` FROM `tb_reporttime` WHERE `id`=1)) as lastExecution")
            )
            ->where('id', '=', $comID)
            ->first();
            return $allExecution->allExecution - $allExecution->lastExecution;
    }

    public static function getLastExecByComId($comID){
        $lastExec = DB::table("tb_companies")
            ->select(
                DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID` = $comID AND
                `date`= ( SELECT MAX(`date`) FROM `tb_execution`)) as lastExecution")
            )
            ->where('id', '=', $comID)
            ->first();
        return $lastExec->lastExecution;
    }

    public static function getExecutionPercentByWorkID2019($companyID, $workID){
        $executions = DB::table('tb_execution')
            ->where('companyID', '=', $companyID)
            ->where('work_id', '=', $workID)
            ->where('date', 'LIKE', '2019' . '%')
            ->get();
        $exec = 0;
        foreach ($executions as $execution) {
            $exec = $execution->percent;
        }
        return $exec;
    }

    public static function getExecutionPercentByCompany2019($comID){
        $sumPlan = DB::table("tb_plan")
            ->where('companyID', '=', $comID)
            ->sum('quantity');
        $sumExecution = DB::table("tb_execution")
            ->where('companyID', '=', $comID)
            ->where('date', 'like', '2019%')
            ->sum('execution');
        if($sumPlan == 0)
          return "";
        else
          return round($sumExecution*100/$sumPlan, 2);
    }

    public static function getSumExecutionByCompany2020($comID){
        $sumPlan = DB::table("tb_plan")
            ->where('companyID', '=', $comID)
            ->sum('quantity');
        $sumExecution = DB::table("tb_execution")
            ->where('companyID', '=', $comID)
            ->where('date', 'like', '2019%')
            ->sum('execution');
        return $sumPlan - $sumExecution;
    }

    public static function getExecution2019($companyID, $workID){
        $executions = DB::table('tb_execution')
            ->where('companyID', '=', $companyID)
            ->where('work_id', '=', $workID)
            ->where('date', 'LIKE', '2019' . '%')
            ->get();
        $exec = 0;
        foreach ($executions as $execution) {
            $exec = $execution->execution;
        }
        return $exec;
    }

    public static function getExecutionWorkTypePercentAvg2019($companyID, $workTypeID){
        $executions = DB::table('tb_execution')
            ->where('companyID', '=', $companyID)
            ->where('work_type_id', '=', $workTypeID)
            ->where('date', 'LIKE', '2019' . '%')
            ->get();
        $sumPercent = 0;
        $plan = new planController;
        foreach ($executions as $execution) {
            $sumPercent = $sumPercent + $execution->percent;
        }
        $planCount = $plan->getCompanyPlanCountByWorkType($companyID, $workTypeID);
        if($sumPercent == 0){
            return 0;
        }
        else{
            return $sumPercent/$planCount;
        }
    }

    public static function getSumExecution2019($companiesID, $workTypeID){
        $sumExecution = DB::table('tb_execution')
            ->where('companyID', '=', $companiesID)
            ->where('work_type_id', '=', $workTypeID)
            ->where('date', 'LIKE', '2019' . '%')
            ->sum('execution');
        return $sumExecution;
    }

    public static function getExecutionAllCompanyIDworkID($companiesID, $workID){
        $sumAllExecution = DB::table('tb_plan')
            ->select(
              DB::raw("(SELECT `quantity` FROM `tb_plan` WHERE `companyID`=$companiesID AND `work_id`=$workID) as planQuantity"),
              DB::raw("((SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID`=$companiesID AND `work_id`=$workID AND
                  date LIKE '2019%')*100/(SELECT `quantity` FROM `tb_plan` WHERE `companyID`=$companiesID AND `work_id`=$workID))
                  as percent2019"),
              DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID`=$companiesID AND `work_id`=$workID AND
                  date LIKE '2019%') as totalExec2019"),
              DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID`=$companiesID AND `work_id`=$workID) as totalExecAll"),
              DB::raw("(SELECT SUM(`execution`) FROM `tb_execution`
                  WHERE `companyID`=$companiesID AND `work_id`=$workID AND
                  `date` BETWEEN (SELECT startDate FROM `tb_reporttime` WHERE id=1) AND (SELECT endDate FROM `tb_reporttime` WHERE id=1))
                  AS lastExec"),
              DB::raw("(SELECT SUM(`execution`) FROM `tb_execution` WHERE `companyID`=$companiesID AND `work_id`=$workID AND
                  `date` LIKE '2020%') as lastexec2020"),
              DB::raw("(SELECT `percent` FROM `tb_execution`  WHERE `companyID`=$companiesID AND `work_id`=$workID  AND `date`= ( SELECT MAX(`date`) FROM `tb_execution` )) as totalPercent")
            )
            ->where('companyID', '=', $companiesID)
            ->where('work_id', '=', $workID)
            ->get();
        return $sumAllExecution;

    }

    public static function getSumAndAvgExecPlan($companyID, $workTypeID){
        $sums = DB::table("tb_companies")
            ->select(
                DB::raw("(SELECT SUM(`quantity`) FROM tb_plan WHERE `companyID`=$companyID AND `work_type_id`=$workTypeID)
                    as sumPlanQuantity"),
                DB::raw("(SELECT SUM(`execution`) FROM tb_execution WHERE `companyID`=$companyID AND `work_type_id`=$workTypeID)
                    as totalSumExec"),
                DB::raw("(SELECT SUM(`execution`) FROM tb_execution WHERE `companyID`=$companyID AND `work_type_id`=$workTypeID
                    AND date LIKE '2019%') as totalSumExec2019"),
                DB::raw("(SELECT SUM(`execution`) FROM tb_execution WHERE `companyID`=$companyID AND `work_type_id`=$workTypeID
                    AND `date` BETWEEN (SELECT startDate FROM `tb_reporttime` WHERE id=1) AND (SELECT endDate FROM `tb_reporttime` WHERE id=1))
                    as lastSumExect"),
                DB::raw("(SELECT SUM(`execution`) FROM tb_execution WHERE `companyID`=$companyID AND `work_type_id`=$workTypeID
                    AND `date` LIKE '2020%') as sumExec2020")
            )
            ->where('id', '=', $companyID)
            ->get();
        return $sums;
    }






  public function store(Request $req){
    $res = "";
    foreach ($req->json as $key => $value) {
      $check = DB::table("tb_execution")
        ->where("companyID", "=", $req->companyID)
        ->where("work_type_id","=",$value['workTypeID'])
        ->where("work_id","=",$value['workID'])
        ->where("date","=",$req->createDate)
        ->get();

        if($check->count() == 0){
          $execution = new execution;
          $execution->companyID = $req->companyID;
          $execution->work_type_id = $value['workTypeID'];
          $execution->work_id = $value['workID'];
          $execution->execution = $value['value'];
          $execution->date = $req->createDate;
          $execution->percent = $this->getPercent($value['value'], $req->companyID, $value['workID']);
          $execution->save();
          $res = "Амжилттай хадгаллаа";


          $log = new logsController;
          $log->insertTableLog($req->ip(), Auth::user()->name, "Өгөгдөл оруулсан", "Гүйцэтгэл",
            explode("м3",$value['workName'])[0]." : ".$value['value'], "".$this->getCompanyName($req->companyID)."  огноо: ".$req->createDate);
        }
        else {
          $res = "Тухайн өдрийн ажлын гүйцэтгэл бүртгэгдсэн байна.";
        }
    }
    return $res;
  }

  public function getCompanyName($comID)
  {
    $company = DB::table('tb_companies')
      ->where('id','=',$comID)
    ->first();
    return $company->companyName;
  }



  public function execDelete(Request $req){
      $exec = execution::find($req->id);
      $exec->delete();

      $log = new logsController;
      $log->insertTableLog($req->ip(), Auth::user()->name, "Өгөгдөл устгав", "Гүйцэтгэл",
        $req->workName." : ".$req->execution , "".$req->comName);

      return "Амжилттай устгалаа.";
  }

  public function execDeleteByCompany($comID){
      $exec = DB::table("tb_execution")
        ->where('companyID', '=', $comID);
      $exec->delete();
      return "Амжилттай устгалаа.";
  }

  public function execUpdate(Request $req){
      $exec = execution::find($req->execRowID);
      $exec->execution = $req->editExec;
      $exec->save();

      $log = new logsController;
      $log->insertTableLog($req->ip(), Auth::user()->name, "Өгөгдөл засав", "Гүйцэтгэл",
        $req->workName." : ".$req->editExec , "".$req->comName." огноо: ".$req->editDate);

      return "Амжилттай хадгаллаа.";
  }

  public function getPercent($val, $comID, $workID){
    $getPlan = DB::table("tb_plan")
      ->where("companyID", "=", $comID)
      ->where("work_id", "=", $workID)
      ->first();

    $quantity = $getPlan->quantity;

    $getExecution = DB::table("tb_execution")
      ->where("companyID", "=", $comID)
      ->where("work_id", "=", $workID)
      ->sum("execution");


    return ($getExecution + $val)*100/$quantity;

  }

  public function getExecByCompany(Request $req) {
    $exec = DB::table("tb_execution")
      ->join("tb_work", "tb_execution.work_id", "=","tb_work.id")
      ->join("tb_work_type", "tb_execution.work_type_id", "=", "tb_work_type.id")
      ->select("tb_execution.id","tb_execution.execution", "tb_execution.date","tb_work.name as workName","tb_work_type.name as workTypeName")
      ->where("companyID", "=", $req->comID)
      ->get();
      return DataTables::of($exec)
          ->make(true);
  }

  public static function getLastExecutionByHeseg($hesegID, $workID){
    $lastExecs = DB::table("tb_execution")
        ->join('tb_companies', 'tb_execution.companyID', '=', 'tb_companies.id')
        ->select(DB::raw("SUM(tb_execution.execution) as lastExec"))
        ->where('tb_companies.heseg_id', '=', $hesegID)
        ->where('tb_execution.work_id', '=', $workID)
        ->whereBetween('tb_execution.date', [DB::raw('(SELECT `startDate` FROM `tb_reporttime` WHERE id=1)'), DB::raw('(SELECT `endDate` FROM `tb_reporttime` WHERE id=1)')])
        ->get();
    foreach ($lastExecs as $lastExec) {
      $lastExec1 = $lastExec->lastExec;
    }
    return $lastExec1;
  }

  public static function getAllExecutionByHeseg($hesegID, $workID){
    $lastExecs = DB::table("tb_execution")
        ->join('tb_companies', 'tb_execution.companyID', '=', 'tb_companies.id')
        ->select(DB::raw("SUM(tb_execution.execution) as lastExec"))
        ->where('tb_companies.heseg_id', '=', $hesegID)
        ->where('tb_execution.work_id', '=', $workID)
        ->get();
    foreach ($lastExecs as $lastExec) {
      $lastExec1 = $lastExec->lastExec;
    }
    return $lastExec1;
  }

  public static function getAllExecByHeseg($hesegID){
      $allHesegExecs = DB::table('tb_execution')
          ->join('tb_companies', 'tb_execution.companyID', '=', 'tb_companies.id')
          ->select(DB::raw("SUM(tb_execution.execution) as allExec"))
          ->where('tb_companies.heseg_id', '=', $hesegID)
          ->get();
      foreach ($allHesegExecs as $allHesegExec) {
        $allExecHeseg = $allHesegExec->allExec;
      }
      return $allExecHeseg;
  }

  public static function getAllExecPercent(){
      $sumPlan = DB::table('tb_plan')
          ->sum('quantity');
      $sumExec = DB::table('tb_execution')
          ->sum('execution');
      return $sumExec*100/$sumPlan;
  }

  public static function getAllExecByCompany($comID){
      $allExecCompany = DB::table('tb_execution')
          ->where('companyID', '=', $comID)
          ->sum('execution');
      return $allExecCompany;
  }
}
