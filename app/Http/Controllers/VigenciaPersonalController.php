<?php

namespace App\Http\Controllers;

use App\Models\VigenciaPersonal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;


class VigenciaPersonalController extends Controller
{
    /*Constructor */
    public function __construct(){
        $this->middleware(['role:Recursos Humanos'])->only('update','editVigencia','store');
    }

    /*Funcion que oermite registrar la vigencia de un personal para un ciertpo periodo
        Parametros recibidos
        1. id del personal.
        2.id del periodo
        3. Fecha de inicio de la vigencia
        4 Fecha de termino de la bigencia
     */
    public function store(Request $request){

        try{
        $VigenciaPersonal=new VigenciaPersonal();

        $VigenciaPersonal->idPersonal=$request->idPersonal;
        $VigenciaPersonal->idPeriodo=$request->idPeriodo;
        $VigenciaPersonal->InicioVigencia=$request->InicioVigencia;
        $VigenciaPersonal->FinVigencia=$request->FinVigencia;

        $VigenciaPersonal->save();

            Session::flash('mensaje', 'Se ha agregado la vigencia correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Personal.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha occurrido un error al agregar la vigencia');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Personal.index');
        }
    }

    /*Funcion que redirige a la vista para definir la vigencia de un personal para un determinado periodo
    Parametros recibidos
        1. id del personal.
        2.id del periodo
    */
    public function editVigencia(Request $request,String $idPersonal, String $idPeriodo){
        //Verificar que el personal y el periodo existan
        $ExistPeriodo=app(PeriodoController::class)->VerificarExistencia($idPeriodo);
        $ExistPersonal=app(PersonalController::class)->VerificarExistencia($idPersonal);

        if($ExistPeriodo && $ExistPersonal){

            $VigenciaPersona=VigenciaPersonal::
            where('idPersonal','=',$idPersonal)
            ->where('idPeriodo','=',$idPeriodo)
            ->get();

            if($VigenciaPersona->isEmpty()){
                $VigenciaPersona= array();
                $nuevoElemento = array(
                    "id"=>null,
                    "InicioVigencia" => null,
                    "FinVigencia" => null,
                    "idPersonal"=>$idPersonal,
                    "idPeriodo"=>$idPeriodo,
                );
                array_push($VigenciaPersona, $nuevoElemento);
            }

            $Periodo=app(PeriodoController::class)->ObtenerPeriodoPorID($idPeriodo);
            $Personal=app(PersonalController::class)->ObtenerPersonalPorID($idPersonal);

            return Inertia::render('Modulos/RH/Personal/Vigencia',[
                'InfoVigencia'=>$VigenciaPersona,
                'personal'=>$Personal,
                'periodo'=>$Periodo
            ]);
        }
        else{
            return back();
        }
    }

    /* Funcion que actualiza el periodo de vigencia de un personal
        1.id de la vigencia
        2. request con la fecha de Incio y termino de la vigencia
    */
    public function update(Request $request, string $id){
        try{
            $VigenciaPersonal=VigenciaPersonal::find($id);
            $VigenciaPersonal->update($request->all());
            Session::flash('mensaje', 'Se ha guardado la vigencia correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Personal.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al definir la vigencia');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Personal.index');
        }
    }

    /* Funcion para obtener la fecha de inicio de la vigencia de un personal pora un determinado periodo
        Parametros recibidos:
        1. id del personal
        2, id del periodo
        Informacion devuelta
        Fecha de Inicio de la vigencia
    */
    public function ObtenerVigenciaInicio(String $idPersonal,String $idPeriodo){
        $VigenciaInicio=VigenciaPersonal::
        where('idPersonal',$idPersonal)->
        where('idPeriodo',$idPeriodo)
        ->pluck('InicioVigencia')
        ->first();
        return $VigenciaInicio;
    }

    /* Funcion para obtener la fecha de termino de la vigencia de un personal pora un determinado periodo
        Parametros recibidos:
        1. id del personal
        2, id del periodo
        Informacion devuelta
        Fecha de termino de la vigencia
    */
    public function ObtenerVigenciaFin(String $idPersonal,String $idPeriodo){
        $VigenciaFin=VigenciaPersonal::
        where('idPersonal',$idPersonal)->
        where('idPeriodo',$idPeriodo)
        ->pluck('FinVigencia')
        ->first();
        return $VigenciaFin;
    }
}

