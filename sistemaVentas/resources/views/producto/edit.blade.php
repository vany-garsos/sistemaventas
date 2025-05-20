@extends('template')

@section('title', 'Editar producto')

@push('css')

<style>
    #descripcion{
        resize: none;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Editar producto</li>
        </ol>
        <div class="container w-100 border border-1 border-primary rounded p-4 mt-3">
            <form action="{{route('productos.update', ['producto'=>$producto])}}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <!--INGRESO DE CODIGO-->
                        <label for="codigo" class="form-label">Codigo</label>
                        <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $producto->codigo)}}">
                        @error('codigo')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    <!--INGRESO DE NOMBRE-->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $producto->nombre)}}">
                        @error('nombre')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    <!--INGRESO DE STOCK-->
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $producto->stock)}}">
                        @error('stock')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    <!--INGRESO DE FECHA VENCIMIENTO-->
                    <div class="col-md-6">
                        <label for="fecha_vencimiento" class="form-label">Fecha vencimiento</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{ old('fecha_vencimiento', $producto->fecha_vencimiento)}}">
                        @error('fecha_vencimiento')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    <!--INGRESO DE DESCRIPCION-->
                     <div class="col-md-12">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                     <!--INGRESO DE IMAGEN-->
                    <div class="col-md-6">
                        <label for="imagen_path" class="form-label">Imagen</label>
                        <input type="file" name="imagen_path" id="imagen_path" class="form-control" value="{{ old('imagen_path')}}" accept="Image/*">
                        @error('imagen_path')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                   <!--INGRESO DE MARCA-->
                    <div class="col-md-6">
                        <label for="marca_id" class="form-label">Marca</label>
                        <select name="marca_id" title="Seleccione una marca" id="marca_id" class="form-control selectpicker" data-live-search="true" data-size="4">
                            @foreach ($marcas as $item)
                            @if ($producto->marca_id == $item->id)
                                <option selected value="{{$item->id}}" {{old('marca_id')==$item->id ? 'selected' : ''}}>{{$item->nombre}}</option>
                            @else
                                <option value="{{$item->id}}" {{old('marca_id')==$item->id ? 'selected' : ''}}>{{$item->nombre}}</option>
                            @endif
                                
                            @endforeach
                        </select>
                        @error('marca_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    <!--INGRESO DE CATEGORIA-->
                     <div class="col-md-6">
                        <label for="categorias" class="form-label">Categoria</label>
                        <select name="categorias[]" title="Seleccione una categoria" id="categorias" class="form-control selectpicker"  data-live-search="true" data-size="4" multiple>
                            @foreach ($categorias as $item)
                            @if (in_array($item->id, $producto->categorias->pluck('id')->toArray()));
                                 <option selected value="{{$item->id}}" {{ (in_array($item->id, old('categorias',[]))) ? 'selected' : ''}}>{{$item->nombre}}</option>
                            @else
                                 <option value="{{$item->id}}" {{ (in_array($item->id, old('categorias',[]))) ? 'selected' : ''}}>{{$item->nombre}}</option>
                            @endif
                               
                            @endforeach
                        </select>
                        @error('categorias')
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
   <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush
