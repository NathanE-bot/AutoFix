<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userID',
        'workshopName',
        'workshopAddress',
        'workshopPhoneNumber',
        'workshopEmail',
        'workshopDescription',
        'isActive'
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function OperationalWorkshop(){
        return $this->hasMany(OperationalWorkshop::class);
    }
    public function WorkshopDetail(){
        return $this->hasMany(WorkshopDetail::class);
    }
    public function WorkshopServis(){
        return $this->hasMany(WorkshopServis::class);
    }
    public function Schedule(){
        return $this->hasMany(Schedule::class);
    }
}
