<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installation extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'id',
        'code',
        'date',
        'date_admission',
        'usd_price',
        'hours_man',
    ];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
    public function revisiondetails()
    {
        return $this->hasMany(Revisiondetail::class);
    }
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'deposit_installations', 'installation_id', 'warehouse_id');
    }
    public function depositinstallations()
    {
        return $this->hasMany(DepositInstallation::class); 
    }
}
