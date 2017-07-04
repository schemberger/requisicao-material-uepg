@extends('layouts.body')

@section('content')


    {!! Form::model($destino, array('url' => 'destino/update/'.$destino->NR_ITEM_DESTINO, 'method' => 'put',
         'class'=>'top form-horizontal', 'id' => 'signupForm')) !!}

    <fieldset>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Órgão de Destino</label>
            <div class="col-md-3">
                <select name="cd_ccdest" class="form-control cd_ccdest select">
                    <option value="{{$orgao_dest_atual->cd_centro}}">{{$orgao_dest_atual->nm_centro}}</option>
                    @foreach($orgao_dest as $aux)
                        <option value="{{$aux->cd_centro}}">{{$aux->nm_centro}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Local de Entrega</label>
            <div class="col-md-3">
                <select name="cd_local" class="form-control cd_local">
                    <option value="{{$local_entrega_atual->CD_LOCAL}}">{{$local_entrega_atual->NM_LOCAL}}</option>
                    @foreach($local_entrega as $aux)
                        <option value="{{$aux->CD_LOCAL}}">{{$aux->NM_LOCAL}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Complemento do Destino</label>
            <div class="col-md-3">
                <input id="textinput" name="compl_destrmd" value="{{$destino->COMPL_DESTRMD}}"
                       class="form-control input-md" type="text">
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Quantidade</label>
            <div class="col-md-2">
                <input id="qt_itemd" name="qt_itemd" value="{{$destino->QT_ITEMD}}"
                       class="form-control input-md qt_item" type="text">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nº Conta Contábil</label>
            <div class="col-md-2">
                <input id="textinput" name="nr_ctauepg" value="{{$destino->NR_CTAUEPG}}"
                       class="form-control input-md" type="text">
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group" style="margin-top: 3%;">
            <div class="col-md-8 col-lg-offset-4">
                <button type="submit" id="button1id" name="button1id" class="btn btn-success">Confirmar</button>
                <a href="{{url('destino/'.$destino->NR_RM .'/'. $destino->ANO_RM.'/'.$destino->CD_CENTRO.'/'. $destino->NR_ITEM)}}"
                   class="btn btn-danger">Voltar</a>
            </div>
        </div>

    <input id="quantidade" type="hidden" value="{{$item->QT_ITEM}}">
    <input type="hidden" name="nr_rm" value="{{$item->NR_RM}}">
    <input type="hidden" name="ano_rm" value="{{$item->ANO_RM}}">
    <input type="hidden" name="cd_centro" value="{{$item->CD_CENTRO}}">
    <input type="hidden" name="nr_item" value="{{$item->NR_ITEM}}">


    </fieldset>

    {!! Form::close() !!}

@stop

@section('end-script')

    <script>
        var usedNames = {};
        $("select[name='cd_local'] > option").each(function () {
            if (usedNames[this.text]) {
                $(this).remove();
            } else {
                usedNames[this.text] = this.value;
            }
        });
    </script>

    <script>
        var usedNames = {};
        $("select[name='cd_ccdest'] > option").each(function () {
            if (usedNames[this.text]) {
                $(this).remove();
            } else {
                usedNames[this.text] = this.value;
            }
        });
    </script>

    <script>

        $(".qt_item").on('change', function (evt) {

            var aux = $('#quantidade').val();
            var qntd = $('#qt_item').val();


            if (qntd >  parseInt(aux)) {
                swal("A quantidade informada é maior que a quantidade cadastrada.");
            }
        });

    </script>

    <script>
        $().ready(function () {
            var quantidade = $("#qt_itemd").val().split('.');
            console.log(quantidade[1]);
            if(quantidade[1] == "000"){
                $("#qt_itemd").val(quantidade[0]);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".select").select2({
                allowClear: true
            });
        });
    </script>

    <script>
        $().ready(function () {

            var qt_item = $('#quantidade').val();

            $("#signupForm").validate({
                rules: {
                    cd_local: "required",
                    qt_itemd: {
                        required: true,
                        max: qt_item
                    },
                    cd_ccdest: {
                        "required": true
                    }
                },
                messages: {
                    cd_local: "O campo Local de Entrega é obrigatório.",
                    qt_itemd: {
                        required: "O campo Quantidade é obrigatório.",
                        max: "A Quantidade não pode ser maior que a quantidade cadastrada."
                    },
                    cd_ccdest: "O campo Órgão de Destino é obrigatório."
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
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.closest('.has-error').find('.select2'));
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
                }
            });
        });

        // add valid and remove error classes on select2 element if valid
        $('.select').on('change', function () {
            if ($(this).valid()) {
                $(this).next('span').removeClass('has-error').addClass('valid');
            }
        });
    </script>

@endsection