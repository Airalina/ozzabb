<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialEntryOrder extends Model
{
    use HasFactory;

    public function materialentryorderdetails()
    {
        return $this->hasMany(MaterialEntryOrderDetail::class, 'entry_order_id');
    }

    public function buyorders()
    {
        return $this->belongsToMany(MaterialEntryOrder::class,'buy_order_material_entry_orders','buy_order_id','entry_order_id');
    }
}
