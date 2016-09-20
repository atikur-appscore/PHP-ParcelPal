<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = [
    	'name','unit_number','street_number','street_name','suburb','state','user_id'
    ];

    protected $hidden = ['id','created_at','updated_at'];

    protected $appends = ['identifier'];

    public function getIdentifierAttribute()
    {
    	return $this->id;
    }
}
