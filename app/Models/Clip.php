<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clip extends Model
{
    use SoftDeletes, HasFactory;

    CONST TYPES = ['Clip', 'Precinto'];

    protected $fillable = ['material_id', 'type', 'long', 'width', 'hole_diameter'];

}
