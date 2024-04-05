@extends('template')

@section('title', 'Editar categoría')

@push('css')

@endpush


@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar Categoría</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
            <li class="breadcrumb-item active">Editar Categoría</li>
        </ol>


        <div class="container w-50 float-start">
            <form action='{{ route('categorias.update', ['categoria' => $categoria]) }}' method="POST">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $categoria->caracteristica->nombre) }}">
                            <div id="nombreHelp" class="form-text">Ingresar nombre.</div>
                            @error('nombre')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $categoria->caracteristica->descripcion) }}</textarea>
                            <div id="idHelp" class="form-text">Ingresar descripción.</div>
                            @error('descripcion')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" id="Cargar" name="Cargar" title="Cargar">Actualizar</button>
                    <button type="reset" class="btn btn-secondary bg-danger text-white" title="Cancelar" data-bs-dismiss="modal">Limpiar</button>
                </div>
            </form>
        </div>

    </div>

@endsection


@push('js')

@endpush