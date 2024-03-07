<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //Constructor
    public function __construct()
    {
        $this->middleware(['role:Administrador'])->only('index');
        $this->middleware(['role:Administrador'])->only('store');
        $this->middleware(['role:Administrador'])->only('edit','update');
        $this->middleware(['role:Administrador'])->only('destroy');
    }
    //Funcion que redirige a vista para mostrar todos los usuarios
    public function index(){
        $Pagination=User::paginate(10);
        $Usuarios=$Pagination->items();
        $roles=Role::all();

        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');
        //Obtener lista del personal
        $Personal=app(PersonalController::class)->ObtenerPersonalSinCuenta();
        return Inertia::render('Modulos/Administrador/Usuarios/Usuarios',[
            'usuarios'=>$Usuarios,
            'roles'=>$roles,
            'personal'=>$Personal,
            'Paginator'=>$Pagination,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);
    }

    /*
    Funcion que permite la creacion de un usuario
    Parametros recibidos en el request:
        1.Informacion del nuevo alumno
     */
    public function store(Request $request){
        $user=new User();

        try{

            // //Hacer validaciones
            // $existName = User::where('name', $request->name)->first();
            // $existEmail = User::where('email', $request->email)->first();

            // if($existName){

            //     dd('Usuario ya existente');

            // }
            // if($existEmail){
            //     dd('Email ya existente');
            // }

            //Obtener datos
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password = Hash::make($request->input('password'));
            $user->Estatus='0';

            //Guardar usuario
            $user->save();
            //Obtener id del nuevo usuario
            $newUserId = $user->id;
            //Asignar cuenta al personal
            $requestCuenta=new Request();
            $parametros=[
                'idPersonal'=>$request->input('PersonalAsignar'),
                'idCuenta'=>$newUserId
            ];
            $requestCuenta->merge($parametros);
            app(PersonalController::class)->asignarCuenta($requestCuenta);
            //Asignar roles a la cuenta
            return redirect()->route('Roles.asignar', [
                'id' => $newUserId,
                'RolesSeleccionados'=>$request->input('RolesSeleccionados'),
            ]);
        }
        catch(Exception $e){
        // Verifica si el error fue causado por un campo único duplicado
            if ($e->getCode()==23000) { // 23000 es el código de error para duplicados de clave única
                Session::flash('mensaje', 'Nombre de usuario o email repetido favor de verificar');
                Session::flash('TipoMensaje', 'Error');
            }
            else{
                Session::flash('mensaje', 'Ha ocurrido un error al registrar el usuario');
                Session::flash('TipoMensaje', 'Error');
            }
            //dd($e->getCode());

            return Redirect::route('Users.index');
        }
    }
    //Funcion para redirigir al formulario para la edicion de la informacion del alumno
    //Parametros recibidos: id del usuario
    public function edit(String $id) {
        //Obtener el usuario
        $User = User::find($id);
        //Verificar si el usuario existe
        if ($User) {
            return Inertia::render ('Modulos/Administrador/Usuarios/formEditarUsuario',[
                'usuario'=>$User,
            ]);
        }
        else{
            return redirect::route('Users.index');
        }
    }
    /*Funcion para actualizar la informacion de un usuario
        Parametros recibidos:
        1. id del usuario
        2. Informacion actualiza del usuario
    */
    public function update(String $id,Request $request) {
        $User=User::find($id);
        //Verifica si el usuario existe
        if($User){
            try{
                $User->update($request->all());
                Session::flash('mensaje', 'Se ha guardado los cambios');
                Session::flash('TipoMensaje', 'Exitoso');
                return redirect::route('Users.index');
            }
            catch(Exception $e){
                Session::flash('mensaje', 'Ha ocurrido un error al intentar actualizar los datos del usuario');
                Session::flash('TipoMensaje', 'Error');
                return redirect::route('Users.index');
            }
        }
        else{
            return redirect::route('Users.index');
        }
    }
    //Funcion para eliminar un usuario
    //Parametros recibidos: id del usuario
    public function destroy(String $id) {
        $User = User::find($id);
        //Verifica si el usuario existe
        if($User){
            try{
                //Eliminar usuario
                $User->delete();
                Session::flash('mensaje', 'Se ha eliminado correctamente al usuario '.$User->name);
                Session::flash('TipoMensaje', 'Exitoso');
                return Redirect::route('Users.index');
            }catch(Exception $e){
                Session::flash('mensaje', 'Ha ocurrido un error al eliminar al usuario '.$User->name);
                Session::flash('TipoMensaje', 'Error');
                return Redirect::route('Users.index');
            }
        }
        else{
            return Redirect::route('Users.index');
        }
    }
    //Funcion para buscar un usuario
    //Parametros recibidos
    //1. Texto enviado par el usuario 2. Campo de busqueda
    //Devuelve array con la lista de usuario encontrados en la busqueda
    public function buscarUsuario(Request $request){
        //Recibir parametros
        $Usuario=$request->input('usuario');
        $campo = $request->input('campo');
        //Hacer busqueda
        $result=User::where($campo, 'LIKE', '%'.$Usuario.'%')->get();
        //Devolver resultados
        return $result;
    }

    /* Funcion para obtener lista de usuarios
    Parametros recibidos: Ninguno
    Informacion devuelta: Lista de usuarios
     */
    public function ObtenerUsuarios(){
        $Users=User::all();
        return $Users;
    }
    /* Funcion para obtener la informacion de un usuario por medio de su id
    Parametros recibidos: id del usuario
    Informacion devuelta: Informacion completa del usuario
     */
    public function ObtenerUsuarioPorID(String $id){
        $user=User::find($id);
        return $user;
    }
    /* Funcion para obtener lista de cuentas de usuario disponibles
    Parametros recibidos: Ninguno
    Informacion devuelta: Lista de usuarios con cuenta disponible
     */
    public function ObtenerUsuariosDisponibles()
    {
        $usuariosDisponibles=User::where('estatus','0')->get();
        return $usuariosDisponibles;
    }
    /* Funcion para obtener lista de permisos de un usuario
    Parametros recibidos: id del usuario
    Informacion devuelta: Lista de permisos del usuario
     */
    public function ObtenerPermisosUsuario(String $idUsuario){
        $user = User::find($idUsuario); //Obtener usuario autenticado
        $permisos = $user->permissions;
        $permisosNames = $permisos->pluck('name')->toArray(); //Obtener solo un array con el nombre de los roles
        return $permisosNames;
    }
}
