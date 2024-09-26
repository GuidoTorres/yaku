<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'company_name', 'fanpage', 'website',
        'email', 'phone', 'turn',
        'country_id', 'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function companyContacts(){
        return $this->hasMany(CompanyContact::class);
    }
    public function opportunities(){
        return $this->hasMany(Opportunity::class);
    }


}
