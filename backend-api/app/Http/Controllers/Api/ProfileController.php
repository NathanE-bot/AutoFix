<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'DoB' => 'date_format:Y-m-d',
            'image' => 'image|file|max:2048'
        ]);

        if ($validator->fails()) {
            $return = [
                'error' => $validator->errors()
            ];
        }
        // dd($req->file('image'));
        $dataUpdatedUser = DB::table('users')->where('id','=',$req->id)->first();
        if ($req->has('image'))
        {

            $fullNameTemp = str_replace(' ', '', $dataUpdatedUser->fullName);
            $ext = $req->image->getClientOriginalExtension();
            $path = $req->file('image')->storeAs('avatar', strtolower($fullNameTemp.$dataUpdatedUser->id.'.'.$ext), 'public');
            $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

            $dataUser = DB::table('users')->where('id','=',$req->id)->where('role','=','1')
            ->update(['displayName'=>$req->displayName,
            'phoneNumber'=>$req->phoneNumber,
            'address'=>$req->address,
            'DoB'=>$req->DoB,
            'profilePicture' => $imagePath]);
        }
        else{
            $dataUser = DB::table('users')->where('id','=',$req->id)->where('role','=','1')
            ->update(['displayName'=>$req->displayName,
            'phoneNumber'=>$req->phoneNumber,
            'address'=>$req->address,
            'DoB'=>$req->DoB,
            'profilePicture' =>'null']);
        }
        return response()->json([$dataUpdatedUser ,'message'=>'Success'], 200);
    }

    // public function uploadImage (Request $req) {

    //     $validator = Validator::make($req->all(), [
    //         'image' => 'image|file|max:2048'
    //     ]);

    //     if ($validator->fails()) {
    //         $return = [
    //             'error' => $validator->errors()
    //         ];
    //     }

    //     $userTemp = DB::table('users')->where('id','=',$req->id)->first();
    //     $fullNameTemp = str_replace(' ', '', $userTemp->fullName);
    //     $ext = $req->image->getClientOriginalExtension();
    //     $path = $req->file('image')->storeAs('avatar', strtolower($fullNameTemp.$userTemp->id.'.'.$ext), 'public');
    //     $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

    //     DB::table('users')->where('id','=',$req->id)->update(['profilePicture' => $imagePath]);

    //     return response()->json([
    //         'path' => $path,
    //         'message' => 'yes'
    //     ], 200);
    // }

}
