<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    const PRINCIPAL = 1;
    const SECONDARY = 2;

    protected $fillable = [
        'name', 'last_name', 'cellphone', 'email',
        'principal', 'company_id', 'user_owner_id', 'user_id',
    ];

    public static function boot(){
        parent::boot();

        static::updating(function (CompanyContact $companyContact){
            if(! \App::runningInConsole()){

                if($companyContact->principal == CompanyContact::PRINCIPAL){
                    //UPDATE ALL COMPANY CONTACTS
                    $company_id = $companyContact->company_id;
                    CompanyContact::where('company_id', $company_id)->update(['principal' => CompanyContact::SECONDARY]);
                    //UPDATE PRINCIPAL
                    //$companyContact->principal = CompanyContact::PRINCIPAL;
                }


            }
        });

    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userOwner(){
        return $this->belongsTo(User::class, 'user_owner_id');
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function activities(){
        return $this->hasMany(Activity::class);
    }

}
