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
use Illuminate\Support\Facades\Storage;

class AdminInsuranceController extends Controller
{
    // try {

    //     return response()->json($data, 200);
    // } catch (Exception $err){
    //     return response()->json($err, 500);
    // }
    public function getDataIncomingInsuranceRequestByAdminID(Request $req){
        try {
            $insurance= DB::table('insurances')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->join('users','users.id','=','insurance_vendors.userID')
            ->select('insurances.id as insuranceID','insurances.userID AS customerID','insurances.phoneNumberClaimer','insurances.emailClaimer',
            'insurances.insuredName','insurance_vendors.insuranceName','insurance_details.insuranceStatus','insurance_details.claimedInsuranceDate',
            'insurances.polisNumber','insurances.licensePlateNumber','insurances.submitDate')
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','=','on progress')
            ->get();
            return response()->json($insurance, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function acceptInsuranceClaim(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'insuranceDescription'=>['required|string|max:500'],
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }



            $dataInsuranceDetails = DB::table('insuranceDetails')
            ->where('insuranceID','=',$req->insuranceID)
            ->update(['insuranceDescription'=>$req->insuranceDescription,
                    'insuranceStatus','=','accepted']);


            return response()->json($scheduleDetail, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function uploadPDFInsurance(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'filePDF'=> 'required|mimes:pdf|max:10000',
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            $dataInsuranceDetails = DB::table('insurance_details')
            ->select('id','filePDF',
            DB::raw('(SELECT insuredName FROM insurances WHERE insurances.id = insurance_details.insuranceID LIMIT 1) AS insuredName'),
            DB::raw('(SELECT submitDate FROM insurances WHERE insurances.id = insurance_details.insuranceID LIMIT 1) AS submitDate'))
            ->where('insuranceID','=',$req->insuranceID)->first();
            if (!is_null($req->filePDF))
            {
                if (!isset($dataInsuranceDetails->filePDF)) {
                    $dataPDF= DB::table('insurance_details')
                    ->select(DB::raw('SUBSTRING(filePDF,30,100) AS path'))
                    ->where('insuranceID','=',$req->insuranceID)
                    ->first();
                    Storage::delete('/public/'.$dataPDF->path);

                    // $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                    $insuredName = str_replace(' ', '', $dataInsuranceDetails->insuredName);
                    $ext = $req->filePDF->getClientOriginalExtension();
                    $path = $req->file('filePDF')->storeAs('avatar', strtolower($insuredName.$dataInsuranceDetails->submitDate.$dataInsuranceDetails->id.'.'.$ext), 'public');
                    $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                    $dataInsuranceDetails = DB::table('insurance_details')
                    ->where('insuranceID','=',$req->insuranceID)
                    ->update(['filePDF'=>$imagePath]);

                }
                else{

                    // $dateNow = carbon::now()->format("Y-m-d_H-i-s");
                    $insuredName = str_replace(' ', '', $dataInsuranceDetails->insuredName);
                    $ext = $req->filePDF->getClientOriginalExtension();
                    $path = $req->file('filePDF')->storeAs('avatar', strtolower($insuredName.$dataInsuranceDetails->submitDate.$dataInsuranceDetails->id.'.'.$ext), 'public');
                    $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                    $dataInsuranceDetails = DB::table('insurance_details')
                    ->where('insuranceID','=',$req->insuranceID)
                    ->update(['filePDF'=>$imagePath]);

                }

            }
            else{
                $dataInsuranceDetails = DB::table('insurance_details')
                ->where('insuranceID','=',$req->insuranceID)
                ->update(['filePDF'=>'null']);
            }
            return response()->json(['Message'=>'Berhasil'], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }

    }

    public function rejectInsuranceClaim(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'insuranceDescription'=>['required|string|max:500'],
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }



            $dataInsuranceDetails = DB::table('insuranceDetails')
            ->where('insuranceID','=',$req->insuranceID)
            ->update(['insuranceDescription'=>$req->insuranceDescription,
                    'insuranceStatus','=','rejected']);


            return response()->json($scheduleDetail, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


    public function getAdminInsuranceDetails(Request $req){
        try {

            $insuranceDetails= DB::table('insurances')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->join('users','users.id','=','insurance_vendors.userID')
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','=','on progress')
            ->get();
            return response()->json($insuranceDetails, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

}
