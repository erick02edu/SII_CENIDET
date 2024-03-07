<?php

namespace App\Http\Controllers;

use App\Models\Materias;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class MateriasController extends Controller
{
    //Constructor
    public function __construct() {
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('edit','update');
        $this->middleware(['role:Administrador'])->only('destroy');
    }
    /* Funcion que redirige a vista con la lista de materias */
    public function index(){
        $Pagination=Materias::paginate(10);
        $Materias=$Pagination->items();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');
        return inertia::render('Modulos/RH/Materias/Materias',[
            'materias'=>$Materias,
            'Paginator'=>$Pagination,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    /* Funcion que permite registrar una nueva materia
    Parametros recibidos:
    Informacion de la nueva materia
    */
    public function store(Request $request){
        $Materia=new Materias();

        try{
            $Materia->Nombre=$request->Nombre;
            $Materia->Descripcion=$request->Descripcion;
            $Materia->Codigo=$request->Codigo;

            $Materia->save();
            Session::flash('mensaje', 'Materia registrada correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Materias.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al registrar la materia');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Materias.index');
        }
    }

    /* Funcion que redirige a la vista con el formulario para la edicion de la informacion de una materia
    Parametro recibidos:
    1. id de la materia que se desea editar*/
    public function edit(String $id){
        $Materia = Materias::find($id);
        return Inertia::render ('Modulos/RH/Materias/formEditarMateria',[
            'materia'=>$Materia,
        ]);
    }
    /* Funcion que permite actualizar la informacion correspondiente auna materia
    Parametros recibidos:
    1. id de la materia a actualizar
    2. Informacion actualizada de la materia */
    public function update(Request $request, String $id){
        try{
            $Materia=Materias::find($id);
            $Materia->update($request->all());
            Session::flash('mensaje', 'Se ha guardado los cambios');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Materias.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al intentar actualizar los datos del usuario');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Materias.index');
        }
    }

    /**Funcion que permite la eliminacion de una materia
    Parametros recibidos:
    1. id de la materia a eliminar
    */
    public function destroy(String $id){
        try{
            $Materia = Materias::find($id);
            $Materia->delete();
            Session::flash('mensaje', 'Se ha eliminado correctamente la materia '.$Materia->Nombre);
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Materias.index');
        }catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al eliminar la materia '.$Materia->Nombre);
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Materias.index');
        }
    }

    /*Funcion que permite buscar una o varias materias en especifico
    Parametros recibidos
        1. Cadena de texto para realizar la busqueda
        2. Campo de busqueda
    Informacion devuelta:
        1.Lista de materias obtenidas de la busqueda
    */
    public function buscar(Request $request){
        $materia=$request->input('materia');
        $campo = $request->input('campo');
        $result=Materias::where($campo, 'LIKE', '%'.$materia.'%')->get();
        return $result;
    }

    /* Funcion que permite obtener una lista de las materias
    Parametros recibidos: Sin parametros
    Informacion devuelta: Lista completa de las materias
    */
    public function ObtenerMaterias(){
        $Materias=Materias::all();
        return $Materias;
    }
}
