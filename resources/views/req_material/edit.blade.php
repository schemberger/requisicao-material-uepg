@extends('layouts.body')


@section('content')

    {!! Form::model($requisicao, array('url' => 'req_material/'.$requisicao->NR_RM, 'method' => 'put', 'id' => 'signupForm',
     'class'=>'top form-horizontal')) !!}

    <fieldset>

        <!-- Button (Double) -->
        <div class="form-group">
            <div class="col-md-8 col-lg-offset-4">
                <a href="{{url('item_req_material/'.$nr_rm.'/'.$ano_rm.'/'.$cd_centro.'/showItens')}}" class="btn btn-primary">Itens</a>
                <a href="{{url('req_material')}}" class="btn btn-danger">Voltar</a>
            </div>
        </div>

        <hr style="height:1px; border:none; color:#000; background-color:#000; margin-top: 0px; margin-bottom: 0px;"/>

        <input type="hidden" name="nr_rm" value="{{$nr_rm}}">
        <input type="hidden" name="ano_rm" value="{{$ano_rm}}">
        <input type="hidden" name="cd_centro" value="{{$cd_centro}}">

        <!-- Text input-->
        <div class="form-group" style="margin-top: 2%">
            <label class="col-md-4 control-label" for="textinput">Órgão</label>
            <div class="col-md-3">
                <input id="textinput" name="cd_centro" value="{{$orgao->nm_centro}}" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Data da Requisição</label>
            <div class="col-md-3">
                <input id="textinput" name="dt_emissao" value="{{date('d/m/Y')}}" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Órgão de Destino</label>
            <div class="col-md-3">
                <select name="cd_ccdest" class="form-control select" href="{{url('/req_material/create')}}">
                    <option value="{{$requisicao->CD_CCDEST}}">{{$orgao_dest_aux->nm_centro}}</option>
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
                <input id="textinput" name="compl_dest" value="{{$requisicao->COMPL_DEST}}"
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

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Local de Entrega</label>
            <div class="col-md-3">
                <input id="loc_entrega" name="loc_entrg" value="{{$requisicao->LOC_ENTRG}}"
                       class="form-control input-md"
                       type="text">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Receptor</label>
            <div class="col-md-3">
                <input id="receptor" name="receptor" value="{{$receptores->RECEPTORES}}"
                       class="form-control input-md" type="text">
            </div>
        </div>

    @if($requisicao->CD_FONTE == null)

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

    @elseif($requisicao->CD_FONTE != null)

        <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="selectbasic">Fonte</label>
                <div class="col-md-3">
                    <select name="cd_fonte" class="form-control">
                        <option value="{{$requisicao->CD_FONTE}}">{{$fonte_aux->NM_FONTE}}</option>
                        @foreach($fonte as $aux)
                            <option value="{{$aux->CD_FONTE}}">{{$aux->NM_FONTE}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1"><span>* Opcional</span></div>
            </div>

    @endif


    <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nº Conta Contábil</label>
            <div class="col-md-3">
                <input id="textinput" name="nr_ctauepg" value="{{$requisicao->NR_CTAUEPG}}"
                       class="form-control input-md" type="text">
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

    @if($opcao_tipo_requisicao == "liberado")

        <!-- Multiple Radios -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="radios">Tipo da Requisição</label>
                <div class="col-md-3">
                    <div class="radio">
                        <label for="radios-0">
                            <input name="tp_rm" id="radios-0" value="1"
                                   <?php if ($requisicao->TP_RM == 1) print "checked"; ?> type="radio">
                            Material
                        </label>
                    </div>
                    <div class="radio">
                        <label for="radios-1">
                            <input name="tp_rm" id="radios-1" value="2"
                                   <?php if ($requisicao->TP_RM == 2) print "checked"; ?> type="radio">
                            Serviço
                        </label>
                    </div>
                </div>
            </div>

        @elseif($opcao_tipo_requisicao == "bloqueado")

            <input type="hidden" name="tp_rm" value="{{$requisicao->TP_RM}}">

    @endif

    <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="justificativa">Justificativa</label>
            <div class="col-md-4">
                <textarea class="form-control" id="justificativa" name="justifica">{{$requisicao->JUSTIFICA}}</textarea>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textarea">Observações</label>
            <div class="col-md-4">
                <textarea class="form-control" id="textarea" name="obs">{{$requisicao->OBS}}</textarea>
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group" style="margin-top: 3%;">
            <div class="col-md-8 col-lg-offset-4">
                <button type="submit" class="btn btn-success">Confirmar</button>
                <a href="{{url('req_material')}}" class="btn btn-danger">Voltar</a>
            </div>
        </div>

    </fieldset>

    {!! Form::close() !!}

@stop

@section('end-script')

    <script type="text/javascript">
        $(document).ready(function () {
            $(".select").select2({
                placeholder: "Selecione um órgão.",
                allowClear: true
            });
        });
    </script>

    <script>
        var usedNames = {};
        $("select[name='cd_fonte'] > option").each(function () {
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

        $(".select").on('change', function (evt) {

            var cd_centro = $(this).val();

            var url = $(this).attr('href');

            $.ajax({

                url: url + '/' + cd_centro +'/receptores',
                type: "get",
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    if (isEmptyObject(data)) {
                        swal("Nenhum Receptor encontrado.");
                        $('#receptor').val('');
                    } else {
                        $('#receptor').val(data.RECEPTORES);
                    }
                }
            });
        });

        function isEmptyObject(obj) {
            var name;
            for (name in obj) {
                return false;
            }
            return true;
        }

    </script>

    <script>
        $().ready(function () {

            $("#signupForm").validate({
                rules: {
                    loc_entrega: "required",
                    receptor: "required",
                    justifica: {
                        required: true,
                        minlength: 10
                    },
                    cd_ccdest: {
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
                    $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
                }
            });
        });

        // add valid and remove error classes on select2 element if valid
        $('.select').on('change', function() {
            if($(this).valid()) {
                $(this).next('span').removeClass('has-error').addClass('valid');
            }
        });
    </script>

@stop