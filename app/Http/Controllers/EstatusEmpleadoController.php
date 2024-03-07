<?php

namespace App\Http\Controllers;

use App\Models\EstatusEmpleado;
use Illuminate\Http\Request;

class EstatusEmpleadoController extends Controller
{
    //Funcion que permite obtener todos los estatus de los empleados
    public function ObtenerEstatusEmpleados(){
        $EstatusEmpleados=EstatusEmpleado::all();
        return $EstatusEmpleados;
    }
    //Funcion que permite ver el estatus de un empleado por medio de su id
    //Parametros recibidos: id del empleado
    public function ObtenerEstatusEmpleadosPorID(String $id){
        $EstatusEmpleados=EstatusEmpleado::find($id);
        return $EstatusEmpleados;
    }
}
