@extends('template')

@section('tite', 'marcas')

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
        <h1 class="mt-4 text-center">Marcas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Marcas</li>
        </ol>


        <div class="mb-4">
            @can('crear-marca')
                <a href="{{ route('marcas.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo
                        registro</button></a>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de marcas
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            @can('editar-marca' || 'eliminar-marca')
                                <th>Acciones</th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($marcas as $marca)
                            <tr>
                                <td>{{ $marca->caracteristica->nombre }}</td>
                                <td>{{ $marca->caracteristica->descripcion }}</td>
                                <td>
                                    @if ($marca->caracteristica->estado == 1)
                                        <span class="rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        @can('editar-marca')
                                            <form action="{{ route('marcas.edit', ['marca' => $marca]) }}" method="GET">
                                                <button type="submit" class="btn btn-warning">Editar</button>
                                            </form>
                                        @endcan

                                        @can('eliminar-marca')
                                            @if ($marca->caracteristica->estado == 1)
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $marca->id }}">Eliminar</button>
                                            @else
                                                <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $marca->id }}">Restaurar</button>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $marca->id }}" tabindex="-1"
                                aria-labelledby="confirmModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                {{ $marca->caracteristica->estado == 1 ? 'Eliminar marca' : 'Restaurar marca' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $marca->caracteristica->estado == 1 ? '¿Seguro deseas eliminar esta marca?' : '¿Deseas restaurar la marca?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>

                                            <form action="{{ route('marcas.destroy', $marca->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">{{ $marca->caracteristica->estado == 1 ? 'Sí, eliminar' : 'Sí, restaurar' }}</button>
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
