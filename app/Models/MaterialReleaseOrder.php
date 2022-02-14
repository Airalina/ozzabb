<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialReleaseOrder extends Model
{
    use HasFactory;

    public function materialreleaseorderdetails()
    {
        return $this->hasMany(MaterialReleaseOrderDetail::class);
    }
}
