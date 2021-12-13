<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

   
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'deposit_materials', 'warehouse_id', 'material_id');
    }

    public function assembleds()
    {
        return $this->belongsToMany(Assembled::class, 'deposit_materials', 'warehouse_id', 'material_id');
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
        return $this->belongsToMany(Installation::class, 'deposit_installations', 'warehouse_id', 'installation_id');
    }

}
