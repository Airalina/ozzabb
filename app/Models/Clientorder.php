<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientorder extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = ['deadline'];
    protected $fillable = [
        'customer_id',
        'customer_name',
        'deliverydomicile_id',
        'deadline',
        'date',
        'order_state',   
    ];

    public function orderdetails()
    {
        return $this->hasMany(Orderdetail::class, 'clientorder_id');
    }
}
