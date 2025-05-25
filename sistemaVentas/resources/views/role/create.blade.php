@extends('template')

@section('title', 'Crear rol')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear rol</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">Crear rol</li>
        </ol>

        <div class="container w-100 border border-1 border-primary rounded p-4 mt-3">
            <form action="{{ route('roles.store')}}" method="POST">
                @csrf
                <div class="row g-3">
                   <!--Nombre del rol-->
                    <div class="row mb-4 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Nombre del rol</label>
                        <div class="col-sm-4">
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                        </div>
                        <div class="col-sm-6">
                            @error('name')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <!--permisos-->
                    <div class="col-12 mb-4">
                        <label for="" class="form-label">Permisos para rol:</label>
                        @foreach($permisos as $permiso)
                            <div class="form-check mb-2">
                                <input type="checkbox" name="permission[]" id="{{ $permiso->id}}" class="form-check-input" value="{{$permiso->id}}">
                                <label for="{{$permiso->id}}" class="form-check-label">{{$permiso->name}}</label>
                            </div>
                        @endforeach
                    </div>

                    @error('permission')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
   
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
