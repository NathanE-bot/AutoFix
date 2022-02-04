<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class InsuranceVendor extends Model
{
    protected $fillable =[
        'userID',
        'insuranceName',
        'phoneNumber',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Insurance(){
        return $this->hasMany(Insurance::class);
    }

}
