<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'parcel_id',
        'recipient_name',
        'address',
        'type',
        'weight',
        'delivery_instructions',
        'priority',
        'run_id',
        'delivered',
        'damage',
        'user_id',
    ];

    protected $hidden = ['id','created_at','updated_at'];

    protected $appends = ['identifier'];

    public function run()
    {
    	return $this->belongsTo(Run::class);
    }

    public function getIdentifierAttribute()
    {
    	return $this->id;
    }

    public function getDeliveredAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function findByParcelId($id)
    {
        return self::where('parcel_id',$id)->first();
    }

    public function getAddressAttribute($value)
    {
        return json_decode($value);
    }
}
