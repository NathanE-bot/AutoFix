<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $fillable = [
        'shopId', 
        'shopName', 
        'shopAddress',
        'LogoURL',
        'operationalHour',
        'gallery',
        'contactPhoneNumber',
        'contactEmailAddress'
    ];
}
