<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revisiondetail extends Model
{
    use SoftDeletes, HasFactory;    
    
    protected $fillable = [
        'id',
        'number_version',
        'installation_id',
        'material_id',
        'amount',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
    
}
