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

    public function allWorkshop()
    {
        try{
            $data = [
                'objectReturn' => Workshop::all()
                // 'objectReturn' => DB::table('users')->get()
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function statusBuka()
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
            $data = [
                'objectReturn' => DB::table('workshops')
                ->join('operational_workshops','operational_workshops.workshopID','=','workshops.id')
                ->get()
            ];
            return response()->json($data , 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    // public function filterworkshop(Request $req)
    // {
    //     $workshopName= $req->workshopName;
    //     $location = $req->location;
    //     $statusOpen = $req->statusOpen;
    //     try{
    //         $data = [
    //             'objectReturn' => DB::table('workshops')
    //             ->where('')
    //             ->get()
    //         ];
    //         return response()->json($data, 200);
    //     } catch (Exception $err){
    //         return response()->json($err, 500);
    //     }
    // }


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


    public function allWorkshopfix()
    {
        try{
            $data = DB::table('workshops')->get();
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

}
