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

    // public function allWorkshop()
    // {
    //     try{
    //         $data = [
    //             'objectReturn' => Workshop::all()
    //             // 'objectReturn' => DB::table('users')->get()
    //         ];
    //         return response()->json($data, 200);
    //     } catch (Exception $err){
    //         return response()->json($err, 500);
    //     }
    // }

    public function viewWorkshop()
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
        'operational_workshops.operationlaDate','workshops.id')
        ->where('operational_workshops.operationlaDate','=',$dateweek)
        ->get();
        $array = array();
        foreach ($dataproses as $value) {
            if ($time >= $value->operationalCloseHour || $time < $value->operationalOpenHour && $dateweek == $value->operationlaDate) {
                array_push($array,'tutup');
                DB::table('workshops')->where('id','=',$value->id)->update([
                    'statusBuka' => 'tutup'
                ]);
            }else if($time >= $value->operationalOpenHour && $time <= $value->operationalCloseHour && $dateweek == $value->operationlaDate){
                array_push($array,'buka');
                DB::table('workshops')->where('id','=',$value->id)->update([
                    'statusBuka' => 'buka'
                ]);
            }
        }
        try{
            $workshops = DB::table('workshops')
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
                // 'objectReturn'=> $workshops['data'][0]->workshop_details[0]->workshop_services[0]
            ];
            return response()->json($data , 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function filterworkshop(Request $req)
    {
        $workshopName= $req->workshopName;
        $location = $req->location;
        $statusOpen = $req->statusOpen;
        try{
            $workshops = DB::table('workshops')
            ->where('workshopName','like','%'.$workshopName.'%')
            ->orWhere('workshopAddress','like','%'.$location.'%')
            ->orWhere('statusBuka','=',$statusOpen)
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

    public function workshopDetailView(Request $req)
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

    public function countDistance()
    {
        try{
            $workshopLokasi = DB::table('workshops')
            ->select('workshops.latitude','workshops.longitude','id')
            ->get();
            $array = array();
            foreach ($workshopLokasi as $value) {
                $earthRadius = 6371000;
                $latitudeFrom = -6.144551;
                $longitudeFrom = 106.857952;
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
                    $value->id,
                    $hasil
                ]);
            }
            $data = [
                'objectReturn' => $array
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string'
        ]);

        if ($validator->fails()) {
            $return = [
                'error' => $validator->errors()
            ];
            return response()->json($return, 400);
        }

        try{
            $data = Workshop::create($request->all());
            return response()->json($data, 201);
        }catch (Exception $error) {
            return response()->json($error, 500);
        }
    }

    public function showById($id)
    {
        try {
            $data = Workshop::find($id);
            return response()->json($data, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string'
        ]);

        if ($validator->fails()) {
            $return = [
                'error' => $validator->errors()
            ];
            return response()->json($return, 400);
        }

        try{
            $data = Workshop::find($id);
            $data->update($request->all());
            return response()->json($data, 200);
        }catch (Exception $error) {
            return response()->json($error, 500);
        }
    }

    public function destroy($id)
    {
        try{
            $data = Workshop::find($id);
            $data->delete();
            return response()->json(['success' => 'data has been deleted'], 200);
        }catch (Exception $error) {
            return response()->json($error, 500);
        }
    }



}
