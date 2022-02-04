<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $fillable = [
        'scheduleID',
        'serviceType',
        'serviceDetail',
    ];

    public function Schedule(){
        return $this->belongsTo(Schedule::class);
    }
}
