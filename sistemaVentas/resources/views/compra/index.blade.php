@extends('template')

@section('tite', 'compras')

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
        <h1 class="mt-4 text-center">Compras</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Compras</li>
        </ol>


        <div class="mb-4">
            @can('crear-compra')
                <a href="{{ route('compras.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo
                        registro</button></a>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de compras
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Comprobante</th>
                            <th>Proveedor</th>
                            <th>Fecha y hora</th>
                            <th>Total</th>
                            @can('editar-compra' || 'eliminar-compra')
                                <th>Acciones</th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td>
                                    <p class="fw-semibold mb-1">{{ $compra->comprobante->tipo_comprobante }}</p>
                                    <p class="text-muted mb-0">{{ $compra->numero_comprobante }}</p>
                                </td>
                                <td>
                                    <p class="fw-semibold mb-1">{{ ucfirst($compra->proveedore->persona->tipo_persona) }}
                                    </p>
                                    <p class="text-muted mb-0">{{ $compra->proveedore->persona->razon_social }}</p>
                                </td>
                                <td>
                                    {{ $compra->fecha_hora }}
                                </td>
                                <td>
                                    {{ $compra->total }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        @can('mostrar-compra')
                                            <form action="{{ route('compras.show', ['compra' => $compra]) }}">
                                                <button type="submit" class="btn btn-info">Ver</button>
                                            </form>
                                        @endcan

                                        @can('eliminar-compra')
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $compra->id }}">Eliminar</button>
                                        @endcan
                                    </div>

                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $compra->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar compra</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro deseas eliminar la compra?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <form action="{{ route('compras.destroy', ['compra' => $compra->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sí, eliminar compra</button>
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
