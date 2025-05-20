@extends('template')

@section('tite', 'Productos')

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
        <h1 class="mt-4 text-center">Productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
        </ol>


        <div class="mb-4">
            <a href="{{ route('productos.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo
                    producto</button></a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla productos
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Categoria</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->marca->caracteristica->nombre }}</td>
                                <td>
                                    @foreach ($producto->categorias as $categoria)
                                        <div class="container">
                                            <div class="row">
                                                <span
                                                    class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{ $categoria->caracteristica->nombre }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($producto->estado == 1)
                                        <span class="rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <!--BOTONES DE ACCION--->
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                         <!--Editar-->
                                        <form action="{{ route('productos.edit', ['producto' => $producto]) }}"
                                            method="GET">
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>
                                        <!--Ver-->
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#openProduct-{{ $producto->id }}">Ver</button>

                                        <!--Eliminar / restaurar-->
                                        @if ($producto->estado == 1)
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $producto->id }}">Eliminar</button>
                                        @else
                                            <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $producto->id }}">Restaurar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal ver producto-->
                            <div class="modal fade" id="openProduct-{{ $producto->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del producto</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label><span class="fw-bolder">Descripcion:
                                                    </span>{{ $producto->descripcion == '' ? 'No existe descripcion' : $producto->descripcion }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label><span class="fw-bolder">Fecha de vencimiento:
                                                    </span>{{ $producto->fecha_vencimiento == '' ? 'No tiene' : $producto->fecha_vencimiento }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label><span class="fw-bolder">Stock:</span>{{ $producto->stock }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="fw-bolder">Imagen: </label>
                                                <div>
                                                    @if ($producto->imagen_path != null)
                                                        <img class="img-fluid img-thumbnail"
                                                            src="{{ Storage::url('public/productos/' . $producto->imagen_path) }}"
                                                            alt="{{ $producto->nombre }}">
                                                    @else
                                                        <label>{{ $producto->nombre }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal eliminar producto-->
                            <div class="modal fade" id="confirmModal-{{ $producto->id }}" tabindex="-1"
                                aria-labelledby="confirmModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                {{ $producto->estado == 1 ? 'Eliminar producto' : 'Restaurar producto' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $producto->estado == 1 ? '¿Seguro deseas eliminar este producto?' : '¿Deseas restaurar el producto?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>

                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">{{ $producto->estado == 1 ? 'Sí, eliminar' : 'Sí, restaurar' }}</button>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
