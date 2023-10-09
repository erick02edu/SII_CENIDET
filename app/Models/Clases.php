<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clases extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['HInicio','HFin','dia','color','idMateria','idAula','idGrupo','idHorario'];
}
