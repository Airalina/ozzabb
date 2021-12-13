<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;

class BuyOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'presentation','buy_order_id','amount','presentation_price','total_price'];
    
    public function material(){
        return $this->belongsTo(Material::class); 
    }
    public function buyorders()
    {
        return $this->belongsTo(BuyOrder::class,'buy_order_id');
    }
    public function materials()
    {
        return $this->belongsTo(Material::class,'material_id');
    }


}
