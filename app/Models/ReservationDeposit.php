<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDeposit extends Model
{
    use HasFactory;

    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'deposit_id'); 
    }
}
