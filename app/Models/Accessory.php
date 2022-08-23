<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessory extends Model
{
    use SoftDeletes, HasFactory;

    CONST TYPES = ['Tapa de conector', 'Fusible', 'Relay', 'Tapón ciego', 'Pasante de goma', 'Portafusible', 'Moldeado'];

    protected $fillable = ['material_id', 'type'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
}
