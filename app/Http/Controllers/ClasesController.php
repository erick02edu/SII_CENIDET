<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClasesController extends Controller
{

    /*
        Funcion que registra las clases de un horario
        Parametors recibidos:
        1. id del horario
        2. Lista de clases del dia Lunes
        3. Lista de clases del dia Martes
        4 Lista de clases del dia Miercoles
        5. Lista de clases del dia Jueves
        6. Lista de clases del dia Viernes
    */
    public function store(Request $request) {
        $idHorario = $request->input('idHorario');
        $ClasesEliminar = Clases::where('idHorario', $idHorario)->get();
        //Eliminar clases
        if(count($ClasesEliminar)!=0){
            foreach($ClasesEliminar as $clase){
                $clase->delete();
            }
        }
        //Registrar las clases de lunes
        $nuevasClasesLunes = $request->input('NuevasClasesLunes');
        if(count($nuevasClasesLunes)!=0){
            foreach ($nuevasClasesLunes as $clase) {
                $Clase=new Clases();
                $Clase->HInicio=$clase['HInicio'];
                $Clase->HFin=$clase['HFin'];
                $Clase->dia=$clase['dia'];
                $Clase->color=$clase['color'];
                $Clase->idMateria=$clase['idMateria'];
                $Clase->idAula=$clase['idAula'];
                $Clase->idGrupo=$clase['idGrupo'];
                $Clase->idHorario=$idHorario;
                $Clase->save();
            }
        }
        //Registrar las clases de Martes
        $nuevasClasesMartes = $request->input('NuevasClasesMartes');
        if(count($nuevasClasesMartes)!=0){
            foreach ($nuevasClasesMartes as $clase) {
                $Clase=new Clases();
                $Clase->HInicio=$clase['HInicio'];
                $Clase->HFin=$clase['HFin'];
                $Clase->dia=$clase['dia'];
                $Clase->color=$clase['color'];
                $Clase->idMateria=$clase['idMateria'];
                $Clase->idAula=$clase['idAula'];
                $Clase->idGrupo=$clase['idGrupo'];
                $Clase->idHorario=$idHorario;
                $Clase->save();
            }
        }
        //Registrar las clases de Miercoles
        $nuevasClasesMiercoles = $request->input('NuevasClasesMiercoles');
        if(count($nuevasClasesMiercoles)!=0){
            foreach ($nuevasClasesMiercoles as $clase) {
                $Clase=new Clases();
                $Clase->HInicio=$clase['HInicio'];
                $Clase->HFin=$clase['HFin'];
                $Clase->dia=$clase['dia'];
                $Clase->color=$clase['color'];
                $Clase->idMateria=$clase['idMateria'];
                $Clase->idAula=$clase['idAula'];
                $Clase->idGrupo=$clase['idGrupo'];
                $Clase->idHorario=$idHorario;
                $Clase->save();
            }
        }
        //Registrar las clases de Jueves
        $nuevasClasesJueves = $request->input('NuevasClasesJueves');
        if(count($nuevasClasesJueves)!=0){
            foreach ($nuevasClasesJueves as $clase) {
                $Clase=new Clases();
                $Clase->HInicio=$clase['HInicio'];
                $Clase->HFin=$clase['HFin'];
                $Clase->dia=$clase['dia'];
                $Clase->color=$clase['color'];
                $Clase->idMateria=$clase['idMateria'];
                $Clase->idAula=$clase['idAula'];
                $Clase->idGrupo=$clase['idGrupo'];
                $Clase->idHorario=$idHorario;
                $Clase->save();
            }
        }
        //Registrar las clases de Viernes
        $nuevasClasesViernes = $request->input('NuevasClasesViernes');
        if(count($nuevasClasesViernes)!=0){
            foreach ($nuevasClasesViernes as $clase) {
                $Clase=new Clases();
                $Clase->HInicio=$clase['HInicio'];
                $Clase->HFin=$clase['HFin'];
                $Clase->dia=$clase['dia'];
                $Clase->color=$clase['color'];
                $Clase->idMateria=$clase['idMateria'];
                $Clase->idAula=$clase['idAula'];
                $Clase->idGrupo=$clase['idGrupo'];
                $Clase->idHorario=$idHorario;
                $Clase->save();
            }
        }
        Session::flash('mensaje', 'Horario actualizado correctamente');
        Session::flash('TipoMensaje', 'Exitoso');
        return redirect()->route('HorariosDocentes.index');
    }

    /**
        Funcion que permite obtener las clases de un dia en especifico
        Parametros recibidos:
        1. Dia del horario
        2. id del horario
     */
    public function ObtenerClasesDia($dia,$idHorario){
        $Clases = Clases::where('dia', $dia)->where('idHorario',$idHorario)->get();
        foreach ($Clases as $clase) {
            $clase->HInicio = date('H:i', strtotime($clase->HInicio));
            $clase->HFin = date('H:i', strtotime($clase->HFin));
        }
        return $Clases;
    }
}
