<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName',
        'displayName',
        'email',
        'password',
        'DoB',
        'phoneNumber',
        'address',
        'role',
        'profilePicture',
        'isActive'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    use HasApiTokens, HasFactory, Notifiable;





    public function messages()
    {
        return $this->hasMany(Message::class);
    } 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Schedule(){
        return $this->hasMany(Schedule::class);
    }
}
