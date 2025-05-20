@extends('template')

@section('title', 'Crear categoria')

@push('css')

<style>
    #box-razon-social{
        display: none;
    }
    #descripcion{
        resize: none;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Crear Cliente</li>
        </ol>

        <div class="container w-100 border border-1 border-primary rounded p-4 mt-3">
            <form action="{{ route('clientes.store')}}" method="POST">
                @csrf
                <div class="row g-3">
                   <!--INGRESO DE TIPO PERSONA-->
                    <div class="col-md-6">
                        <label for="tipo_persona" class="form-label">Tipo de cliente</label>
                        <select name="tipo_persona" id="tipo_persona" class="form-select">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="natural" {{old('tipo_persona')== 'natural' ? 'selected' : ''}}>Persona natural</option>
                            <option value="juridica" {{old('tipo_persona')== 'juridica' ? 'selected' : ''}}>Persona juridica</option>
                        </select>
                        
                        @error('tipo_persona')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                     <!--Razon social---->
                     <div class="col-md-6 mb-2" id="box-razon-social">
                        <label id="label-natural" class="form-label" for="razon_social">Nombres y Apellidos</label>
                        <label id="label-juridica" class="form-label" for="razon_social">Nombre de la empresa</label>

                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}">
                         @error('razon_social')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror

                     </div>

                     <!--direccion-->
                     <div class="col-md-12">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion')}}">
                        @error('direccion')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    <!--documento id-->
                    <div class="col-md-6">
                        <label for="documento_id" class="form-label">Tipo de documento</label>
                        <select name="documento_id" id="documento_id" class="form-select">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach($documentos as $documento)
                             <option value="{{$documento->id}}" {{old('documento_id')==$documento->id ? 'selected' : ''}}>{{$documento->tipo_documento}}</option>
                            @endforeach
                        </select>
                        
                        @error('documento_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!--Numero de documento-->
                     <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Numero de documento</label>
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento')}}">
                        @error('numero_documento')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
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
<script>
    $(document).ready(function(){
        $('#tipo_persona').on('change', function(){
            let selectValue = $(this).val();
            if(selectValue=='natural'){
                $('#label-juridica').hide();
                $('#label-natural').show();
            }else{
                $('#label-natural').hide();
                $('#label-juridica').show();
            }

            $('#box-razon-social').show();
        });
    });
</script>
@endpush
