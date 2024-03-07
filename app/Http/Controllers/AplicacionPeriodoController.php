<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AplicacionPeriodos;
use Inertia\Inertia;
use App\Models\Periodos;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AplicacionPeriodoController extends Controller
{
    //Constructor
    public function __construct(){
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('actualizar');
        $this->middleware(['role:Administrador'])->only('destroy');
    }

    /* Funcion que redirige a vista para ver los periodos de aplicacion */
    public function index(){
        $Pagination=AplicacionPeriodos::paginate(10);
        $AplicacionPeriodo=$Pagination->items();
        $periodos=Periodos::all();
        $ListaIdPeriodos=AplicacionPeriodos::all()->pluck('idPeriodo')->toArray();
        $ListaIdAplicaciones= AplicacionPeriodos::all()->pluck('id')->toArray();

        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        return Inertia::render('Modulos/Administrador/PeriodoAplicacion/PeriodoAplicacion',[
            'aplicaciones'=>$AplicacionPeriodo,
            'periodos'=>$periodos,
            'ListaIDAplicaciones'=>$ListaIdAplicaciones,
            'ListaIDPeriodos'=>$ListaIdPeriodos,
            'Paginator'=>$Pagination,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    /*Funcion para registrar un nuevo periodo de aplicacion
    Parametros recibidos
        1. Datos del nuevo registro para el periodo de aplicacion
    Informacion devuelta
        Esta funcion no devuelve ninguna informacion
    */
    public function store(Request $request){

        $Aplicacion=new AplicacionPeriodos();
        try{
            $Aplicacion->descripcion=$request->descripcion;
            $Aplicacion->idPeriodo=$request->idPeriodo;
            $Aplicacion->save();

            //Definir datos flash de la sesión
            Session::flash('mensaje', 'La aplicación se ha almacenado correctamente.');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Aplicaciones.index');

        }catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al registrar la aplicacion.');
            Session::flash('TipoMensaje', 'Error');
        }
    }

    /*Funcion que permite eliminar un periodo de aplicacion
    Parametros recibidos
        1. Id del elemento a eliminar
    Infomacion devuelta
        Sin informacion
    */
    public function destroy(String $id){
        try{
            $Aplicacion = AplicacionPeriodos::find($id);
            $Aplicacion->delete();
            //Definir datos flash de la sesión
            Session::flash('mensaje', 'La aplicación se ha eliminado correctamente.');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Aplicaciones.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al realizar la eliminacion');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Aplicaciones.index');
        }
    }

    /*
    Funcion que permite actualizar el periodo en que se aplican las apliciones
    Paramtros recibidos
        1.Lista de ids con los periodos a los que se actualizara la aplicacion actualizar
        2.Lista de ids de las apliaciones a actualizar
     */
    public function actualizar(Request $request){
        $cont=0;
        try{
            $ListaIDAplicaciones=$request->input('ListaIDAplicaciones');
            $ListaIdPeriodos=$request->input('ListaIDPeriodos');

            //Actualizar el periodo de todas las aplicaciones
            foreach($ListaIDAplicaciones as $idAplicacion){
                $Aplicacion=AplicacionPeriodos::find($idAplicacion);
                $idNuevo=$ListaIdPeriodos[$cont];
                $Aplicacion->idPeriodo=$idNuevo;
                $Aplicacion->save();
                $cont=$cont+1;
            };
            //Definir datos flash de la sesión
            Session::flash('mensaje', 'Se han actualizado los periodos correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Aplicaciones.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Error al guardar los cambios');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Aplicaciones.index');
        }
    }

    /*Funcion que permite buscar un periodo de aplicacion
    Parametros recibidos en el request
        1. Cadena utilizada para realizar la busqueda
        2. Campo por el cual se realizara la busqueda
    Informacion devuelta
        1.Lista de periodos de aplicacion obtenidos de la busqueda
    */
    public function buscarAplicacion(Request $request){
        $Aplicacion=$request->input('aplicacion'); //Obtener cadena enviada por el usuario
        $campo = $request->input('campo'); //Obtener el campo de busqueda
        //Hacer busqueda de acuerdo al campo
        if($campo=='idPeriodo'){
            $request=new Request();
            $parametros=['periodoBuscar'=>$Aplicacion];
            $request->merge($parametros);
            $periodos=app(PeriodoController::class)->buscarPeriodoCompleto($request);
            $ListaIDS=$periodos->pluck('id');
            $result=AplicacionPeriodos::whereIn('idPeriodo',$ListaIDS)->get();
        }else{
            $result=AplicacionPeriodos::where($campo, 'LIKE', '%'.$Aplicacion.'%')->get();
        }
        //Devolver resultados de la busqueda
        return $result;
    }
}
