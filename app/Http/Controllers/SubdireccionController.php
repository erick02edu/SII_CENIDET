<?php

namespace App\Http\Controllers;

use App\Models\subdireccion;
use Illuminate\Http\Request;

class SubdireccionController extends Controller
{
    /* Funcion para obtener la lista de subdirecciones
    Parametro recibidos: Sin parametros
    Informacion devuelta: Lista completa de subdirecciones */
    public function ObtenerSubdirecciones(){
        $subdireccion=subdireccion::all();
        return $subdireccion;
    }
}
