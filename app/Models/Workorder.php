<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'start_date', 'end_date', 'hours', 'man','hours_man_required'];
    
    public function workorder_orders(){
        return $this->hasMany(ClientorderWorkorder::class);
    }
    public function workorder_details(){
        return $this->hasMany(WorkorderDetail::class);
    }
    public function reservationmaterials(){
        return $this->hasMany(ReservationMaterial::class);
    }
}
