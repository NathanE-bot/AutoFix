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
use Illuminate\Support\Arr;

class WorkshopController extends Controller
{
    /**
     * for authentication
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    /**
     * list all workshop
     */

    public function getAllWorkshop()
    {
        try{
            $workshops = DB::table('workshops')
            ->get()->toArray();
            $workshop_services =  DB::table('workshop_services')
            ->get()->toArray();
            $operational_workshops =  DB::table('operational_workshops')
            ->get()->toArray();
            $workshop_details =  DB::table('workshop_details')
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
            if(empty($workshops)){
                return response()->json(['Message'=>'No data'], 200);
            }
            $data = [
                'objectReturn'=>$workshops
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function getWorkshopApi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datestring = Carbon::now();
        $dateweek = $datestring->dayOfWeek;
        $mytime = new DateTime('now');
        $date = $mytime->format("Y-m-d");
        $time = $mytime->format("H:i:s");
        $dataproses=DB::table('workshops')
        ->join('operational_workshops','operational_workshops.workshopID','=','workshops.id')
        ->select('operational_workshops.operationalCloseHour',
        'operational_workshops.operationalOpenHour',
        'operational_workshops.operationalDate','workshops.id')
        ->where('operational_workshops.operationalDate','=',$dateweek)
        ->get();
        $array = array();
        foreach ($dataproses as $value) {
            if ($time >= $value->operationalCloseHour || $time < $value->operationalOpenHour && $dateweek == $value->operationalDate) {
                array_push($array,'tutup');
                DB::table('workshops')->where('id','=',$value->id)->update([
                    'statusHr' => 'tutup'
                ]);
            }else if($time >= $value->operationalOpenHour && $time <= $value->operationalCloseHour && $dateweek == $value->operationalDate){
                array_push($array,'buka');
                DB::table('workshops')->where('id','=',$value->id)->update([
                    'statusHr' => 'buka'
                ]);
            }
        }
        try{

            $byKM = 6371;
            $currentLat = $request->lat;
            $currentLng = $request->lon;
            $distanceKmLu = 50;

            $workshops = DB::table('workshops')
            ->selectRaw('id,userID,workshopName,workshopAddress,workshopPhoneNumber,workshopEmail,
            workshopDescription,rating,workshopLogo,city,district,province,statusHr,status24Hr,
            ( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance', [$byKM, $currentLat, $currentLng, $currentLat])
            ->havingRaw('distance < ?', [$distanceKmLu])
            ->Where('workshopName','like','%'.$request->workshopName.'%')
            ->Where('district','like','%'.$request->location.'%')
            ->Where('statusHr','like','%'.$request->statusHr.'%')
            ->Where('status24Hr','like','%'.$request->status24Hr.'%')
            ->orderByRaw('distance asc')
            ->paginate(10);
            // $workshop_services =  DB::table('workshop_services')
            // ->get()->toArray();
            // $operational_workshops =  DB::table('operational_workshops')
            // ->get()->toArray();
            // $workshop_details =  DB::table('workshop_details')
            // ->get()->toArray();

            // foreach($workshops['data'] as &$value)
            // {
            //     $value->operational_workshop = array_filter($operational_workshops, function($operational_workshops) use ($value) {
            //         return $operational_workshops->workshopID === $value->id;
            //     });
            //     $value->workshop_details = array_filter($workshop_details, function($workshop_details) use ($value) {
            //         return $workshop_details->workshopID === $value->id;
            //     });
            //     foreach ($workshop_details as &$value2) {
            //         $value2->workshop_services = array_filter($workshop_services, function($workshop_services) use ($value2) {
            //             return $workshop_services->workshopDetailID === $value2->id;
            //         });
            //     }
            // }
            if(empty($workshops)){
                return response()->json(['Message'=>'No data'], 300);
            }

            $data = [
                'objectReturn'=>$workshops
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function filterDataWorkshop(){
        try{
            $workshops = DB::table('workshops')->select('workshopName','district','statusHr','status24Hr')
            ->get();
            $data = [
                'objectReturn'=>$workshops
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function workshopDetailView(Request $req)
    {
        try{
            $workshops = DB::table('workshops')
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

            $workshop_review = DB::table('reviews')
            ->select('reviews.id','reviews.scheduleID','schedules.workshopID','reviews.userName','reviews.reviewDate','reviews.rating','reviews.description')
            ->join('schedules','schedules.id','=','reviews.scheduleID')
            ->where('schedules.workshopID','=',$req->id)
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

                $value->workshop_review = array_filter($workshop_review, function($workshop_review) use ($value) {
                    return $workshop_review->workshopID === $value->id;
                });
            }
            if(empty($workshops)){
                return response()->json(['Message'=>'No data'], 300);
            }
            return response()->json($workshops[0], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function countDistance(Request $request)
    {
        // dd($request->all());
        try{
            $workshopLokasi = DB::table('workshops')
            ->select('workshops.latitude','workshops.longitude','id')
            ->get();
            $array = array();
            foreach ($workshopLokasi as $value) {
                $earthRadius = 6371000;
                $latitudeFrom = $request->lat;
                $longitudeFrom = $request->lon;
                $latitudeTo  = $value->latitude;
                $longitudeTo  = $value->longitude;
                // convert from degrees to radians
                $latFrom = deg2rad($latitudeFrom);
                $lonFrom = deg2rad($longitudeFrom);
                $latTo = deg2rad($latitudeTo);
                $lonTo = deg2rad($longitudeTo);

                $lonDelta = $lonTo - $lonFrom;
                $a = pow(cos($latTo) * sin($lonDelta), 2) +
                    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
                $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

                $angle = atan2(sqrt($a), $b);
                $hasil = $angle * $earthRadius;
                array_push($array,[
                    'workshopId' => $value->id,
                    'distance' => $hasil
                ]);
            }

            // $sortedData = Arr::sort($array, function($key,$value)
            // {
            //     // Sort the student's scores by their name.
            //     return $value[$key]['workshopId'];
            // });

            $data = [
                'objectReturn' => $array
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function getUserProfile(Request $req){
        try {
            $user = DB::table('users')
            ->where('id','=',$req->userID)
            ->first();
            if(empty($user)){
                return response()->json(['Message'=>'No data'], 300);
            }
            return response()->json($user, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string',
    //         'address' => 'required|string'
    //     ]);

    //     if ($validator->fails()) {
    //         $return = [
    //             'error' => $validator->errors()
    //         ];
    //         return response()->json($return, 400);
    //     }

    //     try{
    //         $data = Workshop::create($request->all());
    //         return response()->json($data, 201);
    //     }catch (Exception $error) {
    //         return response()->json($error, 500);
    //     }
    // }

    // public function showById($id)
    // {
    //     try {
    //         $data = Workshop::find($id);
    //         return response()->json($data, 200);
    //     } catch (Exception $err) {
    //         return response()->json($err, 500);
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string',
    //         'address' => 'required|string'
    //     ]);

    //     if ($validator->fails()) {
    //         $return = [
    //             'error' => $validator->errors()
    //         ];
    //         return response()->json($return, 400);
    //     }

    //     try{
    //         $data = Workshop::find($id);
    //         $data->update($request->all());
    //         return response()->json($data, 200);
    //     }catch (Exception $error) {
    //         return response()->json($error, 500);
    //     }
    // }

    // public function destroy($id)
    // {
    //     try{
    //         $data = Workshop::find($id);
    //         $data->delete();
    //         return response()->json(['success' => 'data has been deleted'], 200);
    //     }catch (Exception $error) {
    //         return response()->json($error, 500);
    //     }
    // }
}
