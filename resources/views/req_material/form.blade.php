@extends('layouts.body')

@section('content')
    {!! Form::open(array('url' => 'req_material', 'class'=>'form-horizontal top', 'id' => 'signupForm')) !!}

    <fieldset>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Órgão</label>
            <div class="col-md-3">
                <input id="textinput" name="cd_centro" value="{{$orgao->nm_centro}}" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>

        <input type="hidden" name="cd_centro" value="{{$orgao->cd_centro}}">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="nr_rm">Número da Requisição</label>
            <div class="col-md-3">
                <input id="nr_rm" name="nr_rm" value="{{$nr_rm}}" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>
        <input type="hidden" name="nr_rm" value="{{$nr_rm}}">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Data da Requisição</label>
            <div class="col-md-3">
                <input id="textinput" name="dt_emissao" value="{{date('d/m/Y')}}" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>
        <input type="hidden" name="dt_emissao" value="{{date('d/m/Y')}}">

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Órgão de Destino</label>
            <div class="col-md-3">
                <select name="cd_ccdest" class="form-control select js-example-placeholder-single" id="cd_centro">
                    <option value=""></option>
                    @foreach($orgao_dest as $aux)
                        <option value="{{$aux->cd_centro}}">{{$aux->nm_centro}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Complemento do Destino</label>
            <div class="col-md-3">
                <input id="textinput" name="compl_dest" placeholder="Complemento do Destino"
                       class="form-control input-md" type="text">
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Emissor</label>
            <div class="col-md-3">
                <input id="textinput" name="emissor" value="{{$emissor->nm_usuario}}" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>
        <input type="hidden" name="emissor" value="{{$emissor->nm_usuario}}">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Local de Entrega</label>
            <div class="col-md-3">
                <input id="loc_entrega" name="loc_entrg" value="O Mesmo" class="form-control input-md"
                       type="text">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Receptor</label>
            <div class="col-md-3">
                <input id="receptor" name="receptor" placeholder="Receptor"
                       class="form-control input-md" type="text">
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Fonte</label>
            <div class="col-md-3">
                <select name="cd_fonte" class="form-control">
                    <option hidden selected value="">Selecione uma opção</option>
                    @foreach($fonte as $aux)
                        <option value="{{$aux->CD_FONTE}}">{{$aux->NM_FONTE}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nº Conta Contábil</label>
            <div class="col-md-3">
                <input id="textinput" name="nr_ctauepg" placeholder="Nº Conta Contábil"
                       class="form-control input-md" type="text">
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Multiple Radios -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="radios">Tipo da Requisição</label>
            <div class="col-md-3">
                <div class="radio">
                    <label for="radios-0">
                        <input name="tp_rm" id="radios-0" value="1" checked="checked" type="radio">
                        Material
                    </label>
                </div>
                <div class="radio">
                    <label for="radios-1">
                        <input name="tp_rm" id="radios-1" value="2" type="radio">
                        Serviço
                    </label>
                </div>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="justificativa">Justificativa</label>
            <div class="col-md-4">
                    <textarea class="form-control" id="justificativa" name="justifica"
                              placeholder="Justificativa"></textarea>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textarea">Observações</label>
            <div class="col-md-4">
                <textarea class="form-control" id="textarea" name="obs" placeholder="Observações"></textarea>
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group" style="margin-top: 3%;">
            <div class="col-md-8 col-lg-offset-4">
                <button type="submit" id="button1id" name="button1id" class="btn btn-success">Confirmar</button>
                <a href="{{url('req_material')}}" class="btn btn-danger">Voltar</a>
            </div>
        </div>

    </fieldset>

    {!! Form::close() !!}

@stop

@section('end-script')

    <script>
        $().ready(function () {

//            $.validator.addMethod("justificativa", function (value) {
//                return value != "Contact Name";
//            }, 'Please enter a contact name');

            $("#signupForm").validate({
                ignore: 'input[type=hidden]',
                rules: {
                    loc_entrega: "required",
                    receptor: "required",
                    justifica: {
                        required: true,
                        minlength: 10
                    },
                    cd_centro: {
                        "required": true
                    }
                },
                messages: {
                    loc_entrega: "O campo Local de Entrega é obrigatório.",
                    receptor: "O campo Receptor é obrigatório.",
                    justifica: {
                        required: "O campo Justificativa é obrigatório.",
                        minlength: "O campo Justificativa deve conter no mínimo 10 caracteres."
                    },
                    cd_centro: "O campo Órgão de Destino é obrigatório."
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
                    $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
                }
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".js-example-placeholder-single").select2({
                placeholder: "Selecione um órgão.",
                allowClear: true
            });
        });
    </script>

    <script>

        $(".select").on('change', function (evt) {

            var cd_centro = $(this).val();

            console.log(cd_centro);

            $.ajax({

                url: +cd_centro + "/receptores",
                type: "get",
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    if(isEmptyObject(data)){
                        swal("Nenhum Receptor encontrado.");
                    }else{
                        $('#receptor').val(data.RECEPTORES);
                    }

                }
            });
        });

        function isEmptyObject ( obj ) {
            var name;
            for ( name in obj ) {
                return false;
            }
            return true;
        }

    </script>
@stop
