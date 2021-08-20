<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Material;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name','address','phone','email','contact_name','point_contact','site_url','status'];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

}
