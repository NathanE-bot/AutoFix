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
                    // 'workshopType'=>['required', 'string', 'max:255'],
                    'chronology'=>['required', 'string', 'max:255'],
                    'incidentStatus'=>['required', 'string', 'max:255'],
                    'incidentStatusDescription'=>['required', 'string', 'max:255']


            ]);
    }
}
