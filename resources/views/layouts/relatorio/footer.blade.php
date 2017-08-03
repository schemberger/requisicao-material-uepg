<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/relatorio.css') }}" rel="stylesheet">
    <script src="{!! asset('bootstrap/js/jquery-1.2.6.pack.js') !!}"></script>
    <script src="{{ asset('/bootstrap/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

    <script>
        function substitutePdfVariables() {

            function getParameterByName(name) {
                var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
                return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
            }

            function substitute(name) {
                var value = getParameterByName(name);
                var elements = document.getElementsByClassName(name);

                for (var i = 0; elements && i < elements.length; i++) {
                    elements[i].textContent = value;
                }
            }

            ['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection']
                .forEach(function(param) {
                    substitute(param);
                });
        }
    </script>

</head>
<body onload="substitutePdfVariables()">
<footer id="footer">

    <div class="row">
        <div class="col-lg-offset-1">

            <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%;">
                <div class="col-xs-4">
                    @if(isset($requisicao->CD_FONTE))
                        Fonte: {{$requisicao->CD_FONTE}}
                    @elseif(!isset($requisicao->CD_FONTE))
                        Fonte: -
                    @endif
                </div>

                <div class="col-xs-6 col-xs-offset-2">
                    N° Conta Órgão: {{$requisicao->NR_CTAUEPG}}
                </div>
            </div>

            <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%;">
                <div class="col-xs-12">
                    Destino: {{$orgao_destino->nm_centro}} -  {{$requisicao->CD_CCDEST}}
                </div>
            </div>

            @if(isset($requisicao->COMPL_DEST))
                <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%;">
                    {{$requisicao->COMPL_DEST}}
                </div>
            @endif

            <div class="col-xs-12 col-xs-offset-1" >
                <div class="col-xs-4">
                    Local de Entrega: {{$requisicao->LOC_ENTRG}}
                </div>
                <div class="col-xs-5 col-xs-offset-2">
                    Receptor: {{$requisicao->RECEPTOR}}
                </div>
            </div>

            <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%; text-align: justify">
                <div class="col-xs-10">
                    Justificativa: {{$requisicao->JUSTIFICA}}
                </div>
            </div>

            <div class="col-xs-12 col-xs-offset-1" style="padding-top: 4%; text-align: justify">
                <div class="col-xs-11">
                    Obs: {{$requisicao->OBS}}
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-offset-7">
                    Atenciosamente
                </div>
                <div class="col-xs-offset-6" style="padding-top: 3%;">
                    __________________________________
                </div>
            </div>

        </div>
    </div>
</footer>
</body>
</html>