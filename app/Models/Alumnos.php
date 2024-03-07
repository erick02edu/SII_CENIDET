<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d';
    protected $dates = [
        'FechaNac',
    ];
    protected $fillable=["Nombre","ApellidoP","ApellidoM","FechaNac","noControl","curp","Direccion","Genero","Telefono","idGrupo",'idCarrera'];

}
