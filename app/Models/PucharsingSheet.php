<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\PucharsingSheetOrder;
use  App\Models\PucharsingSheetDetail;
use  App\Models\BuyOrder;

class PucharsingSheet extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'count_orders', 'total_price'];
    public function purchasing_sheet_orders(){
        return $this->hasMany(PucharsingSheetOrder::class);
    }
    public function purchasing_sheet_details(){
        return $this->hasMany(PucharsingSheetDetail::class);
    }
    public function buyorders(){
        return $this->hasMany(BuyOrder::class);
    }
}
