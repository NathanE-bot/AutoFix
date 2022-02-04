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
use App\Insurance;
use App\InsuranceVendor;
use App\InsuranceWorkshop;
use App\InsuranceDetail;
use App\DocumentationInsurance;
use Illuminate\Support\Facades\Storage;
use App\Notification;
class notificationController extends Controller
{
    public function getNoticationList(Request $req){
    try {
        $dataNotif= DB::table('notifications')
        ->where('userID','=',$req->userID)
        ->get();
        return response()->json($dataNotif, 200);
    } catch (Exception $err){
        return response()->json($err, 500);
    }

    }
}
