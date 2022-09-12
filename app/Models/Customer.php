<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'cuit'
    ];

    public function domiciledeliveries()
    {
        return $this->hasMany(DomicileDelivery::class, 'client_id');
    }

    public function clientorders()
    {
        return $this->hasMany(Clientorder::class, 'customer_id');
    }

    public function installations()
    {
        return $this->hasMany(Installation::class, 'customer_id');
    }

    public static function search($search = '', $orderBy  = 'name')
    {
        $querySearch = self::where('name', 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy);

        return $querySearch;
    }

    public function orders()
    {
        return $this->belongsToMany(DomicileDelivery::class, 'clientorders', 'customer_id', 'deliverydomicile_id')
            ->withTimestamps();
    }

    public static function searchList($search = '', $orderBy  = 'name')
    {
        $querySearch = self::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('domicile_admin', 'LIKE', '%' . $search . '%')
            ->orWhere('id', 'LIKE', '%' . $search . '%')
            ->orWhere('phone', 'LIKE', '%' . $search . '%')
            ->orWhere('contact', 'LIKE', '%' . $search . '%')
            ->orWhere('post_contact', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy);

        return $querySearch;
    }

    public function searchInstallations($search = '')
    {
        $installations = $this->installations()
            ->where(function (Builder $query) use ($search) {
                return $query->where('code', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });

        return $installations;
    }
}
