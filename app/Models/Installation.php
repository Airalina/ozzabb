<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Installation extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'id',
        'code',
        'date',
        'date_admission',
        'description',
        'usd_price',
        'hours_man',
        'customer_id'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
        return $this->belongsToMany(Warehouse::class, 'deposit_installations', 'installation_id', 'warehouse_id')->withTimestamps();
    }

    public function depositinstallations()
    {
        return $this->hasMany(DepositInstallation::class);
    }

    public static function search($search = '', $orderBy = 'code')
    {
        $querySearch = self::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('code', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy);

        return $querySearch;
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 40);
    }

    public function findRevisionsDetail(int $number_version)
    {
        $revisionsDetails = $this->revisiondetails()->where('number_version', $number_version)->get();
        return $revisionsDetails;
    }

    public function searchRevisions($search = '', $orderBy = 'number_version')
    {
        $query = $this->revisions()->where(function (Builder $query) use ($search) {
            return $query->whereId($search)
                ->orWhere('number_version', $search)
                ->orWhere('reason', $search);
        })->orderBy($orderBy, 'asc');

        return $query;
    }
}
