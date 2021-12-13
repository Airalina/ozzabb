<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'activo',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
