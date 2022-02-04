<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Otp extends Model
{
    protected $fillable = [
        'temp_userID',
        'otp',

    ];
    public function TempUser(){
        return $this->belongsTo(TempUser::class);
    }
}
