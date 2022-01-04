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

class ScheduleController extends Controller
{

    public function getDataFormMakeScheduleById(Request $req){
            try{
                $workshops = DB::table('workshops')->select('id','userID')
                ->where('id','=',$req->id)
                ->get()->toArray();

                $operational_workshops =  DB::table('operational_workshops')
                ->where('operational_workshops.workshopID','=',$req->id)
                ->get()->toArray();

                $workshop_details =  DB::table('workshop_details')
                ->where('workshop_details.workshopID','=',$req->id)
                ->get()->toArray();

                foreach ($workshop_details as $key=>$value) {
                    $workshop_services =  DB::table('workshop_services')
                    ->join('workshop_details','workshop_details.id','=','workshop_services.workshopDetailID')
                    ->select('workshop_services.id','workshop_details.workshopID','workshopDetailID','serviceType','serviceDetail','price','time')
                    ->where('workshop_details.workshopID','=',$req->id)
                    ->orWhere('workshop_services.workshopDetailID','=',$value->id)
                    ->get()->toArray();
                }

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
                return response()->json($workshops, 200);
            } catch (Exception $err){
                return response()->json($err, 500);
            }
    }


    public function makeScheduleApi(Request $req){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $datestring = Carbon::now();
            $dateweek = $datestring->dayOfWeek;
            $mytime = new DateTime('now');
            $date = $mytime->format("Y-m-d");
            $time = $mytime->format("H:i:s");

            // $validator = Validator::make($req->all(), [
            //     'carModel' => ['required', 'exists:workshop_details', 'max:255'],
            //     'carType' => ['required', 'string','max:255','exists:workshop_details'],
            //     'servicType.*' => ['required', 'string','max:255','exists:workshop_services'],
            //     'servicDetail.*' => ['required', 'string','max:255','exists:workshop_services'],
            //     'description'=>['string','max:400','nullable'],
            //     'sceduleDate'=>['required','date_format:Y-m-d'],
            //     'sceduleTime'=>['required','date_format:H:i:s'],
            //     'workshopID'=>['required','exists:workshops,id']
            //     // 'scheduleDate'=>['required', 'date_format::Y-m-d',function($attribute, $value, $fail) use($date){
            //     //     $sorted = strtotime("+7 day",$date);
            //     //     if (!($fail <= $sorted)) {
            //     //         $fail('The '.$attribute.' is invalid.');
            //     //     }
            //     // }],
            //     // 'scheduleTime'=>['required', 'date_format::H:i:s',function($attribute, $value, $fail) use($time){
            //     //     if (!($fail <= $sorted)) {
            //     //         $fail('The '.$attribute.' is invalid.');
            //     //     }
            //     // }],
            // ]);
            // if ($validator->fails()) {
            //     return $validator->errors();
            // }
            $dataqueryworkshop = DB::table('workshops')->find($req->workshopID);
            $newSchedules = new Schedule;
            $newSchedules -> workshopID = $req->workshopID;
            $newSchedules -> userID = $req->userID;
            $newSchedules -> workshopName = $dataqueryworkshop->workshopName;
            $newSchedules -> workshopAddress = $dataqueryworkshop->workshopAddress;
            $newSchedules -> workshopPhoneNumber = $dataqueryworkshop->workshopPhoneNumber;
            $newSchedules -> workshopEmail = $dataqueryworkshop->workshopEmail;
            $newSchedules -> scheduleDate = $req->scheduleDate;
            $newSchedules -> scheduleTime = $req->scheduleTime;
            $newSchedules -> carModel = $req->carModel;
            $newSchedules -> carType = $req->carType;
            $newSchedules -> timeEstimation = $req->timeEstimation;
            $newSchedules -> priceEstimation = $req->priceEstimation;
            $newSchedules -> scheduleStatus = 'waiting confirmation';
            $newSchedules -> description = $req->description;
            $newSchedules->save();
            $idSchedule = $newSchedules->id;
            $array = array();
            if ($req->has('serviceTypeUmum')) {
                foreach($req->serviceTypeUmum as $key => $value){
                $newscheduledetail = new schedule_details;
                $newscheduledetail -> scheduleID = $idSchedule;
                $newscheduledetail ->serviceType = $req->serviceTypeUmum[$key];
                $newscheduledetail ->serviceDetail = $req->serviceDetailUmum[$key];
                $newscheduledetail->save();
                // kolo pake jobs
                // array_push($newscheduledetail,$array);
                }
            }
            if ($req->has('serviceTypeBerkala')) {
                foreach($req->serviceTypeBerkala as $key => $value){
                    $newscheduledetail = new schedule_details;
                    $newscheduledetail -> scheduleID = $idSchedule;
                    $newscheduledetail ->serviceType = $req->serviceTypeBerkala[$key];
                    $newscheduledetail ->serviceDetail = $req->serviceDetailBerkala[$key];
                    $newscheduledetail->save();
                    //kolo pake jobs
                    // array_push($newscheduledetail,$array);
                }
            }
            $data = [
                'objectReturner'=>[$newSchedules]
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function ShowDataScheduleByUserID(Request $req){
        try{
            $schedule= DB::table('schedules')
            // ->join('schedule_details','schedule_details.scheduleID','=','schedules.id')
            ->where('userID','=',$req->userID)
            ->where('scheduleStatus','=','waiting confirmation')
            ->get()->toArray();

            foreach ($schedule as $key => $value) {
                $dataDetailsSchedule = DB::table('schedule_details')
                ->join('schedules','schedules.id','=','schedule_details.scheduleID')
                ->select('schedule_details.id','schedule_details.scheduleID','schedule_details.serviceType','schedule_details.serviceDetail')
                ->where('schedules.userID','=',$req->userID)
                ->where('schedules.id','=',$value->id)
                ->get()
                ->toArray();
            }
            foreach($schedule as &$value)
            {
                $value->dataDetailsSchedule = array_filter($dataDetailsSchedule, function($dataDetailsSchedule) use ($value) {
                    return $dataDetailsSchedule->scheduleID === $value->id;
                });
            }

            return response()->json($schedule, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

}
