<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $fillable = [
        'name', 'order', 'order_updated_at', 'survey_id',
    ];


    public function survey(){
        return $this->belongsTo(Survey::class);
    }
    public function options(){
        return $this->hasMany(Option::class);
    }
}
