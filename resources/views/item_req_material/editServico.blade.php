@extends('layouts.body')

@section('content')

    @if (isset($mensagem))
        <script>
            $( document ).ready(
                swal("{{$mensagem }}", "", "success")
            );
        </script>
    @endif

    {!! Form::model($item, array('url' => 'item_req_material/updateServico/'.$item->NR_ITEM, 'method' => 'put',
     'class'=>'top form-horizontal', 'id' => 'signupForm')) !!}

    <fieldset>

        <input type="hidden" name="nr_rm" value="{{$item->NR_RM}}">
        <input type="hidden" name="ano_rm" value="{{$item->ANO_RM}}">
        <input type="hidden" name="cd_centro" value="{{$item->CD_CENTRO}}">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Serviço</label>
            <div class="col-md-4">
                <input id="ds_serv" name="ds_serv" class="form-control input-md"
                       type="text" value="{{$item->DS_SERV}}">
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

    <script>
        $().ready(function () {
            var quantidade = $("#qt_item").val().split('.');
            console.log(quantidade[1]);
            if(quantidade[1] == "000"){
                $("#qt_item").val(quantidade[0]);
            }
        });
    </script>

    <script>
        $().ready(function () {

            $.validator.methods.number = function (value, element) {
                return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:[\s\.,]\d{3})+)(?:[\.,]\d+)?$/.test(value);
            };


            $("#signupForm").validate({

                rules: {
                    qt_item: "required",
                    vl_unit: "required"
                },
                messages: {
                    qt_item: "O campo Quantidade é obrigatório.",
                    vl_unit: "O campo Valor Unitário deve conter apenas números ou no formato 0,00."
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },

                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
                }
            });
        });
    </script>

@endsection