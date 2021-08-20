<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id','code','name', 'stock', 'unit', 'presentation', 'usd_price', 'ars_price', 'family','color','description','line_id','usage_id','replace','stock_min','stock_max','stock'];

}
