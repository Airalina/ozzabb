<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositInstallation extends Model
{
    use HasFactory;

    public function revisions()
    {
        return $this->belongsTo(Revision::class,'installation_id');
    }
}
