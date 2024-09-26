<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = [
        'option_id',
    ];

    public function option(){
        return $this->belongsTo(Option::class);
    }
}
