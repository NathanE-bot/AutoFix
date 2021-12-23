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


}
