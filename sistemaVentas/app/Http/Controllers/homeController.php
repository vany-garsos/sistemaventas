<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class homeController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->input('filtro');
        $venta = 0;
        $clientemayor = null;
        $numeroventas = 0;
        $datos = collect();

        if ($filtro == 'dia') {

            $request->validate([
                'fecha_venta' => 'required'
            ]);
            $fecha = $request->input('fecha_venta');

            /*calcular el total de las ventas*/
            $venta = Venta::whereDate('fecha_hora', $fecha)
                ->where('estado', 1)
                ->sum('total');

            /*obtener el cliente que realizó la mayor venta*/
            $clientemayor = Venta::with('cliente.persona')
                ->whereDate('fecha_hora', $fecha)
                ->where('estado', 1)
                ->orderByDesc('total')->first();

            /*contar las ventas totales*/
            $numeroventas = Venta::whereDate('fecha_hora', $fecha)
                ->where('estado', 1)
                ->count();

            /*productos de mayor a menor venta para el grafico de barras*/
            $productos = Producto::with('ventas')->get();

            $datos = DB::table('producto_venta')
                ->join('productos', 'productos.id', '=', 'producto_venta.producto_id')
                ->join('ventas', 'ventas.id', '=', 'producto_venta.venta_id')
                ->select('productos.nombre', DB::raw('SUM(producto_venta.cantidad) as total_vendido'))
                ->whereDate('fecha_hora', $fecha)
                ->where('ventas.estado', 1)
                ->groupBy('productos.nombre')
                ->orderByDesc('total_vendido')
                ->get();

            /**
             * FILTRO POR MES Y AÑO
             */
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
            $campo = $mes . " - " . $request->input('anio');
            $mes = $request->input('mes');
            $anio = $request->input('anio');

            /*calcular el total de las ventas*/
            $venta = Venta::whereMonth('fecha_hora', $mes)
                ->whereYear('fecha_hora', $anio)
                ->where('estado', 1)
                ->sum('total');

            /*obtener el cliente de mayor venta*/
            $clientemayor = Venta::with('cliente.persona')
                ->whereMonth('fecha_hora', $mes)
                ->whereYear('fecha_hora', $anio)
                ->where('estado', 1)
                ->orderByDesc('total')->first();

            /*contar las ventas totales*/
            $numeroventas = Venta::whereMonth('fecha_hora', $mes)
                ->whereYear('fecha_hora', $anio)
                ->where('estado', 1)
                ->count();


            /*productos de mayor a menor venta para el grafico de barras*/
            $productos = Producto::with('ventas')->get();

            $datos = DB::table('producto_venta')
                ->join('productos', 'productos.id', '=', 'producto_venta.producto_id')
                ->join('ventas', 'ventas.id', '=', 'producto_venta.venta_id')
                ->select('productos.nombre', DB::raw('SUM(producto_venta.cantidad) as total_vendido'))
                ->whereMonth('fecha_hora', $mes)
                ->whereYear('fecha_hora', $anio)
                ->where('ventas.estado', 1)
                ->groupBy('productos.nombre')
                ->orderByDesc('total_vendido')
                ->get();

            /**
             * FILTRO ENTRE DOS RANGOS DE FECHAS
             */
        } else if ($filtro == 'rango') {
            $request->validate([
                'semana_inicio' => 'required',
                'semana_fin' => 'required',
            ]);

            $fecha1 =  $request->input('semana_inicio');
            $fecha2 =  $request->input('semana_fin');
            $campo =  "Del " . $request->input('semana_inicio') . " al " . $request->input('semana_fin');

            /*calcular el total de las ventas*/
            $venta = Venta::whereBetween('fecha_hora', [$fecha1, $fecha2])
                ->where('estado', 1)
                ->sum('total');

            /*obtener el cliente de mayor venta*/
            $clientemayor = Venta::with('cliente.persona')
                ->whereBetween('fecha_hora', [$fecha1, $fecha2])
                ->where('estado', 1)
                ->orderByDesc('total')->first();

            /*contar las ventas totales*/
            $numeroventas = Venta::whereBetween('fecha_hora', [$fecha1, $fecha2])
                ->where('estado', 1)
                ->count();

            /*productos de mayor a menor venta para el grafico de barras*/
            $productos = Producto::with('ventas')->get();

            $datos = DB::table('producto_venta')
                ->join('productos', 'productos.id', '=', 'producto_venta.producto_id')
                ->join('ventas', 'ventas.id', '=', 'producto_venta.venta_id')
                ->select('productos.nombre', DB::raw('SUM(producto_venta.cantidad) as total_vendido'))
                ->whereBetween('fecha_hora', [$fecha1, $fecha2])
                ->where('ventas.estado', 1)
                ->groupBy('productos.nombre')
                ->orderByDesc('total_vendido')
                ->get();
        }
        return view('panel.index', compact('venta', 'clientemayor', 'numeroventas', 'datos'));
    }
}
