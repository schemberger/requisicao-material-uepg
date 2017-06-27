<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/css/relatorio.css') }}" rel="stylesheet">
    <script src="{!! asset('bootstrap/js/jquery-1.2.6.pack.js') !!}"></script>
    <script src="{{ asset('/bootstrap/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

    {{--<script>--}}
    {{--function substitutePdfVariables() {--}}

    {{--function getParameterByName(name) {--}}
    {{--var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);--}}
    {{--return match && decodeURIComponent(match[1].replace(/\+/g, ' '));--}}
    {{--}--}}

    {{--function substitute(name) {--}}
    {{--var value = getParameterByName(name);--}}
    {{--var elements = document.getElementsByClassName(name);--}}

    {{--for (var i = 0; elements && i < elements.length; i++) {--}}
    {{--elements[i].textContent = value;--}}
    {{--}--}}
    {{--}--}}

    {{--['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection']--}}
    {{--.forEach(function(param) {--}}
    {{--substitute(param);--}}
    {{--});--}}
    {{--}--}}
    {{--</script>--}}

    <style type="text/css">
        footer {
            border: 0;
            margin: 0;
            padding: 0;
            height: 220mm;
            /*
            In the actual program this height is calculated dynamically in PHP as
            ($headerMargin - $topMargin) * 1.33
            */
        }
    </style>

    <script>
        function subst() {
            var vars = {};
            var x = document.location.search.substring(1).split('&');
            for (var i in x) {
                var z = x[i].split('=', 2);
                vars[z[0]] = unescape(z[1]);
            }
            var x = ['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection'];
            for (var i in x) {
                var y = document.getElementsByClassName(x[i]);
                for (var j = 0; j < y.length; ++j) y[j].textContent = vars[x[i]];
            }
        }
    </script>

</head>
<body onload="subst()">
<footer>

    <div class="row">
        <div class="col-lg-offset-1">

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