<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tube extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'type', 'diameter', 'wall_thickness', 'contracted_diameter', 'minimum_temperature', 'maximum_temperature'];
    
}
