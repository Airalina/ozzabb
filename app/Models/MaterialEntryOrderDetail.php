<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialEntryOrderDetail extends Model
{
    use HasFactory;
    public function materialentryorders()
    {
        return $this->belongsTo(MaterialEntryOrder::class, 'entry_order_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
