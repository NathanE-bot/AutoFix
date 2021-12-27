<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class InsuranceDetail extends Model
{
    protected $fillable =[
        'insuranceID',
        'filePDF',
        'phoneNumber',
        'claimInsuranceDate',
        'insuranceStatus',
        'insuranceDescription'
    ];
}
