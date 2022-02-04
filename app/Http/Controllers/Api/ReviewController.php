<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use App\OperationalWorkshop;
use App\Review;
use App\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\ServceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
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
                if(Review::where('scheduleID', $req->scheduleID)->exists()){
                    return response()->json([
                        'message' => 'Review already exist'
                    ], 401);
                } else {
                    $review = new Review;
                    $review->scheduleID=$req->scheduleID;
                    $review->userName=$req->userName;
                    $review->reviewDate=$req->reviewDate;
                    $review->description=$req->description;
                    $review->rating=$req->rating;
                    $review->save();
                    Schedule::where('id', $req->scheduleID)->update(['isReviewed'=>true]);
                }
                
                $avg_rating= DB::table('reviews')
                ->join('schedules','schedules.id','=','reviews.scheduleID')
                ->selectRaw('ROUND(SUM(reviews.rating)/COUNT(schedules.workshopID),1) AS avg_rating')
                ->where('schedules.workshopID','=',$req->workshopID)
                ->first();

                $updateDataWorkshop= DB::table('workshops')
                ->where('id','=',$req->workshopID)
                ->update(['rating'=>$avg_rating->avg_rating]);

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

    public function viewReviewAPI(Request $req){
        $dataReview = DB::table('reviews')
        ->join('schedules','schedule.id','=','reviews.scheduleID')
        ->where('schedules.workshopID','=',$req->id)
        ->get();
        return response()->json($dataReview, 200);
    }

    // public function countRatingForWorkshopByUserID(Request $req){
    //     $avg_rating= DB::table('reviews')
    //     ->join('schedules','schedules.id','=','reviews.scheduleID')
    //     ->selectRaw('ROUND(SUM(reviews.rating)/COUNT(schedules.workshopID),1) AS avg_rating')
    //     ->where('schedules.workshopID','=',$req->workshopID)
    //     ->first();

    //     $updateDataWorkshop= DB::table('workshops')
    //     ->where('id','=',$req->workshopID)
    //     ->update(['rating'=>$avg_rating->avg_rating]);

    //     return response()->json([$avg_rating,'message'=>'berhasil'], 200);
    // }
}
