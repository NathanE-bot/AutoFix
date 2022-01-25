<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use App\User;
use DB;
use App\Favorites;
use Carbon\Carbon;
class FavoritesController extends Controller
{

    public function makeFavoritesByWorkshopAndUserID(Request $req){
        try {
            if(Favorites::where('userID', $req->userID)->where('workshopID', $req->workshopID)->exists()){
                return response()->json([
                    'message' => 'Already your favorite'
                ], 401);
            } else {
                $dataFavorites = new Favorites;
                $dataFavorites->userID = $req->userID;
                $dataFavorites->workshopID = $req->workshopID;
                $dataFavorites->save();
            }
        }catch (Exception $error) {
            return response()->json($error, 500);
        }

        return response()->json([
            'message' => 'Added to favorite'
        ], 200);
    }

    public function getFavoritesByUserID(Request $req){
        $date = Carbon::now();
        $dateweek = $date->dayOfWeek;
        try {
            $data = DB::table('favorites')
                ->join('users','users.id','=','favorites.userID')
                ->join('workshops','workshops.id','=','favorites.workshopID')
                ->join('operational_workshops','operational_workshops.workshopID','=','workshops.id')
                ->select('favorites.id as favoritesID','favorites.userID as customerID'
                ,'favorites.workshopID','workshops.workshopName','workshops.workshopAddress'
                ,'workshops.rating','workshops.city','workshops.district','workshops.province','workshops.statusHr','workshops.status24Hr', 'workshop.workshopLogo'
                ,'operational_workshops.operationalDate','operational_workshops.operationalOpenHour'
                ,'operational_workshops.operationalCloseHour','users.tokenChat as customerTokenChat',
                'workshops.longitude','workshops.latitude',DB::raw('(SELECT tokenChat FROM users WHERE users.id = workshops.userID LIMIT 1) AS adminTokenChat'))
                ->where('favorites.userID','=',$req->userID)
                ->where('operationalDate','=',$dateweek)
                ->get();
        } catch (Exception $error) {
            return response()->json($error, 500);
        }
        return response()->json([
            'objectReturn' => $data
        ], 200);
    }

    public function deletFavoritesData(Request $req){
        try {
            $data = Favorites::where('userID', $req->userID)->where('workshopID', $req->workshopID);
            if($data->exists()){
                try {
                    $data->delete();
                } catch (Exception $error) {
                    return response()->json($error, 500);
                }
            } else {
                return response()->json([
                    'message' => 'Favorite data does not exist'
                ], 401);
            }
        }catch (Exception $error) {
            return response()->json($error, 500);
        }

        return response()->json([
            'message' => 'Removed from favorite'
        ], 200);
    }
}
