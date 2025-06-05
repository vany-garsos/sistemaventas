@extends('template')

@section('title', 'Realizar venta')

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

        <div class="container mt-4 ">
            <div class="row gy-4">
                <!--venta producto-->
                <div class="col-md-8">

                    <div class="p-3">
                        <div class="row">
                            <!--producto-->
                            <div class="col-md-12 mb-2">
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
                            <!--activar seleccion del codigo de barras
                                                                                                                <div class="col-md-3 mb-2">
                                                                                                                    <div class="form-check form-switch">
                                                                                                                        <input class="form-check-input" type="checkbox" name="switch" id="switch">
                                                                                                                        <label class="form-check-label" for="switch">Codigo de barras</label>
                                                                                                                    </div>

                                                                                                                </div-->

                            <!--stock-->
                            <div class="col-md-3 mb-2">
                                <label for="stock" class="form-label">Stock:</label>
                                <input disabled type="number" name="stock" id="stock" class="form-control">
                            </div>
                            <!--Cantidad-->
                            <div class="col-md-3 mb-2">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>

                            <!--Precio de venta-->
                            <div class="col-md-3 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta</label>
                                <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control"
                                    step="0.1">
                            </div>
                            <!--descuento-->
                            <div class="col-md-3 mb-2">
                                <label for="precio_venta" class="form-label">Descuento:</label>
                                <input type="number" name="descuento" id="descuento" class="form-control">
                            </div>
                            <!--boton para agregar-->
                            <div class="col-md-12 mb-2 text-end">
                                <button type="button" id="btn_agregar" class="btn btn-dark">Agregar</button>
                            </div>
                            <!--tabla para detalles de la venta-->
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover table-bordered">
                                        <thead class="bg-secondary">
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
                                                <th colspan="4">Total $</th>
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
                <div class="col-md-3 h-50">
                    <div class="p-1 mt-3 text-center bg-info">
                        Datos de la venta
                    </div>
                    <div class="p-3">
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


                            <!--Fecha-->
                            @php
                                use Carbon\Carbon;
                                $fecha_hora = Carbon::now()->toDateTimeString();
                            @endphp

                            <div class="col-md-12 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control"
                                    value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">
                            </div>

                            <!--user-->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <!--Botones-->
                            <div class="col-md-12 text-center">
                                <button type="submit" id="btnGuardar" class="btn btn-success">Finalizar venta</button>
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
        let total = 0;
        let nuevoSubtotal = 0;
        /**
         * cuando el dom este cargado y haya un cambio en el producto seleccionado,
         * se ejecute la funcion de mostrarValores 
         **/

        $(document).ready(function() {
            $('#producto_id').change(mostrarValores);

            //    codigoBarras();
        });

        // click en el boton de agregar, va llenar la tabla dinámicamente
        $('#btn_agregar').click(function() {
            agregarProducto();
        });

        // click en el boton cancelar venta, va eliminar las filas en la tabla dinámica
        $('#btnCancelarVenta').click(function() {
            cancelarVenta();
        });


        desabilitarbotones();

        /**
         * Una vez que se selecciona un producto, se muestra el stock 
         * y el precio de venta
         * se obtiene del value del select
         * 
         */
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


            //Si no hay descuento, establece el campo con un valor de 0
            if (descuento == '') {
                descuento = 0;
            }

            //Validaciones
            //1. para que los campos no estén vacíos (producto y cantidad)
            if (idProducto != '' && cantidad != '') {
                //2. Para que los valores ingresados sean correctos
                if (parseInt(cantidad) < 0 || parseFloat(descuento) < 0) {
                    alerta('Ingresa valores correctos');
                } else {
                    //3. Para que la cantidad no supere el stock
                    if (parseInt(cantidad) > parseInt(stock)) {
                        alerta('No hay suficiente stock');
                    } else {
                        let productoExistente = false;
                        //Actualiza los valores de la fila (cantidad, descuento, subtotal, total)
                        $('#tabla_detalle tbody tr').each(function() {
                            let filaTabla = $(this);
                            let idProductoExistente = filaTabla.find('input[name="arrayidproducto[]"]').val();

                            if (idProductoExistente == idProducto) {
                                productoExistente = true;

                                let cantidadInput = filaTabla.find('input[name="arraycantidad[]"]');
                                //clase del span
                                let cantidadTexto = filaTabla.find('td:eq(2) .cantidad-texto');

                                let cantidadActual = parseInt(cantidadInput.val());
                                let cantidadAgregada = parseInt(cantidad);


                                if (isNaN(cantidadActual)) cantidadActual = 0;
                                if (isNaN(cantidadAgregada)) cantidadAgregada = 0;

                                let nuevaCantidad = cantidadActual + cantidadAgregada;
                                cantidadInput.val(nuevaCantidad);

                                //establece la nueva cantidad en un span
                                if (cantidadTexto.length == 0) {
                                    filaTabla.find('td:eq(2)').append('<span class="cantidad-texto">' +
                                        nuevaCantidad + '</span>');
                                } else {
                                    cantidadTexto.text(nuevaCantidad);
                                }

                                let precio = parseFloat(precioVenta);
                                let desc = parseFloat(descuento);

                                if (isNaN(precio)) precio = 0;
                                if (isNaN(desc)) desc = 0;

                                nuevoSubtotal = (nuevaCantidad * precio) - desc;



                                // Actualiza subtotal visible
                                let subtotalTexto = filaTabla.find('td:eq(5) .subtotal-texto');
                                if (subtotalTexto.length == 0) {
                                    filaTabla.find('td:eq(5)').append('<span class="subtotal-texto">' +
                                        nuevoSubtotal.toFixed(2) + '</span>');
                                } else {
                                    subtotalTexto.text(nuevoSubtotal.toFixed(2));
                                }

                                // Actualiza el total general sumando solo la diferencia
                                total = total - ((cantidadActual * precio) - desc) + nuevoSubtotal;

                                //sale del each
                                return false;
                            }
                        });

                        //si el producto no existe, agrega una nueva fila
                        if (!productoExistente) {
                            //calcular valores
                            subtotal[cont] = parseInt(cantidad) * parseFloat(precioVenta) - parseFloat(descuento);
                            total += subtotal[cont];

                            //Crear fila 
                            let fila = '<tr id="fila' + cont + '">' +
                                ' <td>' + (cont + 1) + '</td>' +
                                ' <td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' +
                                nameProducto + '</td>' +
                                ' <td><input type="hidden" name="arraycantidad[]" value="' + cantidad +
                                '"><span class="cantidad-texto">' + cantidad + '</span></td>' +
                                ' <td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' +
                                precioVenta + '</td>' +
                                ' <td><input type="hidden" name="arraydescuento[]" value="' + descuento + '">' + descuento +
                                '</td>' +
                                ' <td><span class="subtotal-texto">' + subtotal[cont].toFixed(2) + '</span></td>' +
                                ' <td><button type="button" class="btn btn-danger" onClick="eliminarProducto(' + cont +
                                ')"><i class="fa-solid fa-trash"></i></button></td>' +
                                '</tr>';


                            cont++;
                            //pintar la informacion en la tabla
                            $('#tabla_detalle').append(fila);

                        }

                        //acciones despues de añadir la fila
                        limpiarCampos();
                        desabilitarbotones();

                        //mostrar los campos calculados
                        $('#sumas').html(sumas);
                        $('#total').html(total);
                        $('#inputTotal').val(total);
                        $('#totalventa').val(total);

                    }
                }
            } else {
                alerta('Faltan campos por llenar');
            }
        }
        //Establece los campos vacios una vez que se haya aregado un producto
        function limpiarCampos() {
            $('#cantidad').val('');
            $('#descuento').val('');
            $('#precio_venta').val('');
            $('#stock').val('');
            let select = $('#producto_id');
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
            const subtotalTexto = $('#fila' + indice).find('td:eq(5)').text();
            const subtotalFila = parseFloat(subtotalTexto);
            //sumas
            total -= subtotalFila;


            //mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#total').html(total);
            $('#inputTotal').val(total);

            //Eliminar la fila de la tabla
            $('#fila' + indice).remove();
            desabilitarbotones();
        }

        //funcion para eliminar todos los productos que se hayan agregado a la tabla
        function cancelarVenta() {
            $('#tabla_detalle > tbody').empty();

            //reinicia valores de las variables
            cont = 0;
            subtotal = [];
            sumas = 0;
            total = 0;

            //muestra los campos calculados
            $('#sumas').html(sumas);

            $('#total').html(total);

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
        /**
         * Verifica si un producto ya esta en una fila de la tabla,
         * de ser asi, actualiza la cantidad, el subtotal y total
         */
        function actualizarfila() {

            $('#tabla_detalle tbody tr').each(function() {
                let filaTabla = $(this);
                let idProductoExistente = filaTabla.find('input[name="arrayidproducto[]"]').val();

                if (idProductoExistente == idProducto) {
                    productoExistente = true;

                    let cantidadInput = filaTabla.find('input[name="arraycantidad[]"]');
                    //clase del span
                    let cantidadTexto = filaTabla.find('td:eq(2) .cantidad-texto');

                    let cantidadActual = parseInt(cantidadInput.val());
                    let cantidadAgregada = parseInt(cantidad);


                    if (isNaN(cantidadActual)) cantidadActual = 0;
                    if (isNaN(cantidadAgregada)) cantidadAgregada = 0;

                    let nuevaCantidad = cantidadActual + cantidadAgregada;
                    cantidadInput.val(nuevaCantidad);

                    //establece la nueva cantidad en un span
                    if (cantidadTexto.length == 0) {
                        filaTabla.find('td:eq(2)').append('<span class="cantidad-texto">' +
                            nuevaCantidad + '</span>');
                    } else {
                        cantidadTexto.text(nuevaCantidad);
                    }


                    let precio = parseFloat(precioVenta);
                    let desc = parseFloat(descuento);

                    if (isNaN(precio)) precio = 0;
                    if (isNaN(desc)) desc = 0;

                    let nuevoSubtotal = (nuevaCantidad * precio) - desc;



                    // Actualiza subtotal visible
                    let subtotalTexto = filaTabla.find('td:eq(5) .subtotal-texto');
                    if (subtotalTexto.length == 0) {
                        filaTabla.find('td:eq(5)').append('<span class="subtotal-texto">' + nuevoSubtotal.toFixed(
                            2) + '</span>');
                    } else {
                        subtotalTexto.text(nuevoSubtotal.toFixed(2));
                    }

                    // Actualiza el total general sumando solo la diferencia
                    total = total - ((cantidadActual * precio) - desc) +
                        nuevoSubtotal;

                    //sale del each
                    return false;
                }
            });
        }
    </script>
@endpush
