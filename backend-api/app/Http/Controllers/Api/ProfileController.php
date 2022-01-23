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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        $dataUser = DB::table('users')->where('id','=',$req->id)->where('role','=','1')
        ->update(['displayName'=>$req->displayName,
        'phoneNumber'=>$req->phoneNumber,
        'address'=>$req->address,
        'DoB'=>$req->DoB]);

        $dataUpdatedUser = DB::table('users')->where('id','=',$req->id)->first();

        return response()->json($dataUpdatedUser, 200);
    }

    public function uploadImage (Request $req) {
        $validator = Validator::make($req->all(), [
            'image' => 'image|file|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        $dataUpdatedUser = DB::table('users')->where('id','=',$req->id)->first();
        if (!is_null($req->image))
        {
            if (!isset($dataUpdatedUser->documentationPicture)) {
                $dataImageProfile= DB::table('users')
                ->select(DB::raw('SUBSTRING(profilePicture,30,100) AS path'))
                ->where('id','=',$req->id)->first();
                Storage::delete('/public/'.$dataImageProfile->path);

                $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                $fullNameTemp = str_replace(' ', '', $dataUpdatedUser->fullName);
                $ext = $req->image->getClientOriginalExtension();
                $path = $req->file('image')->storeAs('avatar', strtolower($fullNameTemp.$dateNow.$dataUpdatedUser->id.'.'.$ext), 'public');
                $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                $dataUser = DB::table('users')->where('id','=',$req->id)
                ->update(['profilePicture' => $imagePath]);

            }
            else{

                $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                $fullNameTemp = str_replace(' ', '', $dataUpdatedUser->fullName);
                $ext = $req->image->getClientOriginalExtension();
                $path = $req->file('image')->storeAs('avatar', strtolower($fullNameTemp.$dateNow.$dataUpdatedUser->id.'.'.$ext), 'public');
                $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                $dataUser = DB::table('users')->where('id','=',$req->id)
                ->update(['profilePicture' => $imagePath]);
            }

        }
        else{
            $dataUser = DB::table('users')->where('id','=',$req->id)->update(['profilePicture' =>null]);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function deleteImage (Request $req) {
        DB::table('users')->where('id','=',$req->id)->update(['profilePicture' => $imagePath]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
