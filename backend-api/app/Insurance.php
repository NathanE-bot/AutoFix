<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable =[
        'userID',
        'vendorInsuranceID',
        'insuredName',
        'phoneNumberClaimer',
        'emailClaimer',
        'addressClaimer',
        'carTypeAndBrand',
        'chassisNumber',
        'polisNumber',
        'licensePlateNumber',
        'driverName',
        'driverSpeed',
        'driverRelation',
        'incidentLocation',
        'vehicleDescription',
        'incidentDate',
        'incidentTime',
        'taxiOnlineStatus',
        'workshopType',
        'chronology',
        'incidentStatus',
        'incidentStatusDescription'
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function InsuranceVendor(){
        return $this->belongsTo(InsuranceVendor::class);
    }
}
