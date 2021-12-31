<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =[
        'scheduleID',
        'userName',
        'reviewDate',
        'description',
        'rating'
    ];
    public function Schedule(){
        return $this->belongsTo(Schedule::class);
    }

}
