<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PucharsingSheetDetail extends Model
{
    use HasFactory;

    protected $fillable = ['pucharsing_sheet_id','material_id','amount','presentation','provider_id'];

}
