<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopPicture extends Model
{
    protected $fillable = [
        'workshopID',
        'workshopPicture',
    ];
    public function Workshop(){
        return $this->belongsTo(Workshop::class);
    }
}
