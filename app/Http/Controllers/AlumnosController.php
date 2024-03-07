<?php

namespace App\Http\Controllers;

use App\Imports\AlumnosImport;
use App\Models\Alumnos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AlumnosController extends Controller
{

    //Constructor
    public function __construct(){
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('edit','update');
        $this->middleware(['role:Administrador'])->only('destroy');
    }

    //Funcion index que redirige a vista con los registros de los alumnos
    public function index(){

        $Pagination=Alumnos::paginate(10);
        $Alumnos=$Pagination->items();
        $Grupos=app(GruposController::class)->ObtenerGrupos();

        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        $Carreras=app(CarreraController::class)->ObtenerCarreras();

        return Inertia::render('Modulos/Serv_Escolares/Alumnos/Alumnos',[
            'alumnos'=>$Alumnos,
            'Paginator'=>$Pagination,
            'grupos'=>$Grupos,
            'carreras'=>$Carreras,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    //Funcion store que permite el registro de nuevos alumnos
    //Parametros recibidos
    //Datos del nuevo alumno por medio de un request
    //No retorna ningun dato
    public function store(Request $request){
        $Alumno=new Alumnos();
        try{
            $Alumno->Nombre=$request->Nombre;
            $Alumno->ApellidoP=$request->ApellidoP;
            $Alumno->ApellidoM=$request->ApellidoM;
            $Alumno->FechaNac=$request->FechaNacimiento;
            $Alumno->noControl=$request->numControl;
            $Alumno->curp=$request->curp;
            $Alumno->Direccion=$request->Direccion;
            $Alumno->Genero=$request->Genero;
            $Alumno->Telefono=$request->Telefono;
            $Alumno->idGrupo=$request->idGrupo;
            $Alumno->idCarrera=$request->idCarrera;
            $Alumno->save();

            Session::flash('mensaje', 'Se ha registrado el alumno correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Alumnos.index');

        }catch(Exception $e){
            //return response()->json(['error'=>$e]);
            Session::flash('mensaje', 'Ha ocurrido un error al registrar el alumno');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Alumnos.index');
        }
    }

    //Funcion edit que redirige al formulario para editar la informacion de un alumno
    //Parametro recibidos
    // id del alumno a editar
    public function edit(String $id){
        $Alumno=Alumnos::find($id);
        if($Alumno->idGrupo!=null){
            $GrupoEditar=app(GruposController::class)->ObtenerGrupoPorID($Alumno->idGrupo);
        }
        else{
            $GrupoEditar=null;
        }
        $ListaCarreras=app(CarreraController::class)->ObtenerCarreras();
        $ListaGrupos=app(GruposController::class)->ObtenerGrupos();

        return Inertia::render ('Modulos/Serv_Escolares/Alumnos/formEditarAlumnos',[
            'alumno'=>$Alumno,
            'GrupoEditar'=>$GrupoEditar,
            'ListaGrupos'=>$ListaGrupos,
            'carreras'=>$ListaCarreras
        ]);
    }
    //Funcion update que permite actualizar la informacion referente a un alumno
    //Parametros recibidos
    //1. id del alumno a editar  2. Informacion editada del alumno
    public function update(String $id,Request $request){
        try{
            $Alumno=Alumnos::find($id);
            $Alumno->update($request->all());
            Session::flash('mensaje', 'Se guardado los cambios correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Alumnos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al guardar los cambios');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Alumnos.index');
        }
    }

    /*Funcion que permite la eliminacion de un alumno del sistema
    Parametros recibidos
    Id del alumno a eliminar*/
    public function destroy(String $id){
        try{
            $Alumno = Alumnos::find($id);
            $Alumno->delete();
            Session::flash('mensaje', 'Se eliminado al alumno correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('Alumnos.index');
        }catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al eliminar la plaza');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Alumnos.index');
        }
    }

    /*Funcion que permite buscar a un alumno dentro de la lista de alumnos
    Paramtros recibidos en el request
        1.Cadena de texto para realizar la busqueda
        2.Campo de busqueda
    Datos que retorna
        Lista de alumnos obtenidos de la busqueda
    */
    public function Buscar(Request $request){
        $Alumno=$request->input('Alumno');
        $campo = $request->input('campo');
        $result=[];

        if ($request->has('Grupo')) {


            if($campo=='Nombre'){
                $result=Alumnos::
                whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Alumno.'%'])->
                whereNull('idGrupo')->get();
            }
            else{
                $result=Alumnos::where($campo, 'LIKE', '%'.$Alumno.'%')->
                whereNull('idGrupo')->get();
            }

        }
        else{
            if($campo=='Nombre'){
                $result=Alumnos::
                whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Alumno.'%'])->get();
            }
            else{
                $result=Alumnos::where($campo, 'LIKE', '%'.$Alumno.'%')->get();
            }
        }


        return $result;

    }
    //Funcion para asignar un grupo a una lista de alumnos
    //Parametro recibidod
    //1. Array con la lista de alumnos 2.id del grupo a asignar a los alumnos
    //Sin parametros a devolver
    public function AsignarGrupo(Request $request){
        //Obtener lista de alumnos seleccionados y grupo que se asignara
        $ListaAlumnos=$request->AlumnosSeleccionados;
        $idGrupo=$request->idGrupo;
        //iterar alumnos y asignarles el grupo
        foreach ($ListaAlumnos as $idAlumno) {
            $Alumno=Alumnos::find($idAlumno);
            $Alumno->idGrupo=$idGrupo;
            $Alumno->save();
        }
        return back();
    }

    /*Funcion que permite obtener los alumnos de u  determinado grupo
    Parametros recibidos
        1. id del grupo del que se desea obtener los alumnos
    Datos devueltos
        Lista de alumnos del grupo buscado
    */
    public function AlumnosPorGrupo(String $id){
        $result=Alumnos::where('idGrupo',$id)->get();
        return $result;
    }

    /*Funcion que permite obtener los alumnos que no tienen un grupo asignado
    Parametros recibidos
        Sin parametros
    Informacion devuelta
        Lista de alumnos sin un grupo asignado
    */
    public function BuscarAlumnosSinGrupo(){
        $result = Alumnos::whereNull('idGrupo')->get();
        return $result;
    }

    /*Funcion que permite retirar a un alumno de su grupo
    Parametro recibidos en el request
        1. id del alumno que se le retira el grupo
    Informacion devuelta
        Esta funcion no devuelve informacion
    */
    public function QuitarGrupo(String $id){
        $Alumno=Alumnos::find($id);
        $Alumno->idGrupo=null;
        $Alumno->save();
        return back();
    }

    /*Funcion que permite importar los datos de un alumno por medio de un archivo excel
    Paramtros recibidos
        1.Archivo de excel para la importacion
    */
    public function ImportarDatos(Request $request){
        try{
            $archivo = $request->file('archivo');
            Excel::import(new AlumnosImport,$archivo);

            Session::flash('mensaje', 'Se importado correctamente los datos');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Alumnos.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al realizar la importacion.Verifique el contenido del excel.Posibles causas del error:
            1. Numero de control repetido en estudiantes
            2. Error en el formato de los datos');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('Alumnos.index');
        }
    }
}
