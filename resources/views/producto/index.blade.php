@extends('template')

@section('title', 'Productos')
    
@push('css')
    {{-- SWEET ALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DATATABLE --------------->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!---------------------------->
@endpush

@section('content')

    @if(session('success'))
        <script>
            let message = '{{ session('success') }}';
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
                Toast.fire({
                icon: "success",
                title: message
            });
        </script>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
        </ol>

        @can('crear-producto')
            <div class="mb-4">
                <a href="{{ route('productos.create') }}">
                    <button type="button" class="btn btn-primary">Añadir nuevo producto</button>
                </a>
            </div>
        @endcan

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Productos
            </div>
            <div class="card-body table-responsive">
                <table id="example" class="table table-light table-striped" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Presentación</th>
                            <th>Categorías</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->marca->caracteristica->nombre }}</td>
                                <td>{{ $item->presentacione->caracteristica->nombre }}</td>
                                <td>
                                    @foreach ($item->categorias as $category)
                                        <div class="container">
                                            <div class="row">
                                                <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{ $category->caracteristica->nombre }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @if ($item->estado == 1)
                                        <span class="fw-bolder rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="fw-bolder rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="text-info mx-1" style="border:none; background-color:transparent;" title="Ver detalle"  data-bs-toggle="modal" data-bs-target="#verModal-{{$item->id}}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    @can('editar-producto')
                                        <form class="d-inline" action="{{ route('productos.edit', ['producto' => $item]) }}" method="GET">
                                            <button type="submit" class="text-success mx-1" style="border:none; background-color:transparent;" title="Editar">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @can('eliminar-producto')
                                        @if ($item->estado == 1)
                                            <button type="button" class="text-danger mx-1" style="border:none; background-color:transparent;" title="Borrar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        @else
                                            <button type="button" class="text-success mx-1" style="border:none; background-color:transparent;" title="Restaurar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">
                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>

                            <!-- Modal VER DETALLE -->
                            <div class="modal fade" id="verModal-{{$item->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="confirmModalLabel">Detalles del producto</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <label><span class="fw-bolder">Descripción: </span> {{ $item->descripcion }}</label>
                                        </div>
                                        <div class="row mb-3">
                                            <label><span class="fw-bolder">Fecha de vencimiento: </span> {{ $item->fecha_vencimiento=='' ? 'No tiene.' : $item->fecha_vencimiento }}</label>
                                        </div>
                                        <div class="row mb-3">
                                            <label><span class="fw-bolder">Stock: </span>{{ $item->stock }}</label>
                                        </div>
                                        <div class="row mb-3">
                                            <label><span class="fw-bolder">Imagen: </span></label>
                                            <div>
                                                @if ($item->img_path != null)
                                                    <img src="{{ Storage::url('public/productos/'.$item->img_path) }}" alt="{{ $item->nombre}}" class="img-fluid img-thumbnail border-4 rounded">
                                                @else
                                                    <img src="" alt="{{ $item->nombre}}" class="">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                                </div>
                            </div>


                            <!-- Modal DELETE -->
                            <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="confirmModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $item->estado ==1 ? '¿Seguro deseas eliminar este producto?' : '¿Seguro deseas restaurar este producto?'}}
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('productos.destroy', ['producto' => $item->id]) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
@endsection

@push('js')
    <!-- DATATABLE -------------------->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        // new DataTable('#example');
        new DataTable('#example', {
            language: {
                info: 'Mostrar página _PAGE_ de _PAGES_',
                infoEmpty: 'No hay registros disponibles',
                infoFiltered: '(filtrado de _MAX_ registros totales)',
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'No se encontró nada - Lo siento',
                search: 'Buscar:',
                paginate: {
                    next:'Siguiente',
                    previous:'Anterior'
                }
            },
            order: [],
            // columns: [
            //     null,
            //     { orderSequence: ['desc', 'asc', ''] },
            //     { orderSequence: ['desc', 'asc', ''] },
            //     { orderSequence: null },
            //     { orderSequence: null },
            //     { orderSequence: null },
            //     { orderSequence: null },
            //     { orderSequence: null },
            //     { orderSequence: null }
            // ]
        });
    </script>
@endpush