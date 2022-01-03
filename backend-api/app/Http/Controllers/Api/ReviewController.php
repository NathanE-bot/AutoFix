<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function makeReviewApi(Request $req){
        try{
            if ($req->status == 'done') {
                $validator = Validator::make($req->all(), [
                    'description'=>['required', 'string', 'max:255'],
                ]);

                $review = new Review;
                $review->scheduleID=$req->scheduleID;
                $review->userName=$req->userName;
                $review->reviewDate=$req->reviewDate;
                $review->description=$req->description;
                $review->save();

                $data = [
                    'objectReturner' =>[$review]
                ];
            }
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function getReviewApi(Request $req){
        $dataReview = DB::table('reviews')
        ->join('schedules','schedule.id','=','reviews.scheduleID')
        ->where('schedules.workshopID','=',$req->id)
        ->get();
        return response()->json($dataReview, 200);
    }
}
