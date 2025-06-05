@extends('template')

@section('tite', 'categorias')

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
        <h1 class="mt-4 text-center">Categorias</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Categorias</li>
        </ol>

        
            <div class="mb-4">
                @can('crear-categoria')
                <a href="{{ route('categorias.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo
                        registro</button></a>
                @endcan
            </div>
        

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla categorias
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->caracteristica->nombre }}</td>
                                <td>{{ $categoria->caracteristica->descripcion }}</td>
                                <td>
                                    @if ($categoria->caracteristica->estado == 1)
                                        <span class="rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        @can('editar-categoria')
                                            <form action="{{ route('categorias.edit', ['categoria' => $categoria]) }}"
                                                method="GET">
                                                <button type="submit" class="btn btn-warning">Editar</button>
                                            </form>
                                        @endcan

                                        @can('eliminar-categoria')
                                            @if ($categoria->caracteristica->estado == 1)
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $categoria->id }}">Eliminar</button>
                                            @else
                                                <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $categoria->id }}">Restaurar</button>
                                            @endif
                                        @endcan

                                    </div>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $categoria->id }}" tabindex="-1"
                                aria-labelledby="confirmModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                {{ $categoria->caracteristica->estado == 1 ? 'Eliminar categoría' : 'Restaurar categoria' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $categoria->caracteristica->estado == 1
                                                ? '¿Seguro deseas eliminar esta categoria?'
                                                : '¿Deseas restaurar la categoria?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>

                                            <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">{{ $categoria->caracteristica->estado == 1 ? 'Sí, eliminar' : 'Sí, restaurar' }}</button>
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
