<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PucharsingSheetOrder extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['pucharsing_sheet_id','clientorder_id'];

    public function clientorder(){
        return $this->belongsTo(Clientorder::class);
    }
}
