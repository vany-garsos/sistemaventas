<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

        
        return view('producto.create', compact('marcas', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        try{
            DB::beginTransaction();
            //Tabla producto
            $producto = new Producto();
            if($request->hasFile('img_path')){
                $name = $producto->hanbleUploadImage($request->file('imagen_path'));
            }else{
                $name =null;
            }

            $producto->fill([
                'codigo' => $request ->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'marca_id' => $request->marca_id,
                'imagen_path' => $name
            ]);

            $producto->save();

            //Tabla categoria-producto
            $categorias = $request->get('categorias');
            $producto->categorias()->attach($categorias);


        }catch(Exception $e){
            DB::rollBack();
        }

        dd($e);

        return redirect()->route('productos.index')->with('success', 'producto registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
