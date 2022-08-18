<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terminal extends Model
{
    use SoftDeletes, HasFactory;

    const MATERIALS = ['Latón', 'Estañado'];
    const TYPES = ['Macho', 'Hembra', 'Ojal'];

    protected $fillable = ['material_id', 'size', 'minimum_section', 'maximum_section', 'material', 'type'];


    public function connectors()
    {
        return $this->belongsToMany(Connector::class)->withTimestamps();
    }

    public function materialId()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

}
