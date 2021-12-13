<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpendOrderDetail extends Model
{
    use HasFactory;

    public function expendorders()
    {
        return $this->belongsTo(ExpendOrder::class,'expend_order_id');
    }

    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }
    public function materials()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
