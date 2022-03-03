<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderdetail extends Model
{
    use SoftDeletes, HasFactory;

    public function installations()
    {
        return $this->hasOne(Installation::class,'code','installation_id');
    }

    public function instalaciones()
    {
        return $this->hasMany(Installation::class,'code','installation_id');
    }
}
