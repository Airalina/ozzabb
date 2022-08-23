<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seal extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['material_id', 'minimum_diameter', 'maximum_diameter', 'type'];
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
    public function connectors()
    {
        return $this->belongsToMany(Connector::class);
    }

}
