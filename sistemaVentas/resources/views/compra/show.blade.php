@extends('template')

@section('title', 'ver compra')

@push('css')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush


@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Ver Compra</li>
        </ol>
    </div>

    <div class="container w-100 rounded p-4 mt-3">
        <!--tipo comprobante-->
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                    <input disabled type="text" class="form-control" value="tipo de comprobante: ">
                </div>
            </div>
            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{$compra->comprobante->tipo_comprobante}}">
            </div>
        </div>
         <!--numero de comprobante-->
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                    <input disabled type="text" class="form-control" value="Número de comprobante: ">
                </div>
            </div>
            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{$compra->numero_comprobante}}">
            </div>
        </div>

        <!--Proveedor-->
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-user_tie"></i></span>
                    <input disabled type="text" class="form-control" value="Proveedor: ">
                </div>
            </div>
            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{$compra->proveedore->persona->razon_social}}">
            </div>
        </div>

        <!--Fecha-->
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                    <input disabled type="text" class="form-control" value="Fecha: ">
                </div>
            </div>
            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($compra->fecha_hora)->format('d-m-Y')}}">
            </div>
        </div>

        <!--Hora-->
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                    <input disabled type="text" class="form-control" value="Hora: ">
                </div>
            </div>
            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{ \Carbon\Carbon::parse($compra->fecha_hora)->format('H:i')}}">
            </div>
        </div>

         <!--Impuesto-->
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                    <input disabled type="text" class="form-control" value="Impuesto: ">
                </div>
            </div>
            <div class="col-sm-8">
                <input id="input-impuesto" disabled type="text" class="form-control" value="{{$compra->impuesto}}">
            </div>
        </div>

        <!--tabla-->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de detalle de la compra
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio de compra</th>
                            <th>Precio de venta</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compra->productos as $item)
                            <tr>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->pivot->cantidad}}</td>
                                <td>{{$item->pivot->precio_compra}}</td>
                                <td>{{$item->pivot->precio_venta}}</td>
                                <td class="td-subtotal">{{$item->pivot->cantidad * $item->pivot->precio_compra}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5"></th>
                        </tr>
                        <tr>
                            <th colspan="4">Sumas: </th>
                            <th id="th_suma"></th>
                        </tr>
                         <tr>
                            <th colspan="4">IVA: </th>
                            <th id="th_iva"></th>
                        </tr>
                         <tr>
                            <th colspan="4">Total: </th>
                            <th id="th_total"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>

//variables
let filasSubtotal = document.getElementsByClassName('td-subtotal');
let cont = 0;
let impuesto = $('#input-impuesto').val();

$(document).ready(function(){
    calcularValores();
});

function calcularValores(){
    for(let i = 0; i<filasSubtotal.length; i++){
        cont +=parseFloat(filasSubtotal[i].innerHTML);
    }

    $('#th_suma').html(cont);
    $('#th_iva').html(impuesto);
    $('#th_total').html(cont + impuesto);

}
</script>
@endpush
