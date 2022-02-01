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
use App\Insurance;
use App\InsuranceVendor;
use App\InsuranceWorkshop;
use App\InsuranceDetail;
use App\DocumentationInsurance;

class InsuranceController extends Controller
{

    public function getVendorInsuranceList(){
        try{

            $data = DB::table('insurance_vendors')->get();

        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'objectReturn' => $data
        ], 200);
    }

    public function getVendorInsuranceByID (Request $req) {
        try {
            $data = DB::table('insurance_vendors')
            ->where('id','=',$req->id)
            ->first();
        } catch (Exception $err) {
            return response()->json($err, 500);
        }

        return response()->json([
            'objectReturn' => $data
        ], 200);
    }


    public function makeInsuranceClaimApi (Request $req){
    try {
        $validator = Validator::make($req->all(), [
            'insuredName'=>['required', 'string', 'max:255'],
            'phoneNumber'=>['required', 'string', 'max:12'],
            'email'=>['required', 'string', 'max:255'],
            'addressClaimer'=>['required', 'string', 'max:255'],
            'carTypeAndBrand'=>['required', 'string', 'max:255'],
            'chassisNumber'=>['required', 'string', 'max:255'],
            'polisNumber'=>['required', 'string', 'max:255'],
            'licensePlateNumber'=>['required', 'string', 'max:255'],
            'driverName'=>['required', 'string', 'max:255'],
            'driverSpeed'=>['required', 'string', 'max:255'],
            'driverRelation'=>['required', 'string', 'max:255'],
            'incidentLocation'=>['required', 'string', 'max:255'],
            'vehicleDescription'=>['required', 'string', 'max:255'],
            'incidentDate'=>['required', 'date_format:Y-M-D'],
            'incidentTime'=>['required', 'date_format:H:i:s'],
            'taxiOnlineStatus'=>['required', 'string', 'max:255'],
            'workshopType'=>['required', 'exists:insurance_workshops,insuranceWorkshopName'],
            'chronology'=>['required', 'string', 'max:255'],
            'incidentStatus'=>['required', 'string', 'max:255'],
            'incidentStatusDescription'=>['required_if:incidentStatus,==,yes', 'string', 'max:255'],
            'documentationPicture.*'=> ['required|image|mimes:jpeg,png,jpg,gif|max:2048'],
            'documentationInsuranceName.*'=> ['required|string|max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        $dateNow = carbon::now()->format("Y-m-d");
        $dataInsurance = new Insurance;
        $dataInsurance->vendorInsuranceID = $req->vendorInsuranceID;
        $dataInsurance->userID = $req-> userID;
        $dataInsurance->insuredName = $req-> insuredName;
        $dataInsurance->phoneNumberClaimer = $req->phoneNumber;
        $dataInsurance->emailClaimer = $req->email;
        $dataInsurance->addressClaimer = $req->addressClaimer;
        $dataInsurance->carTypeAndBrand = $req->carTypeAndBrand;
        $dataInsurance->chassisNumber = $req->chassisNumber;
        $dataInsurance->polisNumber = $req->polisNumber;
        $dataInsurance->licensePlateNumber = $req->licensePlateNumber;
        $dataInsurance->driverName = $req->driverName;
        $dataInsurance->driverSpeed = $req->driverSpeed;
        $dataInsurance->driverRelation = $req->driverRelation;
        $dataInsurance->incidentLocation = $req->incidentLocation;
        $dataInsurance->vehicleDescription = $req->vehicleDescription;
        $dataInsurance->incidentDate = $req->incidentDate;
        $dataInsurance->incidentTime = $req->incidentTime;
        $dataInsurance->taxiOnlineStatus = $req->taxiOnlineStatus;
        $dataInsurance->workshopType = $req->workshopType;
        $dataInsurance->chronology = $req->chronology;
        $dataInsurance->incidentStatus = $req->incidentStatus;
        $dataInsurance->incidentStatusDescription = $req->incidentStatusDescription;
        $dataInsurance->submitDate = $dateNow;
        $dataInsurance->save();
        if ($req->has('documentationPicture'))
        {
            // $dataDocumentInsurance = DB::table('documentation_insurances')->where('insuraceID','=',$req->insuraceID)->first();
            foreach ($req->file('documentationPicture') as $key => $file)
            {
                // foreach ($dataDocumentInsurance as $key => $value) {
                    $fullNameTemp = str_replace(' ', '', $req->documentationInsuranceName[$key]);
                    $ext = $file->getClientOriginalExtension();
                    $path = $file->storeAs('avatar', strtolower($fullNameTemp.$value->id.$key.'.'.$ext), 'public');
                    $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                    // $dataUser = DB::table('documentation_insurances')->where('id','=',$req->id)->where('role','=','1')
                    // ->update(['profilePicture' => $imagePath]);
                    $insuranceDocumentation = new DocumentationInsurance;
                    $insuranceDocumentation->insuranceID = $dataInsurance->id;
                    $insuranceDocumentation->documentationPicture = $imagePath;
                    $insuranceDocumentation -> documentationInsuranceName = $req->documentationInsuranceName[$key];
                    $insuranceDocumentation->save();
                // }
            }
        }
        else
        {
            return response()->json('image not found', 400);
        }
        date_default_timezone_set('Asia/Jakarta');
        $mytime = new DateTime('now');
        $dateNow = $mytime->format("Y-m-d");
        $dataInsuranceDetail = new InsuranceDetail;
        $dataInsuranceDetail->insuranceID=$dataInsurance->id;
        $dataInsuranceDetail->claimInsuranceDate=$dateNow;
        $dataInsuranceDetail->insuranceStatus='on progress';
        $dataInsuranceDetail->save();

        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    // public function uploadImageInsuranceClaim(Request $req){
    //     try {

    //     $validator = Validator::make($req->all(), [
    //         'documentationPicture.*'=> ['required|image|mimes:jpeg,png,jpg,gif|max:2048'],
    //         'documentationInsuranceName.*'=> ['required|string|max:255'],
    //     ]);

    //     if ($req->has('documentationPicture'))
    //     {
    //         // $dataDocumentInsurance = DB::table('documentation_insurances')->where('insuraceID','=',$req->insuraceID)->first();
    //         foreach ($req->file('documentationPicture') as $key => $file)
    //         {
    //             foreach ($dataDocumentInsurance as $key => $value) {
    //                 $fullNameTemp = str_replace(' ', '', $req->documentationInsuranceName[$key]);
    //                 $ext = $file->getClientOriginalExtension();
    //                 $path = $file->storeAs('avatar', strtolower($fullNameTemp.$value->id.$key.'.'.$ext), 'public');
    //                 $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

    //                 // $dataUser = DB::table('documentation_insurances')->where('id','=',$req->id)->where('role','=','1')
    //                 // ->update(['profilePicture' => $imagePath]);
    //                 $insuranceDocumentation = new DocumentationInsurance;
    //                 $insuranceDocumentation->insuranceID = $dataInsurance->id;
    //                 $insuranceDocumentation->documentationPicture = $imagePath;
    //                 $insuranceDocumentation -> documentationInsuranceName = $req->documentationInsuranceName[$key];
    //                 $insuranceDocumentation->save();
    //             }
    //         }
    //     }
    //     else
    //     {
    //         return response()->json('image not found', 400);
    //     }

    //     $data = [
    //         'objectReturner'=>'Berhasil'
    //     ];
    //     return response()->json($data, 200);
    // } catch (Exception $err){
    //     return response()->json($err, 500);
    // }
    // }


    public function getInsuranceStatusApi (Request $req){
        try{
            $scheduleDetail= DB::table('insurances')
            ->join('users','users.id','=','insurances.userID')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->select('insurances.id','insurances.userID','insurances.vendorInsuranceID','insurance_vendors.insuranceName','insurance_details.insuranceStatus',
            'insurance_details.claimedInsuranceDate','insurances.polisNumber','insurances.submitDate', 'insurance_details..filePDF')
            ->where('insurances.userID','=',$req->userID)
            ->orderBy('submitDate','desc')
            ->get();

        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'objectReturn' => $scheduleDetail
        ], 200);
    }


    public function getInsuranceDetailByStatusAccepted (Request $req){
        try{
            $dataAccepted= DB::table('insurances')
            ->join('users','users.id','=','insurances.userID')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->select('insurance_details.insuranceID','insurances.id','insurances.userID','insurances.vendorInsuranceID',
            'insurance_vendors.insuranceName','insurances.insuredName',
            'insurance_details.insuranceStatus','insurance_details.claimedInsuranceDate',
            'insurances.polisNumber','insurance_details.insuranceDescription','insurances.submitDate','insurance_details.filePDF')
            ->where('insurances.userID','=',$req->userID)
            ->where('insurance_details.insuranceID','=',$req->insuranceID)
            ->where('insurance_details.insuranceStatus','=','Approved')
            ->orderBy('insurances.submitDate','desc')
            ->get();

        } catch (Exception $err){
            return response()->json($err, 500);
        }
        return response()->json($dataAccepted, 200);
    }

    public function getInsuranceDetailByStatusRejected (Request $req){
        try{
            $dataRejected= DB::table('insurances')
            ->join('users','users.id','=','insurances.userID')
            ->join('insurance_vendors','insurance_vendors.id','=','insurances.vendorInsuranceID')
            ->join('insurance_details','insurance_details.insuranceID','=','insurances.id')
            ->select('insurance_details.insuranceID','insurances.id','insurances.userID','insurances.vendorInsuranceID',
            'insurance_vendors.insuranceName','insurances.insuredName',
            'insurance_details.insuranceStatus','insurance_details.claimedInsuranceDate',
            'insurances.polisNumber','insurance_details.insuranceDescription','insurances.submitDate')
            ->where('insurances.userID','=',$req->userID)
            ->where('insurance_details.insuranceID','=',$req->insuranceID)
            ->where('insurance_details.insuranceStatus','=','Rejected')
            ->orderBy('insurances.submitDate','desc')
            // ->where('users.role','=','1')
            ->get();

        } catch (Exception $err){
            return response()->json($err, 500);
        }
        return response()->json($dataRejected, 200);
    }

    public function downloadPDFInsurance (Request $req){
        $urlPDF=DB::table('insurance_details')
        ->join('insurances','insurances.id','=','insurance_details.insuranceID')
        ->select('insurance_details.filePDF')
        ->where('insurance_details.insuranceID','=',$req->insuranceID)
        ->where('insurances.userID','=',$req->userID)
        ->get();
        return response()->download($url);
    }}
