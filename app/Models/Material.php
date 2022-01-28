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

    protected $fillable = ['code','name', 'stock', 'family','color','description','line','usage','replace_id','stock_min','stock_max','stock','image'], $photo;
    
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

    public function buy_order_detail()
    {
        return $this->hasOne(BuyOrderDetail::class, 'material_id');
    }

    public function depositmaterials()
    {
        return $this->hasMany(DepositMaterial::class); 
    }
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'deposit_materials', 'material_id', 'warehouse_id');
    }
    public function reservationmaterials()
    {
        return $this->hasMany(ReservationMaterial::class); 
    }
    
    public function cable()
    {
        return $this->hasOne(Cable::class, 'material_id');
    }
}
