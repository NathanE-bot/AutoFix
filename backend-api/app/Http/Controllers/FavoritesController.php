<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
class FavoritesController extends Controller
{

    public function makeFavoritesByWorkshopAndUserID(Request $req){
        $dataFavorites = new Favorite;
        $dataFavorites->userID = $req->userID;
        $dataFavorites->workshopID = $req->workshopID;
    }


    public function getFavoritesByUserID(Request $req){
        $favorite=DB::table('favorites')
        ->join('users','users.id','=','favorites.userID')
        ->join('workshops','workshops.id','=','favorites.workshopID')
        ->where('favorites.userID','=',$req->userID)
        ->get();
    }
}
