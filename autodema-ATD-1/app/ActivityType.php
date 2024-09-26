<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    const CALL = 1;
    const MESSENGER = 2;
    const VIRTUAL_MEETING = 3;
    const F2F_MEETING = 4;
    const EMAIL = 5;

    protected $fillable = [
        'name', 'icon'
    ];

    public function activities(){
        return $this->hasMany(Activity::class);
    }

}
