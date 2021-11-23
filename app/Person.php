<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $table = "persona";

    //
    protected $fillable = [
        'nombre', 
        'departamento',
        'municipio', 
        'localidad',
        'tipo_persona',
        'tipo_cargo',
        'anos_activo'
    ];

    public $timestamps = false;
}
