<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                'objectReturn' => Workshop::all()
                // 'objectReturn' => DB::table('users')->get()
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
