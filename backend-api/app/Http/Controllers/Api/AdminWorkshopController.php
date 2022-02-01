<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use App\WorkshopDetail;
use App\WorkshopService;
use App\Notification;
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


        if(empty($IncomingSchedule)||empty($dataDetailsSchedule)||empty($dataCustomer)){
            return response()->json(['Message'=>'No data'], 200);
        }
        return response()->json([
            'listSchedule' => $IncomingSchedule,
            'listDetails' => $dataDetailsSchedule,
            'listDataCustomer' => $dataCustomer
        ], 200);
    }

    public function acceptScheduleByAdmin(Request $req){
        try {
            $dataSchedule= DB::table('schedules')->where('id','=',$req->scheduleID)->where('scheduleStatus','=','waiting confirmation')
            ->update(['scheduleStatus'=>'accepted',
            'description'=>'Your schedule have been accept. Please Call Customer Service if you have any question']);

            $dataUpdatedSchedule = DB::table('schedules')->where('id','=',$req->scheduleID)->get();

            $dataUserID=DB::table('schedules')->where('id','=',$req->scheduleID)->first();
            $newNotification = new Notification;
            $newNotification->userID = $dataUserID->userID;
            $newNotification->senderName = 'System';
            $newNotification->description = 'Your Schedule Have Been Accept By'.$dataUserID->workshopName.'please see you schedule in profile menu or Contact The admin If you have any question.';
            $newNotification->notificationTime = Carbon::now();
            $newNotification->save();

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
            'description' => 'required|string'
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
        $dataUserID=DB::table('schedules')->where('id','=',$req->scheduleID)->first();
        $newNotification = new Notification;
        $newNotification->userID = $dataUserID->userID;
        $newNotification->senderName = 'System';
        $newNotification->description = 'Your Schedule Have Been Reject By'.$dataUserID->workshopName.'please see you history in profile menu or Contact The admin If you have any question.';
        $newNotification->notificationTime = Carbon::now();
        $newNotification->save();
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
        if(empty($acceptedSchedule)||empty($dataDetailsSchedule)||empty($dataCustomer)){
            return response()->json(['Message'=>'No data'], 200);
        }
        return response()->json([
            'listSchedule' => $acceptedSchedule,
            'listDetails' => $dataDetailsSchedule,
            'listDataCustomer' => $dataCustomer
        ], 200);
    }

    public function cancelScheduleByAdmin(Request $req){
        $validator = Validator::make($req->all(), [
            'description' => 'required|string'
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
        $dataUserID=DB::table('schedules')->where('id','=',$req->scheduleID)->first();

        return response()->json([
            'scheduleID' => $req->scheduleID,
            'message' => 'Order Cancelled'
        ], 200);
    }

    public function doneScheduleByAdmin(Request $req){
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
            'image' => 'image|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }
        $dataUpdatedUser = DB::table('workshops')->where('id','=',$req->workshopID)->first();
        if (!is_null($req->image))
        {
            $dataImageWorkshops = DB::table('workshops')
            ->select(DB::raw('SUBSTRING(workshopLogo,30,100) AS path'))
            ->where('id','=',$req->workshopID)->first();
            Storage::delete('/public/'.$dataImageWorkshops->path);

            $dateTimeNow = carbon::now()->format("Y-m-d_H-i-s");
            $fullNameTemp = str_replace(' ', '', $dataUpdatedUser->workshopName);
            $ext = $req->image->getClientOriginalExtension();
            $path = $req->file('image')->storeAs('avatar', strtolower('LOGO-'.$fullNameTemp.$dataUpdatedUser->id.$dateTimeNow.'.'.$ext), 'public');
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

    // public function uploadGaleryWorkshop(Request $req){
    //     $validator = Validator::make($req->all(), [
    //         'workshopPicture' => 'image|file|max:2048'
    //     ]);


    //     if ($validator->fails()) {
    //         return response()->json([
    //             'id' => 1,
    //             'message'=>$validator->errors()
    //         ], 401);
    //     }
    //     if ($req->has('workshopPicture'))
    //     {
    //         $dataWorkshop =DB::table('workshops')->where('id','=',$req->workshopID)->first();
    //         foreach ($req->file('workshopPicture') as $key => $file)
    //         {
    //             $fullNameTemp = str_replace(' ', '', $dataWorkshop->workshopName);
    //             $ext = $file->getClientOriginalExtension();
    //             $path = $file->storeAs('avatar', strtolower($fullNameTemp.$req->workshopID.$key.'.'.$ext), 'public');
    //             $imagePath = 'http://127.0.0.1:8000/storage/'. $path;

    //             $workshopPicture = new WorkshopPicture;
    //             $workshopPicture->workshopID = $req->workshopID;
    //             $workshopPicture->workshopPicture = $imagePath;
    //             $workshopPicture->save();
    //         }
    //     }
    //     else
    //     {
    //         return response()->json('image not found', 400);
    //     }
    //     return response()->json([
    //         'message' => 'success'
    //     ], 200);
    // }

    public function makeGaleryWorkshopPath(Request $req){
        try{
            $validator = Validator::make($req->all(), [
                'workshopPictureID'=>'required',
                'workshopID'=>'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'id' => 1,
                    'message'=>$validator->errors()
                ], 401);
            }

            if ($req->has('image'))
            {
                $dateTimeNow= carbon::now()->format("Y-m-d_H-i-s");
                $dataWorkshop = DB::table('workshops')->where('id','=',$req->workshopID)->first();
                $fullNameTemp = str_replace(' ', '', $dataWorkshop->workshopName);
                $ext = $req->image->getClientOriginalExtension();
                $path = $req->image->storeAs('avatar', strtolower('galery-'.$fullNameTemp.$req->workshopID.$dateTimeNow.'.'.$ext), 'public');
                $imagePath = 'http://127.0.0.1:8000/storage/'. $path;
                // dd($imagePath);
                if (!is_null($imagePath))
                {
                    // dd(!is_null($imagePath));
                    if (WorkshopPicture::where('id','=',$req->workshopPictureID)->exists()) {

                        $dataImageWorkshops = DB::table('workshop_pictures')
                        ->select(DB::raw('SUBSTRING(workshopPicture,30,100) AS path'))
                        ->where('workshopID','=',$req->workshopID)
                        ->where('id','=',$req->workshopPictureID)->first();
                        Storage::delete('/public/'.$dataImageWorkshops->path);

                        $dataUser = DB::table('workshop_pictures')
                        ->where('workshopID','=',$req->workshopID)
                        ->where('id','=',$req->workshopPictureID)
                        ->update(['workshopPicture' => $imagePath]);
                    }
                    else {
                        $workshopPicture = new WorkshopPicture;
                        $workshopPicture->workshopID = $req->workshopID;
                        $workshopPicture->workshopPicture = $imagePath;
                        $workshopPicture->save();
                    }
                }
                else{
                    $dataUser = DB::table('workshop_pictures')
                    ->where('workshopID','=',$req->workshopID)
                    ->where('id','=',$req->workshopPictureID)
                    ->update(['workshopPicture' =>null]);
                }
            }
            else
            {
                return response()->json('image not found', 400);
            }
        } catch (Exception $err){
            return response()->json($err, 500);
        }
        return response()->json([
            'message' => 'success',
        ], 200);
    }


    // public function updateGaleryWorkshop(Request $req){
    //     $validator = Validator::make($req->all(), [
    //         'workshopPicture.*.workshopPictureID'=>'required',
    //         'workshopPicture.*.imagePath'=>'required|string|max:255'

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'id' => 1,
    //             'message'=>$validator->errors()
    //         ], 401);
    //     }
    //     // foreach ($workshopPicture as $key => $value) {
    //     //     $dataWorkshopPicture = DB::table('workshop_pictures')
    //     //     ->where('workshopID','=',$req->workshopID)
    //     //     ->where('id','=',$req->workshopPicture[$key]['workshopPictureID'])
    //     //     ->get();
    //     // }


    //     if (!is_null($req->imagePath))
    //     {
    //         foreach ($workshopPicture as $key => $value) {
    //             if (WorkshopPicture::where('workshopPicture','=',$req->worksworkshopPicture[$key]['imagePath'])->exist()) {
    //                 $dataUser = DB::table('workshop_pictures')
    //                 ->where('workshopID','=',$req->workshopID)
    //                 ->where('id','=',$req->workshopPicture[$key]['workshopPictureID'])
    //                 ->update(['workshopPicture' => $workshopPicture[$key]['imagePath']]);
    //             }
    //             else {
    //                 $workshopPicture = new WorkshopPicture;
    //                 $workshopPicture->workshopID = $req->workshopID;
    //                 $workshopPicture->workshopPicture = $req->imagePath;
    //                 $workshopPicture->save();
    //             }
    //         }
    //     }
    //     else{
    //         $dataUser = DB::table('workshop_pictures')
    //         ->where('id','=',$req->workshopID)
    //         ->where('id','=',$req->workshopPicture[$key]['workshopPictureID'])
    //         ->update(['workshopPicture' =>null]);
    //     }
    // }


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

                $workshop_picture =  DB::table('workshop_pictures')
                ->orWhere('workshop_pictures.workshopID','=',$value->id)
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
                $value->workshop_picture = array_filter($workshop_picture, function($workshop_picture) use ($value) {
                    return $workshop_picture->workshopID === $value->id;
                });
                $value->workshop_review = array_filter($workshop_review, function($workshop_review) use ($value) {
                    return $workshop_review->workshopID === $value->id;
                });
            }
            if(empty($workshops)){
                return response()->json(['Message'=>'No data'], 200);
            }
            return response()->json([
                'objectReturn' => $workshops[0]
            ], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function getAdminWorkshopProfile(Request $req){
        try{
            $dataProfileAdmin= DB::table('users')->where('id','=',$req->adminID)
            ->where('role','=','2')->get();

            if(empty($dataProfileAdmin)){
                return response()->json(['Message'=>'No data'], 200);
            }
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
            'operationalWorkshop.*.operationalCloseHour'=>['required', 'date_format:H:i:s'],
            'operationalWorkshop.*.operationalOpenHour'=>['required', 'date_format:H:i:s'],
            'workshop_details.*.carModel'=>['required', 'string', 'max:255'],
            'workshop_details.*.carType'=>['required', 'string', 'max:255'],
            'workshop_services.*.serviceType'=> ['required', 'string', 'max:255'],
            'workshop_services.*.serviceDetail'=> ['required', 'string', 'max:255'],
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
            if (empty($req->operationalWorkshop[$key]['operationalOpenHour'])&&empty($req->operationalWorkshop[$key]['operationalCloseHour'])) {
                DB::table('operational_workshops')->where('workshopID','=',$req->id)
                ->where('operationalDate','=',$req->operationalWorkshop[$key]['operationalDate'])
                ->update(['operationalOpenHour'=>'null',
                'operationalCloseHour'=>'null']);
            }
            DB::table('operational_workshops')->where('workshopID','=',$req->id)
            ->where('operationalDate','=',$req->operationalWorkshop[$key]['operationalDate'])
            ->update(['operationalOpenHour'=>$req->operationalWorkshop[$key]['operationalOpenHour'],
            'operationalCloseHour'=>$req->operationalWorkshop[$key]['operationalCloseHour']]);
        }
        foreach ($req->workshop_details as $key => $value)
        {
            // if(!isset($req->workshop_details[$key]['carType']) || !isset($req->workshop_details[$key]['carModel'])){
            //     return response()->json([
            //         'errorCarType' => !isset($req->workshop_details[$key]['carType']),
            //         'errorCarModel' => !isset($req->workshop_details[$key]['carModel']),
            //         'messageCarType'=>'Car type is required',
            //         'messageCarModel'=>'Car model is required',
            //         'message'=>'Field input is required',
            //     ], 401);
            // }
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
            ->update(['serviceType'=>$req->workshop_services[$key]['serviceType'],
            'serviceDetail'=>$req->workshop_services[$key]['serviceDetail']]);
        }

        return response()->json([
            'messageAll' => 'Successfully update car specification',
            'message'=>'Success'
        ], 200);
    }

    public function deleteCarType(Request $req){
        try {
            $dataServic = DB::table('workshop_services')->where('workshopDetailID','=',$req->id)->delete();
            $dataWorkshopDetails= DB::table('workshop_details')
            ->where('id','=',$req->id)
            ->where('workshopID','=',$req->workshopID)->delete();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'message'=>'Car type deleted'
        ], 200);
    }

    public function deleteCarModel(Request $req){
        try {
            $dataWorkshopService = DB::table('workshop_services')
            ->join('workshop_details','workshop_details.id','=','workshop_services.workshopDetailID')
            ->where('workshop_details.workshopID','=',$req->workshopID)
            ->where('workshop_details.carModel','=',$req->carModel)
            ->delete();
            $daWorkshopDetails = DB::table('workshop_details')
            ->where('workshopID','=',$req->workshopID)
            ->where('carModel','=',$req->carModel)
            ->delete();
            // dd($req->all());

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
                'workshopDetail.*.carModel' => ['required', 'string', 'max:255'],
                'workshopDetail.*.carType' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'id' => 1,
                    'message'=>$validator->errors()
                ], 401);
            }

            foreach ($req->workshopDetail as $key => $value)
            {
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

    public function addWorkshopService(Request $req){
        try {
            if(!empty($req->serviceTypeUmum)&&!empty($req->serviceTypeBerkala)){
                $validator = Validator::make($req->all(), [
                    'serviceTypeUmum.*.serviceDetail' => ['required', 'string', 'max:255'],
                    'serviceTypeUmum.*.price' => ['required', 'integer', 'max:255'],
                    'serviceTypeUmum.*.time' => ['required', 'integer', 'max:10'],
                    'serviceTypeBerkala.*.serviceDetail' => ['required', 'string', 'max:255'],
                    'serviceTypeBerkala.*.price' => ['required', 'integer', 'max:1000000000'],
                    'serviceTypeBerkala.*.time' => ['required', 'integer', 'max:10'],
                ]);
            }
            else if(!empty($req->serviceTypeUmum)){
                $validator = Validator::make($req->all(), [
                    'serviceTypeUmum.*.serviceDetail' => ['required', 'string', 'max:255'],
                    'serviceTypeUmum.*.price' => ['required', 'integer', 'max:1000000000'],
                    'serviceTypeUmum.*.time' => ['required', 'integer', 'max:10'],
                ]);

            }
            else if(!empty($req->serviceTypeBerkala)){
                $validator = Validator::make($req->all(), [
                    'serviceTypeBerkala.*.serviceDetail' => ['required', 'string', 'max:255'],
                    'serviceTypeBerkala.*.price' => ['required', 'integer', 'max:1000000000'],
                    'serviceTypeBerkala.*.time' => ['required', 'integer', 'max:10'],
                ]);
            }


            if ($validator->fails()) {
                return response()->json([
                    'id' => 1,
                    'message'=>$validator->errors()
                ], 401);
            }

            if ($req->has('serviceTypeUmum')) {
                foreach($req->serviceTypeUmum as $key=>$value){
                if(!isset($req->serviceTypeUmum[$key]['serviceDetail']) || !isset($req->serviceTypeUmum[$key]['price'])
                ||!isset($req->serviceTypeUmum[$key]['time'])){
                    return response()->json([
                        'messageGeneralService'=>'GeneralService is required',
                        'message'=>'Field input is required',
                    ], 401);
                }
                $addServiceUmum = new WorkshopService;
                $addServiceUmum ->workshopDetailID = $req->serviceTypeUmum[$key]['workshopDetailID'];
                $addServiceUmum ->serviceType = 'servis umum';
                $addServiceUmum ->serviceDetail = $req->serviceTypeUmum[$key]['serviceDetail'];
                $addServiceUmum ->price = $req->serviceTypeUmum[$key]['price'];
                $addServiceUmum ->time = $req->serviceTypeUmum[$key]['time'];
                $addServiceUmum->save();
                }
            }
            else{
                return response()->json(['message'=>'data error'], 401);
            }


            if ($req->has('serviceTypeBerkala')) {
                foreach($req->serviceTypeBerkala as $key=>$value){
                if(!isset($req->serviceTypeBerkala[$key]['serviceDetail'])
                ||!isset($req->serviceTypeBerkala[$key]['price']) || !isset($req->serviceTypeBerkala[$key]['time'])){
                    return response()->json([
                        'messagePeriodicService'=>'PeriodicService is required',
                        'message'=>'Field input is required',
                    ], 401);
                }
                $addServiceBerkala = new WorkshopService;
                $addServiceBerkala ->workshopDetailID = $req->serviceTypeBerkala[$key]['workshopDetailID'];
                $addServiceBerkala ->serviceType = 'servis berkala';
                $addServiceBerkala ->serviceDetail = $req->serviceTypeBerkala[$key]['serviceDetail'];
                $addServiceBerkala ->price = $req->serviceTypeBerkala[$key]['price'];
                $addServiceBerkala ->time = $req->serviceTypeBerkala[$key]['time'];
                $addServiceBerkala->save();
                // kolo pake jobs
                // array_push($newscheduledetail,$array);
                }
            }
            else{
                return response()->json(['message'=>'data error'], 401);
            }
            return response()->json([
                'messageAll' => 'Successfully add car services',
            ], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }

    }

    public function deleteWorkshopServiceByID(Request $req){
        try {
            $dataServic = DB::table('workshop_services')
            ->where('id','=',$req->id)
            ->where('workshopDetailID','=',$req->workshopDetailID)
            ->delete();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'message'=>'Service deleted'
        ], 200);
    }

    public function deleteWorkshopServiceByStatusAndID(Request $req){
        try {
            $dataServic = DB::table('workshop_services')
            ->where('serviceType','=',$req->serviceType)
            ->where('workshopDetailID','=',$req->workshopDetailID)
            ->delete();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'message'=>'Services deleted'
        ], 200);
    }


    public function countAllDataWorkshop(Request $req){
        try {
            $schedule= DB::table('schedules')
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
                    $join->on(DB::raw('DAY(schedules.created_at)'), '=',DB::raw('days.d'))
                    ->where(DB::raw('YEAR(schedules.created_at)'), '=', $req->year)
                    ->where(DB::raw('MONTH(schedules.created_at)'), '=', $req->month);
                }
            )
            ->join('workshops','workshops.id','=','schedules.workshopID')
            ->select(DB::raw('days.d AS day, COUNT(schedules.id) AS countData'))
            ->where('workshops.userID','=',$req->adminID)
            ->where('schedules.scheduleStatus','!=','waiting confirmation')
            ->groupBY('days.d')
            ->get();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            $schedule
        ], 200);
    }

    public function SumAllPriceEstimationWorkshop(Request $req){
        try {
            $schedule= DB::table('schedules')
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
                    $join->on(DB::raw('MONTH(schedules.created_at)'), '=',DB::raw('months.d'))
                    ->where(DB::raw('YEAR(schedules.created_at)'), '=', $req->year);
                }
            )
            ->join('workshops','workshops.id','=','schedules.workshopID')
            ->select(DB::raw('months.d AS day, SUM(schedules.priceEstimation) AS Total_Estimasi'))
            ->where('workshops.userID','=',$req->adminID)
            ->where('schedules.scheduleStatus','=','done')
            ->groupBY('months.d')
            ->get();
        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            $schedule
        ], 200);
    }

    public function countWorkshopByStatus(Request $req){
        try {
            $scheduleDone= DB::table('schedules')
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
                    $join->on(DB::raw('DAY(schedules.created_at)'), '=',DB::raw('days.d'))
                    ->where(DB::raw('YEAR(schedules.created_at)'), '=', $req->year)
                    ->where(DB::raw('MONTH(schedules.created_at)'), '=', $req->month);
                }
            )
            ->join('workshops','workshops.id','=','schedules.workshopID')
            ->select(DB::raw('days.d AS day, COUNT(schedules.id) AS countData'))
            ->where('workshops.userID','=',$req->adminID)
            ->where('schedules.scheduleStatus','=','done')
            ->groupBY('days.d')
            ->get();


            $scheduleReject= DB::table('schedules')
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
                    $join->on(DB::raw('DAY(schedules.created_at)'), '=',DB::raw('days.d'))
                    ->where(DB::raw('YEAR(schedules.created_at)'), '=', $req->year)
                    ->where(DB::raw('MONTH(schedules.created_at)'), '=', $req->month);
                }
            )
            ->join('workshops','workshops.id','=','schedules.workshopID')
            ->select(DB::raw('days.d AS day, COUNT(schedules.id) AS countData'))
            ->where('workshops.userID','=',$req->adminID)
            ->where('schedules.scheduleStatus','=','rejected')
            ->groupBY('days.d')
            ->get();

            $scheduleCancle= DB::table('schedules')
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
                $join->on(DB::raw('DAY(schedules.created_at)'), '=',DB::raw('days.d'))
                ->where(DB::raw('YEAR(schedules.created_at)'), '=', $req->year)
                ->where(DB::raw('MONTH(schedules.created_at)'), '=', $req->month);
            }
        )
        ->join('workshops','workshops.id','=','schedules.workshopID')
        ->select(DB::raw('days.d AS day, COUNT(schedules.id) AS countData'))
        ->where('workshops.userID','=',$req->adminID)
        ->where('schedules.scheduleStatus','=','cancle')
        ->groupBY('days.d')
        ->get();

        $data =[
            'donedArray'=>$scheduleDone,
            'rejectedArray'=>$scheduleReject,
            'cancleArray'=>$scheduleCancle
        ];
        return response()->json([
            $data
        ], 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }


}
