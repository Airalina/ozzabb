<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;

class Connector extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'terminal_id', 'seal_id', 'number_of_ways', 'type', 'connector_id', 'watertight', 'cover', 'lock'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

}
