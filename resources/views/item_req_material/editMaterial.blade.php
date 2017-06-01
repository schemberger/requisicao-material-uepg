@extends('layouts.body')

@section('content')

    {!! Form::model($item, array('url' => 'item_req_material/updateMaterial/'.$item->NR_ITEM, 'method' => 'put', 'class'=>'top form-horizontal')) !!}

    <fieldset>

        <input type="hidden" name="nr_rm" value="{{$item->NR_RM}}">
        <input type="hidden" name="ano_rm" value="{{$item->ANO_RM}}">
        <input type="hidden" name="cd_centro" value="{{$item->CD_CENTRO}}">

    {{--ajax select--}}
    <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Material</label>
            <div class="col-md-4">

                <select class="itemName form-control select" name="itemName">
                    <option value="{{$item->CD_ALMOX}}{{$item->CD_MATCAT}}{{$item->CD_INDMAT}}"
                            selected="selected">{{$material->nm_mat}}</option>
                </select>

            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="justificativa">Complemento</label>
            <div class="col-md-4">
                <textarea class="form-control" id="compl_itemrm"
                          name="compl_itemrm">{{$item->COMPL_ITEMRM}}</textarea>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Unidade</label>
            <div class="col-md-2">
                <input id="unidade" name="unidade" class="form-control input-md"
                       type="text" value="{{$material->uni_matcat}}" disabled>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Quantidade</label>
            <div class="col-md-2">
                <input id="qt_item" name="qt_item" value="{{$item->QT_ITEM}}"
                       class="form-control input-md" type="text">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Valor Unitário</label>
            <div class="col-md-2">
                <input id="vl_unit" name="vl_unit" value="{{$item->VL_UNIT}}"
                       class="form-control input-md" type="text">
            </div>
        </div>

    @if($item->VL_UNIT == null)

        <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="selectbasic">Moeda</label>
                <div class="col-md-2">
                    <select name="id_moeda" id="id_moeda" class="form-control">
                        @foreach($moeda as $k)
                            <option value="{{$k->id_moeda}}">{{$k->ds_moeda}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

    @elseif($item->VL_UNIT != null)

        <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="selectbasic">Moeda</label>
                <div class="col-md-2">
                    <select name="id_moeda" id="id_moeda" class="form-control">
                        <option value="{{$item->ID_MOEDA}}">{{$ds_moeda->ds_moeda}}</option>
                        @foreach($moeda as $k)
                            <option value="{{$k->id_moeda}}">{{$k->ds_moeda}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        @endif

        <input type="hidden" id="descMaterial" name="descMaterial" value="">

        <input type="hidden" id="uni" name="uni" value="">

    <!-- Button (Double) -->
        <div class="form-group" style="margin-top: 3%;">
            <div class="col-md-8 col-lg-offset-4">
                <button type="submit" id="button1id" name="button1id" class="btn btn-success">Confirmar</button>
                <a href="{{ URL::previous() }}" class="btn btn-danger">Voltar</a>
            </div>
        </div>

    </fieldset>

    {!! Form::close() !!}

@stop

@section('end-script')

    <script type="text/javascript">
        $(function () {
            $("#vl_unit").maskMoney();
        })
    </script>

    <script>
        var usedNames = {};
        $("select[name='id_moeda'] > option").each(function () {
            if (usedNames[this.text]) {
                $(this).remove();
            } else {
                usedNames[this.text] = this.value;
            }
        });
    </script>

    <script type="text/javascript">

        $('.itemName').select2({
            minimumInputLength: 3,
            ajax: {
                url: '/requisicao_material/public/item_req_material/searchItem',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.nome + ' - ' + item.unidade,
                                id: item.codigo
                            }
                        })
                    };
                },
                cache: true
            }
        }).on("change", function (e) {

            var codigo = $(".itemName option:last-child").text();

            var aux = codigo.split(' - ');

            $('#unidade').val(aux[1]);

            $('#uni').val(aux[1]);

            $('#descMaterial').val(aux[0]);
        });

    </script>

@endsection