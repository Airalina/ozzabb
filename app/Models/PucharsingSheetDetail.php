<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PucharsingSheetDetail extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['pucharsing_sheet_id','material_id','amount','presentation','provider_id'];
    
    public function materials()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    public function providers()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function material(){
        return $this->belongsTo(Material::class);
    }
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
}
