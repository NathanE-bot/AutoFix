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
}
