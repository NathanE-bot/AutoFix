<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCMController extends Controller
{
    public function index(Request $req){
        $input = $req->all();
        return response()->json($input);
    }
}
