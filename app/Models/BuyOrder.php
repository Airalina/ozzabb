<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Provider;
use  App\Models\Material;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyOrder extends Model
{
    use SoftDeletes, HasFactory;
    protected $dates = ['buy_date'];

    public function materialentryorders()
    {
        return $this->belongsToMany(MaterialEntryOrder::class, 'buy_order_material_entry_orders', 'buy_order_id', 'entry_order_id');
    }

    public function buyorderdetails()
    {
        return $this->hasMany(BuyOrderDetail::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function entry()
    {
        return $this->hasMany(MaterialEntryOrder::class, 'buy_order_id');
    }

    public static function search($search = '', $orderBy  = 'state')
    {
        $querySearch = self::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('provider_id', 'LIKE', '%', $search . '%')
            ->orWhere('order_number', 'LIKE', '%', $search . '%')
            ->orWhere('pucharsing_sheet_id', 'LIKE', '%', $search . '%')
            ->orWhere('order_number', 'LIKE', '%', $search . '%')
            ->orWhere('state', 'LIKE', '%', $search . '%')->orderByDesc($orderBy);
        return $querySearch;
    }
}
