<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\ProviderPrice;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id','date','code','name', 'stock', 'family','color','description','line_id','usage_id','replace','stock_min','stock_max','stock'];
    
    public function provider_prices(){
        return $this->hasMany(ProviderPrice::class); 
    }

}
