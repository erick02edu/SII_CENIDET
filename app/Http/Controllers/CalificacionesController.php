<?php

namespace App\Http\Controllers;

use App\Models\Calificaciones;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Alumnos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CalificacionesController extends Controller
{
    //Constructor
    public function __construct() {
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('subirCalificaciones','ActualizarCalificaciones');
    }

    /*Funcion que redirije a la vista para las calificaciones
    Parametros recibidos: Sin parametros
    Informacion devuelta: Esta funcion no devuelve informacion
    */
    public function index(){
        $ListaMaterias=app(MateriasController::class)->ObtenerMaterias();
        $ListaGrupos=app(GruposController::class)->ObtenerGrupos();
        $ListaPeriodos=app(PeriodoController::class)->ObtenerPeriodos();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');
        return Inertia::render ('Modulos/Serv_Escolares/Calificaciones/Calificaciones',[
            'materias'=>$ListaMaterias,
            'grupos'=>$ListaGrupos,
            'periodos'=>$ListaPeriodos,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    /*Funcion para subir las calificaciones de un alumno
    Parametros recibidos en el request
        1. Lista de calificaciones
        2..Lista de alumnos
        3. id de la materia a la que se asignara la calificacion
        4. id del grupo al que se esta asignando las calificaciones
     */
    public function subirCalificaciones(Request $request) {
        $listaCalificaciones = $request->input('ListaCalificaciones');
        $listaIDAlumnos = $request->input('ListaIDAlumnos');
        $materia = $request->input('Materia');
        $Idgrupo = $request->input('grupo');

        $InfoGrupo=app(GruposController::class)->ObtenerGrupoPorID($Idgrupo);
        $semestre=$InfoGrupo->Semestre;
        $i=0;

        date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico

        foreach ($listaIDAlumnos as $alumno) {
            $Calificacion=new Calificaciones();
            $Calificacion->idAlumno=$alumno;
            $Calificacion->idMateria=$materia;
            $Calificacion->Calificacion=$listaCalificaciones[$i];
            $Calificacion->NumSemestre=$semestre;
            $Calificacion->idProfesor=null;
            $Calificacion->FechaRegistro = date('Y-m-d H:i:s');
            $Calificacion->idGrupo=$Idgrupo;
            $i++;
            $Calificacion->save();
        }
        Session::flash('mensaje', 'Se ha subido las calificaciones correctamente');
        Session::flash('TipoMensaje', 'Exitoso');
        return back();
    }

    /* Funcion que actualiza las calificaciones de un alumno o alumnos
    Parametros recibidos en el request
        1. Lista de calificaciones
        2. id de la materia a la que se esta actualizando la calificacion
        3. id del grupo que se esta actualizando la calificacion
    */
    public function ActualizarCalificaciones(Request $request){
        $listaCalificacionesNuevas= $request->input('ListaCalificaciones');
        $materia = $request->input('Materia');
        $Idgrupo = $request->input('grupo');
        $listaCalificacionesAntes=Calificaciones::
            where('idGrupo',$Idgrupo)->
            where('idMateria',$materia)
            ->get();

        $i=0;
        date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico
        foreach ($listaCalificacionesAntes as $Calificaciones) {
            $Calificaciones->Calificacion=$listaCalificacionesNuevas[$i];
            $Calificaciones->FechaRegistro= date('Y-m-d H:i:s');
            $Calificaciones->save();
            $i++;
        }
        Session::flash('mensaje', 'Se ha actualizado las calificaciones correctamente');
        Session::flash('TipoMensaje', 'Exitoso');
    }

    /* Funcion que busca la lista de calificaciones para una materia de un determinado grupo
    Parametros recibidos
        1.id del grupo
        2. id de la materia
    Informacion devuelta
        Lista de calificaciones obtenidas
    */
    public function Buscar(Request $request){
        $Grupo=$request->input('Grupo');
        $Materia = $request->input('Materia');

        $listaCalificaciones=Calificaciones::
            where('idGrupo',$Grupo)->
            where('idMateria',$Materia)
            ->get('Calificacion');
        return $listaCalificaciones;
    }
    /*Funcion que redirige a la vista definida para ver los promedios
    Parametros recibidos: Sin parametros
    */
    public function Promedios(){
        $Pagination=Alumnos::paginate(10);
        $Alumnos=$Pagination->items();
        $Grupos=app(GruposController::class)->ObtenerGrupos();
        return Inertia::render ('Modulos/Serv_Escolares/Calificaciones/Promedios',[
            'alumnos'=>$Alumnos,
            'Paginator'=>$Pagination,
            'grupos'=>$Grupos,
        ]);
    }

    /* Funcion encargada de general los historiales de los alumnos
    Parametros recibidos
        1. Tipo de historial a generar (General o Especifico)
        2. Lista de alumnos que se generara su historial
        3. * Numero de semestre para generarar el historial (opcional solo si el tipo de historial es Especifico)
    Informacion devuelta:
        Retorno a vista que generar el historial con la informacion obtenida
    */
    public function GenerarHistorial(Request $request){

        $tipoHistorial=$request->tipoHistorial;
        //INICIALIZAR INFORMACION A ENVIAR A LA VISTA
        $NombresAlumnos=[];
        $NumeroAlumnos=count($request->AlumnosSeleccionados);
        $NumSemestres=[];
        $InfoAlumnos=[];
        $CalificacionesTotales=[]; //Array de arrays con las calificaciones de cada alumno
        $PromediosGenerales=[];
        foreach($request->AlumnosSeleccionados as $alumno){
            //Obtner nombre completo de alumno y agregarlo al array de NombresAlumnos
            $NombreAlumno=$alumno['Nombre'].' '.$alumno['ApellidoP'].' '.$alumno['ApellidoM'];
            array_push($InfoAlumnos,$alumno);
            array_push($NombresAlumnos,$NombreAlumno);
            //Obtener calificaciones del alumno
            if($tipoHistorial=='Especifico'){
                $Calificaciones=Calificaciones::
                where('idAlumno',$alumno['id'])
                ->where('NumSemestre',$request->NumSemestre)
                ->orderBy('NumSemestre', 'asc') //Ordenar por numero de semestre
                ->get(['Calificacion','idMateria','NumSemestre','FechaRegistro']);
            }

            else if($tipoHistorial=='General'){
                $Calificaciones=Calificaciones::
                where('idAlumno',$alumno['id'])
                ->orderBy('NumSemestre', 'asc') //Ordenar por numero de semestre
                ->get(['Calificacion','idMateria','NumSemestre','FechaRegistro']);
            }
            //Convertir en array e ingresarlo en el arreglo de calificaciones totales
            $Calificaciones=$Calificaciones->toArray();
            array_push($CalificacionesTotales,$Calificaciones);
            //---OBTENER PROMEDIOS GENERALES--
                $totalCalificaciones = 0;
                $numeroCalificaciones = count($Calificaciones);
                if($numeroCalificaciones>0){
                    // Sumar todas las calificaciones
                    foreach ($Calificaciones as $calificacion) {
                        $totalCalificaciones += $calificacion["Calificacion"];
                    }
                    // Calcular el promedio general
                    $promedioGeneral = $totalCalificaciones / $numeroCalificaciones;
                    // Redondear el promedio a dos cifras decimales
                    $promedioGeneral = round($promedioGeneral, 2);
                }else{
                    $promedioGeneral=0;
                }
                array_push($PromediosGenerales,$promedioGeneral);

            //----OBTENER EL MAYOR SEMESTRE----
            $maxSemestre = null;
            // Iterar sobre el array
            foreach ($Calificaciones as $Calificacion) {
                // Obtener el número de semestre actual
                $ActualSemestre = $Calificacion['NumSemestre'];

                // Actualizar $maxSemestre si el número de semestre actual es mayor
                if ($maxSemestre === null || $ActualSemestre > $maxSemestre) {
                    $maxSemestre = (int)$ActualSemestre;
                }
            }
            array_push($NumSemestres,$maxSemestre);
        }
        $ListaMaterias=app(MateriasController::class)->ObtenerMaterias();
        $ListaCarreras=app(CarreraController::class)->ObtenerCarreras();
        $ListaGrupos=app(GruposController::class)->ObtenerGrupos();

        return Inertia::render ('Modulos/Serv_Escolares/Calificaciones/HistorialAlumnos',[
            'NombreAlumnos'=>$NombresAlumnos,
            'NumeroAlumnos'=>$NumeroAlumnos,
            'NumSemestres'=>$NumSemestres,
            'CalificacionesTotales'=>$CalificacionesTotales,
            'materias'=>$ListaMaterias,
            'PromediosGenerales'=>$PromediosGenerales,
            'InfoAlumnos'=>$InfoAlumnos,
            'carreras'=>$ListaCarreras,
            'grupos'=>$ListaGrupos,
        ]);
    }

    /* Funcion que obtiene la informacion necesaria para visualizar grafica de rendimiento
    Parametros recibidos
        1. id del alumno que se quiere ver su rendimiento
    Informacion devuelta:
        1.Lista de semestres cursados
        2.Lista de promedios generales de cada semestre cursado
        */
    public function VerRendimiento(Request $request){

        $idAlumno=$request->input('id');
        $PromediosGenerales=[];
        $ListaSemestres=[];

        //Obtener calificaciones del alumno
        $Calificaciones=Calificaciones::
        where('idAlumno',$idAlumno)
        ->orderBy('NumSemestre', 'asc') //Ordenar por numero de semestre
        ->get(['Calificacion','idMateria','NumSemestre','FechaRegistro']);

        // $Calificaciones=$Calificaciones->toArray();

        // Verificar si hay calificaciones
        if ($Calificaciones->count() > 0) {
            // Inicializar un array para almacenar sumas y conteos por semestre
            $sumaPorSemestre = [];
            $conteoPorSemestre = [];

            // Calcular sumas y conteos por semestre
            foreach ($Calificaciones as $calificacion) {
                $semestre = $calificacion->NumSemestre;

                if (!isset($sumaPorSemestre[$semestre])) {
                    $sumaPorSemestre[$semestre] = 0;
                    $conteoPorSemestre[$semestre] = 0;
                }

                $sumaPorSemestre[$semestre] += $calificacion->Calificacion;
                $conteoPorSemestre[$semestre]++;
            }

            // Calcular promedio por semestre
            $promedioPorSemestre = [];
            foreach ($sumaPorSemestre as $semestre => $suma) {
                $promedioPorSemestre[$semestre] = $suma / $conteoPorSemestre[$semestre];
            }

            foreach ($promedioPorSemestre as $semestre => $promedio) {
                array_push($ListaSemestres,$semestre);
                array_push($PromediosGenerales,$promedio);
            }

            $semestres = [];

            foreach ($ListaSemestres as $numero) {
                $semestres[] = 'Semestre ' . $numero;
            }

            return response()->json([
                'Semestres'=>$semestres,
                'Promedios'=>$PromediosGenerales
            ]);
        }
        else{
            return $PromediosGenerales;
        }
    }

}













