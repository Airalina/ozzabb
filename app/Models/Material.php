<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\ProviderPrice;
use  App\Models\Line;
use  App\Models\Usage;
use  App\Models\Revisiondetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes, HasFactory;

    const COLORS = [
        1 => [
            'name' => 'Negro',
            'value' => 'black'
        ],
        2 => [
            'name' => 'Marrón',
            'value' => 'saddlebrown'
        ],
        3 => [
            'name' => 'Rojo',
            'value' => 'red'
        ],
        4 => [
            'name' => 'Naranja',
            'value' => 'orange'
        ],
        5 => [
            'name' => 'Amarillo',
            'value' => 'yellow'
        ],
        6 => [
            'name' => 'Verde',
            'value' => 'green'
        ],
        7 => [
            'name' => 'Azul',
            'value' => 'blue'
        ],
        8 => [
            'name' => 'Violeta',
            'value' => 'violet'
        ],
        9 => [
            'name' => 'Gris',
            'value' => 'grey'
        ],
        10 => [
            'name' => 'Blanco',
            'value' => 'black'
        ],
        11 => [
            'name' => 'Rosado',
            'value' => 'palevioletred'
        ],
        12 => [
            'name' => 'Verde claro',
            'value' => 'lightgreen'
        ],
        13 => [
            'name' => 'Celeste',
            'value' => 'cadetblue'
        ]
    ];

    const LINES = [
        1 => 'Bulldog',
        2 => 'Econoseal',
        3 => 'Ecu',
        4 => 'Fastin Faston',
        5 => 'Mini Fit',
        6 => 'Sicma',
        7 => 'Superseal'
    ];

    const USAGES = [
        1 => 'Motos',
        2 => 'General',
        3 => 'GNC',
        4 => 'Electro'
    ];

    const TYPES = [
        'Conectores' => 'connector',
        'Cables' => 'cable',
        'Terminales' =>  'terminal',
        'Sellos' =>  'seal',
        'Tubos' =>  'tube',
        'Accesorios' =>  'accessory',
        'Clips' =>  'clip'
    ];

    protected $fillable = ['code', 'name', 'stock', 'family', 'color', 'description', 'line', 'usage', 'replace_id', 'stock_min', 'stock_max', 'stock', 'image'], $photo;

    public function replace()
    {
        return $this->belongsTo(Material::class, 'replace_id');
    }
    public function getUrl($photo)
    {
        return url("storage/$photo");
    }
    public function revisiondetails()
    {
        return $this->hasMany(Revisiondetail::class);
    }

    public function providerprices()
    {
        return $this->hasMany(ProviderPrice::class);
    }

    public function buy_order_detail()
    {
        return $this->hasOne(BuyOrderDetail::class, 'material_id');
    }

    public function depositmaterials()
    {
        return $this->hasMany(DepositMaterial::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'deposit_materials', 'material_id', 'warehouse_id');
    }

    public function reservationmaterials()
    {
        return $this->hasMany(ReservationMaterial::class);
    }

    public function seals()
    {
        return $this->hasMany(Seal::class);
    }

    public function terminals()
    {
        return $this->hasMany(Terminal::class);
    }

    public function terminal()
    {
        return $this->hasOne(Terminal::class, 'material_id');
    }

    public function seal()
    {
        return $this->hasOne(Seal::class, 'material_id');
    }

    public function cable()
    {
        return $this->hasOne(Cable::class, 'material_id');
    }

    public function connector()
    {
        return $this->hasOne(Connector::class, 'material_id');
    }

    public function accessory()
    {
        return $this->hasOne(Accessory::class, 'material_id');
    }

    public function clip()
    {
        return $this->hasOne(Clip::class, 'material_id');
    }

    public function tube()
    {
        return $this->hasOne(Tube::class, 'material_id');
    }


    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'provider_prices', 'material_id', 'provider_id')
            ->whereNull('provider_prices.deleted_at')
            ->withTimestamps()
            ->withPivot(['id', 'deleted_at']);
    }

    public static function search($search = '', $orderBy  = 'code')
    {
        $querySearch = self::where('code', 'like', '%' . $search . '%')
            ->orderBy($orderBy);

        return $querySearch;
    }

    public static function scopeFamilyMaterials($query, $family)
    {
        return $query->where('family', $family)->has(self::TYPES[$family]);
    }

    public static function searchByFamily($materialQuery, $search = '', $orderBy = 'code')
    {
        $queryWhere = $materialQuery->where(function ($query) use ($search) {
            $query->orWhere('code', 'LIKE', '%' . $search . '%');
        })->orderBy($orderBy, 'asc')
            ->get();

        return $queryWhere;
    }
}
