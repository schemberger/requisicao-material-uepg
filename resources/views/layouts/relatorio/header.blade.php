<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/relatorio.css') }}" rel="stylesheet">
    <script src="{!! asset('bootstrap/js/jquery-1.2.6.pack.js') !!}"></script>
    <script src="{{ asset('/bootstrap/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

</head>
<body>

<div class="row">
    <div class="col-lg-offset-1">

        <div style="padding-top: 4%;">
            <div class="col-xs-2 col-xs-offset-1">
                <img src="{{ asset ('imagens/UEPG-logo.jpg')}}"
                     alt="UEPG - Universidade Estadual de Ponta Grossa"
                     class="img-responsive" style="height: 50px; width: 60px;">
            </div>
            <div class="col-xs-9">
                <h3 class="text-left">Universidade Estadual de Ponta Grossa</h3>
            </div>
        </div>

        <h3 class="text-center">PRÓ-REITORIA DE ASSUNTOS ADMINISTRATIVOS</h3>

        <div class="col-xs-12 col-xs-offset-1" style="padding-top: 5%;">
            <div class="col-xs-4">
                RM. N° {{$requisicao->ANO_RM}}
            </div>

            <div class="col-xs-4 col-xs-offset-3">
                EM {{date('d', strtotime($requisicao->DT_EMISSAO))}} de
                {{date('M', strtotime($requisicao->DT_EMISSAO))}} de {{date('Y', strtotime($requisicao->DT_EMISSAO))}}
            </div>
        </div>

        <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%;">
            <div class="col-xs-8">
                À PRÓ-REITORIA DE ASSUNTOS ADMINISTRATIVOS
            </div>
        </div>

        <div class="col-xs-12 col-xs-offset-1" style="padding-top: 2%; text-align: justify">
            {{$requisicao->CD_CENTRO}} - {{$orgao->nm_centro}}, através desta requisição de material solicita
            as providências administrativas que se fizerem necessárias para a aquisição do que abaixo está especificado.
        </div>

    </div>
</div>

</body>
</html>