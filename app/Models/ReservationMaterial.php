<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationMaterial extends Model
{
    use SoftDeletes, HasFactory;

    public function reservationdeposit()
    {
        return $this->hasOne(ReservationDeposit::class, 'reservation_material_id');
    }

}
