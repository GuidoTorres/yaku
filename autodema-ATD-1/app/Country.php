<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name', 'code'
    ];


    public function companies(){
        return $this->hasMany(Company::class);
    }
}
