<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{


    protected $fillable = [
        'activity_type_id', 'opportunity_id', 'company_contact_id','name',
        'description','did_at','user_id',
    ];


    public function activityType(){
        return $this->belongsTo(ActivityType::class);
    }
    public function companyContact(){
        return $this->belongsTo(CompanyContact::class);
    }
    public function opportunity(){
        return $this->belongsTo(Opportunity::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
