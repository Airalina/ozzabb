<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientorderWorkorder extends Model
{
    use HasFactory;

    public function clientorder(){
        return $this->belongsTo(Clientorder::class);
    }

}