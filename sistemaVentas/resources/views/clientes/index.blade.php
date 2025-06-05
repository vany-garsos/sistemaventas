@extends('template')

@section('tite', 'clientes')

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
        <h1 class="mt-4 text-center">Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>


        <div class="mb-4">
            @can('crear-cliente')
                <a href="{{ route('clientes.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo
                        registro</button></a>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla clientes
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Tipo persona</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->persona->razon_social }}</td>
                                <td>{{ $cliente->persona->direccion }}</td>
                                <td>{{ $cliente->persona->tipo_persona }}</td>
                                <td>
                                    @if ($cliente->persona->estado == 1)
                                        <span class="rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        @can('editar-cliente')
                                            <form action="{{ route('clientes.edit', ['cliente' => $cliente]) }}" method="GET">
                                                <button type="submit" class="btn btn-warning">Editar</button>
                                            </form>
                                        @endcan

                                        @can('eliminar-cliente')
                                            @if ($cliente->persona->estado == 1)
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $cliente->id }}">Eliminar</button>
                                            @else
                                                <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $cliente->id }}">Restaurar</button>
                                            @endif
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                            <!-- Modal eliminar cliente-->
                            <div class="modal fade" id="confirmModal-{{ $cliente->id }}" tabindex="-1"
                                aria-labelledby="confirmModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                {{ $cliente->persona->estado == 1 ? 'Eliminar cliente' : 'Restaurar cliente' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $cliente->persona->estado == 1 ? '¿Seguro deseas eliminar este cliente?' : '¿Deseas restaurar el cliente?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>

                                            <form action="{{ route('clientes.destroy', $cliente->persona->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">{{ $cliente->persona->estado == 1 ? 'Sí, eliminar' : 'Sí, restaurar' }}</button>
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
