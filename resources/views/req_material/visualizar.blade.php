<div class="row">
    <div class="container-fluid">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="modal-header" role="tab" id="headingOne">
                    <div class="col-md-2">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne" class="btn btn-info btn-lg"
                           href="">Detalhes da Requisição</a>
                    </div>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <ul>
                            <li>
                                <label>N° Requisição: </label>
                                {{$requisicao->NR_RM}}
                            </li>
                            <li>
                                <label>Ano: </label>
                                {{$requisicao->ANO_RM}}
                            </li>
                            <li>
                                <label>Órgão: </label>
                                {{$orgao->nm_centro}}
                            </li>
                            <li>
                                <label>Data: </label>
                                {{date('d/m/Y', strtotime($requisicao->DT_EMISSAO))}}
                            </li>
                            <li>
                                <label>Fonte: </label>
                                @if(isset($fonte->NM_FONTE)) {{$fonte->NM_FONTE}} @endif
                            </li>
                            <li>
                                <label>Destino: </label>
                                {{$orgao_dest->nm_centro}}
                            </li>
                            <li>
                                <label>Conta Contábil: </label>
                                {{$requisicao->NR_CTAUEPG}}
                            </li>
                            <li>
                                <label>Local Entrega: </label>
                                {{$requisicao->LOC_ENTRG}}
                            </li>
                            <li>
                                <label>Complemento do Destino: </label>
                                {{$requisicao->COMPL_DEST}}
                            </li>
                            <li>
                                <label>Emissor: </label>
                                {{$requisicao->EMISSOR}}
                            </li>
                            <li>
                                <label>Receptor: </label>
                                {{$requisicao->RECEPTOR}}
                            </li>
                            <li>
                                <label>Justificativa: </label>
                                {{$requisicao->JUSTIFICA}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 3%" class="col-md-offset-1" id="info">
            <div class="col-xs-12">
                <div class="col-md-3">
                    <label>N° Requisição: </label>
                    {{$requisicao->NR_RM}}
                </div>

                <div class="col-md-2 col-md-offset-1">
                    <label>Ano: </label>
                    {{$requisicao->ANO_RM}}
                </div>

                <div class="col-md-6 col-md-offset-1">
                    <label>Órgão: </label>
                    {{$orgao->nm_centro}}
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 3%;">
        @if($tipo == 1)

            <div id="table">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-lg-offset-1">
                        <table class="table table-striped teste">
                            <thead>
                            <th>N°</th>
                            <th class="col-xs-6">Descrição do Item</th>
                            <th>Unidade</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Moeda</th>

                            @foreach($tabela as $ta)

                                <tr>
                                    <td>{{$ta->NR_ITEM}}</td>
                                    <td>
                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div>
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#{{$ta->NR_ITEM}}"
                                                           aria-expanded="false" aria-controls="collapseTwo">
                                                            {{str_limit($ta->NM_MAT, $limit = 50, $end = '...')}}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="{{$ta->NR_ITEM}}" class="panel-collapse collapse" role="tabpanel"
                                                     aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        {{$ta->NM_MAT}} {{$ta->COMPL_MAT}} {{$ta->COMPL_ITEMRM}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                </tr>
                            @endforeach

                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-offset-5" style="margin-top: 2%;">
                <a name="button1id" class="btn btn-warning btn-lg"
                   href="{{url('req_material/'.$requisicao->NR_RM.'/'.date('Y', strtotime($requisicao->DT_EMISSAO)).'/'.$requisicao->CD_CENTRO.'/duplicar')}}">
                    Duplicar Requisição</a>

                <a name="button1id" class="btn btn-success btn-lg" target="_blank"
                   href="{{url('relatorio/material/'.$requisicao->NR_RM.'/'.date('Y', strtotime($requisicao->DT_EMISSAO)).'/'.$requisicao->CD_CENTRO)}}">Imprimir</a>
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

                                </tr>
                            @endforeach

                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-offset-5" style="margin-top: 2%;">
                <a name="button1id" class="btn btn-warning btn-lg"
                   href="{{url('req_material/'.$requisicao->NR_RM.'/'.date('Y', strtotime($requisicao->DT_EMISSAO)).'/'.$requisicao->CD_CENTRO.'/duplicar')}}">
                    Duplicar Requisição</a>

                <a name="button1id" class="btn btn-success btn-lg" target="_blank"
                   href="{{url('relatorio/servico/'.$requisicao->NR_RM.'/'.date('Y', strtotime($requisicao->DT_EMISSAO)).'/'.$requisicao->CD_CENTRO)}}">Imprimir</a>
            </div>

        @endif
    </div>
    
    <div style="margin-top: 1%"></div>
</div>

<script>
    $('#accordion').on('show.bs.collapse', function () {
        $('#info').hide();
    });
    $('#accordion').on('hide.bs.collapse', function () {
        $('#info').show();
    });
</script>




