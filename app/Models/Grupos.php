<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['Semestre','Especialidad','Letra'];
}
