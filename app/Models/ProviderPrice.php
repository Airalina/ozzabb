<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use  App\Models\Provider;

class ProviderPrice extends Model
{
    use HasFactory;
    protected $fillable = ['material_id','provider_id','amount','unit','presentation','usd_price','ars_price','code','name'];
   
    public function material(){
        return $this->belongsTo(Material::class); 
    }

    public function provider(){
        return $this->belongsTo(Provider::class); 
    }
    public function price(){
        return $this->hasMany(Price::class); 
    }
}
