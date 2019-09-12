<?php

namespace App\Http\Controllers\Categoria;

use App\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(!$request->ajax()) return  redirect('/');

        $textBuscar   = $request->textBuscar;
        $opcionBuscar = $request->opcionBuscar;

        if($textBuscar==''){
            
            $categorias = Categoria::orderBy('id','desc')->get();
        }
        else{
            $categorias = Categoria::where($opcionBuscar,'like','%'. $textBuscar . '%')->orderBy('id','desc')->get();
        }
        
        return $categorias;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $categoria = new  Categoria();
        $categoria->nombre      = $request->nombre; 
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion   = '1';
        $categoria->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = 1;
        $categoria->save();

    }

    public function desactivar(Request $request)
    { 
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = Categoria::INACTIVO; 
        $categoria->save();
    }

    public function activar(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = Categoria::ACTIVO; 
        $categoria->save();
    }
}
