@extends('layouts.body')

@section('content')


        <div style="margin-top: 2%;" class="row">
            <div class="col-md-1 col-md-offset-2">
                <a href="{{url('item_req_material/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro.'/showItens')}}"
                   class="btn btn-danger btn-lg glyphicon glyphicon-arrow-left "> Voltar</a>
            </div>

            <div class="col-md-2 col-md-offset-5">
                <a class="btn btn-default btn-primary btn-lg glyphicon glyphicon-plus novo"
                   href="{{url('destino/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro.'/'.$nr_item .'/create')}}"
                   role="button"> Novo</a>
            </div>
        </div>

        <div id="table">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-offset-1">
                    <table class="table table-striped teste" style="margin-top: 2%;">
                        <thead>
                        <th class="col-xs-4">Descrição do Item</th>
                        <th>Orgão Destino</th>
                        <th>Quantidade</th>
                        <th>
                            <div>Alterar</div>
                        </th>
                        <th>
                            <div>Excluir</div>
                        </th>

                        @foreach($tabela as $ta)

                            <tr>
                                <td>
                                    {{$ta->nm_mat}}
                                </td>

                                <td>
                                    {{$ta->nm_centro}}
                                </td>
                                <td>
                                    <?php $aux = explode('.', $ta->QT_ITEMD) ?>
                                    @if($aux[1] == "000")
                                        {{$aux[0]}}
                                    @elseif($aux[1] != "000")
                                        {{$ta->QT_ITEMD}}
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-warning glyphicon glyphicon-pencil edit" id="edit" role="button"
                                       href="{{url('destino/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro. '/'. $nr_item. '/' . $ta->NR_ITEM_DESTINO .'/edit')}}"></a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-danger glyphicon glyphicon-trash delete" role="button" id="delete"
                                       href="{{url('destino/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro. '/'. $nr_item . '/' . $ta->NR_ITEM_DESTINO . '/destroy')}}"></a>
                                </td>
                            </tr>
                        @endforeach

                        </thead>
                    </table>
                </div>
            </div>
        </div>

@stop

@section('end-script')

    <script>
        $(".novo").click(function (event) {
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
                url: url + '/validationNovo',
                type: "get",
                dataType: "json",

                success: function (data) {
                    console.log(data)
                    if (data == "error") {
                        $('#container').hide();
                        swal("Erro!", "Todos os ítens ja foram destinados", "error");
                    } else {
                        window.location.replace(url)
                    }
                }
            });

        });
    </script>

    <script>
        $(".delete").click(function (event) {
            event.preventDefault();

            var url = $(this).attr('href');

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

@endsection
