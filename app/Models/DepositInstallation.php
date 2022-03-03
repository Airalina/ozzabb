<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositInstallation extends Model
{
    use SoftDeletes, HasFactory;

    public function revisions()
    {
        return $this->belongsTo(Revision::class,'installation_id');
    }

    public function installation()
    {
        return $this->belongsTo(installation::class,'installation_id');
    }
}
