<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PucharsingSheet extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'count_orders', 'total_price'];

}
