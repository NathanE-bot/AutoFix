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

    public function viewInsurance(){
        try{
            $data = [
                'objectReturn' => DB::table('insurance_vendors')
                ->get()
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


    public function FormIsurance (Request $req){
    try {

                $validator = Validator::make($req->all(), [
                    'insuredName'=>['required', 'string', 'max:255'],
                    'phoneNumberClaimer'=>['required', 'string', 'max:12'],
                    'emailClaimer'=>['required', 'string', 'max:255'],
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
                    'incidentDate'=>['required', 'date_format:Y-m-d'],
                    'incidentTime'=>['required', 'date_format:H:i:s'],
                    'taxiOnlineStatus'=>['required', 'string', 'max:255'],
                    'workshopType'=>['required', 'exists:insurance_workshops,insuranceWorkshopName'],
                    'chronology'=>['required', 'string', 'max:255'],
                    'incidentStatus'=>['required', 'string'],
                    'incidentStatusDescription'=>['required_if:incidentStatus,==,yes', 'string', 'max:255'],
                    'documentationPicture.*'=> ['required|image|mimes:jpeg,png,jpg,gif|max:2048'],
                    'documentationInsuranceName.*'=> ['required|string|max:255'],
            ]);

            $dataInsurance = new Insurance;
            $dataInsurance->vendorInsuranceID = $req->vendorInsuranceID;
            $dataInsurance->userID = $req-> userID;
            $dataInsurance->insuredName = $req-> insuredName;
            $dataInsurance->phoneNumberClaimer = $req->phoneNumberClaimer;
            $dataInsurance->emailClaimer = $req->emailClaimer;
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
            $dataInsurance->save();


            if ($req->has('documentationPicture'))
            {
                foreach ($req->file('documentationPicture') as $key => $file)
                {
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image = \Storage::dics('public')->put($req->documentationInsuranceName[$key]+$req->userID+'.'+$ext, $file); // your image path
                    $path = '\public\$req->documentationInsuranceName[$key]+$req->userID+'.'+$ext';

                    $insuranceDocumentation = new DocumentationInsurance;
                    $insuranceDocumentation->insuranceID = $dataInsurance->id;
                    $insuranceDocumentation->documentationPicture = $path;
                    $insuranceDocumentation -> documentationInsuranceName = $req->documentationInsuranceName[$key];
                    $insuranceDocumentation->save();
                }

                // $fileNameToStore = serialize($documentationPicture);
            }
            else
            {
                return response()->json('image not found', 400);
            }

            $data = [
                'objectReturner'=>[$dataInsurance,$insuranceDocumentation]
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


    public function ViewInsuranceDetail (){
        
    }


}
