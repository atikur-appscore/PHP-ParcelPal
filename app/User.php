<?php 

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name', 
        'email',
        'phone',
        'password',
        'birthday',
        'location',
        'description',
        'type_id',
        'gender_id',
        'active',
    ];

    protected $hidden = ['is_delete','remember_token','password'];

    public function checkEmail($email)
    {
        return self::where('email', $email)->count();
    }

    public function runs()
    {
        return $this->hasMany(Run::class);
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }

    public function favourites()
    {
        return $this->hasMany(favourite::class);
    }
}
