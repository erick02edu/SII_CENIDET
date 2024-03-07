<?php

namespace App\Http\Controllers;

use App\Models\Grupos;
use App\Models\Periodos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Exception;


class GruposController extends Controller
{

    //Constructor
    public function __construct()
    {
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('edit','update');
        $this->middleware(['role:Administrador'])->only('destroy');
    }
    /* Funcion que redirige a la vista con la lista de grupos*/
    public function index() {
        $Pagination=Grupos::paginate(10);
        $Grupos=$Pagination->items();
        $Periodos=app(PeriodoController::class)->ObtenerPeriodos();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');
        return Inertia::render('Modulos/Serv_Escolares/Grupos/Grupos',[
            'grupos'=>$Grupos,
            'Paginator'=>$Pagination,
            'periodos'=>$Periodos,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    /*Funcion que permite el registro de un nuevo grupo
    Parametros recibidos en el request:
    1. Informacion del nuevo grupo */
    public function store(Request $request) {
        $Grupo=new Grupos();
        try{
            $Grupo->Semestre=$request->Semestre;
            $Grupo->Especialidad=$request->Especialidad;
            $Grupo->Letra=$request->Letra;
            $Grupo->idPeriodo=$request->idPeriodo;
            $Grupo->save();
            Session::flash('mensaje', 'Se ha registrado el grupo correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Grupos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al registrar el grupo');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Grupos.index');
        }
    }

    /* Funcion que redirige al formulario oara la edicion de un grupo
    Parametros recibidos:
    1.id del grupo a editar
    */
    public function edit(string $id)
    {
        $Grupo = Grupos::find($id);
        $Periodos=app(PeriodoController::class)->ObtenerPeriodos();
        return Inertia::render ('Modulos/Serv_Escolares/Grupos/formEditarGrupos',[
            'grupo'=>$Grupo,
            'periodos'=>$Periodos
        ]);
    }

    /*Funcion que permite la actualizacion de la informacion del grupo
    Parametros recibidos:
    1. Informacion actualizada del grupo
    2. id del grupo a actualizar
    */
    public function update(Request $request, string $id) {
        try{
            $Grupo=Grupos::find($id);
            $Grupo->update($request->all());
            Session::flash('mensaje', 'Se ha guardado los cambios');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Grupos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al intentar actualizar los datos del usuario');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Grupos.index');
        }
    }

    /* Funcion que permite eliminar un grupo
    Parametros recibidos
    1. id del grupo a eliminar */
    public function destroy(string $id) {
        try{
            $Grupo= Grupos::find($id);
            $Grupo->delete();
            Session::flash('mensaje', 'Se ha eliminado correctamente al grupo');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Grupos.index');
        }catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al eliminar al usuario');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Grupos.index');
        }
    }

    /* Funcion que permite buscar a un grupo en especifico
    Parametros recibidos
        1. Cadena de texto que sera utilizada para realizar la busqueda
        2. Campo de busqueda
    Informacion devuelta
        1. Lista de grupos obtenidas de la busqueda
    */
    public function Buscar(Request $request){
        $Grupo=$request->input('grupo');
        $campo = $request->input('campo');
        $result=Grupos::where($campo, 'LIKE', '%'.$Grupo.'%')->get();
        return $result;
    }
    /* Funcion que permite redirige a la vista que permite asignar alumnos a un grupos
    Parametros recibidos
    1. id del grupo
    */
    public function EditarAlumnos(String $id){
        $Grupo=Grupos::find($id);

        $PeriodoGrupo=app(PeriodoController::class)->ObtenerPeriodoPorID($Grupo->idPeriodo);
        $AlumnosGrupo=app(AlumnosController::class)->AlumnosPorGrupo($id);
        $AlumnosSinGrupo=app(AlumnosController::class)->BuscarAlumnosSinGrupo();

        return Inertia::render ('Modulos/Serv_Escolares/Grupos/AsignarAlumnos',[
            'grupo'=>$Grupo,
            'periodo'=>$PeriodoGrupo,
            'alumnos'=>$AlumnosGrupo,
            'alumnosSinGrupo'=>$AlumnosSinGrupo
        ]);
    }
    /* Funcion para obtener una lista de los grupos
    Parametros recibidos: Sin parametros
    Informacion devuelta: Lista completa de los grupos*/
    public function ObtenerGrupos(){
        $Grupos=Grupos::all();
        return $Grupos;
    }

    /* Funcion pque permite Obtener los grupos por medio de su periodo
    Parametros recibidos
        1. id del periodo
    Informacion devuelta:
        1. Lista de grupos obtenidos
    */
    public function ObtenerGruposPorPeriodo($idPeriodo){
        $Grupos=Grupos::where('idPeriodo',$idPeriodo)->get();
        return $Grupos;
    }

    /* Funcion que permite obtener la informacion de un grupo por medio de su id
    Parametros recibidos
        1.id del grupo
    Informacion devuelta:
        1. Informacion completa del grupo obtenido
    */
    public function ObtenerGrupoPorID(String $id){
        $Grupo=Grupos::find($id);
        return $Grupo;
    }
}
