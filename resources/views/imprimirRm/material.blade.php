@extends('layouts.relatorio.master')

@section('relatorio')


    <div class="row">
        <div class="col-lg-offset-1">

            <div id="table">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1" style="margin-top: 2%;">
                        <table class="table table-striped teste">
                            <thead style="font-size: 10px">
                            <th class="text-left">Quant.</th>
                            <th class="text-left">Unid.</th>
                            <th class="text-center col-xs-8">Discriminação do Material</th>
                            <th class="pull-right">Valor</th>
                            @foreach($item as $ta)

                                <tr>
                                    <td class="text-left">
                                        <?php $aux = explode('.', $ta->QT_ITEM) ?>
                                        @if($aux[1] == "000")
                                            {{$aux[0]}}
                                        @elseif($aux[1] != "000")
                                            {{$ta->QT_ITEM}}
                                        @endif
                                    </td>

                                    <td class="text-left">
                                        {{$ta->UNI_MATCAT}}
                                    </td>

                                    <td>
                                        {{$ta->NM_MAT}}
                                    </td>

                                    <td class="text-right" id="valor">
                                        @if($ta->VL_UNIT != null)
                                            R$
                                            {{money_format('%i' ,$ta->VL_UNIT)}}
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 42%;">

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
            <div class="col-xs-7">
                Destino: {{$orgao_destino->nm_centro}}
            </div>
            <div class="col-xs-4 col-xs-offset-1">
                {{$requisicao->CD_CCDEST}}
            </div>
        </div>

        @if(isset($requisicao->COMPL_DEST))
            <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%;">
                {{$requisicao->COMPL_DEST}}
            </div>
        @endif

        <div class="col-xs-12 col-xs-offset-1" style="padding-top: 1%;">
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

    </div>

@stop