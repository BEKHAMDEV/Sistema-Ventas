<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Inicio de sesión del sistema" />
        <meta name="author" content="MatiasPalmero" />
        <title>Login - SB Admin</title>
        {{-- <link href="{{ asset('css/template.css') }}" rel="stylesheet" /> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <section class="vh-100 gradient-custom">
                        <div class="container py-5 h-100">
                          <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                              <div class="card bg-dark text-white" style="border-radius: 1rem;">
                                <div class="card-body p-5 text-center">
                      
                                  <div class="mb-md-5 mt-md-4 pb-5">
                      
                                    <h2 class="fw-bold mb-2 text-uppercase">Acceso al sistema</h2>
                                    <p class="text-white-50 mb-5">Ingresa tu email y contraseña!</p>
                      
                                    <div class="m-2">
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
                                    <form action="/login" method="POST">
                                        @csrf
                                        <div class="form-outline form-white mb-4">
                                            <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" />
                                            <label class="form-label" for="typeEmailX">Email</label>
                                        </div>
                        
                                        <div class="form-outline form-white mb-4">
                                            <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                                            <label class="form-label" for="typePasswordX">Contraseña</label>
                                        </div>
                                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Iniciar Sesión</button>
                                    </form>
                      
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    
                </main>
            </div>
            {{-- <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div> --}}
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js')}}"></script>
    </body>
</html>