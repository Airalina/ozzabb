<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReleaseOrderDetail extends Model
{
    use SoftDeletes, HasFactory;

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function material(){
        return $this->belongsTo(Material::class,'product_id'); 
    }

    public function assembled(){
        return $this->belongsTo(Assembled::class,'product_id'); 
    }

    public function installation(){
        return $this->belongsTo(Installation::class,'product_id'); 
    }

}
