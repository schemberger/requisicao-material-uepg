@extends('layouts.relatorio.master')

@section('relatorio')


    <div class="row">
        <div class="col-lg-offset-1">

            <div id="table">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1" style="margin-top: 12%; page-break-inside: avoid">
                        <table class="table table-striped">
                            <thead style="font-size: 12px">
                            <th class="text-left">Quant.</th>
                            <th class="text-center col-xs-8">Discriminação do Serviço</th>
                            <th class="pull-right">Valor</th>
                            @foreach($item as $ta)

                                <tr style="page-break-inside:avoid">
                                    <td class="text-left">
                                        <?php $aux = explode('.', $ta->QT_ITEM) ?>
                                        @if($aux[1] == "000")
                                            {{$aux[0]}}
                                        @elseif($aux[1] != "000")
                                            {{$ta->QT_ITEM}}
                                        @endif
                                    </td>

                                    <td style="text-align: justify;">
                                        {{$ta->DS_SERV}}
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

@stop