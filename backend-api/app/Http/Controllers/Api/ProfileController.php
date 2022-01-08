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
use App\User;
class ProfileController extends Controller
{
    public function getDataProfileUserCustomer(Request $req){
        $dataUser=DB::table('users')
        ->where('id','=',$req->userID)
        ->get();
        return response()->json($dataUser, 200, $headers);
    }

    public function updateDataUserProfile(Request $req){
        $validator = Validator::make($req->all(), [
            'displayName' => 'string',
            'phoneNumber' => 'string',
            'address' => 'string',
            'profilePicture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'DoB' => 'date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $return = [
                'error' => $validator->errors()
            ];
        }
        $ext = strtolower($req->profilePicture->getClientOriginalExtension());
        $image = \Storage::dics('public')
        ->put($req->fullName+$req->id+'.'+$ext, $req->profilePicture);
        $path = '\public\$req->fullName+$req->id+'.'+$ext';
        $dataUser = DB::table('users')->where('id','=',$req->userID)->where('role','=','1')
        ->update(['displayName'=>$req->displayName,
        'phoneNumber'=>$req->phoneNumber,
        'address'=>$req->address,
        'profilePicture'=>$path,
        'DoB'=>$req->DoB]);

        $dataUpdatedUser = DB::table('users')
        ->where('id','=',$req->userID)->where('role','=','1')
        ->get();

        return response()->json($dataUpdatedUser, 400);
        }
    }

