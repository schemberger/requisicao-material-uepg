@extends('layouts.body')

@section('content')


    @if($tipo == 1)

        <div style="margin-top: 2%;" class="row">
            <div class="col-md-1 col-md-offset-2">
                <a href="{{url('req_material/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro.'/edit')}}"
                class="btn btn-danger btn-lg glyphicon glyphicon-arrow-left "> Voltar</a>
            </div>
            <div class="col-md-2 col-md-offset-2">
                <a href="{{url('relatorio/material/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro)}}"
                   class="btn btn-success btn-lg glyphicon glyphicon-print"> Imprimir</a>
            </div>
            <div class="col-md-2 col-md-offset-2">
                <a class="btn btn-default btn-primary btn-lg glyphicon glyphicon-plus"
                   href="{{url('item_req_material/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro.'/createMaterial')}}"
                   role="button"> Novo</a>
            </div>
        </div>

        <div id="table">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-offset-1">
                    <table class="table table-striped teste" style="margin-top: 2%;">
                        <thead>
                        <th class="col-xs-6">Descrição do Item</th>
                        <th>Unidade</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Moeda</th>
                        <th>
                            <div>Alterar</div>
                        </th>
                        <th>
                            <div>Excluir</div>
                        </th>
                        <th>
                            <div>Destinos</div>
                        </th>

                        @foreach($tabela as $ta)

                            <tr>
                                <td>
                                    {{$ta->NM_MAT}}
                                </td>

                                <td class="text-center">
                                    {{$ta->UNI_MATCAT}}
                                </td>

                                <td class="text-center">
                                    <?php $aux = explode('.', $ta->QT_ITEM) ?>
                                    @if($aux[1] == "000")
                                        {{$aux[0]}}
                                    @elseif($aux[1] != "000")
                                        {{$ta->QT_ITEM}}
                                    @endif
                                </td>

                                <td class="text-center" id="valor">
                                    @if($ta->VL_UNIT != null)
                                        R$
                                        {{money_format('%i' ,$ta->VL_UNIT)}}
                                    @endif
                                </td>

                                <td class="text-center">
                                    {{$ta->sigla_moeda}}
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-warning glyphicon glyphicon-pencil edit" id="edit" role="button"
                                       href="{{url('item_req_material/'.$ta->NR_RM.'/'.$ta->ANO_RM.'/'.$ta->CD_CENTRO.'/'.$ta->NR_ITEM.'/editMaterial')}}"></a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-danger glyphicon glyphicon-trash delete" role="button" id="delete"
                                       href="{{url('item_req_material/'.$ta->NR_RM.'/'.$ta->ANO_RM.'/'.$ta->CD_CENTRO.'/'.$ta->NR_ITEM.'/destroyMaterial')}}"></a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-info glyphicon glyphicon-search"
                                       href="{{url('#')}}"></a>
                                </td>
                            </tr>
                        @endforeach

                        </thead>
                    </table>
                </div>
            </div>
        </div>


    @elseif($tipo == 2)

        <div style="margin-top: 2%;" class="row">
            <div class="col-md-1 col-md-offset-2">
                <a href="{{url('req_material')}}" class="btn btn-danger btn-lg glyphicon glyphicon-arrow-left ">
                    Voltar</a>
            </div>
            <div class="col-md-2 col-md-offset-2">
                <a href="{{url('#')}}" class="btn btn-success btn-lg glyphicon glyphicon-print"> Imprimir</a>
            </div>
            <div class="col-md-2 col-md-offset-2">
                <a class="btn btn-default btn-primary btn-lg glyphicon glyphicon-plus"
                   href="{{url('item_req_material/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro.'/createServico')}}"
                   role="button"> Novo</a>
            </div>
        </div>

        <div id="table">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-offset-1">
                    <table class="table table-striped tabela teste">
                        <thead>
                        <th class="col-xs-6">Descrição do Serviço</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Moeda</th>
                        <th>
                            <div>Alterar</div>
                        </th>
                        <th>
                            <div>Excluir</div>
                        </th>
                        <th>
                            <div>Destinos</div>
                        </th>

                        @foreach($tabela as $ta)

                            <tr>
                                <td>
                                    {{$ta->DS_SERV}}
                                </td>

                                <td class="text-center">
                                    <?php $aux = explode('.', $ta->QT_ITEM) ?>
                                    @if($aux[1] == "000")
                                        {{$aux[0]}}
                                    @elseif($aux[1] != "000")
                                        {{$ta->QT_ITEM}}
                                    @endif
                                </td>

                                <td class="text-center" id="valor">
                                    @if($ta->VL_UNIT != null)
                                        R$
                                        {{money_format('%i' ,$ta->VL_UNIT)}}
                                    @endif
                                </td>

                                <td class="text-center">
                                    {{$ta->sigla_moeda}}
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-warning glyphicon glyphicon-pencil edit" id="edit" role="button"
                                       href="{{url('item_req_material/'.$ta->NR_RM.'/'.$ta->ANO_RM.'/'.$ta->CD_CENTRO.'/'.$ta->NR_ITEM.'/editServico')}}"></a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-danger glyphicon glyphicon-trash delete" role="button" id="delete"
                                       href="{{url('item_req_material/'.$ta->NR_RM.'/'.$ta->ANO_RM.'/'.$ta->CD_CENTRO.'/'.$ta->NR_ITEM.'/destroyServico')}}"></a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-info glyphicon glyphicon-search" id="edit"
                                       href="{{url('#')}}"></a>
                                </td>
                            </tr>
                        @endforeach

                        </thead>
                    </table>
                </div>
            </div>
        </div>

    @endif

@stop

@section('end-script')

    <script>
        $(".delete").click(function (event) {
            event.preventDefault();

            var url = $(this).attr('href');

            console.log(url);

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

                window.location.href = url;
            });
        });
    </script>

    <script>
        $().ready(function () {
            console.log($(".teste").attr('href'));
        });
    </script>

@endsection
