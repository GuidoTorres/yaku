<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    const WEB_DESIGN = 1;
    const E_COMMERCE = 2;
    const CORPORATE_WEB = 3;
    const INSTITUTIONAL_WEB = 4;
    const SEO_SEM = 5;
    const WEB_SYSTEM = 6;
    const VIRTUAL_ELECTION = 7;
    const WEB_MAINTENANCE_PLAN = 8;
    const WEB_MAINTENANCE = 9;
    const BRANDING = 10;
    const LOGO_DESIGN = 11;

    protected $fillable = [
        'name', 'description', 'price',
    ];
    /**
     * Get the serviceType's price.
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ".","'");
    }

    public function additionals(){
        return $this
            ->hasMany(Additional::class);
    }

    public function opportunities(){
        return $this
            ->belongsToMany(Opportunity::class)
            ->withTimestamps();
    }
}
