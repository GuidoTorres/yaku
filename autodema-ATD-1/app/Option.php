<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    const WAY_BELOW_MEAN = 1;
    const BELOW_MEAN = 2;
    const MEAN = 3;
    const ABOVE_MEAN = 4;
    const WAY_ABOVE_MEAN = 5;



    protected $fillable = [
        'type', 'question_id',
    ];


    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
