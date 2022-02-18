<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['material_id','name'];
   
    public function material(){
        return $this->belongsTo(Material::class); 
    }
}
