@extends('template')

@section('title', 'Crear Compra')

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
        <h1 class="mt-4 text-center">Crear Compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Crear Compra</li>
        </ol>
    <div>
            

    <div class="container-fluid px-0">
        <form action='{{ route('compras.store') }}' method="POST">
            @csrf
            <div class="row">
                {{-- Compra Producto --}}
                <div class="col-md-8">
                    <div class="w-100 text-light bg-secondary py-1 text-center fw-semibold rounded-top-3">
                        Detalles de la compra
                    </div>
                    <div class="p-3 bg-body-secondary rounded-bottom-3">
                        <div class="row">
                            {{-- Producto --}}
                            <div class="col-12 mb-4">
                                <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" title="Busca un producto" data-size="5">
                                    @foreach ($productos as $item)
                                        <option {{ old('producto_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->codigo.' - '.$item->nombre }}</option>
                                    @endforeach
                                </select>
                                {{-- @error('producto_id')
                                    <small class="text-danger">{{'*'.$message}}</small>
                                @enderror --}}
                            </div>

                                {{-- Cantidad --}}
                                <div class="col-md-4 mb-2">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                                {{-- @error('cantidad')
                                    <small class="text-danger">{{'*'.$message}}</small>
                                @enderror --}}
                            </div>

                            {{-- Precio de compra --}}
                            <div class="col-md-4 mb-2">
                                <label for="precio_compra" class="form-label">Precio de compra:</label>
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">
                                {{-- @error('precio_compra')
                                    <small class="text-danger">{{'*'.$message}}</small>
                                @enderror --}}
                            </div>

                            {{-- Precio de venta --}}
                            <div class="col-md-4 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta:</label>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                                {{-- @error('precio_venta')
                                    <small class="text-danger">{{'*'.$message}}</small>
                                @enderror --}}
                            </div>

                            {{-- Boton para agregar --}}
                            <div class="col-md-12 my-3 text-end">
                                <button id="btn_agregar" type="button" class="btn btn-warning"><i class="fa-solid fa-cart-shopping"></i> Agregar</button>
                            </div>

                            {{-- Tabla para el detalle de la compra --}}
                            <div class="col-md-12">
                                <div class="table-responsive border-3">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="table-dark text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio compra</th>
                                                <th>Precio venta</th>
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

                            {{-- Boton para cancelar compra --}}
                            <div class="col-md-12 mb-2">
                                <button type="button" id="cancelar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Cancelar compra
                                    </button>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Producto --}}
                <div class="col-md-4">
                    <div class="text-white bg-secondary p-1 text-center fw-semibold rounded-top-3">
                        Datos generales
                    </div>
                    <div class="p-3 bg-body-secondary rounded-bottom-3">
                        <div class="row">
                            {{-- Proveedor --}}
                            <div class="col-md-12 mb-2">
                                <label for="proveedore_id" class="form-label">Proveedor:</label>
                                <select name="proveedore_id" id="proveedore_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona" data-size="5">
                                    @foreach ($proveedores as $item)
                                        <option {{ old('proveedore_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->persona->razon_social }}</option>
                                    @endforeach
                                </select>
                                @error('proveedore_id')
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
                                <input type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
                                <?php
                                use Carbon\Carbon;
                                $fecha_hora = Carbon::now()->toDateTimeString();
                                ?>
                                <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">
                                {{-- @error('fecha')
                                    <small class="text-danger">{{'*'.$message}}</small>
                                @enderror --}}
                            </div>

                            {{-- Botones --}}
                            <div class="col-md-12 my-3 text-center">
                                <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                            </div>

                        </div>
                    </div>
                    {{-- <div class="col-12 col-md-6 mb-4">
                        <label for="documento_id" class="form-label">Tipo de documento:</label>
                        <select name="documento_id" id="documento_id" class="form-select">
                            <option value="" selected>Selecciona una opción</option>
                            @foreach ($documentos as $item)
                                <option {{ old('documento_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->tipo_documento }}</option>
                            @endforeach
                        </select>
                        @error('documento_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div> --}}
                </div>
            </div>


            <!-- Modal Cancelar Compra -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quieres cancelar la compra?
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn_cancelar_compra" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
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
            // Boton agregar producto
            $('#btn_agregar').click(function (e) { 
                agregarProducto();
            });

            // Boton para cancelar compra
            $('#btn_cancelar_compra').click(function (e) { 
                cancelarCompra();
            });

            // Deshabilitar botones si no hay productos cargados
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
            let idProducto = $('#producto_id').val();
            let nameProducto = ($('#producto_id option:selected').text()).split(' - ')[1];
            let cantidad = $('#cantidad').val();
            let precioCompra = $('#precio_compra').val();
            let precioVenta = $('#precio_venta').val();

            // Validaciones
            // 1-Para que los campos no esten vacios
            if (nameProducto != '' && cantidad != '' && precioCompra!= '' && precioVenta != '') {

                // 2- Para que los valores ingresados sean los correctos
                if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(precioCompra) > 0 && parseFloat(precioVenta) > 0) {

                    // 3- Para que el preci ode compra sea menor que ele precio de venta
                    if (parseFloat(precioVenta) > parseFloat(precioCompra)) {
                        // Calcular valores
                        subtotal[cont] = round(cantidad * precioCompra);
                        sumas+= subtotal[cont];
                        iva = round(sumas/100 * impuesto);
                        total = round(sumas + iva);

                        let fila = '<tr id="fila_'+cont+'">' +
                                        '<th>'+ (cont + 1) +'</th>' +
                                        '<td><input type="hidden" name="arrayidproducto[]" value="'+idProducto+'">'+ nameProducto +'</td>' +
                                        '<td><input type="hidden" name="arraycantidad[]" value="'+cantidad+'">'+ cantidad +'</td>' +
                                        '<td><input type="hidden" name="arraypreciocompra[]" value="'+precioCompra+'">'+ precioCompra +'</td>' +
                                        '<td><input type="hidden" name="arrayprecioventa[]" value="'+precioVenta+'">'+ precioVenta +'</td>' +
                                        '<td>'+ subtotal[cont] +'</td>' +
                                        '<td><button class="btn btn-danger btn-sm justify-content-center" type="button" onClick="eliminarProducto('+cont+')"><i class="fa-regular fa-circle-xmark fs-5 text-white"></i></button></td>' +
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
                        showModal('Precio de compra incorrecto', 'error');
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

            // Eliminar fila de la tabla
            $('#fila_'+indice).remove();

            // Actualizar vista de botones
            disableButtons();
        }

        function cancelarCompra(){
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
            $('#impuesto').val(impuesto + '%');

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
        }

        // Redondear con dos decimales
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
        
        // Alerta de error con mensje personalizado
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