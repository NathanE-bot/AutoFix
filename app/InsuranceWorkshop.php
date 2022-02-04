<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class InsuranceWorkshop extends Model
{
    protected $fillable =[
        'vendorInsuranceID',
        'insuranceWorkshopName',
    ];
    public function InsuranceVendor(){
        return $this->belongsTo(InsuranceVendor::class);
    }
}
