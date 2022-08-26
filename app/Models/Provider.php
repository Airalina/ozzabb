<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;
use  App\Models\ProviderPrice;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'address', 'phone', 'email', 'contact_name', 'point_contact', 'site_url', 'status', 'cuit'];

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'provider_prices', 'provider_id', 'material_id')
            ->whereNull('provider_prices.deleted_at')
            ->withTimestamps()
            ->withPivot(['id', 'deleted_at']);
    }

    public function provider_prices()
    {
        return $this->hasMany(ProviderPrice::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function buyorders()
    {
        return $this->hasMany(BuyOrder::class);
    }

    public static function search($search = '', $orderBy = 'id')
    {
        $querySearch = self::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('address', 'LIKE', '%' . $search . '%')
            ->orWhere('phone', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhere('contact_name', 'LIKE', '%' . $search . '%')
            ->orWhere('point_contact', 'LIKE', '%' . $search . '%')
            ->orWhere('site_url', 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy);

        return $querySearch;
    }
}
