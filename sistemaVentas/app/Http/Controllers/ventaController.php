<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Comprobante;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;

class ventaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);
        $this->middleware('permission:eliminar-venta', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filtro = $request->input('filtro');

        if ($filtro == 'dia') {

            $request->validate([
                'fecha_venta' => 'required'
            ]);
            $fecha = $request->input('fecha_venta');
            $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
                ->where('estado', 1)
                ->whereDate('fecha_hora', $fecha)
                ->latest()
                ->get();
        } else if ($filtro == 'mes_anio') {
               $request->validate([
                'mes' => 'required',
                'anio' => 'required'
            ]);
            $mes = null;
            switch ($request->input('mes')) {
                case '1':
                    $mes = "Enero";
                    break;
                case '2':
                    $mes = "Febrero";
                    break;
                case '3':
                    $mes = "Marzo";
                    break;
                case '4':
                    $mes = "Abril";
                    break;
                case '5':
                    $mes = "Mayo";
                    break;
                case '6':
                    $mes = "Junio";
                    break;
                case '7':
                    $mes = "Julio";
                    break;
                case '8':
                    $mes = "Agosto";
                    break;
                case '9':
                    $mes = "Septiembre";
                    break;
                case '10':
                    $mes = "Octubre";
                    break;
                case '11':
                    $mes = "Noviembre";
                    break;
                case '12':
                    $mes = "Diciembre";
                    break;

                default:
                    $mes = "";
                    break;
            }
            $month = $request->input('mes');
            $year = $request->input('anio');

            $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
                ->where('estado', 1)
                ->whereMonth('fecha_hora', $month)
                ->whereYear('fecha_hora', $year)
                ->latest()
                ->get();
        } else if($filtro == 'rago'){
            $request->validate([
                'semana_inicio' => 'required',
                'semana_fin' => 'required',
            ]);
            $date1 =  $request->input('semana_inicio');
            $date2 =  $request->input('semana_fin');

            $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
                ->where('estado', 1)
                ->whereBetween('fecha_hora', [$date1, $date2])
                ->latest()
                ->get();
        } else if ($filtro == 'todos'){
            $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
                ->where('estado', 1)
                ->latest()
                ->get();
        }
         else{
            $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
                ->where('estado', 1)
                ->latest()
                ->get();
        }
        

        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subquery = DB::table('compra_producto')
            ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('producto_id');

        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function ($query) use ($subquery) {
                    $query->select('max_created_at')
                        ->fromSub($subquery, 'subquery')
                        ->whereRaw('subquery.producto_id = cpr.producto_id');
                });
        })->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();



        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();



        return view('venta.create', compact('productos', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try {

            DB::beginTransaction();
            //llenar mi tabla venta

            $venta = Venta::create($request->validated());

            //llenar la tabla venta_producto
            //1. recuperar los arrays
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraydescuento');

            //2.Realizar el llenado
            $sizeArray = count($arrayProducto_id);
            $cont = 0;

            while ($cont < $sizeArray) {
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                        'descuento' => $arrayDescuento[$cont]
                    ]
                ]);

                //Actualizar stock
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $cantidad = intval($arrayCantidad[$cont]);

                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update([
                        'stock' => $stockActual - $cantidad
                    ]);

                $cont++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
        }

        return redirect()->route('ventas.index')->with('success', 'venta exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        return view('venta.show', compact('venta'));
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
        Venta::where('id', $id)->update([
            'estado' => 0
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente');
    }

    /**
     * Filtrar por fechas
     */
    public function filtro(Request $request)
    {
        $filtro = $request->input('filtro');
        if ($filtro == 'dia') {

            $request->validate([
                'fecha_venta' => 'required'
            ]);
            $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
                ->where('estado', 1)
                ->where('fecha_venta', '2025-06-02')
                ->latest()
                ->get();
        }
        return view('venta.index', compact('ventas'));
    }
}
