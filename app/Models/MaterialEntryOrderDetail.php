<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialEntryOrderDetail extends Model
{
    use SoftDeletes, HasFactory;
    public function materialentryorders()
    {
        return $this->belongsTo(MaterialEntryOrder::class, 'entry_order_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
