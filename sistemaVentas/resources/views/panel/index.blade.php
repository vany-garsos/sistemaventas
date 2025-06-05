@extends('template')

@section('title', 'Panel')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Panel</li>
        </ol>
        <!-- Filtros -->
        <form action="{{ route('panel') }}" method="GET">

            <!--Elegir un filtro por dia mes o rango de fechas-->
            <div class="row g-3 align-items-center mx-2">

                <div class="col-6 col-lg-2">
                    <div>
                        <label class="form-label" for="filtro">Selecciona un filtro</label>
                    </div>
                    <div>
                        <select class="form-control" name="filtro" id="filtro">
                            <option value="">Elige</option>
                            <option value="dia" {{ old('filtro') == 'dia' ? 'selected' : '' }}>Por día</option>
                            <option value="mes_anio" {{ old('filtro') == 'mes_anio' ? 'selected' : '' }}>Por mes y año
                            </option>
                            <option value="rango" {{ old('filtro') == 'rango' ? 'selected' : '' }}>Entre dos fechas
                            </option>
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

        <!--Tarjetas contenedoras-->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <!--Tarjeta de venta total-->
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Venta total</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $venta }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="d-flex justify-content-center align-items-center bg-success bg-gradient text-white rounded-circle shadow"
                                        style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-dollar-sign fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <!--Tarjeta de cliente con mayor venta-->
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Cliente #1</p>
                                        <h5 class="font-weight-bolder">
                                            @if ($clientemayor)
                                                {{ $clientemayor->cliente->persona->razon_social }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="d-flex justify-content-center align-items-center bg-warning bg-gradient text-white rounded-circle shadow"
                                        style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-medal"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <!--Tarjeta de numero total de ventas-->
                            <div class="row">

                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">No. total de ventas</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $numeroventas }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="d-flex justify-content-center align-items-center bg-danger bg-gradient text-white rounded-circle shadow"
                                        style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-hashtag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <!--Graficos-->
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6>Gráfico de productos más vendidos</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                            <div class="d-flex justify-content-between" id="descripcion" style="display: none;">
                                <span id="texto" class="font-weight-bold"></span>
                            </div>

                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="productosMayorVenta" class="chart-canvas" height="300"></canvas>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
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

            } else if (opcion === 'todos') {
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
    <script>
        const labels = {!! json_encode($datos->pluck('nombre')) !!};
        const data = {!! json_encode($datos->pluck('total_vendido')) !!};
        let ctxProductos = document.getElementById('productosMayorVenta').getContext('2d');
        let myChart = new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad vendida',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            min: 0
                        }
                    }]
                }
            }
        });
    </script>
@endpush
