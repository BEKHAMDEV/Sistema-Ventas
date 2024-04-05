@extends('template')

@section('title', 'Perfil')

@push('css')
    {{-- SWEET ALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h1 class="mt-4 text-center">Configurar perfil</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Configurar Perfil</li>
        </ol>

        <div class="card mt-5">

            <div class="m-4">
                @if ($errors->any())
                    @foreach ($errors->all() as $item)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$item}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @else
                @endif
            </div>

            <form class="card-body" action="{{ route('profile.update', ['profile' => $user]) }}" method="POST">
                @method('PATCH')
                @csrf

                {{-- Nombre --}}
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                            <input disabled type="text" class="form-control" value="Nombres">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                        </div>
                    </div>
                </div>

                {{-- Email --}}
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                            <input disabled type="text" class="form-control" value="Email">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                            <input disabled type="text" class="form-control" value="Contraseña">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col text-center">
                    <input class="btn btn-success" type="submit" value="Guardar cambios">
                </div>
            </form>
        </div>
    </div>
    
@endsection

@push('js')
@endpush