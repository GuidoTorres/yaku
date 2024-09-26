<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignType extends Model
{
    const OTHER = 1;
    const SOCIAL_MEDIA = 2;
    const MAILING = 3;
    const SEM = 4;
    const SEO = 5;
    const REFERRED = 6;
    const CALLING = 7;

    protected $fillable = [
        'name'
    ];

    public function campaigns(){
        return $this->hasMany(Campaign::class);
    }



}
