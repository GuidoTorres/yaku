<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    const ACTIVE = 1;
    const INACTIVE = 2;

    const QUESTIONS = 5;

    protected $fillable = [
        'name', 'state',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }

    public static function encryptSurveyId($id){
        $uid = $id*13*37+165845;
        return $uid;
    }
    public static function decryptSurveyId($uid){
        $id = ($uid-165845)/(13*37);
        return $id;
    }
}
