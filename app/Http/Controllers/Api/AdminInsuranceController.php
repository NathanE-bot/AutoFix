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
use App\Notification;
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
            ->orderBy('insurances.submitDate','asc')
            ->get();
            if(empty($insurance)){
                return response()->json(['Message'=>'No data'], 200);
            }
            return response()->json($insurance, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function acceptInsuranceClaim(Request $req){
        try {
            // $validator = Validator::make($req->all(), [
            //     'insuranceDescription'=>['required', 'string', 'max:500'],
            // ]);
            // if ($validator->fails()) {
            //     return $validator->errors();
            // }
            $dateTimeNow = carbon::now()->format("Y-m-d_H-i-s");
            $dataInsuranceDetails = DB::table('insurance_details')
            ->where('insuranceID','=',$req->insuranceID)
            ->where('insuranceStatus','=','on progress')
            ->update(['insuranceStatus'=>'Approved',
            'insuranceDescription'=>'Your Insurace Claim Request has been Accpt, Please Download The PDF in The Menu Detail , or Contact Our Admin if you have any question',
            'claimedInsuranceDate'=>$dateTimeNow]); // cek ini mau apa descnya

            $dataUserID=DB::table('insurances')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->where('insurances.id','=',$req->insuranceID)->first();
            $newNotification = new Notification;
            $newNotification->userID = $dataUserID->userID;
            $newNotification->senderName = 'System';
            $newNotification->description = 'Your Schedule Have Been Accepted By'.$dataUserID->insuranceName.'please see you history in profile menu or Contact The admin If you have any question.';
            $newNotification->notificationTime = Carbon::now();
            $newNotification->save();
            return response()->json(['message'=>'berhasil'], 200);
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
                    $path = $req->file('filePDF')->storeAs('avatar', strtolower('PDF-'.$insuredName.$dataInsuranceDetails->submitDate.$dataInsuranceDetails->id.'.'.$ext), 'public');
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
                ->update(['filePDF'=>null]);
            }
            return response()->json(['Message'=>'Berhasil'], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }

    }

    public function rejectInsuranceClaim(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'insuranceDescription'=>['required', 'string', 'max:500'],
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }
            $dataDateTimeNow= carbon::now()->format("Y-m-d_H-i-s");
            $dataInsuranceDetails = DB::table('insurance_details')
            ->where('insuranceID','=',$req->insuranceID)
            ->where('insuranceStatus','=','on progress')
            ->update(['insuranceDescription'=>$req->insuranceDescription,'insuranceStatus'=>'Rejected','claimedInsuranceDate'=>$dataDateTimeNow]);

            $dataUserID=DB::table('insurances')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->where('insurances.id','=',$req->insuranceID)->first();

            $newNotification = new Notification;
            $newNotification->userID = $dataUserID->userID;
            $newNotification->senderName = 'System';
            $newNotification->description = 'Your Schedule Have Been Rejected By'.$dataUserID->insuranceName.'please see you history in profile menu or Contact The admin If you have any question.';
            $newNotification->notificationTime = Carbon::now();
            $newNotification->save();
            return response()->json($dataInsuranceDetails, 200);
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
            ->select('insurances.id','insurances.userID','insurances.vendorInsuranceID',
            'insurances.insuredName','insurances.phoneNumberClaimer','insurances.emailClaimer',
            'insurances.addressClaimer','insurances.carTypeAndBrand','insurances.chassisNumber',
            'insurances.polisNumber','insurances.licensePlateNumber','insurances.driverName',
            'insurances.driverSpeed','insurances.driverRelation','insurances.driverLicense','insurances.incidentLocation','insurances.vehicleDescription',
            'insurances.incidentDate','insurances.incidentTime','insurances.taxiOnlineStatus','insurances.workshopType',
            'insurances.chronology','insurances.incidentStatus','insurances.incidentStatusDescription','insurances.submitDate','insurance_vendors.logo','insurance_vendors.email',
            'insurance_vendors.insuranceName','insurance_vendors.phoneNumber','insurance_vendors.address','insurance_details.claimedInsuranceDate','insurance_details.insuranceStatus','insurance_details.insuranceDescription')
            ->where('insurances.id','=',$req->insuranceID)
            ->get();
            // dd($insuranceDetails);
            $documentInsurance = DB::table('documentation_Insurances')
            ->where('insuranceID','=',$insuranceDetails[0]->id)
            ->get();
            if(empty($insuranceDetails)){
                return response()->json(['Message'=>'No data'], 200);
            }
            $data=[
                'objectReturnerDataDetail'=>$insuranceDetails,
                'objectReturnerDocumentation'=>$documentInsurance
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function getInsuranceHistory(Request $req){
        try {
            $insurance= DB::table('insurances')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->join('users','users.id','=','insurance_vendors.userID')
            ->select('insurances.id as insuranceID','insurances.userID AS customerID','insurances.phoneNumberClaimer','insurances.emailClaimer',
            'insurances.insuredName','insurance_vendors.insuranceName','insurance_details.insuranceStatus','insurance_details.claimedInsuranceDate',
            'insurances.polisNumber','insurances.licensePlateNumber','insurances.submitDate')
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','!=','on progress')
            ->orderBY('insurance_details.claimedInsuranceDate','desc')
            ->get();
            if(empty($insurance)){
                return response()->json(['Message'=>'No data'], 200);
            }
            return response()->json($insurance, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function countDataTotalClaimedInsurance(Request $req){
        try {
                $insurance= DB::table('insurances')
                ->rightJoin(DB::raw('(
                    SELECT 1 as d
                    UNION SELECT 2 as d
                    UNION SELECT 3 as d
                    UNION SELECT 4 as d
                    UNION SELECT 5 as d
                    UNION SELECT 6 as d
                    UNION SELECT 7 as d
                    UNION SELECT 8 as d
                    UNION SELECT 9 as d
                    UNION SELECT 10 as d
                    UNION SELECT 11 as d
                    UNION SELECT 12 as d
                    UNION SELECT 13 as d
                    UNION SELECT 14 as d
                    UNION SELECT 15 as d
                    UNION SELECT 16 as d
                    UNION SELECT 17 as d
                    UNION SELECT 18 as d
                    UNION SELECT 19 as d
                    UNION SELECT 20 as d
                    UNION SELECT 21 as d
                    UNION SELECT 22 as d
                    UNION SELECT 23 as d
                    UNION SELECT 24 as d
                    UNION SELECT 25 as d
                    UNION SELECT 26 as d
                    UNION SELECT 27 as d
                    UNION SELECT 28 as d
                    UNION SELECT 29 as d
                    UNION SELECT 30 as d
                    UNION SELECT 31 as d
                ) as days'),
                function($join) use($req){
                    $join->on(DB::raw('DAY(insurances.submitDate)'), '=',DB::raw('days.d'))
                    ->where(DB::raw('YEAR(insurances.submitDate)'), '=', $req->year)
                    ->where(DB::raw('MONTH(insurances.submitDate)'), '=', $req->month);
                }
            )
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->select(DB::raw('days.d AS day, COUNT(insurances.id) AS countData'))
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','!=','on Progress')
            ->groupBY('days.d')
            ->get();

            if(empty($insurance)){
                return response()->json(['Message'=>'No data'], 200);
            }
            return response()->json($insurance, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


    public function getYearInsuranceForFilterHome(){

        try {
            $getTahun = DB::table('insurances')
            ->select(DB::raw('YEAR(insurances.submitDate) as year'))
            ->distinct()
            ->get();
            return response()->json($getTahun, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function countDataTotalClaimedInsuranceByStatus(Request $req){
        try {
            $insuranceAccept= DB::table('insurances')
            ->rightJoin(DB::raw('(
                SELECT 1 as d
                UNION SELECT 2 as d
                UNION SELECT 3 as d
                UNION SELECT 4 as d
                UNION SELECT 5 as d
                UNION SELECT 6 as d
                UNION SELECT 7 as d
                UNION SELECT 8 as d
                UNION SELECT 9 as d
                UNION SELECT 10 as d
                UNION SELECT 11 as d
                UNION SELECT 12 as d
            ) as months'),
            function($join) use($req){
                $join->on(DB::raw('MONTH(insurances.submitDate)'), '=',DB::raw('months.d'))
                ->where(DB::raw('YEAR(insurances.submitDate)'), '=', $req->year);
            }
            )
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->select(DB::raw('months.d AS months, COUNT(insurances.id) AS countData'))
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','=','approved')
            ->groupBY('months.d')
            ->get();

            if(empty($insuranceAccept)){
                return response()->json(['Message'=>'No data'], 200);
            }

            $insuranceRejected= DB::table('insurances')
            ->rightJoin(DB::raw('(
                SELECT 1 as d
                UNION SELECT 2 as d
                UNION SELECT 3 as d
                UNION SELECT 4 as d
                UNION SELECT 5 as d
                UNION SELECT 6 as d
                UNION SELECT 7 as d
                UNION SELECT 8 as d
                UNION SELECT 9 as d
                UNION SELECT 10 as d
                UNION SELECT 11 as d
                UNION SELECT 12 as d
            ) as months'),
            function($join) use($req){
                $join->on(DB::raw('MONTH(insurances.submitDate)'), '=',DB::raw('months.d'))
                ->where(DB::raw('YEAR(insurances.submitDate)'), '=', $req->year);
            }
            )
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->select(DB::raw('months.d AS months, COUNT(insurances.id) AS countData'))
            ->where('insurance_vendors.userID','=',$req->adminID)
            ->where('insurance_details.insuranceStatus','=','rejected')
            ->groupBY('months.d')
            ->get();

            if(empty($insuranceRejected)){
                return response()->json(['Message'=>'No data'], 200);
            }

            $data =[
                'approvedArray'=>$insuranceAccept,
                'rejectedArray'=>$insuranceRejected
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


}
