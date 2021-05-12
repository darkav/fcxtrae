<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'compania_id',
        'tipodoc_id',
        'nombre',
        'documento',
        'estado'
    ];
}
