@extends('template')

@section('title', 'realizar venta')

@push('css')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Crear venta</li>
        </ol>
    </div>
    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <div class="container mt-4">
            <div class="row gy-4">
                <!--venta producto-->
                <div class="col-md-8">
                    <div class="text-white bg-primary p-1 text-center">
                        Detalles de la venta
                    </div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!--producto-->
                            <div class="col-md-6 mb-2">
                                <select name="producto_id" id="producto_id" class="form-control selectpicker"
                                    title="Seleccione un producto" data-live-search="true" data-size="4">
                                    @foreach ($productos as $producto)
                                        <option
                                            value="{{ $producto->id }}-{{ $producto->stock }}-{{ $producto->precio_venta }}">
                                            {{ $producto->codigo . $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--stock-->
                            <div class="col-md-6 mb-2 d-flex">
                                <div class="col-md-2">
                                    <label for="stock" class="form-label">Stock:</label>
                                </div>
                                <input disabled type="number" name="stock" id="stock" class="form-control">
                            </div>
                            <!--Cantidad-->
                            <div class="col-md-4 mb-2">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>

                            <!--Precio de venta-->
                            <div class="col-md-4 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta</label>
                                <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control"
                                    step="0.1">
                            </div>
                            <!--descuento-->
                            <div class="col-md-4 mb-2">
                                <label for="precio_venta" class="form-label">Descuento:</label>
                                <input type="number" name="descuento" id="descuento" class="form-control">
                            </div>
                            <!--boton para agregar-->
                            <div class="col-md-12 mb-2 text-end">
                                <button type="button" id="btn_agregar" class="btn btn-primary">Agregar</button>
                            </div>
                            <!--tabla para detalles de la venta-->
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio de venta</th>
                                                <th>Descuento</th>
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
                                                <th colspan="2"><input type="hidden" name="total" value="0"
                                                        id="inputTotal"><span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!--boton para cancelar venta-->
                            <div class="col-md-12 mb-2 mt-2 text-end">
                                <button type="button" id="btnCancelar" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Cancelar venta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--venta-->
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">
                            <!--cliente-->
                            <div class="col-md-12 mb-2">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-control selectpicker"
                                    title="Seleccione un cliente" data-live-search="true" data-size="4">
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->persona->razon_social }}
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
                                <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker"
                                    title="Seleccione un comprobante" data-live-search="true" data-size="4">
                                    @foreach ($comprobantes as $comprobante)
                                        <option value="{{ $comprobante->id }}">{{ $comprobante->tipo_comprobante }}
                                        </option>
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
                            @php
                                use Carbon\Carbon;
                                $fecha_hora = Carbon::now()->toDateTimeString();
                            @endphp

                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control border-success"
                                    value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">
                            </div>
                            <!--user-->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <!--Botones-->
                            <div class="col-md-12 text-center">
                                <button type="submit" id="btnGuardar" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para cancelar la venta -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar venta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea eliminar la venta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Sí,
                            cancelar venta</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <script>
        //variables
        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let iva = 0;
        let total = 0;

        //Constantes

        let IMPUESTO = 16;

        $(document).ready(function() {
            $('#producto_id').change(mostrarValores);
        });

        $('#btn_agregar').click(function() {
            agregarProducto();
        });

        $('#btnCancelarVenta').click(function() {
            cancelarVenta();
        });

        $('#impuesto').val(IMPUESTO + '%');

        desabilitarbotones();

        //Muestra los valores en la tabla de 'detalle de la venta' una vez que se haya seleccionado un producto'
        function mostrarValores() {
            let dataProducto = document.getElementById('producto_id').value.split('-');
            $('#stock').val(dataProducto[1]);
            $('#precio_venta').val(dataProducto[2]);
        }

        //Al dar click en el boton de agregar se llena dinamicamente la tabla con los valores
        function agregarProducto() {
            let dataProducto = document.getElementById('producto_id').value.split('-');
            let idProducto = dataProducto[0];
            let nameProducto = $('#producto_id option:selected').text();
            let cantidad = $('#cantidad').val();
            let precioVenta = $('#precio_venta').val();
            let descuento = $('#descuento').val();
            let stock = $('#stock').val();

            if (descuento == '') {
                descuento = 0;
            }

            //Validaciones
            //1. para que los campos no estén vacíos
            if (idProducto != '' && cantidad != '') {
                //2. Para que los valores ingresados sean correctos
                if (parseInt(cantidad) < 0 || parseFloat(descuento) < 0) {
                    alerta('Ingresa valores correctos');
                } else {
                    //3. Para que la cantidad no supere el stock
                    if (parseInt(cantidad) > parseInt(stock)) {
                        alerta('No hay suficiente stock');
                    } else {
                        //calcular valores
                        subtotal[cont] = cantidad * precioVenta - descuento;
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
                            ' <td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' +
                            precioVenta + '</td>' +
                            ' <td><input type="hidden" name="arraydescuento[]" value="' + descuento + '">' +
                            descuento +
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


        //Establecer los campos vacios una vez que se haya aregado un producto
        function limpiarCampos() {
            $('#cantidad').val('');
            $('#descuento').val('');
            $('#precio_venta').val('');
            $('#stock').val('');
            let select = $('#producto_id');
            select.selectpicker();
            select.selectpicker('val', '');
        }


        //alerta cuando existan errores en los campos
        function alerta(message) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: message,
            });
        }

        //funcion para eliminar un registro
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

        //funcion para eliminar todos los productos que se hayan agregado a la tabla
        function cancelarVenta() {
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
