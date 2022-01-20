<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationMaterial extends Model
{
    use HasFactory;

    public function reservationdeposit()
    {
        return $this->hasOne(ReservationDeposit::class, 'reservation_material_id');
    }

}
