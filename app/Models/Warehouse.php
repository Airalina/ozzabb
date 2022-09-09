<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Warehouse extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'description', 'location', 'create_date', 'state', 'type', 'temporary'];

    const TYPES = [
        1 => 'Almacén',
        2 => 'Producción',
        3 => 'Ensamblados',
        4 => 'Expedición'
    ];

    const STATES = [
        1 => 'Habilitado',
        2 => 'Lleno',
        3 => 'Deshabilidato',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'deposit_materials', 'warehouse_id', 'material_id')
            ->wherePivot('is_material', 1)
            ->withPivot(['id', 'amount', 'is_material', 'presentation', 'warehouse2_id', 'date_change']);
    }

    public function assembleds()
    {
        return $this->belongsToMany(Assembled::class, 'deposit_materials', 'warehouse_id', 'material_id')
            ->wherePivot('is_material', 0)
            ->withPivot(['id', 'amount', 'is_material', 'presentation', 'warehouse2_id', 'date_change'])
            ->groupBy('material_id')
            ->selectRaw('assembleds.*, SUM(deposit_materials.amount) as total_amount');
    }

    public function depositmaterials()
    {
        return $this->hasMany(DepositMaterial::class);
    }

    public function depositinstallations()
    {
        return $this->hasMany(DepositInstallation::class);
    }

    public function installations()
    {
        return $this->belongsToMany(Installation::class, 'deposit_installations', 'warehouse_id', 'installation_id')
            ->withPivot(['amount', 'serial_number', 'number_version', 'client_order_id'])
            ->groupBy('installation_id')
            ->selectRaw('installations.*, SUM(deposit_installations.amount) as total_amount');
    }

    public static function search($search = '', $orderBy = 'type')
    {
        $querySearch = self::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%')
            ->orWhere('location', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->orWhere('create_date', 'LIKE', '%' . $search . '%')
            ->orWhere('temporary', 'LIKE', '%' . $search . '%')->orderBy($orderBy);

        return $querySearch;
    }

    public static function searchWarehouses($search = '', $warehouseId, $types, $orderBy = 'type')
    {
        $querySearch = self::whereNotIn('id', [$warehouseId])
            ->whereIn('type', $types)
            ->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('location', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('create_date', 'LIKE', '%' . $search . '%')
                    ->orWhere('temporary', 'LIKE', '%' . $search . '%');
            });

        return $querySearch;
    }

    public function searchMaterialsDeposit($search = '')
    {
        $materials = $this->materials()
            ->where(function (Builder $query) use ($search) {
                return $query->where('code', 'LIKE', '%' . $search . '%');
            });

        return $materials;
    }

    public function searchAssembledsDeposit($search = '')
    {
        $assembleds = $this->assembleds()
            ->where(function (Builder $query) use ($search) {
                return $query->where('assembleds.id', 'LIKE', '%' . $search . '%')
                    ->orWhere('assembleds.description', 'LIKE', '%' . $search . '%');
            });

        return $assembleds;
    }

    public function searchInstallationsDeposit($search = '')
    {
        $installations = $this->installations()
            ->where(function (Builder $query) use ($search) {
                return $query->where('code', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });

        return $installations;
    }

    public function searchEntry($destiny, $productId, $productPresentation, $productAmount)
    {
        $entry = $this->depositmaterials()
            ->where('warehouse2_id', $destiny)
            ->where('material_id', $productId)
            ->where('presentation', $productPresentation)
            ->where('amount', $productAmount)
            ->whereType(1)
            ->first();

        return $entry;
    }

    public function findAmountInWarehouse()
    {
        $movements = $this->depositmaterials()
            ->select('*', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('is_material', 'presentation', 'material_id');

        return $movements;
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 40);
    }
}
