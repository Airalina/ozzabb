<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\ProviderPrice;
use  App\Models\Line;
use  App\Models\Usage;
use  App\Models\Revisiondetail;


class Material extends Model
{
    use HasFactory;

    protected $fillable = ['code','name', 'stock', 'family','color','description','line_id','usage_id','replace_id','stock_min','stock_max','stock','image'], $photo;
    
    public function provider_prices()
    {
        return $this->hasMany(ProviderPrice::class); 
    }
    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id');
    }
    public function usage()
    {
        return $this->belongsTo(Usage::class, 'usage_id');
    }
    public function material()
    {
        return $this->belongsTo(Material::class, 'replace_id');
    }
    public function getUrl($photo)
    {
        return url("storage/$photo");
    }
    public function revisiondetails()
    {
        return $this->hasMany(Revisiondetail::class); 
    }
    public function providerprices()
    {
        return $this->hasMany(ProviderPrice::class); 
    }
}
