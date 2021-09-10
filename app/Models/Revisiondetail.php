<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisiondetail extends Model
{
    use HasFactory;

    public function materials()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
