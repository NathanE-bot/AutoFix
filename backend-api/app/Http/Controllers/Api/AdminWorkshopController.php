<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use App\WorkshopDetail;
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

class AdminWorkshopController extends Controller
{
    public function getScheduleByWorkshopIDAndAdminWorkshop(Request $req){
        $IncomingSchedule = DB::table('schedules')
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->join('users','users.ID','=','workshops.userID')
        ->select('schedules.id as scheduleID','schedules.userID as customerID','workshops.userID as AdminID','schedules.workshopID'
        ,'schedules.workshopName','schedules.workshopAddress','schedules.workshopPhoneNumber',
        'schedules.workshopEmail','schedules.scheduleDate','schedules.scheduleTime','schedules.carModel',
        'schedules.carType','schedules.timeEstimation','schedules.priceEstimation','schedules.scheduleStatus'
        ,'schedules.serviceDescription')
        ->where('workshops.userID','=',$req->adminID)
        ->where('scheduleStatus','=','waiting confirmation')
        ->get()
        ->toArray();

        $dataDetailsSchedule = DB::table('schedule_details')
        ->join('schedules','schedules.id','=','schedule_details.scheduleID')
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->select('schedule_details.id','schedule_details.scheduleID','schedule_details.serviceType','schedule_details.serviceDetail')
        ->where('workshops.userID','=',$req->adminID)
        ->where('scheduleStatus','=','waiting confirmation')
        ->get()
        ->toArray();

        $dataCustomer = DB::table('users')
        ->join('schedules','schedules.userID','=','users.id')
        ->select('users.id as customerID','users.fullName','users.phoneNumber')
        ->where('users.role','=','1')
        ->get();



        return response()->json([
            'listSchedule' => $IncomingSchedule,
            'listDetails' => $dataDetailsSchedule,
            'listDataCustomer' => $dataCustomer
        ], 200);
    }

    public function acceptScheduleByAdmin(Request $req){
        $validator = Validator::make($req->all(), [
            'description' => 'string','required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }
        try {
            $dataSchedule= DB::table('schedules')->where('id','=',$req->scheduleID)->where('scheduleStatus','=','waiting confirmation')
            ->update(['scheduleStatus'=>'accepted',
            'description'=>'Your schedule have been accept. Please Call Customer Service if you have any question']);

            $dataUpdatedSchedule = DB::table('schedules')->where('id','=',$req->scheduleID)->get();
        }catch (Exception $err) {
            return response()->json($err, 500);
        }

        return response()->json([
            'scheduleID' => $req->scheduleID,
            'message' => 'Incoming Order Accepted'
        ], 200);
    }

    public function rejectedScheduleByAdmin(Request $req){

        $validator = Validator::make($req->all(), [
            'description' => 'string','required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        $dataSchedule= DB::table('schedules')->where('id','=',$req->scheduleID)->where('scheduleStatus','=','waiting confirmation')
        ->update(['scheduleStatus'=>'rejected',
        'description'=>$req->description]);

        $dataUpdatedSchedule = DB::table('schedules')->where('id','=',$req->scheduleID)->get();

        return response()->json([
            'scheduleID' => $req->scheduleID,
            'message' => 'Incoming Order Rejected'
        ], 200);
    }

    public function getScheduleAcceptedByAdmin (Request $req){
        $acceptedSchedule = DB::table('schedules')
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->join('users','users.ID','=','workshops.userID')
        ->select('schedules.id as scheduleID','schedules.userID as customerID','workshops.userID as AdminID','schedules.workshopID'
        ,'schedules.workshopName','schedules.workshopAddress','schedules.workshopPhoneNumber',
        'schedules.workshopEmail','schedules.scheduleDate','schedules.scheduleTime','schedules.carModel',
        'schedules.carType','schedules.timeEstimation','schedules.priceEstimation','schedules.scheduleStatus'
        ,'schedules.serviceDescription')
        ->where('workshops.userID','=',$req->adminID)
        ->where('scheduleStatus','=','accepted')
        ->get()
        ->toArray();

        $dataDetailsSchedule = DB::table('schedule_details')
        ->join('schedules','schedules.id','=','schedule_details.scheduleID')
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->select('schedule_details.id','schedule_details.scheduleID','schedule_details.serviceType','schedule_details.serviceDetail')
        ->where('workshops.userID','=',$req->adminID)
        ->where('scheduleStatus','=','accepted')
        ->get()
        ->toArray();

        $dataCustomer = DB::table('users')
        ->join('schedules','schedules.userID','=','users.id')
        ->select('users.id as customerID','users.fullName','users.phoneNumber')
        ->where('users.role','=','1')
        ->get();

        return response()->json([
            'listSchedule' => $acceptedSchedule,
            'listDetails' => $dataDetailsSchedule,
            'listDataCustomer' => $dataCustomer
        ], 200);
    }

    public function cancelScheduleByAdmin(Request $req){
        $validator = Validator::make($req->all(), [
            'description' => 'string','required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }
        $dataSchedule= DB::table('schedules')->where('id','=',$req->scheduleID)->where('scheduleStatus','=','accepted')
        ->update(['scheduleStatus'=>'cancelled',
        'description'=>$req->description]);

        return response()->json([
            'scheduleID' => $req->scheduleID,
            'message' => 'Order Cancelled'
        ], 200);
    }

    public function doneScheduleByAdmin(Request $req){
        $validator = Validator::make($req->all(), [
            'description' => 'string','required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }
        $dataSchedule= DB::table('schedules')->where('id','=',$req->scheduleID)->where('scheduleStatus','=','accepted')
        ->update(['scheduleStatus'=>'done',
        'description'=>'Your schedule has been completed, Thank you for using our website']);

        return response()->json([
            'scheduleID' => $req->scheduleID,
            'message' => 'Order Completed'
        ], 200);
    }

    public function updateLogoWorkshop(Request $req){
        $validator = Validator::make($req->all(), [
            'workshopLogo' => 'image|file|max:2048'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }
        $dataUpdatedUser = DB::table('workshops')->where('id','=',$req->workshopID)->first();
        if (!is_null($req->workshopLogo))
        {

            $fullNameTemp = str_replace(' ', '', $dataUpdatedUser->workshopName);
            $ext = $req->workshopLogo->getClientOriginalExtension();
            $path = $req->file('workshopLogo')->storeAs('avatar', strtolower($fullNameTemp.$dataUpdatedUser->id.'.'.$ext), 'public');
            $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

            $dataUser = DB::table('workshops')->where('id','=',$req->workshopID)
            ->update(['workshopLogo' => $imagePath]);
        }
        else{
            $dataUser = DB::table('workshops')->where('id','=',$req->workshopID)
            ->update(['workshopLogo' =>null]);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function uploadGaleryWorkshop(Request $req){
        $validator = Validator::make($req->all(), [
            'workshopPicture' => 'image|file|max:2048'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }
        if ($req->has('workshopPicture'))
        {
            $dataWorkshop =DB::table('workshops')->where('id','=',$req->workshopID)->first();
            foreach ($req->file('workshopPicture') as $key => $file)
            {
                $fullNameTemp = str_replace(' ', '', $dataWorkshop->workshopName);
                $ext = $file->getClientOriginalExtension();
                $path = $file->storeAs('avatar', strtolower($fullNameTemp.$req->workshopID.$key.'.'.$ext), 'public');
                $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                $workshopPicture = new WorkshopPicture;
                $workshopPicture->workshopID = $req->workshopID;
                $workshopPicture->workshopPicture = $imagePath;
                $workshopPicture->save();
            }
        }
        else
        {
            return response()->json('image not found', 400);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function updateGaleryWorkshop(Request $req){
        // $validator = Validator::make($req->all(), [
        //     'idWorkshopPicture'=>'required',
        //     'workshopPicture' => 'image|file|max:2048'
        // ]);
        $validator = Validator::make($req->all(), [
            'workshop_pictures.idWorkshopPicture'=>'required',
            'workshop_pictures.workshopPicture' => 'image|file|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        if ($req->has('workshopPicture'))
        {
            $dataWorkshop = DB::table('workshops')->where('id','=',$req->workshopID)->first();
            // foreach ($req->file('workshopPicture') as $key => $file)
            // {
            //     if (!is_null($req->workshopPicture))
            //     {
            //         $fullNameTemp = str_replace(' ', '', $dataWorkshop->workshopName);
            //         $ext = $file->getClientOriginalExtension();
            //         $path = $file->storeAs('avatar', strtolower($fullNameTemp.$req->workshopID.$key.'.'.$ext), 'public');
            //         $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

            //         $dataUser = DB::table('workshop_pictures')->where('id','=',$req->workshopID)
            //         ->where('id','=',$req->idWorkshopPicture[$key])
            //         ->update(['workshopPicture' => $imagePath]);
            //     }
            //     else{
            //         $dataUser = DB::table('workshop_pictures')
            //         ->where('id','=',$req->workshopID)
            //         ->where('id','=',$req->idWorkshopPicture[$key])
            //         ->update(['workshopPicture' =>null]);
            //     }
            // }
            foreach ($req->workshop_pictures as $key => $file)
            {
                if (!is_null($req->workshop_pictures[$key]['workshopPicture']))
                {
                    $fullNameTemp = str_replace(' ', '', $dataWorkshop->workshopName);
                    $ext = $req->workshop_pictures[$key]['workshopPicture']->getClientOriginalExtension();
                    $path = $req->workshop_pictures[$key]['workshopPicture']->storeAs('avatar', strtolower($fullNameTemp.$req->workshopID.$key.'.'.$ext), 'public');
                    $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

                    $dataUser = DB::table('workshop_pictures')
                    ->where('id','=',$req->workshopID)
                    ->where('id','=',$req->workshop_pictures[$key]['idWorkshopPicture'])
                    ->update(['workshopPicture' => $imagePath]);
                }
                else{
                    $dataUser = DB::table('workshop_pictures')
                    ->where('id','=',$req->workshopID)
                    ->where('id','=',$req->workshop_pictures[$key]['idWorkshopPicture'])
                    ->update(['workshopPicture' =>null]);
                }
            }
        }
        else
        {
            return response()->json('image not found', 400);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function getWorkshopDetailByUserID (Request $req){
        try{
            $workshops = DB::table('workshops')
            ->where('userID','=',$req->adminID)
            ->get()->toArray();

            foreach ($workshops as $key=>$value) {
                $operationalWorkshop =  DB::table('operational_workshops')
                ->orWhere('operational_workshops.workshopID','=',$value->id)
                ->get()->toArray();

                $workshop_details =  DB::table('workshop_details')
                ->orWhere('workshop_details.workshopID','=',$value->id)
                ->get()->toArray();

                $workshop_services =  DB::table('workshop_services')
                ->join('workshop_details','workshop_details.id','=','workshop_services.workshopDetailID')
                ->select('workshop_services.id','workshop_details.workshopID','workshopDetailID','serviceType','serviceDetail','price','time')
                ->orWhere('workshop_details.workshopID','=',$value->id)
                ->get()->toArray();
            }
            $workshop_review = DB::table('reviews')
            ->join('schedules','schedules.id','=','reviews.scheduleID')
            ->select('reviews.id','reviews.scheduleID','schedules.workshopID','reviews.userName','reviews.reviewDate','reviews.rating','reviews.description')
            ->where('schedules.scheduleStatus','=','done')
            ->get()->toArray();


            foreach($workshops as &$value)
            {
                $value->operationalWorkshop = array_filter($operationalWorkshop, function($operationalWorkshop) use ($value) {
                    return $operationalWorkshop->workshopID === $value->id;
                });
                $value->workshop_details = array_filter($workshop_details, function($workshop_details) use ($value) {
                    return $workshop_details->workshopID === $value->id;
                });

                $value->workshop_services = array_filter($workshop_services, function($workshop_services) use ($value) {
                    return $workshop_services->workshopID === $value->id;
                });
            }

        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'objectReturn' => $workshops[0]
        ], 200);
    }

    public function getAdminWorkshopProfile(Request $req){
        try{
            $dataProfileAdmin= DB::table('users')->where('id','=',$req->adminID)
            ->where('role','=','2')->get();

            return response()->json($dataProfileAdmin, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function updateWorkshopForAdminBengkel (Request $req){
        $validator = Validator::make($req->all(), [
            'workshopName'=>['required', 'string', 'max:255'],
            'workshopAddress'=>['required', 'string', 'max:255'],
            'workshopPhoneNumber'=>['required', 'string', 'max:255'],
            'workshopEmail'=>['required', 'string', 'max:255'],
            'workshopDescription'=>['required', 'string', 'max:500'],
            // 'workshopLogo'=>['required', 'image', 'file','max:2048'],
            'city'=>['required', 'string', 'max:255'],
            'district'=>['required', 'string', 'max:255'],
            'province'=>['required', 'string', 'max:255'],
            'latitude'=>['required', 'string', 'max:255'],
            'longitude'=>['required', 'string', 'max:255'],
            'statusHr'=>['required', 'string', 'max:255'],
            'status24Hr'=>['required', 'string', 'max:255'],
            'operationalWorkshop.operationalCloseHour.*'=>['required', 'date_format:H:i:s'],
            'operationalWorkshop.operationalOpenHour.*'=>['required', 'date_format:H:i:s'],
            'workshop_details.carModel.*'=>['required', 'string', 'max:255'],
            'workshop_details.carType.*'=>['required', 'string', 'max:255'],
            'workshop_services.serviceType.*'=> ['required|string|max:255'],
            'workshop_services.serviceDetail.*'=> ['required|string|max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        DB::table('workshops')->where('id','=',$req->id)
        ->where('userID','=',$req->userID)
        ->update(['workshopName'=>$req->workshopName,
        'workshopAddress'=>$req->workshopAddress,
        'workshopPhoneNumber'=>$req->workshopPhoneNumber,
        'workshopEmail'=>$req->workshopEmail,
        'workshopDescription'=>$req->workshopDescription,
        'city'=>$req->city,
        'district'=>$req->district,
        'province'=>$req->province,
        'latitude'=>$req->latitude,
        'longitude'=>$req->longitude,
        'statusHr'=>$req->statusHr,
        'status24Hr'=>$req->status24Hr]);

        foreach ($req->operationalWorkshop as $key => $value)
        {
            DB::table('operational_workshops')->where('workshopID','=',$req->id)
            ->where('operationalDate','=',$req->operationalWorkshop[$key]['operationalDate'])
            ->update(['operationalOpenHour'=>$req->operationalWorkshop[$key]['operationalOpenHour'],
            'operationalCloseHour'=>$req->operationalWorkshop[$key]['operationalCloseHour']]);
        }
        foreach ($req->workshop_details as $key => $value)
        {
            if(!isset($req->workshop_details[$key]['carType']) || !isset($req->workshop_details[$key]['carModel'])){
                return response()->json([
                    'errorCarType' => !isset($req->workshop_details[$key]['carType']),
                    'errorCarModel' => !isset($req->workshop_details[$key]['carModel']),
                    'messageCarType'=>'Car type is required',
                    'messageCarModel'=>'Car model is required',
                    'message'=>'Field input is required',
                ], 401);
            }
            DB::table('workshop_details')->where('workshopID','=',$req->id)
            ->where('id','=',$req->workshop_details[$key]['id'])
            ->update(['carModel'=>$req->workshop_details[$key]['carModel'],
            'carType'=>$req->workshop_details[$key]['carType']]);
        }

        foreach ($req->workshop_services as $key => $value)
        {
            DB::table('workshop_services')
            ->join('workshop_details','workshop_details.id','=','workshop_services.workshopDetailID')
            ->where('workshop_services.id','=',$req->workshop_services[$key]['id'])
            ->where('workshop_details.workshopID','=',$req->id)
            ->where('serviceType','=',$req->workshop_services[$key]['serviceType'])
            ->update(['serviceDetail'=>$req->workshop_services[$key]['serviceDetail']]);
        }
        return response()->json([
            'messageAll' => 'Successfully update car specification',
            'message'=>'Success'
        ], 200);
    }

    public function deleteCarType(Request $req){
        try {
            $dataServic = DB::table('workshop_services')->where('workshopDetailID','=',$req->workshopID)->delete();
            $dataWorkshopDetails=WorkshopDetail::find($req->id)->where('workshopID','=',$req->workshopID)->delete();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'message'=>'Car type deleted'
        ], 200);
    }

    public function deleteCarModel(Request $req){
        try {
            $dataWorkshopDetails = DB::table('workshop_services')
            ->join('workshop_details','workshop_details.id','=','workshop_services.workshopDetailID')
            ->where('workshopID.id','=',$req->workshopID)
            ->where('workshopID.carModel','=',$req->carModel)
            ->delete();

        } catch (Exception $err){
            return response()->json($err, 500);
        }
        return response()->json([
            'message'=>'Car model deleted'
        ], 200);
    }

    public function addNewWorkshopDetail(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'workshopDetail.carModel.*' => ['required', 'string', 'max:255'],
                'workshopDetail.carType.*' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'id' => 1,
                    'message'=>$validator->errors()
                ], 401);
            }

            foreach ($req->workshopDetail as $key => $value)
            {
                if(!isset($req->workshopDetail[$key]['carType']) || !isset($req->workshopDetail[$key]['carModel'])){
                    return response()->json([
                        'errorCarType' => !isset($req->workshopDetail[$key]['carType']),
                        'errorCarModel' => !isset($req->workshopDetail[$key]['carModel']),
                        'messageCarType'=>'Car type is required',
                        'messageCarModel'=>'Car model is required',
                        'message'=>'Field input is required',
                    ], 401);
                }
                $newAdminWorkshopDetail = new WorkshopDetail;
                $newAdminWorkshopDetail->workshopID = $req->workshopID;
                $newAdminWorkshopDetail->carModel = $req->workshopDetail[$key]['carModel'];
                $newAdminWorkshopDetail->carType = $req->workshopDetail[$key]['carType'];
                $newAdminWorkshopDetail->save();
            }

        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'messageAll' => 'Successfully update car specification',
            'message'=>'Successfully add new car model and type'
        ], 200);
    }
}
