<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Proveedore;
use App\Models\Comprobante;
use App\Models\Producto;
use Exception;
use Carbon\Carbon;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class CompraController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-compra|crear-compra|mostrar-compra|eliminar-compra',['only'=> ['index']]);
        $this->middleware('permission:crear-compra',['only'=> ['create', 'store']]);
        $this->middleware('permission:mostrar-compra', ['only' => ['show']]);
        $this->middleware('permission:eliminar-compra',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('proveedore.persona')
        ->where('estado', 1)->latest()->get();


        return view('compra.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedore::whereHas('persona', function($query){
            $query->where('estado',1);
        })->get();
        $productos = Producto::where('estado',1)->get();
        return view('compra.create', compact('proveedores', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {        
        try {
            DB::beginTransaction();

            $compra = Compra::create($request->validated());
            //llenar tabla compra producto
            //1.Recuperar los arrays
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');

            //2.Realizar el llenado
            $sizearray = count($arrayProducto_id);
            $contador = 0;
            while($contador < $sizearray){
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$contador] => [
                        'cantidad' => $arrayCantidad[$contador],
                        'precio_compra' => $arrayPrecioCompra[$contador],
                        'precio_venta' => $arrayPrecioVenta[$contador]
                    ]
                ]);

                //3.actualizar el stock
            
                $producto = Producto::find($arrayProducto_id[$contador]);
                $stockAct = $producto->stock;
                $stockNuevo = intval($arrayCantidad[$contador]);

                DB::table('productos')
                ->where('id', $producto->id)
                ->update([
                    'stock' => $stockAct + $stockNuevo
                ]);

                $contador++;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('compras.index')->with('success', 'compra exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        return view('compra.show', compact('compra'));
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
        
        Compra::where('id', $id)->update([
            'estado' => 0
        ]);
      
        return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente');
    }
}
