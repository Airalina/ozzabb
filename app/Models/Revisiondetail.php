<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;

class Revisiondetail extends Model
{
    use HasFactory;

    public function materials()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
    
}
