<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\ServceProvider;

class HomeController extends Controller
{
    public function getRecommendationWorkshop()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = Carbon::now();
        $dateweek = $date->dayOfWeek;
        try{
            $data = [
                'objectReturn' => DB::table('workshops')
                ->join('operational_workshops','operational_workshops.workshopID','=','workshops.id')
                ->where('rating','>',3)
                ->where('operationalDate','=',$dateweek)
                ->get()
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }
    public function searchdata(Request $req)
    {
        try{
            $key = $req->search;
            $data = [
                'objectReturn' => DB::table('workshops')
                ->where('workshopName','like','%'.$key.'%')
                ->get()
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }
}
