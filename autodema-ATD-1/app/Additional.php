<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Additional extends Model
{
    //SERVICES
    ////WEB DESIGN
    const WD_LOGO_DESIGN = 1;
    const WD_SEO = 2;
    const WD_SEM = 3;

    ////E_COMMERCE
    const CE_LOGO_DESIGN = 4;
    const CE_SEO = 5;
    const CE_SEM = 6;

    ////CORPORATE_WEB
    const CW_LOGO_DESIGN = 7;
    const CW_SEO = 8;
    const CW_SEM = 9;

    ////INSTITUTIONAL_WEB
    const IW_LOGO_DESIGN = 10;
    const IW_SEO = 11;
    const IW_SEM = 12;

    ////SEO_SEM
    const SS_SUBSCRIPTION = 13;

    ////WEB_SYSTEM
    const WS_LOGO_DESIGN = 14;
    const WS_SEO = 15;
    const WS_SEM = 16;

    ////VIRTUAL_ELECTION
    const VE_WHATSAPP = 17;
    const VE_SMS = 18;

    ////WEB_MAINTENANCE_PLAN

    ////WEB_MAINTENANCE

    ////BRANDING

    ////LOGO_DESIGN


    protected $fillable = [
        'name', 'description', 'price', 'service_type_id'
    ];

    public function serviceType(){
        return $this->belongsTo(ServiceType::class);
    }

    public function opportunities(){
        return $this
            ->belongsToMany(Opportunity::class)
            ->withTimestamps();
    }

}
