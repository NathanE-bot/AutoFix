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
        'scheduleStatus'
    ];

    public function Workshop(){
        return $this->belongsTo(Workshop::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Review(){
        return $this->hasMany(Review::class);
    }
}
