<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembled extends Model
{
    use HasFactory;

    public function depositmaterials()
    {
        return $this->hasMany(DepositMaterial::class,'material_id'); 
    }
}
