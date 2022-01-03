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
        try{
            $dataSchedule=DB::table('schedules')->find($req->scheduleID);
            if ($dataSchedule->scheduleStatus == 'done') {
                $validator = Validator::make($req->all(), [
                    'description'=>['required', 'string', 'max:255'],
                ]);

                $review = new Review;
                $review->scheduleID=$req->scheduleID;
                $review->userName=$req->userName;
                $review->reviewDate=$req->reviewDate;
                $review->description=$req->description;
                $review->rating=$req->rating;
                $review->save();
            }
                $data = [
                    'objectReturner' =>$review
                ];

            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
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
