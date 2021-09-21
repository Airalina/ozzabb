<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialEntryOrder extends Model
{
    use HasFactory;

    public function materialentryorderdetails()
    {
        return $this->hasMany(MaterialEntryOrderDetail::class, 'entry_order_id');
    }
}
