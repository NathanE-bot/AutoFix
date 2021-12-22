<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class WorkshopServis extends Model
{
    protected $fillable = [
        'workshopDetailID',
        'servicType',
        'servisDetail',
        'price',
        'time',
    ];
    public function Workshop(){
        return $this->belongsTo(Workshop::class);
    }
}
