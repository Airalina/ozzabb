<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
    use HasFactory;
    protected $fillable = ['section','base_color','line_color', 'braid_configuration', 'norm', 'number_of_unipolar', 'mesh_type', 'operating_temperature', 'material_id'];

}
