<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Mail\NuevoAviso;
use App\Models\Avisos;
use App\Models\Avisos_Usuarios;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AvisosUsuarioController extends Controller
{
    //Constructor
    public function __construct() {
        $this->middleware(['role:Administrador'])->only('store');
    }
    /* Funcion que redirige a la ruta donde se muestran todos los avisos de un determinado usuario
    Parametros recibidos: Sin parametros
    */
    public function VerTodos(){
        $userId = Auth::id();
        $ListaAvisos = Avisos_Usuarios::where('idUsuario', $userId)
        ->pluck('idAviso')->toArray();
        $Avisos = Avisos::whereIn('id', $ListaAvisos)->get()->toArray();

        return Inertia::render('Modulos/RH/Avisos/AvisosUsuario',[
            'avisos'=>$Avisos,
        ]);
    }
    /*Funcion que asigna un nuevo aviso a uno o varios usuario
        Parametros recibidos
        1. Id del aviso a asignar
        2. Lista con los id del los usuarios a asignar el aviso
    */
    public function store(Request $request){
        $Aviso=$request->input('Aviso');
        $ListaUsuarios=$request->input('ListaUsuario');

        foreach($ListaUsuarios as $Usuario){
            $AvisoUsuario=new Avisos_Usuarios();
            $AvisoUsuario->idAviso=$Aviso->id;
            $AvisoUsuario->idUsuario=$Usuario['id'];
            $AvisoUsuario->Leido=0;
            $AvisoUsuario->save();
            Mail::to($Usuario['email'])->send(new NuevoAviso($Aviso->Titulo));
        }
        Session::flash('mensaje', 'Se ha publicado el aviso correctamente');
        Session::flash('TipoMensaje', 'Exitoso');
        return Redirect::route('Avisos.index');
    }
    //Funcion para obtener los anuncios que el usuario no ha leido
    public function ObtenerAnuncios(){
        //Obtener id del usuario autenticado
        $userId = Auth::id();
        $ListaAvisos = Avisos_Usuarios::where('idUsuario', $userId)
        ->where('Leido',0)
        ->pluck('idAviso')->toArray();
        $Avisos = Avisos::whereIn('id', $ListaAvisos)->get()->toArray();
        return Inertia::render('Dashboard',[
            'avisos'=>$Avisos,
        ]);
    }
    /*Funcion que actualiza el campo leido de un aviso
    Parametros recibidos
    1. id del aviso
    */
    public function MarcarLeido(Request $request){
        //Obtener id del usuario autenticado
        $userId = Auth::id();
        $Aviso=Avisos_Usuarios::where('idAviso',$request->input('idAviso'))->
        where('idUsuario',$userId);
        $Aviso->update([
            'Leido'=>1
        ]);
    }
}
