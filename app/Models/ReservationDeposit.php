<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationDeposit extends Model
{
    use SoftDeletes, HasFactory;

    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'deposit_id'); 
    }
}
