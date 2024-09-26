<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpportunityType extends Model
{
    const NEW_CUSTOMER = 1;
    const EXISTING_CUSTOMER = 2;

    protected $fillable = [
        'name'
    ];

    public function opportunities(){
        return $this->hasMany(Opportunity::class);
    }
}
