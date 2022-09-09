<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assembled extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['create_date', 'description'];

    public function depositmaterials()
    {
        return $this->hasMany(DepositMaterial::class, 'material_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'deposit_materials', 'material_id', 'warehouse_id')
        ->wherePivot('is_material', 0)
        ->withPivot('amount')
        ->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'assembled_details', 'assembled_id', 'material_id')
        ->withPivot('amount')
        ->withTimestamps();
    }

    public static function search($search = '')
    {
        $querySearch = self::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%');

        return $querySearch;
    }
}
