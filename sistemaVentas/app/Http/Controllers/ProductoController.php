<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
      function __construct()
    {
        $this->middleware('permission:ver-producto|crear-producto|editar-producto|eliminar-producto',['only'=> ['index']]);
        $this->middleware('permission:crear-producto',['only'=> ['create', 'store']]);
        $this->middleware('permission:editar-producto', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-producto',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with(['categorias.caracteristica','marca.caracteristica'])->latest()->get();
        return view('producto.index', compact('productos'));
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
            if($request->hasFile('imagen_path')){
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
            DB::commit();

        }catch(Exception $e){
           
            DB::rollBack();

        }
      


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
    public function edit (Producto $producto)
    {
         $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

        return view('producto.edit',compact('producto', 'marcas', 'categorias'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        try{
            DB::beginTransaction();
         
            if($request->hasFile('imagen_path')){
                $name = $producto->hanbleUploadImage($request->file('imagen_path'));
                //Eliminar si es que existe una imagen
                if(Storage::disk('public')->exists('productos/'.$producto->imagen_path)){
                    Storage::disk('public')->delete('productos/'.$producto->imagen_path);
                }
            }else{
                $name = $producto->img_path;
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
            $producto->categorias()->sync($categorias);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'producto editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $producto = Producto::find($id);
        if ($producto->estado == 1) {
            Producto::where('id', $producto->id)
                ->update([
                    'estado' => 0
                ]);
            $message="Producto eliminado exitosamente";
        } else {
            Producto::where('id', $producto->id)
                ->update([
                    'estado' => 1
                ]);
                $message="Producto restaurado exitosamente";
        }

        return redirect()->route('productos.index')->with('success', $message);
    }
}
