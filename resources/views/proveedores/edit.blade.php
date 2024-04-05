@extends('template')

@section('title', 'Editar proveedor')

@push('css')
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar Proveedor</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">Editar Proveedor</li>
        </ol>

        <div class="container w-50 float-start">
            <form action='{{ route('proveedores.update', ['proveedore' => $proveedore]) }}' method="POST">
                @method('PATCH')
                @csrf
                <div class="row">
                    {{-- Tipo de Persona --}}
                    <div class="col-12 mb-4">
                        <label for="tipo_persona" class="form-label">Tipo de proveedor: <span class="fw-bold">{{ strtoupper($proveedore->persona->tipo_persona) }}</span></label>
                    </div>

                    {{-- Razón social --}}
                    <div class="col-12 mb-4" id="box-razon-social">
                        @if ($proveedore->persona->tipo_persona == 'natural')
                            <label id="label-natural" for="razon_social" class="form-label">Nombre y apellido:</label>
                        @else
                            <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa:</label>
                        @endif
                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social',$proveedore->persona->razon_social) }}">
                        @error('razon_social')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div class="col-12 mb-4">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $proveedore->persona->direccion) }}">
                        @error('direccion')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    {{-- Tipo de documento --}}
                    <div class="col-12 col-md-6 mb-4">
                        <label for="documento_id" class="form-label">Tipo de documento:</label>
                        <select name="documento_id" id="documento_id" class="form-select">
                            @foreach ($documentos as $item)
                                @if ($proveedore->persona->documento_id == $item->id)
                                    <option selected {{ old('documento_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->tipo_documento }}</option>
                                @else
                                    <option {{ old('documento_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->tipo_documento }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('documento_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    {{-- Número de documento --}}
                    <div class="col-12 col-md-6 mb-4">
                        <label for="numero_documento" class="form-label">Número de documento:</label>
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento', $proveedore->persona->numero_documento) }}">
                        @error('numero_documento')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
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