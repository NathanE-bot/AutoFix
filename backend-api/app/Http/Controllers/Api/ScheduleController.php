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
            $newSchedules -> scheduleStatus = $req->scheduleStatus;
            $newSchedules -> description = $req->description;
            $newSchedules->save();
            $idSchedule = $newSchedules->id;
            // $array = array();
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
                'objectReturner'=>[$newSchedules,$newscheduledetail]
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function ShowDataScheduleByUserID(Request $req){
        try{
            $schedule= DB::table('schedules')
            ->join('users','users.id','=','schedules.userID')
            ->join('schedule_details','schedule_details.scheduleID','=','schedules.id')
            ->distinct()
            ->where('schedules.userID','=',$req->userID)
            // ->where('users.role','=','1')
            ->get();

            // $schedule_detail= DB::table('schedule_details')
            // ->select('scheduleID')
            // ->get()->toArray();
            // foreach ($schedule as $value) {
            //     $value->schedule_detail = array_filter($schedule_detail, function($schedule_detail) use ($value) {
            //         return $schedule_detail->scheduleID === $value->id;
            //     });
            // }
            dd($schedule);
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

}
