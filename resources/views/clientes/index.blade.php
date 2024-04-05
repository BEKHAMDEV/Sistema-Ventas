@extends('template')

@section('title', 'clientes')

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
        <h1 class="mt-4 text-center">Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>

        @can('crear-cliente')
            <div class="mb-4">
                <a href="{{ route('clientes.create') }}">
                    <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
                </a>
            </div>
        @endcan


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Clientes
            </div>
            <div class="card-body">
                <table id="example" class="table table-light table-striped" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Documento</th>
                            <th>Tipo de persona</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->persona->razon_social }}</td>
                                <td>{{ $item->persona->direccion }}</td>
                                <td>
                                    <p class="fw-normal d-inline">{{ $item->persona->documento->tipo_documento }}: </p>
                                    <p class="text-muted d-inline">{{ $item->persona->numero_documento }}</p>
                                </td>
                                <td>{{ $item->persona->tipo_persona }}</td>
                                <td>
                                    @if ($item->persona->estado == 1)
                                        <span class="fw-bolder rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="fw-bolder rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @can('editar-cliente')
                                        <form class="d-inline" action="{{ route('clientes.edit', ['cliente' => $item]) }}" method="GET">
                                            <button type="submit" class="text-success mx-1" style="border:none; background-color:transparent;" title="Editar">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @can('eliminar-cliente')
                                        @if ($item->persona->estado == 1)
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


                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="confirmModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $item->persona->estado ==1 ? '¿Seguro deseas eliminar este cliente?' : '¿Seguro deseas restaurar este cliente?'}}
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('clientes.destroy', ['cliente' => $item->persona->id]) }}" method="POST">
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
    <script src="{{ asset('js/lang_datatable.js')}}"></script>
@endpush