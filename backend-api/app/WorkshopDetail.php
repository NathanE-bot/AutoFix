<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class WorkshopDetail extends Model
{
    protected $fillable = [
        'workshopID',
        'carModel',
        'CarType',
    ];
    public function Workshop(){
        return $this->belongsTo(Workshop::class);
    }
}
