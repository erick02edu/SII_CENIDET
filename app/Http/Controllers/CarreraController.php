<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\PermisosCarreras;
use Illuminate\Http\Request;


class CarreraController extends Controller
{
    /* Funcion que permite obtener la listas de las carreras
    Parametros recibidos: Sin parametros
    Informacion devuelta: Lista completas de carreras
    */
    public function ObtenerCarreras(){
        $Carreras=Carrera::all();
        return $Carreras;
    }
    /*Parametros para obtener la informacion de una carrera por medio de su id
        Parametros recibidos:Id de la carrera
        Informacion devuelta: Informacion completa de la carrera
    */
    public function ObtenerCarreraPorID(String $id){
        $Carrera=Carrera::find ($id);
        return $Carrera;
    }

    /*Funcion que permite buscar una carrera
        Parametros recibidos:
            1. Cadena de texto utilizada para la busqueda
        Informacion devuelta
            1. Lista de carreras obtenidas de la busqueda
    */
    public function Buscar(Request $request){
        $Carrera=$request->input('Carrera');
        // $idUsuario=$request->input('idUsuario');
        $result=Carrera::
        whereRaw("CONCAT(Nivel,' en ',Nombre) LIKE ?",['%'.$Carrera.'%'])->
        get();
        return $result;
    }
}
