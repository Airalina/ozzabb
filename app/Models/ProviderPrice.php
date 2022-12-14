<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use  App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderPrice extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['material_id','provider_id','amount','unit','presentation','provider_code','usd_price','ars_price','code','name'];
   
    public function material(){
        return $this->belongsTo(Material::class); 
    }

    public function provider(){
        return $this->belongsTo(Provider::class); 
    }
    public function prices(){
        return $this->hasMany(Price::class); 
    }
}
