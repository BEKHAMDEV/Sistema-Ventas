@extends('template')

@section('title', 'Crear Venta')

@push('css')
    {{-- SWEET ALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Bootstrap Select --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Crear Venta</li>
        </ol>

        <div class="container-fluid">
            <form action='{{ route('ventas.store') }}' method="POST">
                @csrf
                <div class="row gy-4">

                    {{-- Venta Producto --}}
                    <div class="col-md-8">
                        <div class="text-white bg-primary p-1 text-center">
                            Detalles de la venta
                        </div>
                        <div class="p-3 border border-3 border-primary">
                            <div class="row">
                                {{-- Producto --}}
                                <div class="col-12 mb-4">
                                    <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" title="Busca un producto" data-size="5">
                                        @foreach ($productos as $item)
                                            <option {{ old('producto_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}-{{ $item->stock }}-{{ $item->precio_venta }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    {{-- @error('producto_id')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror --}}
                                </div>

                                {{-- Mostrar stock --}}
                                <div class="d-flex justify-content-end">
                                    <div class="col-md-6 mb-2">
                                        <div class="row">
                                            <label for="stock" class="form-label col-sm-4">En stock:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="stock" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 {{-- Cantidad --}}
                                 <div class="col-md-4 mb-2">
                                    <label for="cantidad" class="form-label">Cantidad:</label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control">
                                    {{-- @error('cantidad')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror --}}
                                </div>

                                {{-- Precio de venta --}}
                                <div class="col-md-4 mb-2">
                                    <label for="precio_venta" class="form-label">Precio de venta:</label>
                                    <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1" disabled>
                                    {{-- @error('precio_venta')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror --}}
                                </div>

                                {{-- Descuento --}}
                                <div class="col-md-4 mb-2">
                                    <label for="descuento" class="form-label">Descuento:</label>
                                    <input type="number" name="descuento" id="descuento" class="form-control">
                                    {{-- @error('descuento')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror --}}
                                </div>

                                {{-- Boton para agregar --}}
                                <div class="col-md-12 my-3 text-end">
                                    <button id="btn_agregar" type="button" class="btn btn-primary">Agregar</button>
                                </div>

                                {{-- Tabla para el detalle de la venta --}}
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="tabla_detalle" class="table table-hover">
                                            <thead class="table-dark text-white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio venta</th>
                                                    <th>Descuento</th>
                                                    <th>Subtotal</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="4">Sumas</th>
                                                    <th colspan="2"><span id="sumas">0</span></th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="4">IVA %</th>
                                                    <th colspan="2"><span id="iva">0</span></th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="4">Total</th>
                                                    <th colspan="2"><input type="hidden" name="total" value="0" id="inputTotal"><span id="total">0</span></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                {{-- Boton para cancelar venta --}}
                                <div class="col-md-12 mb-2">
                                    <button type="button" id="cancelar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Cancelar venta
                                      </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Venta --}}
                    <div class="col-md-4">
                        <div class="text-white bg-success p-1 text-center">
                            Datos generales
                        </div>
                        <div class="p-3 border border-3 border-success">
                            <div class="row">
                                {{-- Cliente --}}
                                <div class="col-md-12 mb-2">
                                    <label for="cliente_id" class="form-label">Cliente:</label>
                                    <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona" data-size="5">
                                        @foreach ($clientes as $item)
                                            <option {{ old('cliente_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->persona->razon_social }}</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror
                                </div>

                                {{-- Tipo de comprobante --}}
                                <div class="col-md-12 mb-2">
                                    <label for="comprobante_id" class="form-label">Comprobante:</label>
                                    <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick" title="Selecciona">
                                        @foreach ($comprobantes as $item)
                                            <option {{ old('comprobante_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->tipo_comprobante }}</option>
                                        @endforeach
                                    </select>
                                    @error('comprobante_id')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror
                                </div>

                                {{-- Numero de comprobante --}}
                                <div class="col-md-12 mb-2">
                                    <label for="numero_comprobante" class="form-label">Número de comprobante:</label>
                                    <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" required>
                                    @error('numero_comprobante')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror
                                </div>

                                {{-- Impuesto --}}
                                <div class="col-md-6 mb-2">
                                    <label for="impuesto" class="form-label">Impuesto:</label>
                                    <input type="text" name="impuesto" id="impuesto" class="form-control border-success" readonly>
                                    @error('impuesto')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror
                                </div>

                                {{-- Fecha --}}
                                <div class="col-md-6 mb-2">
                                    <label for="fecha" class="form-label">Fecha:</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>" readonly>
                                    <?php
                                    use Carbon\Carbon;
                                    $fecha_hora = Carbon::now()->toDateTimeString();
                                    ?>
                                    <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">
                                    {{-- @error('fecha')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                    @enderror --}}
                                </div>

                                {{-- User --}}
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                {{-- Botones --}}
                                <div class="col-md-12 my-3 text-center">
                                    <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Cancelar Venta -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmación</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Seguro que quieres cancelar la venta?
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btn_cancelar_venta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('js')
    {{-- Bootstrap 4, necesario para bootstrap select --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    {{-- Bootstrap select --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    {{-- Eventos --}}
    <script>
        $(document).ready(function () {

            $('#producto_id').change(mostrarValores);

            // Boton agregar producto
            $('#btn_agregar').click(function (e) { 
                agregarProducto();
            });

            // Boton para cancelar venta
            $('#btn_cancelar_venta').click(function (e) { 
                cancelarVenta();
            });

            // // Deshabilitar botones si no hay productos cargados
            disableButtons();

            $('#impuesto').val(impuesto + '%');
        });

        // Variables
        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let iva = 0;
        let total = 0;

        // Constantes
        const impuesto = 21;

        function mostrarValores(){
            let dataProducto = $('#producto_id').val().split('-');
            $('#stock').val(dataProducto[1]);
            $('#precio_venta').val(dataProducto[2]);
        }

        function disableButtons(){
            if(total == 0){
                $('#guardar').hide();
                $('#cancelar').hide();
            }else{
                $('#guardar').show();
                $('#cancelar').show();
            }
        }

        function agregarProducto(){
            let dataProducto = $('#producto_id').val().split('-');

            // Obtener valores de los campos
            let idProducto = dataProducto[0];
            let nameProducto = ($('#producto_id option:selected').text());
            let cantidad = $('#cantidad').val();
            let precioVenta = $('#precio_venta').val();
            let descuento = $('#descuento').val();
            let stock = $('#stock').val();

            if(descuento == ''){
                descuento = 0;
            }
            console.log('1');

            // Validaciones
            // 1-Para que los campos no esten vacios
            if (idProducto != '' && cantidad != '') {

                // 2- Para que los valores ingresados sean los correctos
                if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(descuento) >= 0) {

                    // 3- Para que la cantidad no supere el stock
                    if (parseFloat(cantidad) <= parseFloat(stock)) {
                        // Calcular valores
                        subtotal[cont] = round(cantidad * precioVenta - descuento);
                        sumas+= subtotal[cont];
                        iva = round(sumas/100 * impuesto);
                        total = round(sumas + iva);

                        let fila = '<tr id="fila_'+cont+'">' +
                                        '<th>'+ (cont + 1) +'</th>' +
                                        '<td><input type="hidden" name="arrayidproducto[]" value="'+idProducto+'">'+ nameProducto +'</td>' +
                                        '<td><input type="hidden" name="arraycantidad[]" value="'+cantidad+'">'+ cantidad +'</td>' +
                                        '<td><input type="hidden" name="arrayprecioventa[]" value="'+precioVenta+'">'+ precioVenta +'</td>' +
                                        '<td><input type="hidden" name="arraydescuento[]" value="'+descuento+'">'+ descuento +'</td>' +
                                        '<td>'+ subtotal[cont] +'</td>' +
                                        '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto('+cont+')"><i class="fa-regular fa-circle-xmark fs-3 text-white"></i></button></td>' +
                                    '</tr>';

                        // Acciones despues de añadir la fila
                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont++;
                        disableButtons();

                        // Mostrar los campos calculados
                        $('#sumas').html(sumas);
                        $('#iva').html(iva);
                        $('#total').html(total);
                        $('#impuesto').val(iva);
                        $('#inputTotal').val(total);

                        showModal('Producto agregado', 'success');
                    } else {
                        showModal('Stock incorrecto', 'error');
                    }
                } else {
                    showModal('Valores incorrectos', 'error');
                }
            } else {
                showModal('Le faltan campos por llenar', 'error');
            }
        }

        function eliminarProducto(indice){
            // Calcular valores
            sumas-= round(subtotal[indice]);
            iva = round(sumas/100 * impuesto);
            total = round(sumas + iva);

            // Mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#iva').html(iva);
            $('#total').html(total);
            $('#impuesto').val(iva);
            $('#inputTotal').val(total);
            $('#descuento').val(total);

            // Eliminar fila de la tabla
            $('#fila_'+indice).remove();

            // Actualizar vista de botones
            disableButtons();
        }

        function cancelarVenta(){
            // Eliminar el tbody de la tabla
            $('#tabla_detalle > tbody').empty();

            // Añadir una nueva fila a la tabla
            let fila = '<tr>' +
                            '<th></th>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                        '</tr>';
            $('#tabla_detalle').append(fila);

            // reiniciar valores de las variables
            cont = 0;
            subtotal = [];
            sumas = 0;
            iva = 0;
            total = 0;

            // Mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#iva').html(iva);
            $('#total').html(total);
            $('#impuesto').val(impuesto + '%');
            $('#inputTotal').val(total);

            limpiarCampos();

            // Actualizar vista de botones
            disableButtons();
        }

        function limpiarCampos() {
            let select = $('#producto_id');
            select.selectpicker();
            select.selectpicker('val', '');
            $('#cantidad').val('');
            $('#precio_compra').val('');
            $('#precio_venta').val('');
            $('#stock').val('');
            $('#descuento').val('');
        }

        // // Redondear con dos decimales
        function round(num, decimales = 2) {
            var signo = (num >= 0 ? 1 : -1);
            num = num * signo;
            if (decimales === 0) //con 0 decimales
                return signo * Math.round(num);
            // round(x * 10 ^ decimales)
            num = num.toString().split('e');
            num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
            // x * 10 ^ (-decimales)
            num = num.toString().split('e');
            return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
        }
        
        // // Alerta de error con mensje personalizado
        function showModal(message, icon){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
                Toast.fire({
                icon: icon,
                title: message
            });
        }
    </script>
@endpush