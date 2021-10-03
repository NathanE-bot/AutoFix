<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;

class WorkshopController extends Controller
{
    /**
     * for authentication
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * list all workshop
     */
    public function allWorkshop()
    {
        try{
            $data = [
                'data' => Workshop::all()
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }
}
