<?php

use App\Http\Controllers\AlumnosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\PlazaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AplicacionPeriodoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\AvisosUsuarioController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\bajasPersonalController;
use App\Http\Controllers\CalificacionesController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\DiasHorarioController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\horariosDocentesController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\PermisosCarrerasController;
use App\Http\Controllers\VigenciaPersonalController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
 ])->group(function () {

    //Ruta dashboard
    Route::get('/dashboard',[AvisosUsuarioController::class,'ObtenerAnuncios'])->name('dashboard');

    //Rutas para todos los modulos
    Route::get('Anuncio.view',[AvisosController::class,'AnuncioCompleto'])->name('Anuncio.view');
    Route::get('Anuncios',[AvisosUsuarioController::class,'VerTodos'])->name('Anuncios');
    Route::get('Avisos.Leido',[AvisosUsuarioController::class,'MarcarLeido'])->name('Avisos.Leido');

    //Rutas para modulo de administrador
        //Rutas para periodos de aplicacion
        Route::resource('Aplicaciones',AplicacionPeriodoController::class)->only(['index','destroy','store']);
        Route::post('AplicacionActualizar',[AplicacionPeriodoController::class,'actualizar'])->name('Aplicaciones.actualizar');
        Route::get('Aplicaciones.buscar',[AplicacionPeriodoController::class,'buscarAplicacion']);
         //Rutas para crud usuarios
        Route::resource('Users',UserController::class);
        Route::get('Users.buscar',[UserController::class,'buscarUsuario']);
        //Rutas para tipos de usuario(Roles)
        Route::resource('Roles',RoleController::class);
        Route::get('Roles.buscar',[RoleController::class,'buscarRol']);
        //Rutas para definir Role a Usuario
        Route::get('RolUsuario',[RoleController::class,'ObtenerRolUsuarioAutenticado']); //Ruta pra obtener los roles que tiene el usuario actualmente authenticado
        Route::get('GetRolesUsuario{id}',[RoleController::class,'ObtenerRolUsuario'])->name('GetRolesUsuario'); //Ruta pra obtener los roles que tiene el usuario actualmente authenticado
        Route::get('Users/{User}/editRole',[RoleController::class,'EditRole'])->name('Users.editRole');//Ruta que redirige a la vista para asignar un Rol
        Route::get('AsignarRol',[RoleController::class,'asignarRol'])->name('Roles.asignar');//Ruta que permite obtener todos los Roles
        //Rutas de permisos de sistema
        Route::get('GetPermisosRol{id}',[PermissionController::class,'ObtenerPermisosRol'])->name('GetPermisosRol'); //Ruta pra obtener los roles que tiene el usuario actualmente authenticado
        Route::get('AsignarPermisos',[PermissionController::class,'asignarPermisos'])->name('Permisos.asignar');//Ruta que permite obtener todos los Roles
        Route::get('Roles/{Role}/editPermisos',[PermissionController::class,'editPermisos'])->name('Roles.editPermisos');//Ruta que redirige a la vista para asignar un Rol
        Route::get('/Permisos.remover',[PermissionController::class,'RemoverPermiso']);
        Route::get('/Permisos.asignarUsuario',[PermissionController::class,'AsignarPermisosUsuario'])->name('Permisos.asignarUsuario');//Ruta que permite obtener todos los Roles
        Route::get('Permisos.buscarUsuario/{id}',[PermissionController::class,'ObtenerPermisosUsuario'])->name('Permisos.buscarUsuario');
        Route::get('/Permisos.buscar',[PermissionController::class,'Buscar'])->name('Permisos.buscar');
        //Rutas de permisos carreras
        Route::get('PermisosCarrera.buscar/{id}',[PermisosCarrerasController::class,'ObtenerPermisosCarrera'])->name('PermisosCarrera.buscar');
        Route::get('/PermisosCarreras.asignar',[PermisosCarrerasController::class,'AsignarPermisos'])->name('PermisosCarreras.asignar');
        Route::get('/PermisosCarreras.Eliminar',[PermisosCarrerasController::class,'EliminarPermiso']);
        //Avisos
        Route::resource('Avisos',AvisosController::class);
        Route::get('Avisos.buscar',[AvisosController::class,'Buscar']);

    //Rutas para modulo de Recursos Humanos

        //Rutas para crud Plazas
        Route::resource('Plazas',PlazaController::class);
        Route::get('Plazas.buscar',[PlazaController::class,'buscarPlaza']);
        Route::get('Plazas.Asignadas',[PlazaController::class,'indexAsignadas'])->name('Plazas.Asignadas');
        Route::get('Plazas.SinAsignar',[PlazaController::class,'indexNoAsignadas'])->name('Plazas.SinAsignar');
        //Rutas a categorias
        Route::resource('categorias',CategoriaController::class);
        Route::get('categorias.buscar',[CategoriaController::class,'buscar']);

        //Rutas Personal
        Route::resource('Personal',PersonalController::class);
        Route::get('Personal.Activos',[PersonalController::class,'indexActivos'])->name('Personal.Activos');
        Route::get('Personal.Bajas',[PersonalController::class,'indexBajas'])->name('Personal.Bajas');
        Route::get('Personal.buscar',[PersonalController::class,'buscarPersonal']);
        Route::post('Personal.asignarPlaza',[PersonalController::class,'asignarPlaza'])->name('Personal.asignarPlaza');
        Route::post('Personal.asignarCuenta',[PersonalController::class,'asignarCuenta'])->name('Personal.asignarCuenta');
        Route::get('Personal.Departemento',[PersonalController::class,'ObtenerPersonalDepartamento']);

        Route::get('Personal.Reportes',[PersonalController::class,'Reportes'])->name('Personal.Reportes');
        Route::post('Personal.Antiguedad',[PersonalController::class,'ReporteAntiguedad'])->name('Personal.Antiguedad');
        Route::post('Personal.Rotacion',[PersonalController::class,'ReporteRotacion'])->name('Personal.Rotacion');
        //bajas Personal
        Route::resource('bajasPersonal',bajasPersonalController::class)->only('store');
        //Rutas para crud vigencia Personal
        Route::resource('VigenciaPersonal',VigenciaPersonalController::class)->only(['store','update']);
        Route::get('VigenciaPersonal/{idPersonal}/{idPeriodo}',[VigenciaPersonalController::class,'editVigencia'])->name('VigenciaPersonal.edit');

        //Periodos escolares
        Route::get('Periodo',[PeriodoController::class,'index'])->name('Periodo.index');


         //Rutas para crud departamentos
        Route::resource('Departamentos',DepartamentoController::class);
        Route::get('Departamentos.buscar',[DepartamentoController::class,'buscarDepartamento']);


        //Rutas para crud horarios docentes
        Route::resource('HorariosDocentes',horariosDocentesController::class);
        Route::get('HorarioAdministrativo/{idHorario}',[horariosDocentesController::class,'editAdministrativo'])->name('HorariosDocentes.editAdmin');
        Route::get('HorariosDocentes/{idHorario}/ver',[horariosDocentesController::class,'Ver'])->name('HorariosDocentes.ver');
        Route::get('/formatoPDF/{id}',[horariosDocentesController::class,'FormatoPDF'])->name('HorarioPDF');
        Route::get('/HorConcentrado/{periodo}',[horariosDocentesController::class,'HorarioConcentrado'])->name('HorConcentrado');
        Route::get('HorariosDocentes.buscar',[horariosDocentesController::class,'buscarHorario']);
        Route::post('EnviarCorreo',[horariosDocentesController::class,'CorreoHorario'])->name('EnviarCorreo');
        //Clases
        Route::resource('Clases',ClasesController::class)->only('store');
        //Dias horario administrativo
        Route::resource('Dias',DiasHorarioController::class)->only(['store','destroy']);
        /*-----------------------Rutas para version de escuela------------------------------------------------------------------------------------------*/
            //Rutas para calificaciones
            Route::resource('Calificaciones',CalificacionesController::class)->only(['index']);
            Route::post('Calificaciones.subir',[CalificacionesController::class,'SubirCalificaciones'])->name('Calificaciones.subir');
            Route::post('Calificaciones.Actualizar',[CalificacionesController::class,'ActualizarCalificaciones'])->name('Calificaciones.Actualizar');
            Route::get('Calificaciones.buscar',[CalificacionesController::class,'Buscar']);
            Route::get('Calificaciones.Promedios',[CalificacionesController::class,'Promedios'])->name('Calificaciones.Promedios');
            Route::post('Calificaciones.historial',[CalificacionesController::class,'GenerarHistorial'])->name('Calificaciones.historial');
            Route::get('Calificaciones.Rendimiento',[CalificacionesController::class,'VerRendimiento']);

            //Rutas para crud Grupos
            Route::resource('Grupos',GruposController::class);
            Route::get('Grupos.buscar',[GruposController::class,'Buscar']);
            Route::get('GruposAlumnos/{id}',[GruposController::class,'EditarAlumnos'])->name('Grupos.Alumnos');

            //Carreras
            Route::get('/Carreras.buscar',[CarreraController::class,'Buscar'])->name('Carreras.buscar');

            //Rutas para crud Alumnos
            Route::resource('Alumnos',AlumnosController::class);
            Route::get('Alumnos.buscar',[AlumnosController::class,'Buscar']);
            Route::post('Alumnos.AsignarGrupo',[AlumnosController::class,'AsignarGrupo'])->name('Alumnos.AsignarGrupo');
            Route::put('Alumnos.QuitarGrupo/{id}',[AlumnosController::class,'QuitarGrupo'])->name('Alumnos.QuitarGrupo');
            Route::post('Alumnos.importar', [AlumnosController::class, 'ImportarDatos']);
            Route::get('Alumnos.Grupo/{id}',[AlumnosController::class,'AlumnosPorGrupo'])->name('Alumnos.Grupo');

            //Rutas para Materias
            Route::resource('Materias',MateriasController::class);
            Route::get('Materias.buscar',[MateriasController::class,'buscar']);

            //Rutas para crud Aulas
            Route::resource('Aulas',AulaController::class);
            Route::get('Aula.buscar',[AulaController::class,'Buscar']);

            //Rutas para respaldo
            Route::resource('backup',BackupController::class)->only(['index']);
            Route::get('GenerarBackup',[BackupController::class,'GenerarBackup'])->name('GenerarBackup');
            Route::post('GenerarRestauracion',[BackupController::class,'Restaurar'])->name('GenerarRestauracion');
            Route::post('EliminarRespaldo',[BackupController::class,'EliminarRespaldo'])->name('EliminarRespaldo');
            Route::get('/descargar-archivo/{nombreArchivo}', [BackupController::class,'descargarSQL'])->name('descargar-archivo');
 });

