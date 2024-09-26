<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'last_name', 'cellphone', 'email'
        , 'email_verified_at', 'password', 'state',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const DEVELOPER = 1;

    const ACTIVE = 1;
    const INACTIVE = 2;


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public static function navigation(){
        return auth()->check() ? auth()->user()->role->name : 'guest';
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function companies(){
        return $this->hasMany(Company::class);
    }
    public function companyContacts(){
        return $this->hasMany(CompanyContact::class, 'user_id');
    }
    public function companyContactsOwn(){
        return $this->hasMany(CompanyContact::class, 'user_owner_id');
    }
    public function activities(){
        return $this->hasMany(Activity::class);
    }
    public function pointNotes(){
        return $this->hasMany(PointNote::class);
    }
    public function parameters()
    {
        return $this->belongsToMany(Parameter::class)->withTimestamps();
    }

}
