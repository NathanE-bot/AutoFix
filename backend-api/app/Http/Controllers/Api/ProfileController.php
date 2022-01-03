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

    public function updateDataUserProfile(){
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'displayName' => 'required|string',
            'email' => 'required|string',
            'phoneNumber' => 'required|string',
            'address' => 'required|string',
            'profilePicture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'DoB' => 'required', 'date_format:Y-m-d',
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
        $dataUser = new User;
        $dataUser->fullName = $req->fullName;
        $dataUser->displayName=$req->displayName;
        $dataUser->email=$req->email;
        $dataUser->phoneNumber=$req->phoneNumber;
        $dataUser->address=$req->address;
        $dataUser->profilePicture=$path;
        $dataUser->DoB=$req->DoB;
        $dataUser->save();
            return response()->json($return, 400);
        }
    }

