<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'code',
        'date',
        'date_admission',
        'usd_price',
        'hours_man',
    ];
    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
    public function revisiondetails()
    {
        return $this->hasMany(Revisiondetail::class);
    }
}
