<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderdetail extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'clientorder_id',
        'installation_id',
        'revision_id',
        'cantidad',
        'unit_price_usd'
    ];

    public function installation()
    {
        return $this->belongsTo(Installation::class, 'installation_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function instalaciones()
    {
        return $this->hasMany(Installation::class, 'installation_id', 'code');
    }
}
