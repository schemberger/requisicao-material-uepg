@extends('layouts.master')


@section('body')

    @include('sweet::alert')

    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="{{url('/')}}">
                <img alt="UEPG - Universidade Estadual de Ponta Grossa"
                     class="img-responsive" style="margin-top: -4px;">
            </a>
        </div>

        <div class="navbar-header navbar-right" style="padding: 0 15px;">
            <p class="navbar-text pull-left">
                @include(Config::get('sgiauthorizer.view.loggedUserView'))
            </p>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('message'))
        <div class="alert alert-danger">
            <strong>{{ session('message') }}</strong>
        </div>
    @endif

    @if (session('error'))
        <script>
            $( document ).ready(
                swal("{{ session('error') }}", "", "error")
            );
        </script>
    @endif

    @if (session('success'))

        <script>
            $( document ).ready(
                swal("{{ session('success') }}", "", "success")
            );
        </script>

    @endif

    @yield('login')


    @if(Auth::check())

        <div class="row">
            <div class="col-md-10 col-lg-offset-1" style="margin-top: 2%">


                <!-- Second navbar for categories -->
                <nav class="navbar navbar-default">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="{{url ('/')}}">Requisição de Material </a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right menu-superior">
                                <li><a href="{{url ('req_material')}}">Requisição</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Compras<b
                                                class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Quadro de Coleta</a></li>
                                        <li><a href="#">RPE</a></li>
                                        <li><a href="#">Guia de Transferência</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Teste</a></li>
                            </ul>

                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container -->
                </nav><!-- /.navbar -->
            </div>
        </div>


    @endif

    @yield('content')


    <footer class="_footer navbar navbar-default pull-left pull-down">
        <div class="container-fluid">
            <p class="navbar-text">© {{date("Y")}} - <a href="http://pitangui.uepg.br/nti" target="_blank">Núcleo de
                    Tecnologia de
                    Informação - UEPG</a>
                </br>Problemas na visualização? <a href="mailto: internet@uepg.br" target="_blank">internet@uepg.br</a>
            </p>

            <div class="navbar-header navbar-right hidden-xs">
                <a class="navbar-brand" href="http://pitangui.uepg.br/nti" target="_blank">
                    <img src="https://sistemas.uepg.br/producao/abertura/imagens/NTI-48x48.png"
                         alt="NTI - Núcleo de Tecnologia de Informação" class="img-responsive"
                         style="margin-top: -4px;">
                </a>
            </div>
        </div>
    </footer>

@endsection