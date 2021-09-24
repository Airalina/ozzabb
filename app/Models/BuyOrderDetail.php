<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyOrderDetail extends Model
{
    use HasFactory;

    public function materials()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
    public function buyorders()
    {
        return $this->belongsTo(BuyOrder::class,'buy_order_id');
    }

}
