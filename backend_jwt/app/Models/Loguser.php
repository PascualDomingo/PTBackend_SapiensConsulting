<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loguser extends Model
{
    use HasFactory;

    protected $table = 'loguser';

    protected $fillable = [
        'user_id',
        'tipo_evento',
        'descripcion',
    ];
}
