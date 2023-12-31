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
    public function __construct(){
        $this->middleware(['role:Recursos Humanos'])->only('update','editVigencia','store');
    }

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

    public function ObtenerVigenciaInicio(String $idPersonal,String $idPeriodo){
        $VigenciaInicio=VigenciaPersonal::
        where('idPersonal',$idPersonal)->
        where('idPeriodo',$idPeriodo)
        ->pluck('InicioVigencia')
        ->first();
        return $VigenciaInicio;
    }

    public function ObtenerVigenciaFin(String $idPersonal,String $idPeriodo){
        $VigenciaFin=VigenciaPersonal::
        where('idPersonal',$idPersonal)->
        where('idPeriodo',$idPeriodo)
        ->pluck('FinVigencia')
        ->first();
        return $VigenciaFin;
    }
}
