<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Requisição de Material</title>

    <link href="{{ asset('/bootstrap/css/sticky-footer.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/css-layout-master.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/modal-success.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/css-gerais.css') }}" rel="stylesheet">

    <link href="{{ asset('sweetalert-master/dist/sweetalert.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="{!! asset('bootstrap/js/jquery-1.2.6.pack.js') !!}"></script>
    <script src="{!! asset('bootstrap/js/jquery.maskedinput-1.1.4.pack.js') !!}"></script>

    <script src="{!! asset('sweetalert-master/dist/sweetalert.min.js') !!}"></script>

    <script src="{{ asset('/bootstrap/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

    {{--Link para plugin validacao jquery--}}
    <script src="{{ asset('validation/dist/jquery.validate.js') }}"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


    {{--Link para componente autocomplete usado em view--}}
    <script src="{{ asset('/select2/dist/js/select2.js') }}"></script>
    <link href="{{ asset('/select2/dist/css/select2.css') }}" rel="stylesheet">

    {{--Máscara moedas--}}
    <script src="{{ asset('/bootstrap/js/jquery.maskMoney.js') }}"></script>

    <link href="{{ asset('/imagens/logo2.ico') }}" rel="shortcut icon" type="image/x-icon">

    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>--}}

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript">
        $(window).load(function () {
            $('#myModal').modal('show');
        });
    </script>

    <noscript>
        <meta http-equiv="refresh" content="2; url= https://sistemas.uepg.br/producao/suplementares/NTI/js_erro.html"
              &gt;&lt>
    </noscript>

    @stack('script')

</head>
<body>
@yield('body')
</body>
</html>

@yield('end-script')

