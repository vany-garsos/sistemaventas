@extends('template')

@section('title', 'perfil')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h1 class="mt-4 text-center">Configurar perfil</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
    </div>
    <div class="container">
        <form action="{{ route('profile.update', ['profile' => $user]) }}" method="POST">
            @method('PATCH')
            @csrf

            @if ($errors->any())
                @foreach ($errors->all() as $item)
                    <div class="mt-4">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $item }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach

            @endif

            <!--Nombre-->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Nombre">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $user->name) }}">
                </div>
            </div>


            <!--Email-->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Email">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}">
                </div>
            </div>

            <!--Password-->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Contraseña">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="col text-center">
                <input type="submit" value="Guardar cambios" class="btn btn-success">
            </div>
        </form>
    </div>
@endsection

@push('js')
@endpush
