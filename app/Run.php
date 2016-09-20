<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Run extends Model
{
    protected $fillable = [
        'title',
        'date_at',
        'start_location',
        'end_location',
        'distance',
        'calculated',
        'start_time',
        'end_time',
        'user_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'date_at'];

    protected $appends = ['identifier','date','date_format'];

    protected $hidden = ['id','created_at','updated_at','date_at'];

    public function parcels()
    {
    	return $this->hasMany(Parcel::class)->select('id','id as identifier','run_id','parcel_id','recipient_name','address','type','weight','delivery_instructions','priority','delivered');
    }

    public function getDateAttribute($value)
    {
    	return $this->date_at->getTimestamp();
    }

    public function getDateFormatAttribute($value)
    {
        return date('d/m/Y', strtotime($this->date_at));
    }

    public function getStartTimeAttribute($value)
    {
        return date('h:i A', strtotime($value));
    }

    public function getEndTimeAttribute($value)
    {
        return date('h:i A', strtotime($value));
    }

    public function getCalculatedAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function getIdentifierAttribute()
    {
    	return $this->id;
    }

    public function getStartLocationAttribute($value)
    {
        return json_decode($value);
    }

    public function getEndLocationAttribute($value)
    {
        return json_decode($value);
    }
}
