@extends('template')

@section('title', 'Crear usuario')

@push('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear usuario</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Crear usuario</li>
        </ol>

        <div class="container w-100 border border-1 border-primary rounded p-4 mt-3">
            <form action="{{ route('users.store')}}" method="POST">
                @csrf
                <div class="row g-3">
                   <!--Nombre-->
                    <div class="row mb-4 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Nombre del usuario</label>
                        <div class="col-sm-4">
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                        </div>
                        <div class="col-sm-6">
                            @error('name')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>
                     <!--Email-->
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                        </div>
                        <div class="col-sm-6">
                            @error('email')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>

                     <!--Password-->
                    <div class="row mb-4">
                        <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                        <div class="col-sm-4">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <div class="form-text text-info">
                                Escriba una contraseña segura, debe incluir números
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @error('password')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <!--Password-->
                    <div class="row mb-4">
                        <label for="password" class="col-sm-2 col-form-label">Confirmar contraseña</label>
                        <div class="col-sm-4">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <div class="form-text text-info">
                                Por favor, repite la contraseña
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @error('password_confirm')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <!--Roles-->
                    <div class="row mb-4">
                        <label for="password" class="col-sm-2 col-form-label">Seleccionar rol</label>
                        <div class="col-sm-4">
                            <select name="role" id="role" title="Seleccione un rol" class="form-control selectpicker"  data-live-search="true">
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}" @selected(old('role') == $role->name)>{{$role->name}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-sm-6">
                            @error('password')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
   <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush
