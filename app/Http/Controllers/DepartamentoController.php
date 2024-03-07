<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use App\Models\User;
use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DepartamentoController extends Controller
{
    //Constructor
    public function __construct()
    {
        $this->middleware(['role:Recursos Humanos'])->only('index');
        $this->middleware(['role:Recursos Humanos'])->only('store');
        $this->middleware(['role:Recursos Humanos'])->only('edit','update');
        $this->middleware(['role:Recursos Humanos'])->only('destroy');
    }
    /*Funcion que redirige a vista con la lista de departamentos
    Parametros recibidos:
    1. Informacion para la creacion de un nuevo departamento*/
    public function index(){
        $Pagination=Departamentos::paginate(10);
        $departamentos=$Pagination->items();
        $personal=app(PersonalController::class)->ObtenerPersonal();
        $subdirecciones=app(SubdireccionController::class)->ObtenerSubdirecciones();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');
        return Inertia::render('Modulos/RH/Departamentos/Departamentos',[
            'departamentos'=>$departamentos,
            'personal'=>$personal,
            'Paginator'=>$Pagination,
            'subdirecciones'=>$subdirecciones,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }
    //Funcion que permite la creacion de un nuevo departamento
    public function store(Request $request)    {
        $Departamento=new Departamentos();
        try{
            $Departamento->Nombre=$request->Nombre;
            $Departamento->Descripcion=$request->Descripcion;
            $Departamento->idEncargado = $request->idEncargado;
            $Departamento->idSubdireccion = $request->idSubdireccion;

            $Departamento->save();
            Session::flash('mensaje', 'Se ha registrado el departamento correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Departamentos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'ha ocurrido un error al registrar el departamento');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Departamentos.index');
        }
    }
    //Funcion que redirige a vista para editar un departamento
    //Parametros recibidos: id del departamento a editar
    public function edit(string $id)   {
        $Departamento = Departamentos::find($id);
        $personal=app(PersonalController::class)->ObtenerPersonalAlta();
        if($Departamento->idEncargado!=null){
            $JefeActual=app(PersonalController::class)->ObtenerPersonalPorID($Departamento->idEncargado);
        }
        else{
            $JefeActual=0;
        }
        $subdirecciones=app(SubdireccionController::class)->ObtenerSubdirecciones();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        return Inertia::render ('Modulos/RH/Departamentos/formEditarDepartamento',[
            'departamento'=>$Departamento,
            'personal'=>$personal,
            'JefeActual'=>$JefeActual,
            'subdirecciones'=>$subdirecciones,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }
    /*Funcion que permite actualizar la informacion de un departamento
    Parametros recibidos:
    1. id del departamento
    2. Informacion actualizada del departamento
    */
    public function update(Request $request, string $id)    {
        try{
            $Departamento=Departamentos::find($id);
            $Departamento->update($request->all());
            Session::flash('mensaje', 'Se han guardado los cambios correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Departamentos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al guardar los cambios');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Departamentos.index');
        }
    }
    /*  Funcion que permite realizar la eliminacion de un departamento
    Parametros recibidos:
    1.id del departamento a eliminar  */
    public function destroy(string $id){
        try{
            $Departamento = Departamentos::find($id);
            $Departamento->delete();

            Session::flash('mensaje', 'Se eliminado correctamente el departamento');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Departamentos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al eliminar el departamento');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Departamentos.index');
        }
    }
    //Funcion que devuelve la lista de departamentos completa
    //Parametros recibidos: Sin parametros
    public function ObtenerDepartamentos(){
        $Departamentos=Departamentos::all();
        return $Departamentos;
    }
    /*Funcion que devuelve un departamento por medio de su id
    Parametro recibido:
        1.id del departamento buscado
    Informacion devuelta:
        1. Informacion del departamento buscado
    */
    public function ObtenerDepartamentoPorID(String $id){
        $Departamento=Departamentos::find($id);
        return $Departamento;
    }
    /*Funcion que busca un departamento
    Paraetros recibidos
    1. Cadena de texto para realizar la busqueda del departamento
    2. Campo de busqueda
    Informacion devuelta
    1.Lista de departamento encontrados en la busqueda
    */
    public function buscarDepartamento(Request $request){
        $Departamento=$request->input('departamento');
        $campo = $request->input('campo');
        if($campo=='idEncargado'){
            $request=new Request();
            $parametros=['usuario'=>$Departamento,'campo'=>'name'];
            //Unir $parametros a request
            $request->merge($parametros);
            $users=app(UserController::class)->buscarUsuario($request);
            $ListaIDS=$users->pluck('id');
            $result=Departamentos::whereIn('idEncargado',$ListaIDS)->get();
        }
        else{
            $result=Departamentos::where($campo, 'LIKE', '%'.$Departamento.'%')->get();
        }
        return $result;
    }
}
