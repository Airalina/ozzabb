<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revision extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'id',
        'number_version',
        'installation_id'
    ];

    public function installations()
    {
        return $this->belongsTo(Installation::class,'installation_id');
    }

    public function revisiondetails()
    {
        return $this->hasMany(Revisiondetail::class,'installation_id','installation_id');
    }
}
