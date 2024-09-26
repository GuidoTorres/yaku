<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointNote extends Model
{
    protected $fillable = [
        'user_id', 'sampling_point_id', 'description', 'url'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function samplingPoint(){
        return $this->belongsTo(SamplingPoint::class);
    }

}
