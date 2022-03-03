<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReleaseOrder extends Model
{
    use SoftDeletes, HasFactory;

    public function materialreleaseorderdetails()
    {
        return $this->hasMany(MaterialReleaseOrderDetail::class);
    }
}
