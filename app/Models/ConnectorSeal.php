<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectorSeal extends Model
{
    use HasFactory;
    protected $table="connector_seal";
    protected $fillable = ['connector_id','seal_id'];
}
