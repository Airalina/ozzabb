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
        'start_date',
        'buys',
        'date',
        'order_state',
        'order_job',
        'arp_price',
        'usd_price',
    ];

    const STATES = [
        1 => 'nuevo',
        2 => 'confirmado',
        3 => 'rechazado',
        4 => 'demorado',
        5 => 'produccion',
        6 => 'deposito'
    ];

    public function orderdetails()
    {
        return $this->hasMany(Orderdetail::class, 'clientorder_id');
    }

    public function installations()
    {
        return $this->belongsToMany(Installation::class, 'orderdetails', 'clientorder_id', 'installation_id')
            ->withPivot(['revision_id', 'cantidad'])
            ->wherePivot('revision_id', '<>', 0)
            ->withTimestamps();
    }

    public function domicile_deliveries()
    {
        return $this->belongsTo(DomicileDelivery::class, 'deliverydomicile_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public static function search($search = '', $dateSearch = '', $stateSearch = '', $orderBy  = 'id')
    {
        $querySearch = self::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('customer_id', 'LIKE', '%' . $search . '%')
            ->orWhere('customer_name', 'LIKE', '%' . $search . '%')
            ->orWhere('date', 'LIKE', '%' . $dateSearch . '%')
            ->orWhere('usd_price', 'LIKE', '%' . $search . '%')
            ->orWhere('arp_price', 'LIKE', '%' . $search . '%')
            ->orWhere('deadline', 'LIKE', '%' . $dateSearch . '%')
            ->orWhere('order_state', 'LIKE', '%' . $stateSearch . '%')
            ->orWhere('date', 'LIKE', '%' . $dateSearch . '%')
            ->orWhereDay('deadline', $search)
            ->orWhereMonth('deadline', $search)
            ->orWhereYear('deadline', $search)
            ->orWhere('buys', 'LIKE', '%' . $search . '%')
            ->orWhere('order_job', 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy);

        return $querySearch;
    }
}
