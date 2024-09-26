<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name','description',
    ];

    const ADMINISTRATOR = 1;
    const SUPERVISOR = 2;
    const ANALYST = 3;
    const VISUALIZER = 4;
    const VISITOR = 5;

    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class);
    }
    public function parameters(){
        return $this->belongsToMany(Parameter::class)->withTimestamps();
    }
}
