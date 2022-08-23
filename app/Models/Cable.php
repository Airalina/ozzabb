<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cable extends Model
{
    use SoftDeletes, HasFactory;

    const CONFIGURATIONS = ['16 x 30 mm', '34 x 20 mm', '7 x 0.25 mm', '16 x 0.20 mm'];
    const NORMS = ['Iram 247-5', 'Iram 247-3', 'IR', 'ID', 'Blindado', 'Multifilar'];

    protected $fillable = ['section', 'base_color', 'line_color', 'braid_configuration', 'norm', 'number_of_unipolar', 'mesh_type', 'operating_temperature', 'material_id'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
}
