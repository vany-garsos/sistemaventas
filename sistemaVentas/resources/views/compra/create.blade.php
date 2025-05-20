@extends('template')

@section('title', 'Crear compra')


@push('css')
@endpush


@section('content')
  <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Crear Compra</li>
        </ol>
  </div>
    <form action="" method="POST">
        @csrf

        <div class="container mt-4">
            <div class="row gy-4">
                <!--compra producto-->
                <div class="col-md-8">
                    <div class="text-white bg-primary p-1 text-center">
                        Detalles de la compra
                    </div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!--producto-->
                            <div class="col-md-12 mb-2">
                                <select name="producto_id" id="producto_id" class="form-select">
                                    <option value="" selected disabled>Selecciona un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{$producto->id}}">{{$producto->codigo.'-'.$producto->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <!--Cantidad-->
                            <div class="col-md-4 mb-2">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>
                              <!--Precio de compra-->
                            <div class="col-md-4 mb-2">
                                <label for="precio_compra" class="form-label">Precio de compra</label>
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">
                            </div>
                              <!--Precio de venta-->
                            <div class="col-md-4 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta</label>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                            </div>
                            <div class="col-md-12 mb-2 text-end">
                                <button class="btn btn-primary">Agregar</button>
                            </div>
                            <!--tabla para detalles de la compra-->
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio de compra</th>
                                                <th>Precio de venta</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Sumas</th>
                                                <th>0</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>IGV</th>
                                                <th>0</th>
                                            </tr>
                                             <tr>
                                                <th></th>
                                                <th>Total</th>
                                                <th>0</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--producto-->
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">
                            <!--proveedor-->
                            <div class="col-md-12 mb-2">
                                <label for="proveedore_id" class="form-label">Proveedor</label>
                                <select name="proveedore_id" id="proveedore_id" class="form-select">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    @foreach ($proveedores as $proveedore)
                                        <option value="{{$proveedore->id}}">{{$proveedore->persona->razon_social}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--Tipo de comprobante-->
                            <div class="col-md-12 mb-2">
                                <label for="comprobante_id" class="form-label">Comprobante</label>
                                <select name="comprobante_id" id="comprobante_id" class="form-select">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    @foreach ($comprobantes as $comprobante)
                                        <option value="{{$comprobante->id}}">{{$comprobante->tipo_comprobante}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!--Numero de comprobante-->
                            <div class="col-md-12 mb-2">
                                <label for="numero_comprobante" class="form-label">Numero de comprobante</label>
                              <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" required>
                            </div>
                            <!--Impuesto-->
                            <div class="col-md-6 mb-2">
                                <label for="impuesto" class="form-label">Impuesto</label>
                              <input type="text" name="impuesto" id="impuesto" class="form-control border-success" readonly>
                            </div>
                            <!--Fecha-->
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                              <input type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d")?>">
                            </div>
                            <!--Botones-->
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection


@push('js')
@endpush
