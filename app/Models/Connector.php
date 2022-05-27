<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connector extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['id','material_id', 'terminal_id', 'seal_id', 'number_of_ways', 'type', 'connector_id', 'watertight', 'cover', 'lock'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function terminals()
    {
        return $this->belongsToMany(Terminal::class);
    }

    public function seals()
    {
        return $this->belongsToMany(Seal::class);
    }

}
