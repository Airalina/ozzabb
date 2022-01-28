<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\ProviderPrice;
use  App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['provider_price_id','price_id','provider_id','date','code','name', 'price'];
    
    public function provider_price(){
        return $this->belongsTo(ProviderPrice::class); 
    }
    public function provider(){
        return $this->belongsTo(Provider::class); 
    }
}
