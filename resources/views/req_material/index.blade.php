@extends('layouts.body')

@section('content')

    <div class="container">

        <div class="row margin-material">
            <div class="col-sm-3 test">
                <!-- Select Basic -->
                <label class="control-label" for="selectbasic"></label>
                <div class="col-sm-12">
                    <select name="ano_rm" id="ano_rm" class="form-control" onchange="table()">
                        @while($ano_atual >= $ano_rm)
                            <option value="{{$ano_atual}}">{{$ano_atual}}</option>
                            <?php $ano_atual--; ?>
                        @endwhile
                    </select>
                </div>
            </div>

            <div class="col-sm-6 test">
                <!-- Select Basic -->
                <label class="control-label" for="selectbasic"></label>
                <div class="col-xs-12">
                    <select name="cd_centro" id="cd_centro" class="form-control">
                        <option hidden selected>Selecione um órgão.</option>
                        @foreach($nm_centro as $nm)
                            <option value="{{$nm->cd_centro}}">{{$nm->nm_centro}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>

                <a id="search" name="button1id" class="btn btn-primary glyphicon glyphicon-search"
                   href="{{url('req_material/showTable')}}"></a>

                <a id="novo" class="btn btn-default btn-success btn-lg glyphicon glyphicon-plus col-lg-offset-2"
                   href="{{url('req_material/create')}}" role="button"> Novo</a>
            </div>

        </div>

    </div>

@stop


@push('script')

@endpush

@section('end-script')

    <script>
        $("#search").click(function (event) {
            event.preventDefault();

            url = $(this).attr('href');

            ano_rm = $('#ano_rm').val();

            cd_centro = $('#cd_centro').val();

            if (cd_centro != "Selecione uma opção") {

                url = url + '/' + ano_rm + '/' + cd_centro;

                console.log(cd_centro);

                this.href = url;
                window.location = url;

            } else {
                swal("Selecione um órgão.")
            }

        });
    </script>

    <script>
        $("#novo").click(function (event) {
            event.preventDefault();

            url = $(this).attr('href');

            cd_centro = $('#cd_centro').val();

            if (cd_centro != "Selecione um órgão.") {

                url = url + '/' + cd_centro;

                this.href = url;
                window.location = url;

            } else {
                $('#novo').prop("disabled", true);
                swal("Selecione um órgão.")
            }

        });
    </script>

@stop