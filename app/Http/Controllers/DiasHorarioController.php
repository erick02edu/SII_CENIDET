<?php

namespace App\Http\Controllers;

use App\Models\DiasHorario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DiasHorarioController extends Controller
{
    /*Funcion que registra lo informacion de los dias de un horario de tipo asdministrativo
    Parametros recibidos
    1. id del horario para registrar los dias
    2. Informacion de los dias del horario del dia Lunes (HInicio,HFin)
    3. Informacion de los dias del horario del dia Martes (HInicio,HFin)
    4. Informacion de los dias del horario del dia Miercoles (HInicio,HFin)
    5. Informacion de los dias del horario del dia Jueves (HInicio,HFin)
    6. Informacion de los dias del horario del dia Viernes (HInicio,HFin)
    */
    public function store(Request $request){
        $idHorario = $request->input('idHorario');
        $DiasEliminar = DiasHorario::where('idHorario', $idHorario)->get();
        //Eliminar dias
        if(count($DiasEliminar)!=0){
            foreach($DiasEliminar as $dias){
                $dias->delete();
            }
        }
        try{
            //Registrar el dia de lunes
            $nuevosDiasLunes = $request->input('NuevoDiaLunes');
            if($nuevosDiasLunes!=null){
                foreach ($nuevosDiasLunes as $dia) {
                    $Dia=new DiasHorario();
                    $Dia->HInicio=$dia['HInicio'];
                    $Dia->HFin=$dia['HFin'];
                    $Dia->dia=$dia['dia'];
                    $Dia->idHorario=$idHorario;
                    $Dia->save();
                }
            }
            //Registrar el dia de martes
            $nuevosDiasMartes = $request->input('NuevoDiaMartes');
            if($nuevosDiasMartes!=null){
                foreach ($nuevosDiasMartes as $dia) {
                    $Dia=new DiasHorario();
                    $Dia->HInicio=$dia['HInicio'];
                    $Dia->HFin=$dia['HFin'];
                    $Dia->dia=$dia['dia'];
                    $Dia->idHorario=$idHorario;
                    $Dia->save();
                }
            }
            //Registrar el dia de miercoles
            $nuevosDiasMiercoles = $request->input('NuevoDiaMiercoles');
            if($nuevosDiasMiercoles!=null){
                foreach ($nuevosDiasMiercoles as $dia) {
                    $Dia=new DiasHorario();
                    $Dia->HInicio=$dia['HInicio'];
                    $Dia->HFin=$dia['HFin'];
                    $Dia->dia=$dia['dia'];
                    $Dia->idHorario=$idHorario;
                    $Dia->save();
                }
            }
            //Registrar el dia de jueves
            $nuevosDiasJueves = $request->input('NuevoDiaJueves');
            if($nuevosDiasJueves!=null){
                foreach ($nuevosDiasJueves as $dia) {
                    $Dia=new DiasHorario();
                    $Dia->HInicio=$dia['HInicio'];
                    $Dia->HFin=$dia['HFin'];
                    $Dia->dia=$dia['dia'];
                    $Dia->idHorario=$idHorario;
                    $Dia->save();
                }
            }
            //Registrar el dia de Viernes
            $nuevosDiasViernes = $request->input('NuevoDiaViernes');
            if($nuevosDiasViernes!=null){
                foreach ($nuevosDiasViernes as $dia) {
                    $Dia=new DiasHorario();
                    $Dia->HInicio=$dia['HInicio'];
                    $Dia->HFin=$dia['HFin'];
                    $Dia->dia=$dia['dia'];
                    $Dia->idHorario=$idHorario;
                    $Dia->save();
                }
            }
            //Registrar el dia de Sabado
            $nuevosDiasSabado = $request->input('NuevoDiaSabado');
            if($nuevosDiasSabado!=null){
                foreach ($nuevosDiasSabado as $dia) {
                    $Dia=new DiasHorario();
                    $Dia->HInicio=$dia['HInicio'];
                    $Dia->HFin=$dia['HFin'];
                    $Dia->dia=$dia['dia'];
                    $Dia->idHorario=$idHorario;
                    $Dia->save();
                }
            }
            Session::flash('mensaje', 'Se ha guardado los cambios del horario correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect()->route('HorariosDocentes.index');
        }
        catch(Exception){
            Session::flash('mensaje', 'Ha ocurrido un error al guardar los cambios del horario');
            Session::flash('TipoMensaje', 'Error');
            return redirect()->route('HorariosDocentes.index');
        }
    }

    /*Funcion que obtiene la informacion de un determinado dia de un determinado horario
    Paramtros recibidos
    1. Nombre del dia que se requiere la informacion Ejemplo: Lunes
    2. id del horario
    Informacion devuelta:
    1. Lista de la informacion del dia solicitado(HInicio y HFin) de un determinado horario
     */
    public function ObtenerDiasHorario(String $dia,String $idHorario){
        $Dias=DiasHorario::where('dia', $dia)->where('idHorario',$idHorario)->get();
        foreach ($Dias as $Dia) {
            //Cambiar formato de la hora de inicio y fin
            $Dia->HInicio = date('H:i', strtotime($Dia->HInicio));
            $Dia->HFin = date('H:i', strtotime($Dia->HFin));
        }
        return $Dias;
    }
}
