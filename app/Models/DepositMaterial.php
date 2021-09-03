<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMaterial extends Model
{
    use HasFactory;

    public function materials()
    {
        return $this->belongsTo(Material::class,'material_id');
    }

    public function assembleds()
    {
        return $this->belongsTo(Assembled::class,'material_id');
    }
}
