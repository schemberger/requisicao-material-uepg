@extends('layouts.body')

@section('content')

    <div class="container">

        <div class="row margin-material">
            <div class="col-sm-3 test">
                <!-- Select Basic -->
                <label class="control-label" for="selectbasic"></label>
                <div class="col-sm-12">
                    <select name="ano_rm" id="ano_rm" class="form-control" onchange="table()">
                        <option value="{{$ano_rm}}">{{$ano_rm}}</option>
                        @while($ano_atual >= $ano_rm_min)
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
                    <select name="cd_centro" id="cd_centro" class="form-control" onchange="table()">
                        <option value="{{$cd_centro}}">{{$nm_centro_atual->nm_centro}}</option>
                        @foreach($nm_centro as $nm)
                            <option value="{{$nm->cd_centro}}">{{$nm->nm_centro}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <a id="search" name="button1id" class="btn btn-primary glyphicon glyphicon-search"
                   href="{{url('req_material/showTable')}}"></a>

                <a class="btn btn-default btn-success btn-lg glyphicon glyphicon-plus col-lg-offset-2"
                   href="{{url('req_material/create')}}" role="button" id="novo"> Novo</a>
            </div>

        </div>

        <div id="table">
            <div class="row">
                <table class="table table-striped teste" style="margin-top: 4%;">
                    <thead>
                    <th>Número</th>
                    <th>Data</th>
                    <th class="text-center col-xs-7">Justificativa</th>
                    <th>Orçamento</th>
                    <th>
                        <div style="width: 10%">Visualizar</div>
                    </th>
                    <th>
                        <div style="width: 10%">Excluir</div>
                    </th>
                    <th>
                        <div style="width: 10%">Alterar</div>
                    </th>

                    @foreach($tabela as $ta)

                        <tr>
                            <td>
                                {{$ta->nr_rm}}
                            </td>

                            <td>
                                {{date('d/m/Y', strtotime($ta->dt_emissao))}}
                            </td>

                            <td>
                                {{$ta->justificativa}}
                            </td>

                            <td class="text-right">
                                @if($ta->orcamento == 'S')
                                    <div class="glyphicon glyphicon-ok" style="color: green;"></div>
                                @endif
                            </td>

                            <td class="text-center">
                                <a class="btn btn-info glyphicon glyphicon-search visualizar" role="button"
                                   href="{{url('req_material/show/'.$ta->nr_rm.'/'.date('Y', strtotime($ta->dt_emissao)).'/'.$ta->CD_CENTRO)}}"></a>
                            </td>

                            <td class="text-center">
                                <a class="btn btn-danger glyphicon glyphicon-trash delete" role="button" id="delete"
                                   href="{{url('req_material/'.$ta->nr_rm.'/'.date('Y', strtotime($ta->dt_emissao)).'/'.$ta->CD_CENTRO.'/delete')}}"></a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-warning glyphicon glyphicon-pencil edit" id="edit"
                                   href="{{url('req_material/'.$ta->nr_rm.'/'.date('Y', strtotime($ta->dt_emissao)).'/'.$ta->CD_CENTRO.'/edit')}}"></a>
                            </td>
                        </tr>
                    @endforeach

                    </thead>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div id="data"></div>

            </div>
        </div>
    </div>


@stop


@push('script')

@endpush

@section('end-script')

    <script>
        var usedNames = {};
        $("select[name='ano_rm'] > option").each(function () {
            if (usedNames[this.text]) {
                $(this).remove();
            } else {
                usedNames[this.text] = this.value;
            }
        });
    </script>

    <script>
        var usedNames = {};
        $("select[name='cd_centro'] > option").each(function () {
            if (usedNames[this.text]) {
                $(this).remove();
            } else {
                usedNames[this.text] = this.value;
            }
        });
    </script>

    <script>
        $("#search").click(function (event) {
            event.preventDefault();

            url = $(this).attr('href');

            ano_rm = $('#ano_rm').val();

            cd_centro = $('#cd_centro').val();

            console.log(url);

            if (cd_centro != "Selecione uma opção") {

                url = url + '/' + ano_rm + '/' + cd_centro;

                console.log(cd_centro);

                this.href = url;
                window.location = url;

            } else {
                swal("Selecione uma opção.")
            }

        });
    </script>

    <script>
        $(".delete").click(function (event) {
            event.preventDefault();

            var url = $(this).attr('href');

            var ano_rm = $("#ano_rm option:selected").val();

            var cd_centro = $("#cd_centro option:selected").val();

            console.log(ano_rm, cd_centro);

            swal({
                title: "Tem certeza?",
                text: "Você não será capaz de recuperar esse dado.",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#DD6B55",
                confirmButtonColor: "#5cb85c",
                confirmButtonText: "Confirmar",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (!isConfirm) return;

                swal({
                    title: 'Carregando!',
                    imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif',
                    imageSize: '200x150',
                    animation: false,
                    showConfirmButton: false
                });

                $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                    success: function (data) {
                        console.log(data)
                        if (data.status == "Error") {
                            swal("Erro ao Excluir!", data.msg, "error");
                        } else {
                            swal("Feito!", data.msg, "success");
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>

    <script>

        $(".edit").click(function (event) {
            event.preventDefault();

            var url = $(this).attr('href');

            swal({
                title: 'Carregando!',
                imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif',
                imageSize: '200x150',
                animation: false,
                showConfirmButton: false
            });

            $.ajax({
                url: url + '/validationEdit',
                type: "get",
                dataType: "json",

                success: function (data) {
                    console.log(data)
                    if (data.status == "Error") {
                        $('#container').hide();
                        swal("Erro ao Editar!", data.msg, "error");
                    } else {
                        window.location.replace(url)
                    }
                }
            });

        });

    </script>

    <script>

        $(".visualizar").click(function (event) {
            event.preventDefault();

            var url = $(this).attr('href');

            swal({
                title: 'Carregando!',
                imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif',
                imageSize: '200x150',
                animation: false,
                showConfirmButton: false
            });

            $.ajax({
                url: url,
                type: "get",
                dataType: "json",

                success: function(data){

                    swal.close();

                    $('#data').html(data);

                    $('#myModal').modal('show');

                }
            });

        });

    </script>

    <script>
        $("#novo").click(function (event) {
            event.preventDefault();

            url = $(this).attr('href');

            cd_centro = $('#cd_centro').val();

            ano_rm = $('#ano_rm').val();

            var d = new Date();

            if(ano_rm >= d.getFullYear()){

                if (cd_centro != "Selecione um órgão.") {

                    url = url + '/' + cd_centro;

                    this.href = url;
                    window.location = url;

                } else {
                    $('#novo').prop("disabled", true);
                    swal("Selecione um órgão.")
                }
            }else{
                $('#novo').prop("disabled", true);
                swal("O ano não pode ser menor que o ano atual.")
            }



        });
    </script>

@stop