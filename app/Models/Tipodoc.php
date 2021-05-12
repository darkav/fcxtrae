<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipodoc extends Model
{
    use HasFactory;

    protected $fillable =[
        'nombre',
        'version',
        'dir_xsd'
    ];
}
