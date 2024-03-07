<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Recursos Humanos'])->only('index');
        $this->middleware(['role:Recursos Humanos'])->only('store');
        $this->middleware(['role:Recursos Humanos'])->only('edit','update');
        $this->middleware(['role:Recursos Humanos'])->only('destroy');
    }

    /*Funcion que redirige a vista donde se editan las categorias */
    public function index(){
        $Pagination=categoria::paginate(10);
        $categorias=$Pagination->items();
        // Obtener datos flash de la sesión
        $mensaje = Session::get('mensaje');
        $TipoMensaje = Session::get('TipoMensaje');

        return Inertia::render('Modulos/RH/Plazas/Categorias',[
            'categorias'=>$categorias,
            'Paginator'=>$Pagination,
            'mensaje' => $mensaje,
            'tipoMensaje' => $TipoMensaje,
        ]);

    }

    /* Funcion que permite registrar una nueva categoria
    Parametros recibidos
    1. Informacion de la nueva categoria
    */
    public function store(Request $request){
        $categoria=new categoria();
        try{
            $categoria->Descripcion=$request->Descripcion;
            $categoria->Clave=$request->Clave;
            $categoria->Horas=$request->Horas;

            $categoria->save();
            Session::flash('mensaje', 'Se ha registrado la categoria correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('categorias.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al registrar la categoria');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('categorias.index');
        }
    }

    /* Funcion que redirige al formulario para la edicion de una ctaegoria
    Parametros recibidos:
    1.id de la categoria a editar
    */
    public function edit(String $id){

        $Categoria = categoria::find($id);
        if($Categoria){
            return Inertia::render ('Modulos/RH/Plazas/formEditarCategorias',[
                'categoria'=>$Categoria,
            ]);
        }else{
            return back();
        }
    }

    /* Funcion que permite actualizar la informacion de una categoria
    Parametros recibidos
    1.id de la categoria
    2. Informacion actualizada de la categoria
    */
    public function update(String $id,Request $request){
        try{

            $Categoria=categoria::find($id);
            $Categoria->update($request->all());
            Session::flash('mensaje', 'Se han guardado los cambios correctamente');
            Session::flash('TipoMensaje', 'Exitoso');
            return redirect::route('categorias.index');
        }
        catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al guardar los cambios');
            Session::flash('TipoMensaje', 'Error');
            return redirect::route('categorias.index');
        }

    }

    /*
    Funcion que permite la eliminacion de una categoria
    Parametros recibidos
    1. id de la categoria a eliminar
     */
    public function destroy(String $id){
        try{
            $Categoria = categoria::find($id);
            $Categoria->delete();
            Session::flash('mensaje', 'Se eliminado correctamente la categoria');
            Session::flash('TipoMensaje', 'Exitoso');
            return Redirect::route('categorias.index');
        }catch(Exception $e){
            Session::flash('mensaje', 'Ha ocurrido un error al eliminar la categoria');
            Session::flash('TipoMensaje', 'Error');
            return Redirect::route('categorias.index');
        }
    }

    //Funcion que permite obtener la lista de categorias
    //Paramtros recibidos: Sin parametros
    //Informacion devuelta: Lista completa de las categorias
    public function ObtenerCategorias(){
        $categorias=categoria::all();
        return $categorias;
    }

    //Funcion que permite obtener la informacion de una categoria por medio de su id
    //Parametros recibidos: id de la categoria
    //Informacion que devuelve: Informacion de la categoria obtenida
    public function ObtenerCategoriaPorID(String $id) {
        $categoria=categoria::find($id);
        return $categoria;
    }

    /*Funcion que permite buscar una categoria
    Parametros recibidos
    1. Cdena de texto utilizada para la busqueda
    2. Campo por el que se realizara la busqueda
    Informacion devuelta:
    Lista de categorias obtenidas de la busqueda
    */
    public function buscar(Request $request){
        $Categoria=$request->input('categoria');
        $campo = $request->input('campo');
        $result=categoria::where($campo, 'LIKE', '%'.$Categoria.'%')->get();
        return $result;
    }
}
