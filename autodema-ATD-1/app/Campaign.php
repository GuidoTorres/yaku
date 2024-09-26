<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 2;

    protected $fillable = [
        'name', 'state', 'campaign_type_id', 'user_id',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function campaignType(){
        return $this->belongsTo(CampaignType::class);
    }
    public function opportunities(){
        return $this->hasMany(Opportunity::class);
    }

}
