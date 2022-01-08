<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use App\OperationalWorkshop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\ServceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class HistoryController extends Controller
{
    public function getHistoryByScheduleStatusAndUserID(Request $req){
        try{
            $dataHistory=DB::table('schedules')
            // ->join('schedule_details','schedule_details.scheduleID','=','schedules.id')
            ->where('userID','=',$req->userID)
            ->where('scheduleStatus','=','done')
            ->get()->toArray();

            // foreach ($dataHistory as $key => $value) {
                $dataDetailsSchedule = DB::table('schedule_details')
                ->join('schedules','schedules.id','=','schedule_details.scheduleID')
                ->select('schedule_details.id','schedule_details.scheduleID','schedule_details.serviceType','schedule_details.serviceDetail')
                ->where('schedules.userID','=',$req->userID)
                ->where('scheduleStatus','=','done')
                ->get()
                ->toArray();
            // }
            // foreach($dataHistory as &$value)
            // {
            //     $value->dataDetailsSchedule = array_filter($dataDetailsSchedule, function($dataDetailsSchedule) use ($value) {
            //         return $dataDetailsSchedule->scheduleID === $value->id;
            //     });
            // }
            $data = [
                'objectReturn' =>$dataHistory,$dataDetailsSchedule
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }
}
