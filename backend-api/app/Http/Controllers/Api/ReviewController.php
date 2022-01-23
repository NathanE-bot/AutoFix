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
use App\Review;
class ReviewController extends Controller
{
    public function formReviewAPI(Request $req){
        
        $dataSchedule=DB::table('schedules')->find($req->scheduleID);
        if ($dataSchedule->scheduleStatus == 'done') {
            $validator = Validator::make($req->all(), [
                'description'=>['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errId'=> 1,
                    'message'=>$validator->errors()
                ], 401);
            }
            
            try{
                $review = new Review;
                $review->scheduleID=$req->scheduleID;
                $review->userName=$req->userName;
                $review->reviewDate=$req->reviewDate;
                $review->description=$req->description;
                $review->rating=$req->rating;
                $review->save();

            } catch (Exception $err){
                return response()->json([
                    'errId'=> 5,
                    'err'=> $err
                ], 500);
            }

            return response()->json([
                'messageTitle'=>'Review successfully made',
                'messageSubtitle'=>'Thankyou for your feedback'
            ], 200);
        }        
    }

    // public function viewReviewAPI(Request $req){
    //     $dataReview = DB::table('reviews')
    //     ->join('schedules','schedule.id','=','reviews.scheduleID')
    //     ->where('schedules.workshopID','=',$req->id)
    //     ->get();
    //     return response()->json($dataReview, 200);
    // }
}
