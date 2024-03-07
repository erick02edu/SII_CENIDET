<?php

namespace App\Http\Controllers;
use App\Models\Periodos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeriodoController extends Controller
{
    /*Funcio que permite obtener la lista de periodos
        Parametros recibidos:Sin parametros
        Informacion devuelta: Lista completa de periodos
    */
    public function ObtenerPeriodos(){
        $Periodos=Periodos::all();
        return $Periodos;
    }

    /*Funcion que permite obtener la informacion de un periodo por medio de su id
        Parametros recibidos:id del periodo
        Informacion devuelta: Informacion completa del periodo
    */
    public function ObtenerPeriodoPorID(String $id){
        $Periodo=Periodos::find($id);
        return $Periodo;
    }

    public function buscarPeriodoCompleto(Request $request){
        $PeriodoBuscar=$request->input('periodoBuscar');
        $ListaPeriodos=Periodos::whereRaw("CONCAT(mesInicio,' ',AñoInicio,'-',mesTermino,' ',AñoTermino) LIKE ?", ["%$PeriodoBuscar%"])
        ->get();
        return $ListaPeriodos;
    }
    /*Funcion que verifica si existe in periodo
    Parametros recibidos:
        1.id del periodo
    Informacion devuelta:
        1.Devuelve true si existe el periodo y si no false
    */
    public function VerificarExistencia(String $id){
        $Periodo=Periodos::find($id);
        if($Periodo){
            return true;
        }
        else{
            return false;
        }
    }

}
