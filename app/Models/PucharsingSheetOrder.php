<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PucharsingSheetOrder extends Model
{
    use HasFactory;

    protected $fillable = ['pucharsing_sheet_id','clientorder_id'];
}
