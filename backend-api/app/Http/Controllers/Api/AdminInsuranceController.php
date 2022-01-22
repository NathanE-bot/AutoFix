<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use App\OperationalWorkshop;
use App\WorkshopPicture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\ServceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Schedule;
use App\ScheduleDetail;
class AdminInsuranceController extends Controller
{
    // try {

    //     return response()->json($data, 200);
    // } catch (Exception $err){
    //     return response()->json($err, 500);
    // }
    public function getDataIncomingInsuranceRequestByAdminID(Request $req){
        try {
            $scheduleDetail= DB::table('insurances')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->join('users','users.id','=','insurance_vendors.userID')
            ->select('insurances.id','insurances.userID AS customerID',DB::raw('(SELECT phoneNumber FROM users WHERE users.id = insurances.userID LIMIT 1) AS phoneNumber'),'insurance_vendors.userID as adminID','insurances.vendorInsuranceID',
            'insurance_vendors.insuranceName','insurance_details.insuranceStatus','insurance_details.claimInsuranceDate',
            'insurances.polisNumber')
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','=','waiting confirmation')
            ->get();
            return response()->json($scheduleDetail, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function acceptInsuranceClaim(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'insuranceDescription'=>['required|string|max:500']
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            if (condition) {
                # code...
            }


            $dataInsuranceDetails = DB::table('insuranceDetails')
            ->where('id','=',$req->id)->where('insuranceID','=',$req->insuranceID)
            ->update(['insuranceDescription'=>$req->insuranceDescription]);


            return response()->json($scheduleDetail, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function uploadPDFInsurance(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'filePDF'=> ['required|image|mimes:pdf|max:2048'],
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            $dataInsuranceDetails = DB::table('insuranceDetails')
            ->where('id','=',$req->id)->where('insuranceID','=',$req->insuranceID)->first();
            if (!is_null($req->filePDF))
            {
                if (!isset($dataInsuranceDetails->filePDF)) {
                    $dataPDF= DB::table('insuranceDetails')
                    ->select(DB::raw('SUBSTRING(filePDF,30,100) AS path'))
                    ->where('id','=',$req->id)->first();
                    Storage::delete('/public/'.$dataPDF->path);

                    $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                    $date = str_replace(' ', '', $dataInsuranceDetails->claimInsuranceDate);
                    $ext = $req->image->getClientOriginalExtension();
                    $path = $req->file('image')->storeAs('avatar', strtolower($fullNameTemp.$dateNow.$dataInsuranceDetails->id.'.'.$ext), 'public');
                    $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                    $dataInsuranceDetails = DB::table('insuranceDetails')
                    ->where('id','=',$req->id)->where('insuranceID','=',$req->insuranceID)
                    ->update(['filePDF'=>$req->filePDF]);

                }
                else{

                    $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                    $date = str_replace(' ', '', $dataInsuranceDetails->claimInsuranceDate);
                    $ext = $req->image->getClientOriginalExtension();
                    $path = $req->file('image')->storeAs('avatar', strtolower($fullNameTemp.$dateNow.$dataInsuranceDetails->id.'.'.$ext), 'public');
                    $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                    $dataInsuranceDetails = DB::table('insuranceDetails')
                    ->where('id','=',$req->id)->where('insuranceID','=',$req->insuranceID)
                    ->update(['filePDF'=>$req->filePDF]);
                }

            }
            else{
                $dataInsuranceDetails = DB::table('insuranceDetails')
                ->where('id','=',$req->id)->where('insuranceID','=',$req->insuranceID)
                ->update(['filePDF'=>'null']);
            }


            $dataInsuranceDetails = DB::table('insuranceDetails')
            ->where('id','=',$req->id)->where('insuranceID','=',$req->insuranceID)
            ->update(['filePDF'=>$req->filePDF]);


            return response()->json($scheduleDetail, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }

    }
}
