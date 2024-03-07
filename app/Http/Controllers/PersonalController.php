<?php

namespace App\Http\Controllers;

use App\Models\personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioRegistrado;
use Exception;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PersonalController extends Controller
{
    //Constructor
    public function __construct(){
        $this->middleware(['role:Recursos Humanos'])->only('index','indexActivos','indexBajas');
        $this->middleware(['role:Recursos Humanos'])->only('store','create');
        $this->middleware(['role:Recursos Humanos'])->only('edit','update');
        $this->middleware(['role:Recursos Humanos'])->only('destroy');
        //$this->middleware(['role:Recursos Humanos'])->only('asignarCuenta');
        $this->middleware(['role:Recursos Humanos'])->only('asignarPlaza');
    }
    //Ruta index que redirige a vista con la lista de todo el personal
    public function index(){
        $Pagination=personal::paginate(10);
        $personal=$Pagination->items();

        $plazas=app(PlazaController::class)->ObtenerPlazas();
        $plazasDisponibles=app(PlazaController::class)->ObtenerPlazasDisponibles();

        $usuarios=app(UserController::class)->ObtenerUsuarios();
        $usuariosDisponibles=app(UserController::class)->ObtenerUsuariosDisponibles();

        $categorias=app(CategoriaController::class)->ObtenerCategorias();

        $numeroRegistros = personal::all()->count();

        $ArregloFilas=[];
        $EstatusEmpleados=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleados();
        $Departamentos=app(DepartamentoController::class)->ObtenerDepartamentos();
        $Periodos=app(PeriodoController::class)->ObtenerPeriodos();

        for( $i=0 ; $i<$numeroRegistros ;  $i++){
            array_push($ArregloFilas,false);
        }

        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        return Inertia::render('Modulos/RH/Personal/Personal',[
            'personal'=>$personal,
            'plazas'=>$plazas,
            'plazasDisponibles'=>$plazasDisponibles,
            'usuarios'=>$usuarios,
            'usuariosDisponibles'=>$usuariosDisponibles,
            'categorias'=>$categorias,
            'filas'=> $ArregloFilas,
            'Paginator'=>$Pagination,
            'Filtro'=>'Todos',
            'EstatusEmpleado'=>$EstatusEmpleados,
            'departamentos'=>$Departamentos,
            'periodos'=>$Periodos,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]); //Regresar a la vista personal
    }
    //Ruta index que redirige a vista con la lista del personal con un estatus activo
    public function indexActivos(){

        $Pagination=personal::where('Estatus','A')->paginate(10);
        $personal=$Pagination->items();

        $plazas=app(PlazaController::class)->ObtenerPlazas();
        $plazasDisponibles=app(PlazaController::class)->ObtenerPlazasDisponibles();

        $usuarios=app(UserController::class)->ObtenerUsuarios();
        $usuariosDisponibles=app(UserController::class)->ObtenerUsuariosDisponibles();

        $categorias=app(CategoriaController::class)->ObtenerCategorias();

        $numeroRegistros = personal::all()->count();

        $ArregloFilas=[];

        $EstatusEmpleados=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleados();
        $Departamentos=app(DepartamentoController::class)->ObtenerDepartamentos();
        $Periodos=app(PeriodoController::class)->ObtenerPeriodos();

        for( $i=0 ; $i<$numeroRegistros ;  $i++){
            array_push($ArregloFilas,false);
        }

        return Inertia::render('Modulos/RH/Personal/Personal',[
            'personal'=>$personal,
            'plazas'=>$plazas,
            'plazasDisponibles'=>$plazasDisponibles,
            'usuarios'=>$usuarios,
            'usuariosDisponibles'=>$usuariosDisponibles,
            'categorias'=>$categorias,
            'filas'=> $ArregloFilas,
            'Paginator'=>$Pagination,
            'Filtro'=>'Activos',
            'EstatusEmpleado'=>$EstatusEmpleados,
            'departamentos'=>$Departamentos,
            'periodos'=>$Periodos
        ]);
    }
     //Ruta index que redirige a vista con la lista del personal dado de bajo
    public function indexBajas(){

        $Pagination=personal::where('Estatus','B')->paginate(10);
        $personal=$Pagination->items();

        $plazas=app(PlazaController::class)->ObtenerPlazas();
        $plazasDisponibles=app(PlazaController::class)->ObtenerPlazasDisponibles();

        $usuarios=app(UserController::class)->ObtenerUsuarios();
        $usuariosDisponibles=app(UserController::class)->ObtenerUsuariosDisponibles();

        $categorias=app(CategoriaController::class)->ObtenerCategorias();

        $numeroRegistros = personal::all()->count();

        $ArregloFilas=[];

        $EstatusEmpleados=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleados();
        $Departamentos=app(DepartamentoController::class)->ObtenerDepartamentos();
        $Periodos=app(PeriodoController::class)->ObtenerPeriodos();

        for( $i=0 ; $i<$numeroRegistros ;  $i++){
            array_push($ArregloFilas,false);
        }

        return Inertia::render('Modulos/RH/Personal/Personal',[
            'personal'=>$personal,
            'plazas'=>$plazas,
            'plazasDisponibles'=>$plazasDisponibles,
            'usuarios'=>$usuarios,
            'usuariosDisponibles'=>$usuariosDisponibles,
            'categorias'=>$categorias,
            'filas'=> $ArregloFilas,
            'Paginator'=>$Pagination,
            'Filtro'=>'Bajas',
            'EstatusEmpleado'=>$EstatusEmpleados,
            'departamentos'=>$Departamentos,
            'periodos'=>$Periodos
        ]);
    }
    //Funcion para redirigir a vista para dar de alta un personal
    public function create(){
        $Departamentos=app(DepartamentoController::class)->ObtenerDepartamentos();
        $EstatusEmpleados=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleados();
        $usuarios=app(UserController::class)->ObtenerUsuariosDisponibles();
        return Inertia::render('Modulos/RH/Personal/AltaPersonal',[
            'departamentos'=>$Departamentos,
            'estatus'=>$EstatusEmpleados,
            'usuarios'=>$usuarios
        ]);
    }
    /*Funcion para agregar un personal
        Parametros recibidos:
            1. Informacion del nuevo personal
    */
    public function store(Request $request){

        $Personal=new personal();



        $Personal->ApellidoP=$request->ApellidoP;
        $Personal->ApellidoM=$request->ApellidoM;
        $Personal->Nombre=$request->Nombre;
        $Personal->RFC=$request->RFC;
        $Personal->LugarNacimiento=$request->LugarNacimiento;
        $Personal->FechaNacimiento=$request->FechaNacimiento;
        $Personal->Sexo=$request->Sexo;
        $Personal->EstadoCivil=$request->EstadoCivil;
        $Personal->Direccion=$request->Direccion;
        $Personal->Colonia=$request->Colonia;
        $Personal->CodigoPostal=$request->CodigoPostal;
        $Personal->Ciudad=$request->Ciudad;
        $Personal->EntFederativa=$request->EntFederativa;
        $Personal->Telefono=$request->Telefono;
        $Personal->CURP=$request->CURP;
        $Personal->CorreoPers=$request->CorreoPers;

        $Personal->NivEst1=$request->NivEst1;
        $Personal->GradoMax1=$request->GradoMax1;
        $Personal->Estudio1=$request->Estudio1;

        $Personal->NivEst2=$request->NivEst2;
        $Personal->GradoMax2=$request->GradoMax2;
        $Personal->Estudio2=$request->Estudio2;

        $Personal->NivEst3=$request->NivEst3;
        $Personal->GradoMax3=$request->GradoMax3;
        $Personal->Estudio3=$request->Estudio3;

        $Personal->Titulo=$request->Titulo;

        $Personal->Nombramiento=$request->Nombramiento;
        $Personal->numEmpleado=$request->numEmpleado;
        $Personal->EstatusEmpleado=$request->EstatusEmpleado;

        $Personal->IngAñoSNEST=$request->IngAñoSNEST;
        $Personal->IngQuinSNEST=$request->IngQuinSNEST;

        $Personal->IngAñoGob=$request->IngAñoGob;
        $Personal->IngQuinGob=$request->IngQuinGob;

        $Personal->IngAñoSEP=$request->IngAñoSEP;
        $Personal->IngQuinSEP=$request->IngQuinSEP;

        $Personal->IngAñoPlan=$request->IngAñoPlan;
        $Personal->IngQuinPlan=$request->IngQuinPlan;

        $Personal->TipoAct=$request->TipoAct;


        $Personal->	idDepAdscripcion=$request->idDepAdscripcion;
        $Personal->	idDepAcademico=$request->idDepAcademico;



        $Personal->idUsuario=$request->idUsuario;

        date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico
        $Personal->FechaRegistro=date("Y-m-d");

        $DescripcionEstatus=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleadosPorID($request->EstatusEmpleado);


        if($DescripcionEstatus->Descripcion!='Activo'){
            $Personal->Estatus='B';
            $Personal->idUsuario=null;
        }
        else{
            $Personal->Estatus='A';
            $Personal->idUsuario=$request->idUsuario;
        }

        $Personal->save();

        //Verificar si se ingreso como una baja
        if($DescripcionEstatus->Descripcion!='Activo'){


            dd('Es una baja');

            $requestEnviar=new Request();
            $parametros=[
                'idPersonal'=>$Personal->id,
                'idEstatus'=>$request->EstatusEmpleado,
            ];
            $requestEnviar->merge($parametros);
            app(bajasPersonalController::class)->store($requestEnviar);

        }

        //Enviar correo si se asigno cuenta
        if($request->idUsuario!=0){
            $user=app(UserController::class)->ObtenerUsuarioPorID($request->idUsuario);
            Mail::to($user->email)->send(new UsuarioRegistrado($user));
        }


        Session::flash('mensaje', 'Se ha registrado el personal correctamente');
        Session::flash('TipoMensaje', 'Exitoso');

        return Redirect::route('Personal.index');



    }
    /*Funcion para redirigir a vista para editar un personal
        Parametros recibidos
            1. id del personal a editar
    */
    public function edit(string $id){
        $Departamentos=app(DepartamentoController::class)->ObtenerDepartamentos();
        $EstatusEmpleados=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleados();
        $usuarios=app(UserController::class)->ObtenerUsuariosDisponibles();
        $Personal = personal::find($id);
        if($Personal->idUsuario!=null){
            $cuentaAsignada=app(UserController::class)->ObtenerUsuarioPorID($Personal->idUsuario);
        }
        else{
        $cuentaAsignada=0;
        }
        return Inertia::render ('Modulos/RH/Personal/formEditarPersonal',[
            'personalEditar'=>$Personal,
            'departamentos'=>$Departamentos,
            'estatus'=>$EstatusEmpleados,
            'usuarios'=>$usuarios,
            'cuentaAsignada'=>$cuentaAsignada
        ]);
    }
    /*Funcion para actualizar la informacion de un personal
        Parametros recibidos
            1. id del personal a editar
            2. Informacion actualizada del personal
    */
    public function update(Request $request, string $id){
        try{
            $Personal=personal::find($id);

            $DescripcionEstatus=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleadosPorID($request->EstatusEmpleado);
            $Personal->update($request->all());

            if($DescripcionEstatus->Descripcion!='Activo'){
                $Personal->Estatus='B';
                $Personal->save();

                $requestEnviar=new Request();
                $parametros=[
                    'idPersonal'=>$Personal->id,
                    'idEstatus'=>$request->EstatusEmpleado,
                    'RazonBaja'=>$DescripcionEstatus->Descripcion,
                ];
                $requestEnviar->merge($parametros);

                app(bajasPersonalController::class)->store($requestEnviar);

                //Generar reporte de baja

                //Obtener puesto del personal
                date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico
                //Verificar si tenia una plaza
                if($Personal->idPlaza==null){
                    $CategoriaPlaza=null;
                }
                else{
                    $PlazaPersonal=app(PlazaController::class)->ObtenerPlazaPorID($Personal->idPlaza);
                    $CategoriaPlaza=app(CategoriaController::class)->ObtenerCategoriaPorID($PlazaPersonal->idCategoria);
                }

                //Obtener infromacion del jefe de departamento
                $DepartamentoPersonalBaja=app(DepartamentoController::class)->ObtenerDepartamentoPorID($Personal->idDepAdscripcion);

                //Verificar si el departamento tiene un jefe de departamento
                if($DepartamentoPersonalBaja->idEncargado!=null){
                    //Obtener datos del Jefe de departamento
                    $JefeDepartamento=$this->ObtenerPersonalPorID($DepartamentoPersonalBaja->idEncargado);
                }
                else{
                    //Definir Jefe de departamento como null
                    $JefeDepartamento=null;
                }
                return Inertia::render('Modulos/RH/Personal/ReporteBaja',[
                    'personal'=>$Personal,
                    'RazonBaja'=>$DescripcionEstatus->Descripcion,
                    'categoria'=>$CategoriaPlaza,
                    'FechaBaja'=>date("d-m-Y"),
                    'Departamento'=>$DepartamentoPersonalBaja->Nombre,
                    'JefeDepartamento'=>$JefeDepartamento,
                ]);
            }
            else{
                //Eliminar de bajas personal
                //app(bajasPersonalController::class)->delete($Personal->id);
                $Personal->Estatus='A';
                $Personal->save();
            }
            Session::flash('mensaje', 'Cambios guardados correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('Personal.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al actualizar los datos');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('Personal.index');
        }
    }
    /*Funcion que permite dar de baja a un personal
        Parametros recibidos:
        1. id del personal
    */
    public function destroy(string $id){
        $Personal=personal::find($id);
        if($Personal->Estatus=='A'){
            $Personal->Estatus='B';
        }
        else if($Personal->Estatus=='B'){
            $Personal->Estatus='A';
        }
        $Personal->save();
        return redirect::route('Personal.index');
    }
    /*Funcion para buscar un personal
        Parametros recibidos:
            1. Cadena de texto para hacer la busqueda
            2. Campo de busqueda
            3. Opcion del filtro activa(esto es si se busca dentro del personal activo, el dado de baja o todos)
        Informacion devuelta:
            1. LIsta de personales encontrados en la busqueda
    */
    public function buscarPersonal(Request $request){
        $Personal=$request->input('personal');
        $campo = $request->input('campo');
        $Filtro = $request->input('Filtro');
        $Departamento = $request->input('Departamento');
        if($Filtro=='Todos'){
            if($campo=='Nombre'){
                if($Departamento==0){
                    $result=personal::
                    whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Personal.'%'])->get();
                }
                else{
                    $result=personal::
                    whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Personal.'%'])->
                    where('idDepAdscripcion','=',$Departamento)->get();
                }
            }
            else{
                if($Departamento==0){
                    $result=personal::where($campo, 'LIKE', '%'.$Personal.'%')->get();
                }
                else{
                    $result=personal::where($campo, 'LIKE', '%'.$Personal.'%')->
                    where('idDepAdscripcion','=',$Departamento)->get();
                }
            }
        }
        else if($Filtro=='Activos'){
            if($campo=='Nombre'){
                if($Departamento==0){
                    $result=personal::
                    whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Personal.'%'])->
                    where('Estatus','=','A')->get();
                }
                else{
                    $result=personal::
                    whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Personal.'%'])->
                    where('Estatus','=','A')->
                    where('idDepAdscripcion','=',$Departamento)->get();
                }
            }
            else{
                if($Departamento==0){
                    $result=personal::where($campo, 'LIKE', '%'.$Personal.'%')->
                    where('Estatus','=','A')->get();
                }
                else{
                    $result=personal::where($campo, 'LIKE', '%'.$Personal.'%')->
                    where('Estatus','=','A')->
                    where('idDepAdscripcion','=',$Departamento)->get();
                }
            }
        }
        else if($Filtro=='Bajas'){
            if($campo=='Nombre'){
                if($Departamento==0){
                    $result=personal::
                    whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Personal.'%'])->
                    where('Estatus','=','B')->get();
                }
                else{
                    $result=personal::
                    whereRaw("CONCAT(Nombre,' ',ApellidoP,' ',ApellidoM) LIKE ?",['%'.$Personal.'%'])->
                    where('Estatus','=','B')->
                    where('idDepAdscripcion','=',$Departamento)->get();
                }
            }
            else{
                if($Departamento==0){
                    $result=personal::where($campo, 'LIKE', '%'.$Personal.'%')->
                    where('Estatus','=','B')->get();
                }
                else{
                    $result=personal::where($campo, 'LIKE', '%'.$Personal.'%')->
                    where('Estatus','=','B')->
                    where('idDepAdscripcion','=',$Departamento)->get();
                }

            }
        }
        return $result;
    }
    //Funcion para asignar una plaza a un personal
    //Parametros recibidos
        //Variable request que contiene los siguientes datos:
        //1.id del personal a asignar la cuenta 2. id de la plaza que se va asignar
    //No regresa ningun resultado
    public function asignarPlaza(Request $request){

        $Personal=personal::find($request->input('idPersonal'));

        $Personal->idPlaza=$request->input('idPlaza');

        $Personal->save();

        return redirect::route('Personal.index');
    }
    /*Funcion para asignar cuenta a un personal
        Parametros recibidos:
        1. id del personal
        2. id de la cuenta de usuario
    */
    public function asignarCuenta(Request $request){
        $Personal=personal::find($request->input('idPersonal'));
        $Personal->idUsuario=$request->input('idCuenta');
        $Personal->save();
    }
    /*Funcion para obtener lista del personal
        Parametros recibidos: ninguno
        Informacion devuelta: Lista completa del personal
    */
    public function ObtenerPersonal(){
        $Personal=personal::all();
        return $Personal;
    }
    //Funcion para obtener el personal deado de alta
    //Parametros recibidos; Ninguno
    //Devuelve lista con el personal con estatus activo
    public function ObtenerPersonalAlta(){
        $Personal=personal::where('Estatus','=','A')->get();
        return $Personal;
    }
    /*Funcion para obtener personal por medio del id
        Parametros recibidos:
            1. id del personal
        Informacion devuelta:
            1. Informacion completa del personal
    */
    public function ObtenerPersonalPorID(String $id){
        $Personal=personal::find($id);
        return $Personal;
    }
    /*Funcion para obtener todo el personal de un departamento
        Paramettros recibidos:
            1. id del departamento
        Informacion devuelta:
            1. Lista del personal que pertence a ese departamento
    */
    public function ObtenerPersonalDepartamento(Request $request){
        $departamento = $request->input('departamento');
        $Personal=personal::where('idDepAdscripcion','=',$departamento)->get();
        if($Personal->isEmpty()){
            $Personal=[];
        }
        return response()->json(['Personal'=>$Personal]);
    }
    //Funcion que redirige a la vista para los reportes relacionados con el personal
    public function Reportes(){
        return Inertia::render ('Modulos/RH/Reportes/Reportes',[
        ]);
    }
    //Funciones para obtener el personal que no tiene asignada una cuenta de usuario
    //Parametros recibidos: Ninguno
    //Devuelve lista de personal sin cuenta
    public function ObtenerPersonalSinCuenta(){
        $PersonalSinCuenta=Personal::where('idUsuario',null)->get(['id','Nombre','ApellidoP','ApellidoM']);
        return $PersonalSinCuenta;
    }
    public function PersonalDepartamento(Request $request){
        $departamento = $request->input('departamento');
        $Personal=personal::where('idDepAdscripcion','=',$departamento)->get();
        if($Personal->isEmpty()){
            $Personal=[];
        }
        return $Personal;
    }
    //Función para obtener informacion para el reporte de rotacion de personal
    //Parametros recibido
    //Variable de tipo Request que contiene la fecha de inicio y la fecha de fin que se toma para generar el reporte de rotacion
    //Retorna a vista que genera el reporte de rotacion
    public function ReporteRotacion(Request $request){
        $FechaInicio=$request->FechaInicio;
        $FechaFin=$request->FechaFin;
        //Obtener contrataciones que estan entre el rango definido de fechas
        $RegitrosContrataciones = Personal::whereBetween('FechaRegistro', [$FechaInicio, $FechaFin])->get([
            'Nombre','ApellidoP','ApellidoM','Sexo','RFC','numEmpleado','FechaRegistro'
        ]);
        $RegitrosContrataciones=$RegitrosContrataciones->toArray();
        //Obtener porcentajes
        $totalHombres = 0;
        $totalMujeres = 0;
        foreach ($RegitrosContrataciones as $contratacion) {
            if ($contratacion['Sexo'] == 'Masculino') {
                $totalHombres++;
            } elseif ($contratacion['Sexo'] == 'Femenino') {
                $totalMujeres++;
            }
        }
        // Calcular porcentajes
        $totalContrataciones = count($RegitrosContrataciones);
        if($totalContrataciones>0){
            $porcentajeHombres =round( ($totalHombres / $totalContrataciones) * 100  , 2 );
            $porcentajeMujeres =round( ($totalMujeres / $totalContrataciones) * 100  , 2 );
        }
        else{
            $porcentajeHombres=0;
            $porcentajeMujeres=0;
        }
        //Obtener bajas defeinidas entre ese rango de fechas
        $RegistrosBajas=app(bajasPersonalController::class)->ObtenerBajasEntreFechas($FechaInicio,$FechaFin);
        //Obtener lista con los nombre de cada estatus sin repetir
        $ListaIDSEstatus = array_values(array_unique(array_column($RegistrosBajas, 'idEstatus')));
        $ListaNombresEstatus=[];

        foreach($ListaIDSEstatus as $idEstatus){
            //Obtener informacion del estatus
            $NombreEstatus=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleadosPorID($idEstatus);
            $NombreEstatus=$NombreEstatus->Descripcion;
            array_push($ListaNombresEstatus,$NombreEstatus);
        }
        //Obtener porcentaje para cada estatus
        //Obtener array con la frecuencia de cada idEstatus
        $frecuenciaEstatus = array_count_values(array_column($RegistrosBajas, 'idEstatus'));
        // Calcular el porcentaje para cada idEstatus
        $porcentajesBajas = [];
        $totalBajas = count($RegistrosBajas);
        $i=0;
        //Recorrer cada fecuencia por su idEstatus y obtner su frecuencia
        foreach ($frecuenciaEstatus as $idEstatus => $frecuencia) {
            if($totalBajas>0){
                $porcentaje = ($frecuencia / $totalBajas) * 100;
            }
            else{
                $porcentaje=0;
            }
            $porcentajesBajas[$i] = round($porcentaje,2);
            $i++;
        }
        //Obtener la lista de los estatus empleado
        $ListaEstatusEmpleado=app(EstatusEmpleadoController::class)->ObtenerEstatusEmpleados();
        //Redigir a la vista con la informacion obtenida
        return Inertia::render ('Modulos/RH/Reportes/ReporteRotacionPersonal',[
            'RegitrosContrataciones'=>$RegitrosContrataciones,
            'RegistrosBajas'=>$RegistrosBajas,
            'ListaEstatusEmpleado'=>$ListaEstatusEmpleado,
            'FechaInicio'=>$FechaInicio,
            'FechaFin'=>$FechaFin,
            'totalHombres'=>$totalHombres,
            'totalMujeres'=>$totalMujeres,
            'porcentajeHombres'=>$porcentajeHombres,
            'porcentajeMujeres'=>$porcentajeMujeres,
            'ListaNombreEstatus'=>$ListaNombresEstatus,
            'porcentajesBajas'=>$porcentajesBajas,
        ]);
    }
    /*Funcion para obtener informacion del reporte de antiguedad
        Parametros recibidos:
        1. Rangos creados para antiguedad Ejemplo(Nombre:Antiguo,Operador:Mas, Años:10 )
    */
    public function ReporteAntiguedad(Request $request){
        $RangoAntiguedades=$request->json()->all();
        $NumeroDeRangos=count($RangoAntiguedades);
        //Inicializar Objeto
        $i=0;
        foreach ($RangoAntiguedades as $Rangos => $Rango) {
            $nombreRango=$Rango['NombreRango'];
            $Años=(int) $Rango['Años'];
            $Operador=$Rango['Operador'];
            // Define las propiedades del objeto como un array asociativo
            $propiedades = [
                'NombreRango'=>$nombreRango,
                'Años'=>$Años,
                'Operador'=>$Operador,
                'ListaPersonal' => [],
                'NumPersonas'=>0,
                'PorcentajeEmpleados'=>'',
                'PorcentajeRestante'=>''
            ];
            // Crea el objeto stdClass y asigna las propiedades
            $PersonalPorRango[$i] = (object)$propiedades;
            $i++;
        }
        //dd($PersonalPorRango);
        //Obtener antiguedad del personal
        $empleados = Personal::all();
        $i=0;
        foreach ($empleados as $empleado) {
            //Obtener los a;os de antiguedad del empleado
            $fechaIngreso = new Carbon($empleado->FechaRegistro);
            $antiguedad = $fechaIngreso->diffInYears(Carbon::now());
            $i++;

            foreach ($PersonalPorRango as $Rango) {
                //Verificar si cumple con las condiciones para poder ingresar dentro de un personal
                $Años=(int) $Rango->Años;
                $Operador=$Rango->Operador;
                // dd($Operador);
                if($Operador=='Mas'){
                    if($antiguedad>=$Años){
                        $ArrayEmpleado=$empleado->toArray();
                        array_push($Rango->ListaPersonal,$ArrayEmpleado);
                    }
                }
                if($Operador=='Menos'){
                    if($antiguedad<$Años){
                        $ArrayEmpleado=$empleado->toArray();
                        array_push($Rango->ListaPersonal,$ArrayEmpleado);
                    }
                }
            }
        }
        $TotalEmpleados=count($empleados->toArray());
        foreach ($PersonalPorRango as $Rango) {
            $numEmpleadosRango=count($Rango->ListaPersonal);
            $porcentaje =round( ($numEmpleadosRango / $TotalEmpleados) * 100,2);
            $Rango->PorcentajeEmpleados=$porcentaje;
            $PorcentajeRestante=100-$porcentaje;
            $Rango->PorcentajeRestante=$PorcentajeRestante;
            $Rango->NumPersonas=count($Rango->ListaPersonal);
        }
        return Inertia::render ('Modulos/RH/Reportes/ReporteAntiguedad',[
            'InformacionRango'=>$PersonalPorRango,
        ]);
    }
    /*Funcion para verificar si existe un personal con un cierto ID
        Parametros recibidos:
        1. id el personal
        Informacion devuelta:
        1. Devuelve true si existe el personal y false si no existe
    */
    public function VerificarExistencia(String $id){
        $Persona=Personal::find($id);
        if($Persona){
            return true;
        }
        else{
            return false;
        }
    }
}
