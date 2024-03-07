<?php

namespace App\Http\Controllers;

use App\Models\bajasPersonal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class bajasPersonalController extends Controller
{
    /*Funcion que registra una baja de personal
        Parametros recibidos
        1. id del Personal a dar baja
    */
    public function store(Request $request){

        //Verificar si ya se habia dado de baja el alumno anteriormente
        $RegistroBajasAnterior=bajasPersonal::where('idPersonal',$request->input('idPersonal'))->get();

        if($RegistroBajasAnterior->isNotEmpty()){
            // La colección tiene al menos un registro --ya se ha dado de baja antes actualizar fecha de baja
            $registroActualizar = bajasPersonal::where('idPersonal', $request->input('idPersonal'))->first();
            date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico
            $FechaNueva=date("Y-m-d");
            $EstatusNuevo=$request->input('idEstatus');

            $registroActualizar->update([
                'FechaBaja' => $FechaNueva,
                'idEstatus'=>$EstatusNuevo
            ]);
        }
        else{
            $bajasPersonal=new bajasPersonal();
            $bajasPersonal->idPersonal=$request->input('idPersonal');
            $bajasPersonal->idEstatus=$request->input('idEstatus');

            date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico
            $bajasPersonal->FechaBaja=date("Y-m-d");
            $bajasPersonal->save();

        }
    }
    /* Funcion que elimina la baja de un personal
    Parametros recibidos
    1. id del Personal
    */
    public function delete(String $idPersonal){
        $registroEliminar = bajasPersonal::where('idPersonal', $idPersonal)->first();
        $registroEliminar->delete();
    }
    /*
    Funcion que permite obtener los registros de bajas entre dos determinadas fechas
        Parametros recibidos
        1. Fecha 1
        2. Fecha 2
    */
    public function ObtenerBajasEntreFechas($FechaInicio,$FechaFin){
        $Regitrosbajas = bajasPersonal::whereBetween('FechaBaja', [$FechaInicio, $FechaFin])->get();
        $Regitrosbajas=$Regitrosbajas->toArray();
        return $Regitrosbajas;
    }
}
