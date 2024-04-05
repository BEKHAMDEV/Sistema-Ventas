@extends('template')

@section('title', 'Crear proveedor')

@push('css')
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <style>
        #descripcion{
            resize: none;
        }

        #box-razon-social{
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Proveedor</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">Crear Proveedor</li>
        </ol>

        <div class="container w-50 float-start">
            <form action='{{ route('proveedores.store') }}' method="POST">
                @csrf
                <div class="row">
                    {{-- Tipo de Persona --}}
                    <div class="col-12 mb-4">
                        <label for="tipo_persona" class="form-label">Tipo de proveedor:</label>
                        <select name="tipo_persona" id="tipo_persona" class="form-select">
                            <option value="" selected>Selecciona una opción</option>
                            <option value="natural" {{ old('tipo_persona') == 'natural' ? 'selected' : '' }}>Persona natural</option>
                            <option value="juridica" {{ old('tipo_persona') == 'juridica' ? 'selected' : '' }}>Persona juridica</option>
                        </select>
                        @error('tipo_persona')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    {{-- Razón social --}}
                    <div class="col-12 mb-4" id="box-razon-social">
                        <label id="label-natural" for="razon_social" class="form-label">Nombre y apellido:</label>
                        <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa:</label>
                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social') }}">
                        @error('razon_social')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div class="col-12 mb-4">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
                        @error('direccion')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    {{-- Tipo de documento --}}
                    <div class="col-12 col-md-6 mb-4">
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
                    </div>

                    {{-- Número de documento --}}
                    <div class="col-12 col-md-6 mb-4">
                        <label for="numero_documento" class="form-label">Número de documento:</label>
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento') }}">
                        @error('numero_documento')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" id="Cargar" name="Cargar" title="Cargar">Cargar datos</button>
                    <a href="{{ route('proveedores.index') }}"><button type="button" class="btn btn-secondary bg-danger text-white" title="Cancelar" data-bs-dismiss="modal">Cerrar</button></a>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#tipo_persona').on('change', function(){
                let selectValue = $(this).val();
                // natural // juridica
                if(selectValue == 'natural'){
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