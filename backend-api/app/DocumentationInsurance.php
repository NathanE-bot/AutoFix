<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class DocumentationInsurance extends Model
{
    protected $fillable =[
        'insuranceID',
        'documentationInsuranceName',
        'documentationPicture',
    ];
}
