<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'userID',
        'senderName',
        'description',
        'notificationTime',
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
}
