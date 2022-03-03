<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\BuyOrder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialEntryOrder extends Model
{
    use SoftDeletes, HasFactory;

    public function materialentryorderdetails()
    {
        return $this->hasMany(MaterialEntryOrderDetail::class, 'entry_order_id');
    }

    public function buyorders()
    {
        return $this->belongsToMany(MaterialEntryOrder::class,'buy_order_material_entry_orders','buy_order_id','entry_order_id');
    }
    public function buy_order()
    {
        return $this->belongsTo(BuyOrder::class, 'buy_order_id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
   
    
}
