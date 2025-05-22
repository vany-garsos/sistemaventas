@extends('template')

@section('title', 'Crear compra')


@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <form action="{{ route('compras.store') }}" method="POST">
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
                                <select name="producto_id" id="producto_id" class="form-control selectpicker" title="Seleccione un producto" data-live-search="true" data-size="4">
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">
                                            {{ $producto->codigo . '-' . $producto->nombre }}
                                        </option>
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
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control"
                                    step="0.1">
                            </div>
                            <!--Precio de venta-->
                            <div class="col-md-4 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta</label>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control"
                                    step="0.1">
                            </div>
                            <div class="col-md-12 mb-2 text-end">
                                <button type="button" id="btn_agregar" class="btn btn-primary">Agregar</button>
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
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">Sumas</th>
                                                <th colspan="2"><span id="sumas">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">IVA</th>
                                                <th colspan="2"><span id="iva">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">Total</th>
                                                <th colspan="2"><input type="hidden" name="total" value="0" id="inputTotal"><span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!--boton para cancelar compra-->
                            <div class="col-md-12 mb-2 mt-2 text-end">
                                <button type="button" id="btnCancelar" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Cancelar compra
                                </button>
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
                                <select name="proveedore_id" id="proveedore_id" class="form-control selectpicker" title="Seleccione un proveedor" data-live-search="true" data-size="4">
                
                                    @foreach ($proveedores as $proveedore)
                                        <option value="{{ $proveedore->id }}">{{ $proveedore->persona->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proveedore_id')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!--Tipo de comprobante-->
                            <div class="col-md-12 mb-2">
                                <label for="comprobante_id" class="form-label">Comprobante</label>
                                <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker" title="Seleccione un comprobante" data-live-search="true" data-size="4">
                                    @foreach ($comprobantes as $comprobante)
                                        <option value="{{ $comprobante->id }}">{{ $comprobante->tipo_comprobante }}</option>
                                    @endforeach
                                </select>
                                @error('comprobante_id')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            <!--Numero de comprobante-->
                            <div class="col-md-12 mb-2">
                                <label for="numero_comprobante" class="form-label">Numero de comprobante</label>
                                <input type="text" name="numero_comprobante" id="numero_comprobante"
                                    class="form-control">
                                @error('numero_comprobante')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!--Impuesto-->
                            <div class="col-md-6 mb-2">
                                <label for="impuesto" class="form-label">Impuesto</label>
                                <input type="text" name="impuesto" id="impuesto" class="form-control border-success"
                                    readonly>
                                @error('impuesto')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!--Fecha-->
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control border-success"
                                    value="<?php echo date('Y-m-d'); ?>">
                                    <?php 
                                    use Carbon\Carbon;
                                        $fecha_hora = Carbon::now()->toDateTimeString();
                                    ?>
                                    <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                            </div>
                            <!--Botones-->
                            <div class="col-md-12 text-center">
                                <button type="submit" id="btnGuardar" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para eliminar productos -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea eliminar la compra?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btnCancelarCompra" type="button" class="btn btn-danger" data-bs-dismiss="modal">Sí,
                            cancelar compra
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection


@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn_agregar').click(function() {
                agregarProducto();
            });

            $('#btnCancelarCompra').click(function() {
                cancelarCompra();
            });

            $('#impuesto').val(IMPUESTO + '%');

            desabilitarbotones();
        });

        //variables

        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let iva = 0;
        let total = 0;

        //constantes
        const IMPUESTO = 16;


        function agregarProducto() {
            let idProducto = $('#producto_id').val();
            let nameProducto = ($('#producto_id option:selected').text()).split('-')[1];
            let cantidad = $('#cantidad').val();
            let precioCompra = $('#precio_compra').val();
            let precioVenta = $('#precio_venta').val();

            //Validaciones
            //1. para que los campos no estén vacíos
            if (nameProducto != '' && cantidad != '' && precioCompra != '' && precioVenta != '') {

                //2. Para que los valores ingresados sean correctos
                if (cantidad <= 0 || precioCompra <= 0 || precioVenta <= 0) {
                    alerta('Ingresa valores correctos, mayores que 0');
                } else {
                    //3. Que el precio de compra sea menor que el precio de venta
                    if (precioCompra > precioVenta) {
                        alerta('El precio de COMPRA no puede ser mayor al precio de VENTA');
                    } else {
                        //calcular valores
                        subtotal[cont] = cantidad * precioVenta;
                        sumas += subtotal[cont];
                        iva = sumas / 100 * IMPUESTO;

                        total = sumas + iva;

                        //Crear fila
                        let fila = '<tr id="fila' + cont + '">' +
                            ' <td>' + (cont + 1) + '</td>' +
                            ' <td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' +
                            nameProducto +
                            '</td>' +
                            ' <td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad +
                            '</td>' +
                            ' <td><input type="hidden" name="arraypreciocompra[]" value="' + precioCompra + '">' +
                            precioCompra + '</td>' +
                            ' <td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' +
                            precioVenta +
                            '</td>' +
                            ' <td>' + subtotal[cont] + '</td>' +
                            ' <td><button type="button" class="btn btn-danger" onClick="eliminarProducto(' + cont +
                            ')"><i class="fa-solid fa-trash"></i></button></td>' +
                            ' </tr>';


                        //acciones despues de añadir la fila
                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont++;
                        desabilitarbotones();

                        //mostrar los campos calculados
                        $('#sumas').html(sumas);
                        $('#iva').html(iva);
                        $('#total').html(total);
                        $('#impuesto').val(iva);
                        $('#inputTotal').val(total);
                    }
                }
            } else {
                alerta('Faltan campos por llenar');
            }

        }

        function limpiarCampos() {
          
            $('#cantidad').val('');
            $('#precio_compra').val('');
            $('#precio_venta').val('');
            let select = $('#producto_id');
            select.selectpicker();
            select.selectpicker('val', '');
        }

        function alerta(message) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: message,
            });
        }

        function eliminarProducto(indice) {
            //sumas
            sumas -= subtotal[indice];
            iva = sumas / 100 * IMPUESTO;
            total = sumas + iva;

            //mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#iva').html(iva);
            $('#total').html(total);
            $('#impuesto').val(iva);
            $('#inputTotal').val(total);

            //Eliminar la fila de la tabla
            $('#fila' + indice).remove();
            desabilitarbotones();
        }

        function cancelarCompra() {
            $('#tabla_detalle > tbody').empty();

            //reiniciar valores de las variables
            cont = 0;
            subtotal = [];
            sumas = 0;
            iva = 0;
            total = 0;

            //mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#iva').html(iva);
            $('#total').html(total);
            $('#impuesto').val(IMPUESTO + '%');
            $('#inputTotal').val(total);

            limpiarCampos();
            desabilitarbotones();
        }

        //ocultar botones cuando no haya productos
        function desabilitarbotones() {
            if (total == 0) {
                $('#btnCancelar').hide();
                $('#btnGuardar').hide();
            } else {
                $('#btnCancelar').show();
                $('#btnGuardar').show();
            }
        }
    </script>
@endpush
