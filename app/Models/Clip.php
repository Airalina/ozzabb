<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    use HasFactory;

    
    protected $fillable = ['material_id', 'type', 'long', 'width', 'hole_diameter'];
}
