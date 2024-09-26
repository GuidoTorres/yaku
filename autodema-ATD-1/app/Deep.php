<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deep extends Model
{
    protected $fillable = [
        'name'
    ];

    public function samplings(){
        return $this->hasMany(Sampling::class);
    }
}
