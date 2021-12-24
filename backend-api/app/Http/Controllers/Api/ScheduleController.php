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
    public function dataMakeSchedule(Request $req)
    {
        try{
            $workshops = DB::table('workshops')->where('id','=',$req->id)
            ->get()->toArray();
            $operational_workshops =  DB::table('operational_workshops')
            ->get()->toArray();
            $workshop_details =  DB::table('workshop_details')
            ->get()->toArray();
            $workshop_services =  DB::table('workshop_services')
            ->get()->toArray();

            foreach($workshops as &$value)
            {
                $value->operational_workshop = array_filter($operational_workshops, function($operational_workshops) use ($value) {
                    return $operational_workshops->workshopID === $value->id;
                });
                $value->workshop_details = array_filter($workshop_details, function($workshop_details) use ($value) {
                    return $workshop_details->workshopID === $value->id;
                });
                foreach ($workshop_details as &$value2) {
                    $value2->workshop_services = array_filter($workshop_services, function($workshop_services) use ($value2) {
                        return $workshop_services->workshopDetailID === $value2->id;
                    });
                }
            }

            $data = [
                'objectReturn'=>$workshops
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


    public function makeSchedule(Request $req){
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
            if ($validator->fails()) {
                return $validator->errors();
            }
            $dataqueryworkshop = DB::table('workshops')->find($req->workshopID);
            $newSchedules = new Schedule;
            $newSchedules -> workshopName = $dataqueryworkshop->workshopName;
            $newSchedules -> workshopAddress = $dataqueryworkshop->workshopAddress;
            $newSchedules -> workshopPhoneNumber = $dataqueryworkshop->workshopPhoneNumber;
            $newSchedules -> workshopEmail = $dataqueryworkshop->workshopEmail;
            $newSchedules -> workshopDescription = $dataqueryworkshop->workshopDescription;
            $newSchedules -> rating = $dataqueryworkshop->rating;
            $newSchedules -> caryType = $req->carType;
            $newSchedules->save();
            $idSchedule = $newSchedules->id;
            $array = array();
            foreach($req->servicTypeUmum as $key => $value){
                $newscheduledetail = new schedule_details;
                $newscheduledetail -> scheduleID = $idSchedule;
                $newscheduledetail ->servicType = $req->servicTypeUmum[$key];
                $newscheduledetail ->servicDetail = $req->servicDetailBerkala[$key];
                $newscheduledetail->save();
                array_push($newscheduledetail,$array);

            }
            foreach($req->servicTypeBerkala as $key => $value){
                $newscheduledetail = new schedule_details;
                $newscheduledetail -> scheduleID = $idSchedule;
                $newscheduledetail ->servicType = $req->servicTypeBerkala[$key];
                $newscheduledetail ->servicDetail = $req->servicDetailBerkala[$key];
                $newscheduledetail->save();
                array_push($newscheduledetail,$array);
            }

            $data = [
                'objectReturner'=>[$newSchedules,$newscheduledetail]
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

}
