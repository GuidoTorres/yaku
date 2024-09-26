<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sampling extends Model
{
    const FOR_APPROVAL = 1;
    const APPROVED = 2;
    const DISAPPROVED = 3;

    const GREEN_ALERT = 1;
    const YELLOW_ALERT = 2;
    const RED_ALERT = 3;

    const ECA_YELLOW_THRESHOLD = 0.1;

    const NORMAL_PARAMETER = 1;
    const NEAR_BELLOW_LIMIT = 2;
    const BELLOW_LIMIT = 3;
    const NEAR_UPPER_LIMIT = 4;
    const UPPER_LIMIT = 5;
    const DIFFERENT_THAN_ALLOWED = 6;

    const ECA_MIN_MAX = 1;
    const ECA_MIN = 2;
    const ECA_MAX = 3;
    const ECA_ALLOWED = 4;
    const ECA_NULL = 5;

    protected $fillable = [
        'sampling_point_id', 'deep_id', 'state','utm_zone','north','east','latitude',
        'longitude','sampling_date','user_created_id','user_approved_id'
    ];


    public function samplingPoint(){
        return $this->belongsTo(SamplingPoint::class);
    }
    public function deep(){
        return $this->belongsTo(Deep::class);
    }
    public function userCreated(){
        return $this->belongsTo(User::class, 'user_created_id');
    }
    public function userApproved(){
        return $this->belongsTo(User::class, 'user_approved_id');
    }
    public function samplingParameters(){
        return $this->hasMany(SamplingParameter::class);
    }

}
