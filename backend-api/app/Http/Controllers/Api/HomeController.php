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
    public function getRecommendationWorkshop(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = Carbon::now();
        $dateweek = $date->dayOfWeek;
        try{
            $byKM = 6371;
            $currentLat = $request->lat;
            $currentLng = $request->lon;
            $distanceKmLu = 50;
            $data = DB::table('workshops')
                ->join('operational_workshops','operational_workshops.workshopID','=','workshops.id')
                ->join('workshop_pictures','workshop_pictures.workshopID','=','workshops.id')
                ->selectRaw('(workshop_pictures.workshopPicture LIMIT 1 ) as workshop_picture,operational_workshops.operationalDate,operational_workshops.operationalOpenHour,operational_workshops.operationalCloseHour,workshops.id,workshops.userID,workshops.workshopName,workshops.workshopAddress,workshops.workshopPhoneNumber,workshops.workshopEmail,
                workshops.workshopDescription,workshops.rating,workshops.workshopLogo,workshops.city,workshops.district,workshops.province,workshops.statusHr,workshops.status24Hr,
                ( ? * acos( cos( radians(?) ) * cos( radians( workshops.latitude ) ) * cos( radians( workshops.longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(workshops.latitude)) ) ) AS distance', [$byKM, $currentLat, $currentLng, $currentLat])
                ->havingRaw('distance < ?', [$distanceKmLu])
                ->where('workshops.rating','>',3)
                ->where('operational_workshops.operationalDate','=',$dateweek)
                ->orderByRaw('distance asc')
                ->get();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'objectReturn' => $data
        ], 200);
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
