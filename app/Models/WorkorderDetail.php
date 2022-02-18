<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workorderdetail extends Model
{
    use SoftDeletes, HasFactory;
    
    public function material(){
        return $this->belongsTo(Material::class);
    }
}
