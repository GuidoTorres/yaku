<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    const VERY_LOW = 1;
    const LOW = 2;
    const MEDIUM = 3;
    const HIGH = 4;
    const VERY_HIGH = 5;

    protected $fillable = [
        'name', 'code', 'company_id', 'opportunity_type_id','campaign_id',
        'user_owner_id','user_id','stage_id','company_contact_id',
        'budget','service_price','order','order_updated_at',
        'probability','closed_at','quotation','contract','work_order',
    ];

    public function getBudgetAttribute($value)
    {
        return number_format($value, 2, ".","'");
    }

    public function getServicePriceAttribute($value)
    {
        return number_format($value, 2, ".","'");
    }

    public static function boot(){
        parent::boot();

        static::updating(function (Opportunity $opportunity){
            if(! \App::runningInConsole()){

                $stage_old = $opportunity->getOriginal('stage_id');
                $stage_new = $opportunity->stage_id;

                $wasClosed =$stage_old == Stage::CLOSED_WON || $stage_old == Stage::CLOSED_LOST;
                $isClosedNow =$stage_new == Stage::CLOSED_WON || $stage_new == Stage::CLOSED_LOST;

                if($isClosedNow && !$wasClosed){
                    $opportunity->closed_at = now();
                }
            }
        });

    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function opportunityType(){
        return $this->belongsTo(OpportunityType::class);
    }
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    public function userOwner(){
        return $this->belongsTo(User::class, 'user_owner_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function stage(){
        return $this->belongsTo(Stage::class);
    }
    public function companyContact(){
        return $this->belongsTo(CompanyContact::class);
    }
    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function serviceTypes(){
        return $this
            ->belongsToMany(ServiceType::class)
            ->withTimestamps();
    }
    public function additionals(){
        return $this
            ->belongsToMany(Additional::class)
            ->withTimestamps();
    }
    public function stageTotal(){
        return $this->sum("service_price");
    }
}
