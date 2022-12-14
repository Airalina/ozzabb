<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositMaterial extends Model
{
    use SoftDeletes, HasFactory;

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }

    public function assembled()
    {
        return $this->belongsTo(Assembled::class,'material_id');
    }

    public function warehouse2()
    {
        return $this->belongsTo(Warehouse::class,'warehouse2_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }
}
