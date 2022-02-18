<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tube extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['material_id', 'type', 'diameter', 'wall_thickness', 'contracted_diameter', 'minimum_temperature', 'maximum_temperature'];
    
}
