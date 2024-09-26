<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    const CONTACT_INITIATED = 1;
    const FIRST_MEETING = 2;
    const PROPOSE_SENT = 3;
    const PRICES_NEGOTIATION = 4;
    const CLOSED_WON = 5;
    const CLOSED_LOST = 6;

    protected $fillable = [
        'name', 'order',
    ];

    public function opportunities(){
        return $this->hasMany(Opportunity::class);
    }

}
