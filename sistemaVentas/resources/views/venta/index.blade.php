@extends('template')

@section('title', 'ventas')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush



@section('content')
    @if (session('success'))
        <script>
            let message = "{{ session('success') }}"
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ventas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ventas</li>
        </ol>


        <div class="mb-4">
            <!-- Filtros -->
            <form action="{{route('ventas.index')}}" method="GET">

                <!--Elegir un filtro por dia mes o rango de fechas-->
                <div class="row g-3 align-items-center">

                    <div class="col-6 col-lg-2">
                        <div>
                            <label class="form-label" for="filtro">Filtro de búsqueda</label>
                        </div>
                        <div>
                            <select class="form-control" name="filtro" id="filtro">
                                <option value="">Selecciona una opción</option>
                                <option value="dia" {{ old('filtro') == 'dia' ? 'selected' : '' }}>Por día</option>
                                <option value="mes_anio" {{ old('filtro') == 'mes_anio' ? 'selected' : '' }}>Por mes y año
                                </option>
                                <option value="rango" {{ old('filtro') == 'rango' ? 'selected' : '' }}>Entre dos fechas
                                </option>
                                <option value="todos"{{old('filtro')== 'todos' ? 'selected' : ''}}>Todos</option>
                            </select>
                        </div>
                    </div>

                    <!--Opcion dia-->
                    <div id="select-dia" style="display: none;" class="col-6 col-lg-2">
                        <div>
                            <label for="fecha" class="form-label">Selecciona un día</label>
                        </div>
                        <div>
                            <input type="date" name="fecha_venta" class="form-control" value="{{ old('fecha_venta') }}">
                        </div>

                    </div>


                    <!--Opcion mes y año-->
                    <div id="select-mes" style="display: none;" class="col-6 col-lg-2">

                        <div>
                            <label class="form-label" for="anio">Selecciona un año</label>
                        </div>
                        <div>
                            <select class="form-control" name="anio">
                                <option value="">Selecciona un año</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>

                    <div id="select-anio" style="display: none;" class="col-6 col-lg-2">
                        <div>
                            <label class="form-label" for="mes">Selecciona un mes</label>
                        </div>
                        <div>
                            <select class="form-control" name="mes">
                                <option value="">Selecciona un mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option><!--  -->
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>


                    <!--Opcion entre rango de 2 fechas-->
                    <div id="semana" style="display: none;" class="col-6 col-lg-2">
                        <div>
                            <label for="semana_inicio" class="form-label">Fecha 1</label>
                        </div>
                        <div>
                            <input type="date" name="semana_inicio" id="semana_inicio" class="form-control">
                        </div>
                    </div>
                    <div id="semana2" style="display: none;" class="col-6 col-lg-2">
                        <div>
                            <label for="semana_fin" class="form-label">Fecha 2</label>
                        </div>
                        <div>
                            <input type="date" name="semana_fin" id="semana_fin" class="form-control">
                        </div>

                    </div>
                    <!--Boton de envio-->

                    <div class="col-6 col-lg-2 mt-5" style="display: none;" id="boton">
                        <button class="btn btn-secondary" id="envio" type="submit">Buscar</button>
                    </div>

                </div>
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>

 <div class="mb-4">
            @can('crear-venta')
                <a href="{{ route('ventas.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo
                        registro</button></a>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de ventas
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>

                            <th>Cliente</th>
                            <th>Fecha y hora</th>
                            <!-- <th>Usuario</th>-->
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>
                                    <p class="text-muted mb-0">{{ $venta->cliente->persona->razon_social }}</p>
                                </td>
                                <td>
                                    {{ $venta->fecha_hora }}
                                </td>
                                <!--  <td>
                                                {{ $venta->user->name }}
                                            </td>-->
                                <td>
                                    {{ $venta->total }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        @can('mostrar-venta')
                                            <form action="{{ route('ventas.show', ['venta' => $venta]) }}">
                                                <button type="submit" class="btn btn-info">Ver</button>
                                            </form>
                                        @endcan

                                        @can('eliminar-venta')
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $venta->id }}">Eliminar</button>
                                        @endcan
                                    </div>

                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $venta->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar venta</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro deseas eliminar la venta?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <form action="{{ route('ventas.destroy', ['venta' => $venta->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sí, eliminar venta</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function mostrarForm(e) {

            var opcion = e.target.value;

            let dia = document.getElementById('select-dia');
            let mes = document.getElementById('select-mes');
            let anio = document.getElementById('select-anio');
            let semana = document.getElementById('semana');
            let semana2 = document.getElementById('semana2');
            let boton = document.getElementById('boton');



            dia.style.display = 'none';
            mes.style.display = 'none';
            anio.style.display = 'none';
            semana.style.display = 'none';
            semana2.style.display = 'none';
            boton.style.display = 'none';


            if (opcion === 'dia') {
                dia.style.display = 'block';
                boton.style.display = 'block';


            } else if (opcion === 'mes_anio') {
                mes.style.display = 'block';
                anio.style.display = 'block';
                boton.style.display = 'block';

            } else if (opcion === 'rango') {
                semana.style.display = 'block';
                semana2.style.display = 'block';
                boton.style.display = 'block';

            } else if(opcion === 'todos'){
                boton.style.display = 'block';
            }


        }
        document.addEventListener('DOMContentLoaded', function() {
            const selectFiltro = document.getElementById('filtro');

            if (selectFiltro) {
                selectFiltro.addEventListener('change', mostrarForm);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
