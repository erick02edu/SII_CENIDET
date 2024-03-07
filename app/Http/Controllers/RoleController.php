<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    //Constructor
    public function __construct() {
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('AsignarRol','EditRole');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('edit','update');
        $this->middleware(['role:Administrador'])->only('destroy');
    }
    //Funcion que redirige a vista donde se gestionan los roles
    public function index(){
        $Pagination=Role::paginate(10);
        $Roles=$Pagination->items();
        $Permisos=app(PermissionController::class)->ObtenerPermisos();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');
        return Inertia::render('Modulos/Administrador/RolesPermisos/Roles',[
            'roles'=>$Roles,
            'Permisos'=>$Permisos,
            'Paginator'=>$Pagination,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }
    /*Funcion para registrar un nuevo tipo de usuario(Rol)
        Parametros recibidos:
        1. Informacion del nuevo rol
    */
    public function store(Request $request){
        $Role=new Role();
        $Role->name=$request->name;
        $Role->guard_name='web';
        $Role->save();
        $newRoleId = $Role->id;
        return redirect()->route('Permisos.asignar', ['id' => $newRoleId, 'PermisosSeleccionados'=>$request->input('PermisosSeleccionados')]);
    }
    /*Funcion para redirigir al formulario de edicion de un tipo de usuario(Rol)
        Parametros recibidos
        1. id del rol
    */
    public function edit(String $id) {
        $Role = Role::find($id);
        if($Role){
            return Inertia::render ('Modulos/Administrador/RolesPermisos/formEditarRol',[
                'rol'=>$Role,
            ]);
        }
        else{
            return back();
        }
    }
    /*Funcion para actualizar la informacion de un rol
        Parametros recibidos
        1.id del rol
        2. Informacion actualizada del rol
    */
    public function update(String $id,Request $request)   {
        $Role=Role::find($id);
        //Verificar si existe el rol
        if($Role){
            try{
                $Role->update($request->all());
                Session::flash('mensaje', 'Cambio realizado exitosamente');
                Session::flash('TipoMensaje', 'Exitoso');
                return redirect::route('Roles.index');
            }
            catch(Exception $e){
                Session::flash('mensaje', 'No se pudo realizar el cambio');
                Session::flash('TipoMensaje', 'Error');
                return redirect::route('Roles.index');
            }
        }
        else{
            return redirect::route('Roles.index');
        }
    }

    //Funcion para eliminar un role
    //Parametros recibidos: id del rol a eliminar
    public function destroy(String $id) {
        $Role = Role::find($id);
        //Verificar si existe el rol
        if($Role){
            try{
                $Role->delete();
                Session::flash('mensaje', 'Se ha eliminado correctamente el rol');
                Session::flash('TipoMensaje', 'Exitoso');
                return Redirect::route('Roles.index');
            }
            catch(Exception $e){
                Session::flash('mensaje', 'No se pudo eliminar el rol');
                Session::flash('TipoMensaje', 'Error');
                return Redirect::route('Roles.index');
            }
        }
        else{
            return redirect::route('Roles.index');
        }
    }
    /*Funcion para obtener la lista completa de los roles
        Parametros recibidos: Sin parametros
        Informacion devuelta: Lista completa de los roles
    */
    public function ObtenerRoles(){
        $Roles=Role::all();
        return $Roles;
    }
    /*Funcion para devolver todos los usuarios de un determinado rol
        Parametros recibidos: id del rol
        Informacion devuelta: Lista de usuario con el determinado rol
    */
    public function ObtenerUsuariosDeUnRol(String $IdRol){
        $Rol=Role::find($IdRol);
        $ListaUsuarios=User::role($Rol->name)->get();
        $ListaUsuarios = $ListaUsuarios->map(function ($user) {
            return $user->toArray();
        })->all();
        return $ListaUsuarios;
    }

    /*Funcion para obtener rol del usuario authenticado
        Parametros recibidos: Sin parametros
        Informacion devuelta: Lista de roles del usuario
    */
    public function ObtenerRolUsuarioAutenticado() {
        $user=Auth::user(); //obtener usuario autenticado
        $roles = $user->roles; // Esto obtendrá una colección de roles asignados al usuario
        $roleNames = $roles->pluck('name')->toArray(); //Obtener solo un array con el nombre de los roles
        return response()->json(['ListaRoles'=>$roleNames]);
    }
    /*Funcion para obtener rol de un usuario por medio de su id
        Parametros recibidos:
            1. id del usuario
        Informacion devuelta:
            1.Lista de roles del usuario
    */
    public function ObtenerRolUsuario(String $id) {
        $User = User::find($id);
        $roles = $User->roles; // Esto obtendrá una colección de roles asignados al usuario
        $roleNames = $roles->pluck('name')->toArray(); //Obtener solo un array con el nombre de los roles
        return response()->json(['ListaRolesUsuario'=>$roleNames]);
    }

    //Funcion para redirigir al formulario que permite la asignacion de un rol a un susuario
    //Parametros recibidos:
    //id del usuario
    public function EditRole(String $id){
        $User = User::find($id);
        $roles = $User->getRoleNames();
        $roleIds = $User->roles->pluck('id')->all();
        $ListaRoles=Role::all();
        return Inertia::render ('Modulos/Administrador/RolesPermisos/AsignarRol',[
            'usuario'=>$User,
            'RolesActuales'=>$roles,
            'ListaRolesTotal'=>$ListaRoles,
            'rolesMarcar'=>$roleIds
        ]);
    }
    /*Funcion para asignar un rol a un usuario
        Parametros recibidos
            1. id del usuario
            2. Lista de roles a asignar
    */
    public function AsignarRol(Request $request){
        $id=$request->input('id');
        $User = User::find($id);
        //Verificar si existe el usuario
        if($User){
            $User->roles()->sync($request->input('RolesSeleccionados'));
            Session::flash('mensaje', 'Usuario registrado correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return back()->with([$id]);
        }
        else{
            return redirect::route('Roles.index');
        }
    }
    /*Funcion para buscar un rol
        Parametros recibidos
            1. Cadena de tecto para realizar la buqeda
            2. Campo de busqueda
        Informacion devuelta:
            1. Lista de roles que se encontraron en la busqueda
    */
    public function buscarRol(Request $request){
        $rol=$request->input('Rol'); //Obtener cadena envianda
        $campo = $request->input('campo'); //Obtener el campo por el que se realizara la busqueda
        $result=Role::where($campo, 'LIKE', '%'.$rol.'%')->get();
        return $result;
    }
}
