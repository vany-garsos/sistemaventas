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
        <div class="row">
            <!--Clientes-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-people-group px-2"></i><span>Clientes</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Cliente;
                                $clientes = count(Cliente::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $clientes }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('clientes.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <!--Categoria-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-tag px-2"></i><span>Categorias</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Categoria;
                                $categorias = count(Categoria::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $categorias }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('categorias.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <!--Compra-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-store px-2"></i><span>Compras</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Compra;
                                $compras = count(Cliente::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $compras }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('compras.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <!--Marcas-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-bullhorn px-2"></i><span>Marcas</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Marca;
                                $marcas = count(Marca::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $marcas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('marcas.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

              <!--Productos-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-brands fa-shopify px-2"></i><span>Productos</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Producto;
                                $productos = count(Producto::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $productos }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('productos.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

              <!--Proveedores-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-user-group px-2"></i><span>Proveedores</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Proveedore;
                                $proveedores = count(Proveedore::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $proveedores }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('proveedores.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

              <!--Usuarios-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-user px-2"></i><span>Usuarios</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\User;
                                $users = count(User::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $users }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('users.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
               <!--Ventas-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-cart-shopping px-2"></i><span>Ventas</span>
                            </div>
                            <div class="col-4">
                                <?php
                                use App\Models\Venta;
                                $ventas = count(Venta::all());
                                ?>
                                <p class="text-center fw-bold fs-4">{{ $ventas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('ventas.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
   
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
