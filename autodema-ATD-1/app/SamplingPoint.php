<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplingPoint extends Model
{
    const FIXED_POINT = 1;
    const FLOAT_POINT = 2;

    const FIXED_TITLE = "Red de monitoreo";
    const FLOAT_TITLE = "Puntos de monitoreo";

    const FIXED_DESCRIPTION = "Estación de monitoreo fija";
    const FLOAT_DESCRIPTION = "Estación de monitoreo asociada";

    protected $fillable = [
        'name','hidrographic_unit','utm_zone','north','east','latitude','longitude', 'eca_id', 'eca_2_id', 'basin_id', 'reservoir_id', 'zone_id', 'user_created', 'type'
    ];

    public function samplings(){
        return $this->hasMany(Sampling::class);
    }
    public function pointNotes(){
        return $this->hasMany(PointNote::class);
    }
    public function zone(){
        return $this->belongsTo(Zone::class);
    }
    public function basin(){
        return $this->belongsTo(Basins::class);
    }
    public function reservoir(){
        return $this->belongsTo(Reservoir::class);
    }
    public function eca(){
        return $this->belongsTo(Eca::class);
    }
    public function transitionEca(){
        return $this->belongsTo(Eca::class, 'eca_2_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_created');
    }
}
