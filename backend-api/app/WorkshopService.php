<?php

namespace App;
use db;
use Illuminate\Database\Eloquent\Model;

class WorkshopService extends Model
{
    protected $fillable = [
        'workshopDetailID',
        'serviceType',
        'serviceDetail',
        'price',
        'time',
    ];

    public function WorkshopDetail(){
        return $this->belongsTo(WorkshopDetail::class);
    }
}

