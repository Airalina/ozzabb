<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'domicile_admin',
        'contact',
        'post_contact',
        'email',
        'estado',
        
    ];

    public function domiciledeliveries()
    {
        return $this->hasMany(DomicileDelivery::class ,'cliente_id');
    }

    public function clientorders()
    {
        return $this->hasMany(Clientorder::class, 'customer_id');
    }
}
