@extends('layouts.body')

@section('content')

    <div style="margin-top: 3%" class="col-md-offset-4">
        <ul>
            <li>Número da Requisição: {{$requisicao->NR_RM}}</li>
            <li>Ano da Requisição: {{$requisicao->ANO_RM}}</li>
            <li>Órgão: {{$orgao->nm_centro}}</li>
            <li>Órgão de Destino: {{$orgao_dest->nm_centro}}</li>
            <li>Complemento do Destino: {{$requisicao->COMPL_DEST}}</li>
            <li>Data de Emissão: {{date('d/m/Y', strtotime($requisicao->DT_EMISSAO))}}</li>
            <li>Emissor: {{$requisicao->EMISSOR}}</li>
            <li>Local de Entrega: {{$requisicao->LOC_ENTRG}}</li>
            <li>Receptor: {{$requisicao->RECEPTOR}}</li>
            <li>Justificativa: {{$requisicao->JUSTIFICA}}</li>
            <li>Fonte: @if(isset($fonte->NM_FONTE)) {{$fonte->NM_FONTE}} @endif</li>
            <li>Nº Conta Contábil: {{$requisicao->NR_CTAUEPG}}</li>
        </ul>
    </div>


    @if($tipo == 1)

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

@stop

@section('end-script')

@endsection
