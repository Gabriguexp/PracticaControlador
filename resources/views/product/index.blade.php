@extends('base')

<!-- head, header, body, footer, js-->
@section('head')
    <title>Tienda Vergeles | Productos</title>
    <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}" type="text/css" />
@endsection
@section('body')

    <div class="modal" id="modalDelete" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Confirm delete?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form id="modalDeleteResourceForm" action="" method="post">
                @method('delete')
                @csrf
                <input type="submit" class="btn btn-primary" value="Delete resource"/>
            </form>
          </div>
        </div>
      </div>
    </div>

@if (isset($message))
    @if ($code == 200)
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endif

@endif
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">Tienda Vergeles</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    @if(isset($token))
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded">Admin</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a href ="{{url('logout') }}"class="nav-link py-3 px-0 px-lg-3 rounded">Cerrar sesión</a></li>
                    @else
                    <li class="nav-item mx-0 mx-lg-1"><a href ="{{url('login') }}"class="nav-link py-3 px-0 px-lg-3 rounded">Iniciar sesión</a></li>
                    @endif
            </div>
        </div>
    </nav>
        <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            @if (isset($message) && isset($code))
                @if ($code == 200)
                    <div class="alert alert-success" role="alert">    
                @else
                    <div class="alert alert-danger" role="alert">
                @endif
            
                {{ $message }}
            </div>
            @endif
            @if (count($products) == 0)
            <h3>No se han encontrado productos.</h3>
            @else
            <table class="table">
                <thead>
                    <td><h4>Nombre</h4></td>
                    <td><h4>Precio</h4></td>
                </thead>
                @foreach ($products as $product)
                    <tr>
                        <td>{{$product['name'] }}</td>
                        <td>{{$product['price'] }}€</td>
                        <td><a class="link table-option" href="{{url('products/'.$product['id']) }}">Ver detalle</a></td>
                        @if(isset($token))
                        <td><a class="link table-option" href="{{url('products/'.$product['id'].'/edit') }}">Editar</a></td>
                        <td><a class="link table-option" href="javascript: void(0);" data-url="{{ url('products/' . $product['id']) }}" data-bs-toggle="modal" data-bs-target="#modalDelete">Borrar</a><td></td>
                        @endif
                        
                    </tr>
            @endforeach    
            </table>
            @endif
            @if(isset($token))
                <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
                <a class="link"href="{{url('products/create')}}">Añadir nuevo producto</a>
            @endif
    </div>
    </header>
        <!-- Footer-->
        <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Location</h4>
                        <p class="lead mb-0">
                            C/ Primavera
                            <br />
                            Granada, España
                        </p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Around the Web</h4>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="text-uppercase mb-4">About Freelancer</h4>
                        <p class="lead mb-0">
                            Freelance is a free to use, MIT licensed Bootstrap theme created by
                            <a href="http://startbootstrap.com">Start Bootstrap</a>
                            .
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright &copy; G.G 2021</small></div>
        </div>

@endsection

@section('js')

<script type="text/javascript" src="{{ url('assets/js/delete.js') }}"></script>
@endsection