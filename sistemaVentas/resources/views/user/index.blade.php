@extends('template')

@section('title', 'usuarios')

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
        <h1 class="mt-4 text-center">Usuarios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
        </ol>


        <div class="mb-4">
            <a href="{{ route('users.create') }}"><button type="button" class="btn btn-primary">Añadir un nuevo usuarrio</button></a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de usuarios
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody> 
                        @foreach($users as $user)
                           <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>  
                                <td>{{$user->getRoleNames()->first()}}</td>
                                     <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <form action="{{ route('users.edit', ['user' => $user]) }}"
                                            method="GET">
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>  
                                              <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $user->id }}">Eliminar</button>       
                                    </div>
                                </td>
                           </tr>
                            <!-- Modal eliminar usuario-->
                            <div class="modal fade" id="confirmModal-{{ $user->id }}" tabindex="-1"
                                aria-labelledby="confirmModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                              Eliminar usuario
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro deseas al usuario?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>

                                            <form action="{{ route('users.destroy', ['user'=>$user->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">Sí, eliminar</button>
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
