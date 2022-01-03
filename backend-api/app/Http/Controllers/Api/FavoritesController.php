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
        try {
            $data = [
                $favorite=DB::table('favorites')
                ->join('users','users.id','=','favorites.userID')
                ->join('workshops','workshops.id','=','favorites.workshopID')
                ->where('favorites.userID','=',$req->userID)
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
