<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table ='calificaciones';
    protected $fillable=['idAlumno','idMateria','Calificacion','NumSemestre','idProfesor'];
}
