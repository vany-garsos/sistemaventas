@extends('template')

@section('title', 'Editar proveedor')

@push('css')

<style>
 
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar proveedore</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">Crear Proveedor</li>
        </ol>

        <div class="container w-100 border border-1 border-primary rounded p-4 mt-3">
            <form action="{{ route('proveedores.update', ['proveedore'=>$proveedore])}}" method="POST">
                @method('PATCH')
                @csrf
                <div class="row g-3">
                   <!--INGRESO DE TIPO PERSONA-->
                    <div class="col-md-6">
                        <label for="tipo_persona" class="form-label">Tipo de cliente: <span class="fw-bolder">{{$proveedore->persona->tipo_persona}}</span> </label>
                    </div>
                     <!--Razon social---->
                     <div class="col-md-12 mb-2" id="box-razon-social">
                        @if ($proveedore->persona->tipo_persona == 'natural')
                            <label id="label-natural" class="form-label" for="razon_social">Nombres y Apellidos</label>
                        @else 
                            <label id="label-juridica" class="form-label" for="razon_social">Nombre de la empresa</label>
                        @endif

                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social', $proveedore->persona->razon_social)}}">
                         @error('razon_social')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror

                     </div>

                     <!--direccion-->
                     <div class="col-md-12">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $proveedore->persona->direccion)}}">
                        @error('direccion')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{route('proveedores.index')}}" class="btn btn-secondary">Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')

@endpush
