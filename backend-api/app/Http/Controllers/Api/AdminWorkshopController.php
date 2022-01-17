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
use App\Schedule;
use App\ScheduleDetail;

class AdminWorkshopController extends Controller
{
    public function getScheduleByWorkshopIDAndAdminWorkshop(Request $req){
        $IncomingSchedule = DB::table('schedules')
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->join('users','users.ID','=','workshops.userID')
        ->select('schedules.id as scheduleID','schedules.userID as customerID','workshops.userID as AdminID','schedules.workshopID'
        ,'schedules.workshopName','schedules.workshopAddress','schedules.workshopPhoneNumber',
        'schedules.workshopEmail','schedules.scheduleDate','schedules.scheduleTime','schedules.carModel',
        'schedules.carType','schedules.timeEstimation','schedules.priceEstimation','schedules.scheduleStatus'
        ,'schedules.description')
        ->where('workshops.userID','=',$req->adminID)
        ->where('scheduleStatus','=','waiting confirmation')
        ->get()
        ->toArray();

        $dataDetailsSchedule = DB::table('schedule_details')
        ->join('schedules','schedules.id','=','schedule_details.scheduleID')
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->select('schedule_details.id','schedule_details.scheduleID','schedule_details.serviceType','schedule_details.serviceDetail')
        ->where('workshops.userID','=',$req->adminID)
        ->where('scheduleStatus','=','waiting confirmation')
        ->get()
        ->toArray();
        $data =['objectReturner'=>$IncomingSchedule,$dataDetailsSchedule];
        return response()->json($data, 200);
    }

    public function accpetScheduleByAdmin(Request $req){
        if ($req->scheduleStatus=='accepted') {
            $validator = Validator::make($req->all(), [
                'description' => 'string','required'
            ]);

            if ($validator->fails()) {
                $return = [
                    'error' => $validator->errors()
                ];
            }
            $dataSchedule= Schedule::find($req->scheduleID)->where('scheduleStatus','=','waiting confirmation')
            ->update(['scheduleStatus'=>$req->scheduleStatus,
            'description'=>$req->description]);
        }
        $dataUpdatedSchedule = DB::table('schedules')->where('id','=',$req->scheduleID)->get();

        return response()->json($dataUpdatedSchedule, 200);
    }

    public function rejectedScheduleByAdmin(Request $req){


        if ($req->scheduleStatus=='rejected') {
            $validator = Validator::make($req->all(), [
                'description' => 'string','required'
            ]);

            if ($validator->fails()) {
                $return = [
                    'error' => $validator->errors()
                ];
            }
            $dataSchedule= Schedule::find($req->scheduleID)->where('scheduleStatus','=','waiting confirmation')
            ->update(['scheduleStatus'=>$req->scheduleStatus,
            'description'=>$req->description]);
        }
        $dataUpdatedSchedule = DB::table('schedules')->where('id','=',$req->scheduleID)->get();

        return response()->json($dataUpdatedSchedule, 200);
    }

    public function updateWorkshopForAdminBengkel (Request $req){

    }

    public function getWorkshopProfileByUserID (Request $req){
        try{
            $workshops = DB::table('workshops')
            ->where('userID','=',$req->adminID)
            ->get()->toArray();

            foreach ($workshops as $key=>$value) {
            $operational_workshops =  DB::table('operational_workshops')
            ->orWhere('operational_workshops    .workshopID','=',$value->id)
            ->get()->toArray();

            $workshop_details =  DB::table('workshop_details')
            ->orWhere('workshop_details.workshopID','=',$value->id)
            ->get()->toArray();

            $workshop_services =  DB::table('workshop_services')
            ->join('workshop_details','workshop_details.id','=','workshop_services.workshopDetailID')
            ->select('workshop_services.id','workshop_details.workshopID','workshopDetailID','serviceType','serviceDetail','price','time')
            ->orWhere('workshop_details.workshopID','=',$value->id)
            ->get()->toArray();
            }
            $workshop_review = DB::table('reviews')
            ->join('schedules','schedules.id','=','reviews.scheduleID')
            ->select('reviews.id','reviews.scheduleID','schedules.workshopID','reviews.userName','reviews.reviewDate','reviews.rating','reviews.description')
            ->where('schedules.scheduleStatus','=','done')
            ->get()->toArray();


            foreach($workshops as &$value)
            {
                $value->operational_workshop = array_filter($operational_workshops, function($operational_workshops) use ($value) {
                    return $operational_workshops->workshopID === $value->id;
                });
                $value->workshop_details = array_filter($workshop_details, function($workshop_details) use ($value) {
                    return $workshop_details->workshopID === $value->id;
                });

                $value->workshop_services = array_filter($workshop_services, function($workshop_services) use ($value) {
                    return $workshop_services->workshopID === $value->id;
                });
            }

            return response()->json($workshops[0], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }
}
