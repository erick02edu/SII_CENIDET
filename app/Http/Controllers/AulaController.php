<?php
//Importaciones
namespace App\Http\Controllers;
use App\Models\Aula;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Illuminate\Support\Facades\Session;

class AulaController extends Controller
{
    //Constructor
    public function __construct(){
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('edit','update');
        $this->middleware(['role:Administrador'])->only('destroy');
    }
    //Funcion para obtener los datos de todas las aulas y redirigir a vista para visualizar las aulas
    public function index() {
        $Pagination=Aula::paginate(10);
        $Aulas=$Pagination->items();

        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        return Inertia::render('Aulas',[
            'aulas'=>$Aulas,
            'Paginator'=>$Pagination,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }
    /*Funcion para registrar una nueva Aula
    Parametros recibidos
        1. Datos de la nueva aula que se desea registrar
    */
    public function store(Request $request) {
        try{
            $Aula=new Aula();
            $Aula->NombreAula=$request->NombreAula;
            $Aula->Capacidad=$request->Capacidad;
            $Aula->Ubicacion=$request->Ubicacion;

            $Aula->save();

            Session::flash('mensaje', 'Se ha registrado el aula correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Aulas.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al registrar el aula');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Aulas.index');
        }
    }

    /*Funcion para redirigir al formulario para actualizar la informacion de un aula
    Parametros recibidos
        1. id del aula a la que se le actualizaran su informacion
    */
    public function edit(String $id){
        $Aula = Aula::find($id);
        return Inertia::render ('formEditarAulas',[
            'aula'=>$Aula,
        ]);
    }

    /*Funcion que permite la actualizacion de la informacion de un aula
    Paramtros recibidos
        1.id del aula a editar
        2.Informacion nueva para hacer la actualizacion
    */
    public function update(String $id,Request $request) {
        try{
            $Aula=Aula::find($id);
            $Aula->update($request->all());
            Session::flash('mensaje', 'Se ha guardado los cambios');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Aulas.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al intentar actualizar los datos del usuario');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Aulas.index');
        }
    }

    /*uncion para obtener la informacion de un aula en especifico
        Parametros recibidos
            1. id del aula que se desea obtener la informacion
        Informacion devuelta
            Informacion del aula solicita por medio del id
    */
    public function getData(String $id){
        $Aula = Aula::find($id);
        return response()->json($Aula);
    }

    /*Funcion que permite la eliminacion de un aula
        Parametros recibidos
        1.id del aula que se desea eliminar
    */
    public function destroy(String $id){
        try{
            $Aula = Aula::find($id);
            $Aula->delete();
            Session::flash('mensaje', 'Se ha eliminado correctamente el aula '.$Aula->NombrAula);
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Aulas.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al eliminar al usuario '.$Aula->NombreAula);
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Aulas.index');
        }
    }

    /*
    Funcion que devuelve la lista de aulas completas
        Parametros recibidos: Sin parametros
        Informacion devuelta: Lista completa de aulas
    */
    public function ObtenerAulas(){
        $Aulas=Aula::all();
        return $Aulas;
    }
    /*Funcion que permite realizar la busqueda de un aula
        Paramtros recibidos
        1. Cadena de texto utilizada para realizar la busqueda
        2. Campo de busqueda
        Informacion devuelta:
        Lista de aula obtenidas por medio de la busqueda
    */
    public function Buscar(Request $request){
        $Aula=$request->input('Aula');
        $campo = $request->input('campo');
        $result=Aula::where($campo, 'LIKE', '%'.$Aula.'%')->get();
        return $result;
    }
}
