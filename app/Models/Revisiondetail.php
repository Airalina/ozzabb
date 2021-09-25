<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;

class Revisiondetail extends Model
{
    use HasFactory;

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
