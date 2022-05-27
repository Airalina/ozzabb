<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectorTerminal extends Model
{
    use HasFactory;
    protected $table="connector_terminal";
    protected $fillable = ['connector_id','terminal_id'];
}
