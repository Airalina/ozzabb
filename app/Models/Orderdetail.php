<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    use HasFactory;

    public function installations()
    {
        return $this->hasOne(Installation::class,'code','installation_id');
    }

    public function instalaciones()
    {
        return $this->hasMany(Installation::class,'code','installation_id');
    }
}
