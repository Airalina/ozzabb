<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;

class Terminal extends Model
{
    use HasFactory;
    protected $fillable = ['material_id','size','minimum_section','maximum_section', 'material', 'type'];

    public function material_info()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
