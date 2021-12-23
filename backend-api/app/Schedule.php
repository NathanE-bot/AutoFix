<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Schedule extends Model
{
    protected $fillable = [
        'userID',
        'workshopID',
        'workshopName',
        'workshopAddress',
        'scheduleDate',
        'scheduleTime',
        'carModel',
        'carType',
        'timeEstimation',
        'priceEstimation',
        'schedulleStatus'
    ];

    public function Workshop(){
        return $this->belongsTo(Workshop::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
