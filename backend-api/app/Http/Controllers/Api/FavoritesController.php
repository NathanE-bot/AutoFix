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
            $dataFavorites = new Favorites;
            $dataFavorites->userID = $req->userID;
            $dataFavorites->workshopID = $req->workshopID;
            $dataFavorites->save();
            return response()->json(['success' => 'data favorited added'], 200);
        }catch (Exception $error) {
            return response()->json($error, 500);
        }
    }


    public function getFavoritesByUserID(Request $req){
        $date = Carbon::now();
        $dateweek = $date->dayOfWeek;
        try {
            $data = [
                $favorite=DB::table('favorites')
                ->join('users','users.id','=','favorites.userID')
                ->join('workshops','workshops.id','=','favorites.workshopID')
                ->join('operational_workshops','operational_workshops.workshopID','=','workshops.id')
                ->select('favorites.id as favoritesID','favorites.userID as customerID'
                ,'favorites.workshopID','workshops.workshopName','workshops.workshopAddress'
                ,'workshops.rating','workshops.city','workshops.district','workshops.province','workshops.statusHr','workshops.status24Hr'
                ,'operational_workshops.operationalDate','operational_workshops.operationalOpenHour'
                ,'operational_workshops.operationalCloseHour')
                ->where('favorites.userID','=',$req->userID)
                ->where('operationalDate','=',$dateweek)
                ->get()

            ];
            return response()->json($data, 200);
        }catch (Exception $error) {
            return response()->json($error, 500);
        }
    }


    public function deletFavoritesData(Request $req){
        try {
            $findDataFavorites = Favorites::find($req->id);
            $findDataFavorites->delete();
            return response()->json(['success' => 'favorites has been remove'], 200);
        }catch (Exception $error) {
            return response()->json($error, 500);
        }
    }
}
