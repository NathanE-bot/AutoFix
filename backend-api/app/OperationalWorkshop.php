<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class OperationalWorkshop extends Model
{
    protected $fillable = [
        'workshopID',
        'operationlaDate',
        'operationalOpenHour',
        'operationalCloseHour',
    ];
    public function Workshop(){
        return $this->belongsTo(Workshop::class);
    }
}