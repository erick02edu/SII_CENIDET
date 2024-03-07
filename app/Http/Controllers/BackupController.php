<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Backup\BackupDestination\Backup;
use Inertia\Inertia;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Env;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class BackupController extends Controller
{
    // Constructor
    public function __construct()
    {
        $this->middleware(['role:Administrador'])->only('index');
    }

    //Funcion que redirige a la vista para realizar el resplado y restauracion de la BD
    public function index() {
        //Obtener archivos de la ruta definida para los backups --app/backups/
        $rutaBackups=app_path('backups');
        $archivos = File::files($rutaBackups);
        //Ordenar archivos por el mas reciente
        usort($archivos, function ($a, $b) {
            return $b->getMTime() <=> $a->getMTime();
        });
        // Función para solo obtner los datos necesarios
        $transformarArchivo = function ($archivo) {
            return [
                'filename' => $archivo->getFilename(), //nombre del archivo
                'pathname' => $archivo->getPathname(), //Ruta del archivo
                'size'     => round($archivo->getSize()/1000,2), //Tamaño del archivo
            ];
        };
        // Aplicar la transformación a cada elemento del array original
        $archivosTransformados = array_map($transformarArchivo, $archivos);
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        return Inertia::render('Backup',[
            'archivos'=>$archivosTransformados,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    //Funcion que permite generar el respaldo de la base de datos
    //Parametro recibidos: Sin parametros
    public function GenerarBackup(){
        date_default_timezone_set('America/Mexico_City');//Zona horaria Mexico
        //Concatenar nombre para el archivo con la fecha y hora de generacion
        $backupFileName = 'RESPALDO_SII_CENIDET_' . date('Y-m-d_H-i-s') . '.sql';
        try{
            //Obtener datos para el comando
            $UserName=env('DB_USERNAME');
            $NombreBase=env('DB_DATABASE');

            //Concatenar el comando para respaldar                //Carpeta guardar        //Nombre del archivo para guardar
            $command = "mysqldump -u $UserName $NombreBase > " . app_path('backups') ."\\". $backupFileName;
            
            //Ejecutar comando
            $resultado = shell_exec($command);
            Session::flash('mensaje', 'Se ha generado correctamento el respaldo');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('backup.index');

        }catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al generar el respaldo');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('backup.index');
        }
    }
    /* Funcion que permite hacer la restauracion de la infromacion de la BD
        Parametros recibidos
        //Ruta del archivo sql del cual se desea hacer la restauracion
    */
    public function Restaurar(Request $request){
        //Recibir la ruta del archivo que se restaurara
        $ArchivoRestaurar = $request->input('ruta');
        try{
            //Obtener datos para el comando
            $UserName=env('DB_USERNAME');
            $NombreBase=env('DB_DATABASE');

            //Concatenar comando para restaurar BD
            $command = "mysql -u $UserName $NombreBase < $ArchivoRestaurar";
            //Ejecutar comando
            $resultado = shell_exec($command);
            Session::flash('mensaje', 'Se ha restaurado correctamento los datos');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('backup.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al hacer la restauracion');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('backup.index');
        }
    }
    //Funcion que permite la decarga del archivo sql
    //Parametros recibidos: Ruta del archivo que se desea descargar
    public function descargarSQL($rutaCompleta){
        //Descargar archivo
        return response()->download($rutaCompleta);
    }

    /* Funcion que permite eliminar un respaldo de la lista de respaldos
        Parametros recibidos
        1.Ruta del archivo que se desea eliminar
    */
    public function EliminarRespaldo(Request $request){
        try{
            //Obtener ruta del respaldo a eliminar
            $ArchivoEliminar=$request->input('ruta');
            //Si el archivo existe
            if(File::exists($ArchivoEliminar)){
                unlink($ArchivoEliminar); //Eliminar archivo
            }
            Session::flash('mensaje', 'Respaldo eliminado correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('backup.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ocurrio un error al hacer la eliminacion del respaldo');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('backup.index');
        }
    }

}

