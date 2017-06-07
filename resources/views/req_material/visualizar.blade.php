@extends('layouts.body')

@section('content')

    <div class="col-md-offset-5" style="margin-top: 2%;">
        <a name="button1id" class="btn btn-primary btn-lg"
           href="{{url('req_material/'.$requisicao->NR_RM.'/'.date('Y', strtotime($requisicao->DT_EMISSAO)).'/'.$requisicao->CD_CENTRO.'/duplicar')}}">
            Duplicar Requisição</a>
    </div>

    <div class="container-fluid">

        <div style="margin-top: 3%" class="col-md-offset-1">
            <div class="col-xs-12">
                <div class="col-md-2">
                    <label>Número da Requisição: </label>
                    {{$requisicao->NR_RM}}
                </div>

                <div class="col-md-2 col-md-offset-1">
                    <label>Ano da Requisição: </label>
                    {{$requisicao->ANO_RM}}
                </div>

                <div class="col-md-7 col-md-offset-1">
                    <label>Órgão: </label>
                    {{$orgao->nm_centro}}
                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 1%">
                <div class="col-md-2">
                    <label>Data Emissão: </label>
                    {{date('d/m/Y', strtotime($requisicao->DT_EMISSAO))}}
                </div>

                <div class="col-md-2 col-md-offset-1">
                    <label>Fonte: </label>
                    @if(isset($fonte->NM_FONTE)) {{$fonte->NM_FONTE}} @endif
                </div>

                <div class="col-md-7 col-md-offset-1">
                    <label>Órgão de Destino: </label>
                    {{$orgao_dest->nm_centro}}
                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 1%">
                <div class="col-md-2">
                    <label>Conta Contábil: </label>
                    {{$requisicao->NR_CTAUEPG}}
                </div>

                <div class="col-md-2 col-md-offset-1">
                    <label>Local Entrega: </label>
                    {{$requisicao->LOC_ENTRG}}
                </div>

                <div class="col-md-3 col-md-offset-1">
                    <label>Complemento do Destino: </label>
                    {{$requisicao->COMPL_DEST}}
                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 1%">
                <div class="col-md-5">
                    <label>Emissor: </label>
                    {{$requisicao->EMISSOR}}
                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 1%">
                <div class="col-md-5">
                    <label>Receptor: </label>
                    {{$requisicao->RECEPTOR}}
                </div>
            </div>


            <div class="col-xs-12" style="margin-top: 1%">
                <div class="col-md-11">
                    <label>Justificativa: </label>
                    {{$requisicao->JUSTIFICA}}
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid" style="margin-top: 2%;">
        @if($tipo == 1)

            <div id="table" >
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-lg-offset-1">
                        <table class="table table-striped teste" >
                            <thead>
                            <th class="col-xs-6">Descrição do Item</th>
                            <th>Unidade</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Moeda</th>

                            @foreach($tabela as $ta)

                                <tr>
                                    <td>
                                        {{$ta->NM_MAT}}
                                    </td>

                                    <td class="text-center">
                                        {{$ta->UNI_MATCAT}}
                                    </td>

                                    <td class="text-center">
                                        {{$ta->QT_ITEM}}
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
                                </tr>
                            @endforeach

                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        @elseif($tipo == 2)

            <div id="table">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-lg-offset-1">
                        <table class="table table-striped tabela teste">
                            <thead>
                            <th class="col-xs-6">Descrição do Serviço</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Moeda</th>

                            @foreach($tabela as $ta)

                                <tr>
                                    <td>
                                        {{$ta->DS_SERV}}
                                    </td>

                                    <td class="text-center">
                                        {{$ta->QT_ITEM}}
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

                                </tr>
                            @endforeach

                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        @endif
    </div>




@stop

@section('end-script')

@endsection
