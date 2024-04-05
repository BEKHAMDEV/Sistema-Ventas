@extends('template')

@section('title', 'Ver Compra')

@push('css')
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver Compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Ver Compra</li>
        </ol>


        <div class="container-fluid border border-3 rounded p-5 mt-3">

            {{-- Tipo de comprobante --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                        <input type="text" class="form-control" value="Tipo de comprobante: " disabled>
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{{ $compra->comprobante->tipo_comprobante }}" disabled>
                </div>
            </div>

             {{-- Numero de comprobante --}}
             <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                        <input type="text" class="form-control" value="Número de comprobante: " disabled>
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{{ $compra->numero_comprobante }}" disabled>
                </div>
            </div>

            {{-- Proveedor --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                        <input type="text" class="form-control" value="Proveedor: " disabled>
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{{ $compra->proveedore->persona->razon_social }}" disabled>
                </div>
            </div>

            {{-- Fecha --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="text" class="form-control" value="Fecha: " disabled>
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($compra->fecha_hora)->format('d-m-Y') }}" disabled>
                </div>
            </div>

             {{-- Hora --}}
             <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                        <input type="text" class="form-control" value="Hora: " disabled>
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($compra->fecha_hora)->format('H:i') }}" disabled>
                </div>
            </div>

            {{-- Impuesto --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                        <input type="text" class="form-control" value="Impuesto: " disabled>
                    </div>
                </div>
                <div class="col-sm-8">
                    <input id="impuesto" type="text" class="form-control" value="{{ $compra->impuesto }}" disabled>
                </div>
            </div>

            {{-- Tabla--}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabla de detalle de la compra
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark text-white">
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
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->pivot->cantidad }}</td>
                                    <td>{{ $item->pivot->precio_compra }}</td>
                                    <td>{{ $item->pivot->precio_venta }}</td>
                                    <td class="td_subtotal">{{ ($item->pivot->cantidad) * ($item->pivot->precio_compra) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5"></th>
                            </tr>
                            <tr>
                                <th colspan="4">Sumas</th>
                                <th id="th_suma"></th>
                            </tr>
                            <tr>
                                <th colspan="4">IVA:</th>
                                <th id="th_iva"></th>
                            </tr>
                            <tr>
                                <th colspan="4">Total</th>
                                <th id="th_total"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script>

        // Variables

        let filaSubtotal = $('.td_subtotal');
        let cont = 0;
        let impuesto = $('#impuesto').val()

        $(document).ready(function () {
            calcularValores();
        });

        function calcularValores(){
            for (let i = 0; i < filaSubtotal.length; i++) {
                cont += parseFloat(filaSubtotal[i].innerHTML);
            }
            $('#th_suma').html(cont);
            $('#th_iva').html(impuesto);
            $('#th_total').html(cont+parseFloat(impuesto));
        }

    </script>
@endpush