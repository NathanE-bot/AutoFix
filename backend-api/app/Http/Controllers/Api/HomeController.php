<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function getRecommendationWorkshop()
    {
        try{
            $data = [
                'objectReturn' => DB::table('workshops')
                ->where('rating','>',3)
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
