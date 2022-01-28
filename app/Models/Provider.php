<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use  App\Models\ProviderPrice;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
     use SoftDeletes, HasFactory;

    protected $fillable = ['name','address','phone','email','contact_name','point_contact','site_url','status','cuit'];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }
    public function provider_prices(){
        return $this->hasMany(ProviderPrice::class); 
    }

    public function buyorders()
    {
        return $this->hasMany(BuyOrder::class);
    }
   
}
