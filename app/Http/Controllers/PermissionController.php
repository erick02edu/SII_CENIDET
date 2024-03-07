<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    //Constructor
    public function __construct()
    {
        $this->middleware(['role:Administrador'])->only(['editPermisos','asignar']);
    }
    /*Funcion que asignar permisos a un determinado rol por su Id
        Parametros recibidos:
        1. Lista de Permisos para asignar al rol
        2. id del rol
    */
    public function asignarPermisos(Request $request){
        $id=$request->input('id');
        $Role = Role::find($id);
        $Role->syncPermissions([$request->input('PermisosSeleccionados')]);

        Session::flash('mensaje', 'Se ha creado correctamente el nuevo rol');
        Session::flash('TipoMensaje', 'Exitoso');
        return back()->with([$id]);
    }
    /*Funcion que redirige al formulario para editar los permisos de un rol
    Parametros recibidos:
    1. id del rol
    */
    public function EditPermisos(String $id){
        $Role = Role::find($id);

        $permissions = $Role->permissions;
        $permissionsArray = $permissions->pluck('name')->toArray();
        $permissionsID = $permissions->pluck('id')->toArray();

        $ListaPermisos=Permission::all();
        return Inertia::render ('Modulos/Administrador/RolesPermisos/AsignarPermisos',[
            'rol'=>$Role,
            'permisosAsignados'=>$permissionsArray,
            'permisosIDAsignados'=>$permissionsID,
            'ListaPermisosTotal'=>$ListaPermisos,
        ]);
    }
    /*Funcion para obtener una lista de permisos
    Parametros recibidos:
        Sin parametros
    Informacion devuelta:
        Lista completa de permisos
    */
    public function ObtenerPermisos(){
        $Permisos=Permission::all();
        return $Permisos;
    }
    /*Funcion para obtener los permisos de un determinado rol
    Parametros recibidos:
        1.id del rol
    Informacion devuelta:
        2. Lista de permisos del rol
    */
    public function ObtenerPermisosRol(String $id){
        $Role = Role::find($id); //obtener usuario autenticado
        $permisos = $Role->permissions;// Esto obtendrá una colección de permisos asignados a un rol
        $permisosNames = $permisos->pluck('name')->toArray(); //Obtener solo un array con el nombre de los roles
        return response()->json(['ListaPermisosRol'=>$permisosNames]);
    }
    /*Funcion para obtener los permisos de un usuario
    Parametros recibidos:
        1. idUsuario
    Informacion devuelta:
        2. Lista de permisos del usuario
    */
    public function ObtenerPermisosUsuario(String $idUsuario){
        $user=app(UserController::class)->ObtenerUsuarioPorID($idUsuario);
        $permisosUsuario = $user->permissions;
        return $permisosUsuario;
    }
    /*Funcion para asignar una lista de permisos a un usuario
        Parametros recibidos:
            1. id del usuario
            2. Lista de permisos a asignar
    */
    public function AsignarPermisosUsuario(Request $request){
        $idUsuario=$request->input('idUsuario'); //Obtener id usuario
        $user=app(UserController::class)->ObtenerUsuarioPorID($idUsuario); //Obtener Usuario
        $PermisosSeleccionados=$request->input('PermisosSeleccionados'); //Obtener lista de permisos

        foreach($PermisosSeleccionados as $Permiso){
            $user->givePermissionTo($Permiso); //AsignarPermisos a un determinado Usuario
        }
        return response()->json([
            'mensaje'=>'Se ha asignado todos los permisos del sistema correctamente',
            'tipoMensaje'=>'Exitoso'
        ]);
        return back();
    }
    /*Funcion que permite quitar un permiso a un usuario
        Parametros recibidos en el request:
        1. id del usuario
        2. id del permiso a eliminar
    */
    public function RemoverPermiso(Request $request){
        try{
            $idUsuario=$request->input('idUsuario');
            $idPermiso=$request->input('idPermiso');

            $user=app(UserController::class)->ObtenerUsuarioPorID($idUsuario);
            $permiso = Permission::findById($idPermiso);

            $user->revokePermissionTo($permiso);//Remover permiso

            return response()->json([
                'mensaje'=>'Se ha removido el permiso correctamente',
                'tipoMensaje'=>'Exitoso'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'mensaje'=>'Ocurrio un erroral remover el permiso',
                'tipoMensaje'=>'Error'
            ]);
        }
    }
    /*Funcion para buscar un permiso
        Parametros recibidos:
            1. Cadena de texto para realizar la busqueda
        Informacion devuelta:
            1. Lista de permisos encontrados en la busqueda
    */
    public function Buscar(Request $request){
        $Permiso=$request->input('Permiso'); //Obtener cadena enviada
        $result=Permission::where('name', 'LIKE', '%'.$Permiso.'%')->get(); //Hacer busqueda
        return $result;//Devolver resultados
    }
}
