<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $fillable =[
        'userID',
        'workshopID',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
