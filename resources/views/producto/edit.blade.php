@extends('template')

@section('title', 'Editar producto')

@push('css')
    <style>
        #descripcion{
            resize: none;
        }
    </style>
    {{-- Bootstrap Select --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar Producto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Producto</a></li>
            <li class="breadcrumb-item active">Editar Producto</li>
        </ol>

        <div class="container row">
            <div class="col-12 col-md-9 border p-4">
                <form action='{{ route('productos.update', ['producto'=>$producto]) }}' method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row mb-4">
                        {{-- Codigo --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="codigo" class="form-label">Código:</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo', $producto->codigo) }}">
                            @error('codigo')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- Nombre --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}">
                            @error('nombre')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- Descripcion --}}
                        <div class="col-12 mb-4">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
                            @error('descripcion')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        
                        {{-- Fecha vencimiento --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $producto->fecha_vencimiento) }}">
                            @error('fecha_vencimiento')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- Imagen --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="img_path" class="form-label">Imagen:</label>
                            <input type="file" class="form-control" id="img_path" name="img_path" value="{{ old('img_path') }}">
                            @error('img_path')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- Marca --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="marca_id" class="form-label">Marca:</label>
                            <select title="Seleccione una marca..." data-live-search="true" data-size="5" name="marca_id" id="marca_id" class="form-control selectpicker show-tick">
                                @foreach ($marcas as $item)
                                    @if ($producto->marca_id == $item->id)
                                        <option selected value="{{ $item->id }}" {{ old('marca_id') == $item->id? 'selected': '' }}>{{ $item->nombre }}</option> 
                                    @else
                                        <option value="{{ $item->id }}" {{ old('marca_id') == $item->id? 'selected': '' }}>{{ $item->nombre }}</option> 
                                    @endif
                                @endforeach
                            </select>
                            @error('marca_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- Presentacion --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="presentacione_id" class="form-label">Presentación:</label>
                            <select title="Seleccione una presentación..." data-live-search="true" data-size="5" name="presentacione_id" id="presentacione_id" class="form-control selectpicker show-tick">
                                @foreach ($presentaciones as $item)
                                    @if ($producto->presentacione_id == $item->id)
                                        <option selected value="{{ $item->id }}" {{ old('presentacione_id') == $item->id? 'selected': '' }}>{{ $item->nombre }}</option>
                                    @else
                                        <option value="{{ $item->id }}" {{ old('presentacione_id') == $item->id? 'selected': '' }}>{{ $item->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('presentacione_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- Categorias --}}
                        <div class="col-12 col-md-6 mb-4">
                            <label for="categorias" class="form-label">Categorías:</label>
                            <select title="Seleccione una categoría..." data-live-search="true" data-size="5" name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                                @foreach ($categorias as $item)
                                    @if (in_array($item->id,$producto->categorias->pluck('id')->toArray()))
                                        <option selected value="{{ $item->id }}" {{ (in_array($item->id , old('categorias', []))) ? 'selected' : '' }}>{{ $item->nombre }}</option>
                                    @else
                                        <option value="{{ $item->id }}" {{ (in_array($item->id , old('categorias', []))) ? 'selected' : '' }}>{{ $item->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('categorias')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>


                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="Cargar" name="Cargar" title="Cargar">Guardar</button>
                        <a href="{{ route('productos.index') }}"><button type="button" class="btn btn-secondary bg-danger text-white" title="Cancelar" data-bs-dismiss="modal">Cerrar</button></a>
                    </div>
                </form>
            </div>
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
@endpush