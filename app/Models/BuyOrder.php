<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Provider;
use  App\Models\Material;

class BuyOrder extends Model
{
    use HasFactory;
    protected $dates = ['buy_date'];

    public function materialentryorders()
    {
        return $this->belongsToMany(MaterialEntryOrder::class,'buy_order_material_entry_orders','buy_order_id','entry_order_id');
    }

    public function buyorderdetails()
    {
        return $this->hasMany(BuyOrderDetail::class,'id','buy_order_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
